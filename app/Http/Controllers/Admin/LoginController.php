<?php

namespace App\Http\Controllers\Admin;

use App\Models\Firewall;
use App\Models\WebData;
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
        return view('admin.login', ['webData' => WebData::where(['lang' => app()->getLocale(), 'website_key' => 'admin'])->first()]);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request->merge(['ip' => \Request::ip()]);

        // 防火牆
        $firewallData = Firewall::where(['guard' => 'admin', 'active' => 1])->get();
        $firewallBlack = $firewallData->where('rule', 0)->map(function($item, $key) { return $item->ip; })->toArray();
        $firewallWhite = $firewallData->where('rule', 1)->map(function($item, $key) { return $item->ip; })->toArray();
        $firewallWhite = count($firewallWhite) > 0 ? $firewallWhite : [\Request::ip()];

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
