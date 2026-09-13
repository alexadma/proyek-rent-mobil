@extends('layouts.main')

@section('container')

{{-- ===================== HERO ===================== --}}
<section class="relative pt-32 pb-16 overflow-hidden">
    {{-- Background --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-black via-black/80 to-black z-10"></div>
        <img src="https://images.unsplash.com/photo-1494976388531-d1058494cdd8?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
             alt="" class="w-full h-full object-cover opacity-15">
    </div>
    {{-- Decorative orbs --}}
    <div class="absolute top-20 right-[10%] w-80 h-80 bg-yellow-500/8 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-[15%] w-96 h-96 bg-yellow-500/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="relative z-20 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center" data-aos="fade-up">
            <div class="inline-flex items-center gap-2 bg-white/5 backdrop-blur-sm border border-yellow-500/20 rounded-full px-5 py-2 mb-6">
                <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span>
                <span class="text-xs font-semibold text-yellow-500 uppercase tracking-widest">My Account</span>
            </div>
            <h1 class="text-4xl sm:text-5xl font-bold mb-3" style="font-family:'Poppins',sans-serif;">
                <span class="bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 bg-clip-text text-transparent">Profil Saya</span>
            </h1>
            <p class="text-gray-400 text-sm max-w-md mx-auto">Kelola informasi akun, foto profil, dan data pribadi Anda</p>
        </div>
    </div>
</section>

{{-- ===================== MAIN CONTENT ===================== --}}
<section class="relative z-10 -mt-8 pb-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">

            {{-- =================== ALERTS =================== --}}
            @if (session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center gap-3 backdrop-blur-sm" data-aos="fade-up" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)">
                <div class="w-10 h-10 bg-emerald-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check text-emerald-400 text-sm"></i>
                </div>
                <span class="text-emerald-300 text-sm font-medium">{{ session('success') }}</span>
            </div>
            @endif

            @if (session('fail'))
            <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 flex items-center gap-3 backdrop-blur-sm" data-aos="fade-up">
                <div class="w-10 h-10 bg-red-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation text-red-400 text-sm"></i>
                </div>
                <span class="text-red-300 text-sm font-medium">{{ session('fail') }}</span>
            </div>
            @endif

            {{-- =================== PROFILE CARD =================== --}}
            <div class="glass-effect-dark rounded-3xl overflow-hidden border border-white/5" data-aos="fade-up" data-aos-delay="100" x-data="profileController()">

                {{-- Avatar Header --}}
                <div class="relative px-6 sm:px-8 pt-8 pb-6" x-show="!isEditing" x-transition>
                    <div class="absolute inset-0 bg-gradient-to-b from-yellow-500/5 to-transparent pointer-events-none"></div>
                    <div class="relative flex flex-col sm:flex-row items-center gap-6">
                        {{-- Photo Section --}}
                        <div class="relative flex-shrink-0">
                            {{-- Current Photo / Initial --}}
                            <div class="relative" x-data="photoPreview()">
                                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl overflow-hidden bg-gradient-to-br from-yellow-400 to-yellow-600 shadow-lg shadow-yellow-500/20 ring-4 ring-black/50 flex items-center justify-center">
                                    <template x-if="!photoPreviewSrc">
                                        <span class="text-black font-bold text-4xl sm:text-5xl" style="font-family:'Poppins',sans-serif;">{{ strtoupper(substr($customer->nama ?? $customer->username, 0, 1)) }}</span>
                                    </template>
                                    <img x-show="photoPreviewSrc"
                                         :src="photoPreviewSrc"
                                         :alt="customerName"
                                         class="w-full h-full object-cover"
                                         x-transition:opacity>
                                </div>
                            </div>
                        </div>

                        {{-- User Info --}}
                        <div class="text-center sm:text-left flex-1 min-w-0">
                            <h2 class="text-2xl font-bold text-white truncate" style="font-family:'Poppins',sans-serif;" x-text="customerName"></h2>
                            <p class="text-gray-400 text-sm mt-1 truncate" x-text="customerEmail"></p>
                            <div class="flex items-center justify-center sm:justify-start gap-2 mt-3">
                                <span class="inline-flex items-center gap-1 text-xs text-yellow-500/80 bg-yellow-500/10 px-3 py-1 rounded-full">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span x-text="memberSince"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========== VIEW MODE ========== --}}
                <div id="profileView" class="px-6 sm:px-8 pb-8" x-init="initViewMode()">
                    {{-- Profile Information Section --}}
                    <section class="mb-8" x-show="!isEditing" x-transition>
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-lg font-semibold text-white flex items-center gap-2" style="font-family:'Poppins',sans-serif;">
                                <div class="w-7 h-7 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                                    <i class="fas fa-user text-yellow-500 text-xs"></i>
                                </div>
                                Informasi Profil
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- Nama --}}
                            <div class="bg-white/[0.02] rounded-2xl p-5 border border-white/5 hover:border-yellow-500/20 transition-all duration-300 group">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-8 h-8 rounded-lg bg-yellow-500/10 flex items-center justify-center group-hover:bg-yellow-500/20 transition-colors">
                                        <i class="fas fa-user text-yellow-500 text-xs"></i>
                                    </div>
                                    <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Nama Lengkap</span>
                                </div>
                                <p class="text-white font-medium pl-11" x-text="profileData.nama"></p>
                            </div>

                            {{-- Username --}}
                            <div class="bg-white/[0.02] rounded-2xl p-5 border border-white/5 hover:border-yellow-500/20 transition-all duration-300 group">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-8 h-8 rounded-lg bg-yellow-500/10 flex items-center justify-center group-hover:bg-yellow-500/20 transition-colors">
                                        <i class="fas fa-at text-yellow-500 text-xs"></i>
                                    </div>
                                    <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Username</span>
                                </div>
                                <p class="text-white font-medium pl-11" x-text="profileData.username"></p>
                            </div>
                        </div>
                    </section>

                    {{-- Contact Information Section --}}
                    <section class="mb-8" x-show="!isEditing" x-transition>
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-lg font-semibold text-white flex items-center gap-2" style="font-family:'Poppins',sans-serif;">
                                <div class="w-7 h-7 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                                    <i class="fas fa-address-book text-yellow-500 text-xs"></i>
                                </div>
                                Informasi Kontak
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- Email --}}
                            <div class="bg-white/[0.02] rounded-2xl p-5 border border-white/5 hover:border-yellow-500/20 transition-all duration-300 group">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-8 h-8 rounded-lg bg-yellow-500/10 flex items-center justify-center group-hover:bg-yellow-500/20 transition-colors">
                                        <i class="fas fa-envelope text-yellow-500 text-xs"></i>
                                    </div>
                                    <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Email</span>
                                </div>
                                <p class="text-white font-medium pl-11 truncate" x-text="profileData.email"></p>
                            </div>

                            {{-- Telepon --}}
                            <div class="bg-white/[0.02] rounded-2xl p-5 border border-white/5 hover:border-yellow-500/20 transition-all duration-300 group">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-8 h-8 rounded-lg bg-yellow-500/10 flex items-center justify-center group-hover:bg-yellow-500/20 transition-colors">
                                        <i class="fas fa-phone text-yellow-500 text-xs"></i>
                                    </div>
                                    <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">No. Telepon</span>
                                </div>
                                <p class="text-white font-medium pl-11" x-text="profileData.nohp"></p>
                            </div>
                        </div>

                        {{-- Alamat (Full Width) --}}
                        <div class="bg-white/[0.02] rounded-2xl p-5 border border-white/5 hover:border-yellow-500/20 transition-all duration-300 group mt-4">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-8 h-8 rounded-lg bg-yellow-500/10 flex items-center justify-center group-hover:bg-yellow-500/20 transition-colors">
                                    <i class="fas fa-map-marker-alt text-yellow-500 text-xs"></i>
                                </div>
                                <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Alamat</span>
                            </div>
                            <p class="text-white font-medium pl-11 whitespace-pre-line" x-text="profileData.alamat"></p>
                        </div>
                    </section>

                    {{-- Edit Button --}}
                    <div class="flex justify-end pt-6 border-t border-white/5" x-show="!isEditing" x-transition>
                        <button type="button"
                                @click="enterEditMode()"
                                class="group relative px-7 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-semibold rounded-full overflow-hidden transition-all duration-300 hover:shadow-lg hover:shadow-yellow-500/30 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:ring-offset-2 focus:ring-offset-black">
                            <span class="relative z-10 flex items-center gap-2">
                                <i class="fas fa-pen text-xs"></i> Edit Profil
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-yellow-500 to-yellow-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </button>
                    </div>

                {{-- ========== EDIT MODE ========== --}}
                <form id="profileForm" class="px-6 sm:px-8 pb-8"
                      action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                      x-show="isEditing" x-transition
                      @submit.prevent="submitForm">
                    @csrf
                    @method('PUT')

                    {{-- Photo Upload in Edit Mode --}}
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 mb-8 pb-6 border-b border-white/5" x-data="photoPreview()">
                        <div class="relative flex-shrink-0">
                            <div class="w-24 h-24 rounded-2xl overflow-hidden bg-gradient-to-br from-yellow-400 to-yellow-600 shadow-lg shadow-yellow-500/20 ring-4 ring-black/50 flex items-center justify-center">
                                <template x-if="!photoPreviewSrc">
                                    <span class="text-black font-bold text-3xl" style="font-family:'Poppins',sans-serif;">{{ strtoupper(substr($customer->nama ?? $customer->username, 0, 1)) }}</span>
                                </template>
                                <img x-show="photoPreviewSrc"
                                     :src="photoPreviewSrc"
                                     :alt="customerName"
                                     class="w-full h-full object-cover"
                                     x-transition:opacity>
                            </div>
                            <label class="absolute -bottom-2 -right-2 w-9 h-9 bg-yellow-500 hover:bg-yellow-600 rounded-xl flex items-center justify-center ring-3 ring-black/50 cursor-pointer transition-all duration-200 hover:scale-105 shadow-lg"
                                 title="Ganti Foto Profil">
                                <input type="file"
                                       name="foto"
                                       accept="image/jpeg,image/png,image/jpg,image/webp"
                                       class="hidden"
                                       @change="handleFileSelect($event)">
                                <i class="fas fa-camera text-white text-xs"></i>
                            </label>
                            @error('foto')
                            <p class="absolute -bottom-8 left-0 right-0 text-center text-xs text-red-400 bg-red-500/10 px-2 py-1 rounded">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="text-center sm:text-left">
                            <p class="text-white font-medium">Foto Profil</p>
                            <p class="text-gray-500 text-xs mt-1">Klik ikon kamera untuk mengganti foto. Maksimal 2MB (JPG, PNG, WEBP)</p>
                            <button type="button"
                                    @click="removePhoto()"
                                    x-show="photoPreviewSrc"
                                    class="mt-2 text-xs text-red-400 hover:text-red-300 transition-colors flex items-center gap-1 justify-center sm:justify-start">
                                <i class="fas fa-trash"></i> Hapus Foto
                            </button>
                        </div>
                    </div>

                    {{-- Profile Information Section --}}
                    <section class="mb-8">
                        <h3 class="text-lg font-semibold text-white flex items-center gap-2 mb-5" style="font-family:'Poppins',sans-serif;">
                            <div class="w-7 h-7 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                                <i class="fas fa-user text-yellow-500 text-xs"></i>
                            </div>
                            Informasi Profil
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            {{-- Nama --}}
                            <div>
                                <label for="nama" class="flex items-center gap-2 text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-2.5 block">
                                    <div class="w-6 h-6 rounded-md bg-yellow-500/10 flex items-center justify-center">
                                        <i class="fas fa-user text-yellow-500 text-[10px]"></i>
                                    </div>
                                    Nama Lengkap
                                </label>
                                <input type="text" name="nama" id="nama"
                                       value="{{ old('nama', $customer->nama) }}"
                                       class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:border-yellow-500/50 transition-all duration-200"
                                       required autofocus autocomplete="name">
                                @error('nama')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                            </div>

                            {{-- Username (Readonly) --}}
                            <div>
                                <label for="username" class="flex items-center gap-2 text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-2.5 block">
                                    <div class="w-6 h-6 rounded-md bg-yellow-500/10 flex items-center justify-center">
                                        <i class="fas fa-at text-yellow-500 text-[10px]"></i>
                                    </div>
                                    Username
                                </label>
                                <input type="text" name="username" id="username"
                                       value="{{ old('username', $customer->username) }}"
                                       class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3 text-white text-sm opacity-50 cursor-not-allowed"
                                       required readonly autocomplete="username">
                                <p class="mt-1.5 text-[11px] text-gray-600">Tidak dapat diubah.</p>
                            </div>
                        </div>
                    </section>

                    {{-- Contact Information Section --}}
                    <section class="mb-8">
                        <h3 class="text-lg font-semibold text-white flex items-center gap-2 mb-5" style="font-family:'Poppins',sans-serif;">
                            <div class="w-7 h-7 rounded-lg bg-yellow-500/10 flex items-center justify-center">
                                <i class="fas fa-address-book text-yellow-500 text-xs"></i>
                            </div>
                            Informasi Kontak
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            {{-- Email --}}
                            <div>
                                <label for="email" class="flex items-center gap-2 text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-2.5 block">
                                    <div class="w-6 h-6 rounded-md bg-yellow-500/10 flex items-center justify-center">
                                        <i class="fas fa-envelope text-yellow-500 text-[10px]"></i>
                                    </div>
                                    Email
                                </label>
                                <input type="email" name="email" id="email"
                                       value="{{ old('email', $customer->email) }}"
                                       class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:border-yellow-500/50 transition-all duration-200"
                                       required autocomplete="email">
                                @error('email')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                            </div>

                            {{-- Telepon --}}
                            <div>
                                <label for="nohp" class="flex items-center gap-2 text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-2.5 block">
                                    <div class="w-6 h-6 rounded-md bg-yellow-500/10 flex items-center justify-center">
                                        <i class="fas fa-phone text-yellow-500 text-[10px]"></i>
                                    </div>
                                    No. Telepon
                                </label>
                                <input type="tel" name="nohp" id="nohp"
                                       value="{{ old('nohp', $customer->nohp) }}"
                                       class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:border-yellow-500/50 transition-all duration-200"
                                       required autocomplete="tel" placeholder="08xxxxxxxxxx">
                                @error('nohp')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                                <p class="mt-1.5 text-[11px] text-gray-600">Format: 08xxxxxxxxxx atau +628xxxxxxxxxx</p>
                            </div>
                        </div>

                        {{-- Alamat (Full Width) --}}
                        <div class="mt-5">
                            <label for="alamat" class="flex items-center gap-2 text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-2.5 block">
                                <div class="w-6 h-6 rounded-md bg-yellow-500/10 flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-yellow-500 text-[10px]"></i>
                                </div>
                                Alamat
                            </label>
                            <textarea name="alamat" id="alamat" rows="3"
                                      class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:border-yellow-500/50 transition-all duration-200 resize-none"
                                      required autocomplete="street-address">{{ old('alamat', $customer->alamat) }}</textarea>
                            @error('alamat')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>
                    </section>

                    {{-- Password Section --}}
                    <section class="mb-8">
                        <div class="flex items-center gap-2.5 mb-5">
                            <div class="w-7 h-7 rounded-lg bg-white/5 flex items-center justify-center">
                                <i class="fas fa-shield-alt text-gray-500 text-[10px]"></i>
                            </div>
                            <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Ubah Password <span class="text-gray-600 normal-case tracking-normal">(opsional)</span></span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="password" class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-2.5 block">Password Baru</label>
                                <input type="password" name="password" id="password"
                                       class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:border-yellow-500/50 transition-all duration-200"
                                       autocomplete="new-password" placeholder="••••••••">
                                @error('password')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-2.5 block">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:border-yellow-500/50 transition-all duration-200"
                                       autocomplete="new-password" placeholder="••••••••">
                            </div>
                        </div>
                    </section>

                    {{-- Actions --}}
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-6 border-t border-white/5">
                        <button type="submit"
                                :disabled="saving"
                                class="group relative w-full sm:w-auto px-7 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-semibold rounded-full overflow-hidden transition-all duration-300 hover:shadow-lg hover:shadow-yellow-500/30 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:ring-offset-2 focus:ring-offset-black disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 disabled:hover:shadow-none">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                <template x-if="!saving">
                                    <i class="fas fa-check text-xs"></i> Simpan Perubahan
                                </template>
                                <template x-if="saving">
                                    <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Menyimpan...
                                </template>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-yellow-500 to-yellow-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </button>
                        <button type="button"
                                @click="cancelEdit()"
                                :disabled="saving"
                                class="w-full sm:w-auto px-7 py-3 bg-white/5 hover:bg-white/10 text-gray-300 font-semibold rounded-full border border-white/10 transition-all duration-300 text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                            Batal
                        </button>
                    </div>
                </form>
                </div>

            </div>

            {{-- =================== QUICK LINKS =================== --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ url('/riwayat') }}"
                   class="group glass-effect-dark rounded-2xl p-5 border border-white/5 hover:border-yellow-500/20 transition-all duration-300 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-400/10 to-yellow-600/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-file-invoice text-yellow-500"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-white font-semibold text-sm">Riwayat Transaksi</h3>
                        <p class="text-gray-500 text-xs mt-0.5 truncate">Lihat invoice dan status pesanan</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-600 group-hover:text-yellow-500 transition-colors text-xs"></i>
                </a>
                <a href="{{ route('sewa') }}"
                   class="group glass-effect-dark rounded-2xl p-5 border border-white/5 hover:border-yellow-500/20 transition-all duration-300 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-400/10 to-yellow-600/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-car text-yellow-500"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-white font-semibold text-sm">Sewa Mobil</h3>
                        <p class="text-gray-500 text-xs mt-0.5 truncate">Pesan kendaraan baru sekarang</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-600 group-hover:text-yellow-500 transition-colors text-xs"></i>
                </a>
            </div>

        </div>
    </div>
