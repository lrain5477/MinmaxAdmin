<?php

namespace Minmax\Member\Web;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;
use Minmax\Base\Web\FirewallRepository;

/**
 * Class LoginController
 */
class LoginController extends BaseController
{
    use AuthenticatesUsers, AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * @var \Illuminate\Support\Collection|\Minmax\Base\Models\WorldLanguage[] $languageData
     */
    protected $languageData;

    /**
     * @var \Minmax\Base\Models\WebData $webData
     */
    protected $webData;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Minmax\Base\Models\Firewall[]
     */
    protected $firewallData;

    /**
     * Create a new controller instance.
     *
     * @param  FirewallRepository $firewallRepository
     * @return void
     */
    public function __construct(FirewallRepository $firewallRepository)
    {
        // 設定 防火牆資料
        $this->firewallData = $firewallRepository->all(['guard' => 'web', 'active' => true]);

        // 設定 導向網址
        //$this->redirectTo = ($this->webData->system_language == app()->getLocale() ? '' : (app()->getLocale() . '/')) . $this->redirectTo;

        $this->middleware('guest')->except('logout');

        $this->middleware(function ($request, $next) {
            /** @var Request $request */
            $thisAttributes = $request->get('controllerAttributes');

            $this->webData = $thisAttributes['webData'] ?? abort(404);

            return $next($request);
        });
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('MinmaxMember::web.login', ['webData' => $this->webData]);
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
        $firewallBlack = $this->firewallData->where('rule', false)->map(function ($item) {
            return $item->ip;
        })->toArray();
        $firewallWhite = $this->firewallData->where('rule', true)->map(function ($item) {
            return $item->ip;
        })->toArray();
        $firewallWhite = count($firewallWhite) > 0 ? $firewallWhite : [$request->ip()];

        $this->validate($request, [
            $this->username() => [
                'required',
                'string',
                'max:16',
                Rule::exists('member', $this->username())->where(function ($query) {
                    /** @var \Illuminate\Database\Query\Builder $query */
                    $query->where('active', true);
                }),
            ],
            'password' => 'required|string',
            'captcha' => ['required', Rule::in([session('web_captcha_login')])],
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

        return redirect(langRoute('web.home'));
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     */
    protected function authenticated(Request $request, $user)
    {
        LogHelper::login('web', $request, $user->username, 1, 'Login success');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
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
