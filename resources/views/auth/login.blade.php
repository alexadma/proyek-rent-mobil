<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-indigo-500 rounded-full opacity-10 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-purple-500 rounded-full opacity-10 blur-3xl"></div>
        
        <!-- Logo or Brand -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                Selamat Datang Kembali
            </h2>
            <p class="text-sm text-gray-400 mt-2">Silakan masuk ke akun Anda</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Username Field -->
            <div class="group">
                <x-input-label for="username" :value="__('Username')" class="text-sm font-medium text-gray-300 group-focus-within:text-indigo-400 transition-colors duration-200" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-400 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <x-text-input 
                        id="username" 
                        class="block w-full pl-10 pr-3 py-3 bg-gray-800/50 border-2 border-gray-700 rounded-xl text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200" 
                        type="text" 
                        name="username" 
                        :value="old('username')" 
                        required 
                        autofocus 
                        autocomplete="username"
                        placeholder="Masukkan username Anda" 
                    />
                </div>
                <x-input-error :messages="$errors->get('username')" class="mt-2 text-sm text-red-400" />
            </div>

            <!-- Password Field with Toggle -->
            <div class="group" x-data="{ showPassword: false }">
                <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-300 group-focus-within:text-indigo-400 transition-colors duration-200" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-400 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    
                    <!-- Password Input -->
                    <input 
                        :type="showPassword ? 'text' : 'password'"
                        id="password" 
                        class="block w-full pl-10 pr-12 py-3 bg-gray-800/50 border-2 border-gray-700 rounded-xl text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200"
                        name="password"
                        required 
                        autocomplete="current-password"
                        placeholder="Masukkan password Anda"
                    />
                    
                    <!-- Toggle Password Visibility Button -->
                    <button 
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-indigo-400 focus:outline-none transition-colors duration-200"
                        :class="{ 'text-indigo-400': showPassword }"
                    >
                        <!-- Eye Icon (Visible) -->
                        <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        
                        <!-- Eye Off Icon (Hidden) -->
                        <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-400" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center space-x-2 cursor-pointer group">
                    <input id="remember_me" type="checkbox" class="w-4 h-4 bg-gray-800 border-2 border-gray-700 rounded-md text-indigo-500 focus:ring-indigo-500 focus:ring-offset-0 focus:ring-2 transition-colors duration-200 cursor-pointer" name="remember">
                    <span class="text-sm text-gray-300 group-hover:text-white transition-colors duration-200">{{ __('Ingat saya') }}</span>
                </label>

                @if (Route::has('password.request'))
                <a class="text-sm text-gray-400 hover:text-indigo-400 transition-colors duration-200 font-medium" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col space-y-3">
                <x-primary-button class="w-full justify-center py-3 px-4 bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-xl hover:shadow-indigo-500/30 transform hover:scale-[1.02] transition-all duration-200">
                    <span class="flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        <span>{{ __('Masuk') }}</span>
                    </span>
                </x-primary-button>

                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-gray-900 text-gray-400">atau</span>
                    </div>
                </div>

                <a href="{{ route('register') }}" class="w-full text-center py-3 px-4 bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white font-semibold rounded-xl border-2 border-gray-700 hover:border-gray-600 transition-all duration-200 transform hover:scale-[1.02]">
                    {{ __('Buat Akun Baru') }}
                </a>
            </div>
        </form>

    <!-- Add Alpine.js for the toggle functionality -->
    <script src="//unpkg.com/alpinejs" defer></script>
</x-guest-layout>