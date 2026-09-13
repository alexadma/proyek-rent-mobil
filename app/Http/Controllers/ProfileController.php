<?php

namespace App\Http\Controllers;

use App\Services\CustomerProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        private CustomerProfileService $profileService
    ) {}

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

    public function update(Request $request): RedirectResponse
    {
        $customer = Auth::guard('web')->user();

        if (! $customer) {
            return redirect()->route('login')->with('fail', 'Silakan login terlebih dahulu.');
        }

        $this->profileService->updateProfile($customer, $request);

        return redirect()->route('profile')->with('success', 'Profile berhasil diperbarui.');
    }
}