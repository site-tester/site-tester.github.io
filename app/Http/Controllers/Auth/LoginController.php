<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('Content Manager') || $user->hasRole('Barangay') || $user->hasRole('Municipal Admin')) {
            return redirect()->route('backpack.dashboard'); // Redirect to admin dashboard
        // } elseif ($user->hasRole('Barangay')) {
        //     return redirect()->route('barangay.dashboard'); // Redirect to trainer dashboard
        } elseif ($user->hasRole('Normal User')) {
            if ($user->isApprove) {
                return redirect()->route('donor.dashboard');
            }
            return redirect()->route('landing')->with('error','The Account is not Approved Yet');
        }

        // Default redirection if no role is matched
        return redirect()->route('home'); // Or wherever you want to send them
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
