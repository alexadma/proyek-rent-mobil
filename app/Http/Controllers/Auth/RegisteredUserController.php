<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|min:3|max:255|unique:customers,username',
            'email' => 'required|string|email|max:255|unique:customers,email',
            'alamat' => 'required|string|max:255',
            'nohp' => 'required|string|max:13|unique:customers,nohp',
            'password' => 'required|string|confirmed|min:5|max:255',
        ]);

        $customer = Customer::create([
            'username' => $validated['username'],
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'email' => $validated['email'],
            'nohp' => $validated['nohp'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($customer));

        return redirect()->route('login')->with('status', 'Registrasi berhasil! Silakan masuk menggunakan akun Anda.');
    }
}