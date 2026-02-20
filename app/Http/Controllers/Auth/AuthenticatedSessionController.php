<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($fieldType == 'text') {
            $request->validate([
                'username' => 'required|exists:users,username',
                'password' => 'required|min:5|max:45|exists:users,password',
            ], [
                'username.required' => 'Email atau Username dibutuhkan',
                'username.email' => 'Username Invalid',
                'username.exists' => 'Username tidak terdaftar di sistem',
                'password.exists' => 'Password salah!',
                'password.required' => 'Password dibutuhkan'
            ]);
        } else {
            $request->validate([
                'username' => 'required|exists:users,username',
                'password' => 'required|min:5|max:45',
            ], [
                'username.required' => ' Username dibutuhkan',
                'username.exists' => 'Username tidak terdaftar di sistem',
                'password.exists' => 'Password salah!',
                'password.required' => 'Password dibutuhkan'
            ]);
        }

        $creds = array(
            $fieldType => $request->username,
            'password' => $request->password
        );

        if (Auth::guard('admin')->attempt($creds)) {
            return redirect()->route('home.admin');
        } elseif (Auth::guard('web')->attempt($creds)) {
            return redirect()->route('home');
        } 
        else {
            session()->flash('fail', 'Incorrect credentials');
            return redirect()->route('login');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout(); // Logout admin
        }
    
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout(); // Logout customer
        }
    
        return redirect('/home');
    }
}
