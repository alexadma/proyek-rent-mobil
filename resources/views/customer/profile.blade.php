@extends('layouts.mainsewa')

@section('container')
<div class="bg-black min-h-screen">
    <div class="container mx-auto mt-8 mb-12">
        <div class="max-w-3xl mx-auto">
            <div class="glass-effect-dark rounded-2xl p-8 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-3xl font-bold gradient-text">Profile</h1>
                    <a href="{{ route('sewa') }}" class="text-yellow-500 hover:text-yellow-400 transition-colors text-sm flex items-center gap-1">
                        <i class="fas fa-arrow-left"></i> Kembali ke Sewa
                    </a>
                </div>

                @if (session('success'))
                    <div class="bg-green-900/50 border border-green-500 text-green-100 px-4 py-3 rounded-lg mb-6 flex items-center gap-2" role="alert">
                        <i class="fas fa-check-circle text-green-400"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('fail'))
                    <div class="bg-red-900/50 border border-red-500 text-red-100 px-4 py-3 rounded-lg mb-6 flex items-center gap-2" role="alert">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                        <span>{{ session('fail') }}</span>
                    </div>
                @endif

                <div id="profileView" class="space-y-6">
                    <div class="flex items-center gap-6 p-4 bg-black/30 rounded-xl">
                        <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-black font-bold text-2xl">{{ strtoupper(substr($customer->nama ?? $customer->username, 0, 1)) }}</span>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-white">{{ $customer->nama ?? $customer->username }}</h2>
                            <p class="text-gray-400 text-sm">{{ $customer->email }}</p>
                            <p class="text-gray-500 text-xs mt-1">Member sejak {{ $customer->created_at->format('d F Y') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-black/30 rounded-xl p-4">
                            <label class="text-xs font-medium text-yellow-500 uppercase tracking-wider">Nama Lengkap</label>
                            <p class="text-white mt-1">{{ $customer->nama }}</p>
                        </div>
                        <div class="bg-black/30 rounded-xl p-4">
                            <label class="text-xs font-medium text-yellow-500 uppercase tracking-wider">Username</label>
                            <p class="text-white mt-1">{{ $customer->username }}</p>
                        </div>
                        <div class="bg-black/30 rounded-xl p-4">
                            <label class="text-xs font-medium text-yellow-500 uppercase tracking-wider">Email</label>
                            <p class="text-white mt-1">{{ $customer->email }}</p>
                        </div>
                        <div class="bg-black/30 rounded-xl p-4">
                            <label class="text-xs font-medium text-yellow-500 uppercase tracking-wider">Nomor Telepon</label>
                            <p class="text-white mt-1">{{ $customer->nohp }}</p>
                        </div>
                        <div class="bg-black/30 rounded-xl p-4 md:col-span-2">
                            <label class="text-xs font-medium text-yellow-500 uppercase tracking-wider">Alamat</label>
                            <p class="text-white mt-1 whitespace-pre-wrap">{{ $customer->alamat }}</p>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-white/10">
                        <button type="button" id="editProfileBtn" class="px-6 py-2.5 bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-semibold rounded-full hover:shadow-lg hover:shadow-yellow-500/50 transition-all hover:scale-105">
                            <i class="fas fa-edit mr-2"></i> Edit Profile
                        </button>
                    </div>
                </div>

                <form id="profileForm" action="{{ route('profile.update') }}" method="POST" class="hidden space-y-6" x-data="profileForm()">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="nama" value="Nama Lengkap" />
                        <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full bg-black/30 border-white/10 text-white placeholder-gray-400" :value="old('nama', $customer->nama)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                    </div>

                    <div>
                        <x-input-label for="username" value="Username" />
                        <x-text-input id="username" name="username" type="text" class="mt-1 block w-full bg-black/30 border-white/10 text-white placeholder-gray-400" :value="old('username', $customer->username)" required autocomplete="username" readonly />
                        <p class="mt-1 text-xs text-gray-500">Username tidak dapat diubah.</p>
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-black/30 border-white/10 text-white placeholder-gray-400" :value="old('email', $customer->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="nohp" value="Nomor Telepon" />
                        <x-text-input id="nohp" name="nohp" type="tel" class="mt-1 block w-full bg-black/30 border-white/10 text-white placeholder-gray-400" :value="old('nohp', $customer->nohp)" required autocomplete="tel" />
                        <x-input-error class="mt-2" :messages="$errors->get('nohp')" />
                        <p class="mt-1 text-xs text-gray-500">Format: 08xxxxxxxxxx atau +628xxxxxxxxxx</p>
                    </div>

                    <div>
                        <x-input-label for="alamat" value="Alamat" />
                        <textarea id="alamat" name="alamat" rows="3" class="mt-1 block w-full bg-black/30 border border-white/10 rounded-md shadow-sm py-2 px-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required autocomplete="street-address">{{ old('alamat', $customer->alamat) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
                    </div>

                    <div class="pt-4 border-t border-white/10">
                        <x-input-label for="password" value="Password Baru (Opsional)" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full bg-black/30 border-white/10 text-white placeholder-gray-400" autocomplete="new-password" />
                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah password. Minimal 8 karakter.</p>
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-black/30 border-white/10 text-white placeholder-gray-400" autocomplete="new-password" />
                        <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-white/10">
                        <button type="submit" id="saveBtn" class="px-6 py-2.5 bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-semibold rounded-full hover:shadow-lg hover:shadow-yellow-500/50 transition-all hover:scale-105 flex items-center gap-2" :disabled="saving">
                            <span x-show="!saving"><i class="fas fa-save mr-2"></i> Simpan</span>
                            <span x-show="saving" class="flex items-center gap-2"><svg class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Menyimpan...</span>
                        </button>
                        <button type="button" id="cancelBtn" class="px-6 py-2.5 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-full transition-all">
                            <i class="fas fa-times mr-2"></i> Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function profileForm() {
    return {
        saving: false,
        init() {
            this.$watch('saving', (value) => {
                if (value) {
                    this.$refs.saveBtn?.classList.add('opacity-75', 'cursor-not-allowed');
                } else {
                    this.$refs.saveBtn?.classList.remove('opacity-75', 'cursor-not-allowed');
                }
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const editBtn = document.getElementById('editProfileBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const profileView = document.getElementById('profileView');
    const profileForm = document.getElementById('profileForm');

    if (editBtn && profileView && profileForm) {
        editBtn.addEventListener('click', function() {
            profileView.classList.add('hidden');
            profileForm.classList.remove('hidden');
        });
    }

    if (cancelBtn && profileView && profileForm) {
        cancelBtn.addEventListener('click', function() {
            profileForm.classList.add('hidden');
            profileView.classList.remove('hidden');
        });
    }
});
</script>
@endsection