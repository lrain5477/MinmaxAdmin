<?php

namespace App\Http\Controllers\Admin;

use App\Models\Firewall;
use Auth;
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => [
                'required',
                'string',
                'max:16',
                Rule::exists('admin', $this->username())->where(function($query) {
                    $query->where('active', '=', 1);
                }),
            ],
            'password' => 'required|string',
            'captcha' => ['required', Rule::in([session('adminCaptcha')])],
        ]);

        // 驗證防火牆
        $firewallData = Firewall::where(['guard' => 'admin'])->get();

        // 驗證白名單 IP
        if($firewallData->where('rule', 1)->count() > 0) {
            if($firewallData->where('rule', 1)->where('ip', \Request::ip())->count() < 1) {
                // LogHelper::loginLog($request->input('username'), 'Login Deny', 'Failed');
                return redirect()->route('admin.login')->withErrors(['ip' => __('validation.custom.ip.white')]);
            }
        }
        // 驗證黑名單 IP
        if($firewallData->where('rule', 0)->where('ip', \Request::ip())->count() > 0) {
            // LogHelper::loginLog($request->input('username'), 'Login Deny', 'Failed');
            return redirect()->route('admin.login')->withErrors(['ip' => __('validation.custom.ip.black')]);
        }
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

        return redirect()->route('admin.home');
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
