<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerProfileUpdateRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

    public function update(CustomerProfileUpdateRequest $request)
    {
        $customer = Auth::guard('web')->user();

        if (! $customer) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu.'], 401);
            }
            return redirect()->route('login')->with('fail', 'Silakan login terlebih dahulu.');
        }

        $validated = $request->validated();

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $fotoDir = public_path('foto-profile');
            if (!is_dir($fotoDir)) {
                mkdir($fotoDir, 0755, true);
            }

            // Delete old photo if exists
            if ($customer->foto && file_exists(public_path($customer->foto))) {
                unlink(public_path($customer->foto));
            }

            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move($fotoDir, $filename);
            $validated['foto'] = 'foto-profile/' . $filename;
        }

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $customer->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile berhasil diperbarui.',
                'data' => [
                    'nama' => $customer->nama,
                    'username' => $customer->username,
                    'email' => $customer->email,
                    'nohp' => $customer->nohp,
                    'alamat' => $customer->alamat,
                    'foto' => $customer->foto ? asset($customer->foto) : null,
                ]
            ]);
        }

        return redirect()->route('profile')->with('success', 'Profile berhasil diperbarui.');
    }
}