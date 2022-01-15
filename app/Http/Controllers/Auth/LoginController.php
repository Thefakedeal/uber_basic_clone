<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo(){
        switch(Auth::user()->role){
            case User::ROLE_ADMIN:
                return route('admin.home');
            case User::ROLE_DRIVER:
                return route('driver.home');
            default:
                return '/';
        }
    }

    public function authenticated()
    {
        switch(Auth::user()->role){
            case User::ROLE_ADMIN:
                return redirect(route('admin.home'));
            case User::ROLE_DRIVER:
                return redirect(route('driver.home'));
            default:
                return redirect('/');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
