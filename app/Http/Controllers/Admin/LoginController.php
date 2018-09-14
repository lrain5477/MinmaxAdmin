<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Repositories\Admin\FirewallRepository;
use App\Repositories\Admin\WebDataRepository;
use App\Repositories\Admin\WorldLanguageRepository;
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
    protected $redirectTo = '/siteadmin';

    /** @var \Illuminate\Support\Collection|\App\Models\WorldLanguage[] $languageData */
    protected $languageData;

    /**
     * @var \App\Models\WebData $webData
     */
    protected $webData;

    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Firewall[] */
    protected $firewallData;

    /**
     * Create a new controller instance.
     *
     * @param  WebDataRepository $webDataRepository
     * @param  FirewallRepository $firewallRepository
     * @return void
     */
    public function __construct(WebDataRepository $webDataRepository, FirewallRepository $firewallRepository)
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

        // 設定 防火牆資料
        $this->firewallData = $firewallRepository->all(['guard' => 'admin', 'active' => 1]);

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
        return view('admin.login', ['webData' => $this->webData]);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request->merge(['ip' => $request->ip()]);

        // 防火牆
        $firewallBlack = $this->firewallData->where('rule', 0)->map(function ($item) {
            return $item->ip;
        })->toArray();
        $firewallWhite = $this->firewallData->where('rule', 1)->map(function ($item) {
            return $item->ip;
        })->toArray();
        $firewallWhite = count($firewallWhite) > 0 ? $firewallWhite : [$request->ip()];

        if ($request->input($this->username()) === 'sysadmin') {
            $firewallBlack = [];
            $firewallWhite = [$request->ip()];
        }

        // 防火牆阻擋紀錄
        if (!in_array($request->ip(), $firewallWhite) || in_array($request->ip(), $firewallBlack)) {
            LogHelper::login('admin', $request, $request->input($this->username()), 1, 'Login success');
        }

        $this->validate($request, [
            $this->username() => [
                'required',
                'string',
                'max:16',
                Rule::exists('admin', $this->username())->where(function ($query) {
                    /** @var \Illuminate\Database\Query\Builder $query */
                    $query->where('active', '=', 1);
                }),
            ],
            'password' => 'required|string',
            'captcha' => ['required', Rule::in([session('admin_captcha_login')])],
            'ip' => [
                Rule::in($firewallWhite),
                Rule::notIn($firewallBlack),
            ],
        ], [
            'ip.in' => __('validation.custom.ip.white'),
            'ip.not_in' => __('validation.custom.ip.black'),
        ]);
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

        return redirect(langRoute('admin.home'));
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     */
    protected function authenticated(Request $request, $user)
    {
        LogHelper::login('admin', $request, $user->username, 1, 'Login success');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return \Auth::guard('admin');
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
