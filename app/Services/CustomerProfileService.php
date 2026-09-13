<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerProfileService
{
    /**
     * Update customer profile including photo and password.
     */
    public function updateProfile(Customer $customer, Request $request): void
    {
        $request->validate([
            'nama' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255'],
            'nohp' => ['sometimes', 'string', 'max:20'],
            'alamat' => ['sometimes', 'string', 'max:500'],
            'foto' => ['sometimes', 'image', 'file', 'max:5000'],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
        ]);

        $validated = $request->only(['nama', 'email', 'nohp', 'alamat']);

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $validated['foto'] = $this->handlePhotoUpload($customer, $request->file('foto'));
        }

        // Handle password
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->input('password'));
        }

        $customer->update($validated);
    }

    private function handlePhotoUpload(Customer $customer, $file): string
    {
        $fotoDir = public_path('foto-profile');
        if (! is_dir($fotoDir)) {
            mkdir($fotoDir, 0755, true);
        }

        // Delete old photo
        if ($customer->foto && file_exists(public_path($customer->foto))) {
            unlink(public_path($customer->foto));
        }

        $filename = time().'_'.$file->getClientOriginalName();
        $file->move($fotoDir, $filename);

        return 'foto-profile/'.$filename;
    }
}