</section>

{{-- ===================== ALPINE JS COMPONENTS ===================== --}}
<script>
// Pass server data to Alpine via JSON-encoded variables
window.customerData = {
    nama: @json($customer->nama),
    username: @json($customer->username),
    email: @json($customer->email),
    nohp: @json($customer->nohp),
    alamat: @json($customer->alamat),
    foto: @json($customer->foto ? asset($customer->foto) : null),
    initial: @json(strtoupper(substr($customer->nama ?? $customer->username, 0, 1))),
    memberSince: @json('Member sejak ' . $customer->created_at->format('d M Y'))
};

function photoPreview() {
    return {
        photoPreviewSrc: window.customerData.foto || null,
        initial: window.customerData.initial,
        customerName: window.customerData.nama || window.customerData.username,
        customerEmail: window.customerData.email,
        memberSince: window.customerData.memberSince,

        handleFileSelect(event) {
            const file = event.target.files[0];
            if (!file) return;

            // Validate file type
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert('Format file tidak valid. Gunakan JPEG, PNG, JPG, atau WEBP.');
                event.target.value = '';
                return;
            }

            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                event.target.value = '';
                return;
            }

            // Create preview
            const reader = new FileReader();
            reader.onload = (e) => {
                this.photoPreviewSrc = e.target.result;
            };
            reader.readAsDataURL(file);
        },

        removePhoto() {
            this.photoPreviewSrc = null;
            const input = document.getElementById('photoInput');
            if (input) input.value = '';
        }
    }
}

