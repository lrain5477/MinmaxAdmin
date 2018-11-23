<?php

namespace App\Http\Controllers\Administrator;

use App\Helpers\LogHelper;
use App\Repositories\Administrator\WebDataRepository;
use App\Repositories\Administrator\WorldLanguageRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;

class LoginController extends BaseController
{
    use AuthenticatesUsers, AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/administrator';

    /** @var \Illuminate\Support\Collection|\App\Models\WorldLanguage[] $languageData */
    protected $languageData;

    /**
     * @var \App\Models\WebData $webData
     */
    protected $webData;

    /**
     * Create a new controller instance.
     *
     * @param  WebDataRepository $webDataRepository
     * @return void
     */
    public function __construct(WebDataRepository $webDataRepository)
    {
        // 設定 語言資料
        $this->languageData = \Cache::rememberForever('languageSet', function() {
            return (new WorldLanguageRepository())
                ->all(function($query) {
                    /** @var \Illuminate\Database\Query\Builder $query */
                    $query->where('active', '1')->orderBy('sort');
                });
        });

        // 設定 網站資料
        $this->webData = $webDataRepository->getData() ?? abort(404);
        if ($this->webData->active != '1') abort(404, $this->webData->offline_text);

        // 設定 導向網址
        $this->redirectTo .= $this->languageData->count() > 1 ? ('/'.app()->getLocale()) : '';

        $this->middleware('guest')->except('logout');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('administrator.login', ['webData' => $this->webData]);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => [
                'required',
                'string',
                'max:16',
                Rule::exists('administrator', $this->username())
                    ->where(function($query) {
                        /** @var \Illuminate\Database\Query\Builder $query */
                        $query
                            ->where('active', '=', 1)
                            ->where(function($query) {
                                /** @var \Illuminate\Database\Query\Builder $query */
                                $query
                                    ->whereNull('allow_ip')
                                    ->orWhere('allow_ip', 'like', '%\'' . request()->ip() . '\'%');
                            });
                    }),
            ],
            'password' => 'required|string',
            'captcha' => ['required', Rule::in([session('administrator_captcha_login')])],
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect(langRoute('administrator.home'));
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     */
    protected function authenticated(Request $request, $user)
    {
        LogHelper::login('administrator', $request, $user->username, 1, 'Login success');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return \Auth::guard('administrator');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }
}
