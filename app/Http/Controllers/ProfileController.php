<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerProfileUpdateRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        $customer = Auth::guard('web')->user();

        if (! $customer) {
            return redirect()->route('login')->with('fail', 'Silakan login terlebih dahulu.');
        }

        return view('customer.profile', [
            'title' => 'Profile',
            'customer' => $customer,
        ]);
    }

    public function update(CustomerProfileUpdateRequest $request): RedirectResponse
    {
        $customer = Auth::guard('web')->user();

        if (! $customer) {
            return redirect()->route('login')->with('fail', 'Silakan login terlebih dahulu.');
        }

        $validated = $request->validated();

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $customer->update($validated);

        return redirect()->route('profile')->with('success', 'Profile berhasil diperbarui.');
    }
}