function profileController() {
    return {
        isEditing: false,
        saving: false,
        customerName: window.customerData.nama || window.customerData.username,
        customerEmail: window.customerData.email,
        memberSince: window.customerData.memberSince,
        profileData: {
            nama: window.customerData.nama,
            username: window.customerData.username,
            email: window.customerData.email,
            nohp: window.customerData.nohp,
            alamat: window.customerData.alamat
        },

        initViewMode() {
            // Data is already set from window.customerData
        },

        enterEditMode() {
            this.isEditing = true;
            // Scroll to form
            this.$nextTick(() => {
                const form = document.getElementById('profileForm');
                if (form) {
                    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        },

        cancelEdit() {
            this.isEditing = false;
            // Scroll back to top of card
            this.$nextTick(() => {
                const view = document.getElementById('profileView');
                if (view) {
                    view.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        },

        async submitForm() {
            this.saving = true;
            const form = document.getElementById('profileForm');
            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // Update local data
                    this.profileData.nama = formData.get('nama');
                    this.profileData.email = formData.get('email');
                    this.profileData.nohp = formData.get('nohp');
                    this.profileData.alamat = formData.get('alamat');

                    // Update photo preview if changed
                    const photoInput = document.getElementById('photoInput');
                    if (photoInput && photoInput.files[0]) {
                        // Photo will be updated on page reload via session
                    }

                    this.isEditing = false;
                    this.showToast('success', data.message || 'Profile berhasil diperbarui.');

                    // Reload page to show updated data including photo
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.showValidationErrors(data.errors);
                    } else {
                        this.showToast('error', data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                    }
                }
            } catch (error) {
                this.showToast('error', 'Terjadi kesalahan jaringan. Silakan coba lagi.');
            } finally {
                this.saving = false;
            }
        },

        showToast(type, message) {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `fixed bottom-6 right-6 z-50 p-4 rounded-2xl flex items-center gap-3 backdrop-blur-sm shadow-lg transform transition-all duration-300 ${
                type === 'success'
                    ? 'bg-emerald-500/10 border border-emerald-500/20 text-emerald-300'
                    : 'bg-red-500/10 border border-red-500/20 text-red-300'
            }`;
            toast.innerHTML = `
                <div class="w-10 h-10 ${type === 'success' ? 'bg-emerald-500/20' : 'bg-red-500/20'} rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas ${type === 'success' ? 'fa-check' : 'fa-exclamation'} ${type === 'success' ? 'text-emerald-400' : 'text-red-400'} text-sm"></i>
                </div>
                <span class="text-sm font-medium">${message}</span>
            `;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100px)';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        },

        showValidationErrors(errors) {
            // Remove existing error messages
            document.querySelectorAll('.validation-error').forEach(el => el.remove());

            Object.keys(errors).forEach(field => {
                const input = document.getElementById(field);
                if (input) {
                    const errorEl = document.createElement('p');
                    errorEl.className = 'mt-1.5 text-xs text-red-400 validation-error';
                    errorEl.textContent = errors[field][0];
                    input.parentNode.appendChild(errorEl);
                    input.classList.add('border-red-500/50', 'focus:ring-red-500/50', 'focus:border-red-500/50');
                }
            });

            // Scroll to first error
            const firstError = document.querySelector('.validation-error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    }
}
</script>
@endsection