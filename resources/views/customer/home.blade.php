@extends('layouts.main')

@section('container')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Video/Image -->
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/70 to-transparent z-10"></div>
        <img src="https://images.unsplash.com/photo-1494976388531-d1058494cdd8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
             alt="Hero Background" 
             class="w-full h-full object-cover animate-kenburns">
    </div>
    
    <!-- Hero Content -->
    <div class="relative z-20 container mx-auto px-4 sm:px-6 lg:px-8 py-32">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div data-aos="fade-right" data-aos-delay="200">
                <div class="inline-flex items-center bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 mb-6 border border-yellow-500/30">
                    <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse mr-2"></span>
                    <span class="text-sm font-medium text-yellow-500">Premium Car Rental Service</span>
                </div>
                
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold leading-tight mb-6">
                    <span id="typed-output" class="gradient-text"></span>
                    <br>
                    <span class="text-white">Solusi Sewa Mobil</span>
                    <br>
                    <span class="bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">Cepat & Terpercaya</span>
                </h1>
                
                <p class="text-lg text-gray-300 mb-8 max-w-lg" data-aos="fade-right" data-aos-delay="400">
                    Nikmati pengalaman berkendara terbaik dengan armada mobil premium kami. 
                    Layanan 24/7 dengan harga kompetitif dan driver profesional.
                </p>
                
                <div class="flex flex-wrap gap-4" data-aos="fade-right" data-aos-delay="600">
                    <a href="/daftarmobil" 
                       class="group relative px-8 py-4 bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-semibold rounded-full overflow-hidden transition-all duration-300 hover:shadow-lg hover:shadow-yellow-500/50 hover:scale-105">
                        <span class="relative z-10">Lihat Daftar Mobil</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-yellow-500 to-yellow-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                    
                    <a href="#about-section" 
                       class="group px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-full border border-white/20 hover:bg-white/20 transition-all duration-300 hover:scale-105">
                        <i class="fas fa-play mr-2 text-yellow-500 group-hover:animate-pulse"></i>
                        Tentang Kami
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-3 gap-8 mt-12 pt-8 border-t border-white/10" data-aos="fade-up" data-aos-delay="800">
                    <div>
                        <div class="text-3xl font-bold gradient-text">500+</div>
                        <div class="text-sm text-gray-400">Mobil Tersedia</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold gradient-text">1000+</div>
                        <div class="text-sm text-gray-400">Pelanggan Puas</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold gradient-text">24/7</div>
                        <div class="text-sm text-gray-400">Layanan</div>
                    </div>
                </div>
            </div>
            
            <div class="relative" data-aos="fade-left" data-aos-delay="400">
                <!-- Floating Car Image -->
                <div class="relative floating">
                    <img src="https://i.pinimg.com/564x/34/49/10/344910343716de41e27f92a6c0320708.jpg" 
                         alt="Premium Car" 
                         class="relative z-10 w-full max-w-lg mx-auto rounded-2xl shadow-2xl">
                    
                    <!-- Decorative Elements -->
                    <div class="absolute -top-6 -right-6 w-32 h-32 bg-yellow-500/20 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-yellow-500/20 rounded-full blur-2xl"></div>
                    
                    <!-- Badge -->
                    <div class="absolute -top-4 -right-4 z-20 bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-bold px-4 py-2 rounded-full shadow-xl animate-bounce">
                        <i class="fas fa-star mr-1"></i>
                        Premium Quality
                    </div>
                </div>
                
                <!-- Features List -->
                <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 w-[90%] glass-effect-dark rounded-2xl p-4 backdrop-blur-md">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="text-yellow-500 text-xl mb-1"><i class="fas fa-wifi"></i></div>
                            <div class="text-xs text-gray-300">Free WiFi</div>
                        </div>
                        <div class="text-center">
                            <div class="text-yellow-500 text-xl mb-1"><i class="fas fa-snowflake"></i></div>
                            <div class="text-xs text-gray-300">AC Dingin</div>
                        </div>
                        <div class="text-center">
                            <div class="text-yellow-500 text-xl mb-1"><i class="fas fa-shield-alt"></i></div>
                            <div class="text-xs text-gray-300">Asuransi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 animate-bounce">
        <a href="#about-section" class="text-white/60 hover:text-white transition-colors">
            <i class="fas fa-chevron-down text-2xl"></i>
        </a>
    </div>
</section>

<!-- About Section -->
<section id="about-section" class="py-24 relative overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div data-aos="fade-right">
                <span class="text-yellow-500 font-semibold text-sm tracking-wider uppercase mb-4 block">Tentang Kami</span>
                <h2 class="text-4xl lg:text-5xl font-bold mb-6">
                    Pengalaman Terbaik Dalam
                    <span class="gradient-text">Setiap Perjalanan</span>
                </h2>
                
                <div class="space-y-4 text-gray-300">
                    <p class="leading-relaxed">
                        Kami adalah perusahaan rental mobil premium yang berdedikasi untuk memberikan solusi 
                        transportasi terbaik di Sukabumi. Dengan pengalaman bertahun-tahun, kami memahami bahwa 
                        setiap perjalanan memiliki cerita uniknya sendiri.
                    </p>
                    
                    <p class="leading-relaxed">
                        DJVR.com menyediakan berbagai pilihan unit mobil terawat dan nyaman untuk perjalanan 
                        wisata maupun bisnis Anda. Setiap mobil kami dilengkapi dengan fitur terkini dan 
                        didukung oleh driver profesional yang ramah dan berpengalaman.
                    </p>
                </div>
                
                <!-- Features Grid -->
                <div class="grid grid-cols-2 gap-4 mt-8">
                    <div class="glass-effect-dark p-4 rounded-xl hover:scale-105 transition-transform">
                        <div class="text-yellow-500 text-2xl mb-2"><i class="fas fa-car"></i></div>
                        <h4 class="font-semibold">Armada Baru</h4>
                        <p class="text-sm text-gray-400">Unit < 2 tahun</p>
                    </div>
                    
                    <div class="glass-effect-dark p-4 rounded-xl hover:scale-105 transition-transform">
                        <div class="text-yellow-500 text-2xl mb-2"><i class="fas fa-clock"></i></div>
                        <h4 class="font-semibold">24/7 Layanan</h4>
                        <p class="text-sm text-gray-400">Siap melayani</p>
                    </div>
                    
                    <div class="glass-effect-dark p-4 rounded-xl hover:scale-105 transition-transform">
                        <div class="text-yellow-500 text-2xl mb-2"><i class="fas fa-map-marked-alt"></i></div>
                        <h4 class="font-semibold">Luar Kota</h4>
                        <p class="text-sm text-gray-400">Perjalanan jauh</p>
                    </div>
                    
                    <div class="glass-effect-dark p-4 rounded-xl hover:scale-105 transition-transform">
                        <div class="text-yellow-500 text-2xl mb-2"><i class="fas fa-headset"></i></div>
                        <h4 class="font-semibold">Support</h4>
                        <p class="text-sm text-gray-400">Responsif 24 jam</p>
                    </div>
                </div>
            </div>
            
            <div class="relative" data-aos="fade-left">
                <div class="relative rounded-2xl overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                         alt="Our Team" 
                         class="w-full h-auto">
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                    
                    <!-- Experience Badge -->
                    <div class="absolute bottom-6 left-6 glass-effect-dark rounded-xl p-4">
                        <div class="text-3xl font-bold text-yellow-500">10+</div>
                        <div class="text-sm text-gray-300">Tahun Pengalaman</div>
                    </div>
                </div>
                
                <!-- Decorative Pattern -->
                <div class="absolute -z-10 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-72 h-72 bg-yellow-500/20 rounded-full blur-3xl"></div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-24 bg-gradient-to-b from-transparent to-white/5">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
            <span class="text-yellow-500 font-semibold text-sm tracking-wider uppercase mb-4 block">Keunggulan Kami</span>
            <h2 class="text-4xl lg:text-5xl font-bold mb-6">
                Mengapa Memilih
                <span class="gradient-text">Kami?</span>
            </h2>
            <p class="text-gray-400">
                Kami memberikan pelayanan terbaik dengan berbagai keunggulan yang membuat pengalaman sewa mobil Anda menjadi lebih menyenangkan.
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Feature Cards -->
            @php
            $features = [
                [
                    'icon' => 'fa-solid fa-shield-halved',
                    'title' => 'Terpercaya',
                    'desc' => 'Legalitas jelas dan terjamin'
                ],
                [
                    'icon' => 'fa-solid fa-bolt',
                    'title' => 'Cepat',
                    'desc' => 'Proses booking instan'
                ],
                [
                    'icon' => 'fa-solid fa-tag',
                    'title' => 'Harga Bersaing',
                    'desc' => 'Termurah di Sukabumi'
                ],
                [
                    'icon' => 'fa-solid fa-hand-holding-heart',
                    'title' => 'Pelayanan Prima',
                    'desc' => 'Customer service ramah'
                ]
            ];
            @endphp
            
            @foreach($features as $feature)
            <div class="group glass-effect-dark rounded-2xl p-6 hover:scale-105 transition-all duration-300 hover:shadow-xl hover:shadow-yellow-500/10" 
                 data-aos="fade-up" 
                 data-aos-delay="{{ $loop->index * 100 }}">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="{{ $feature['icon'] }} text-black text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">{{ $feature['title'] }}</h3>
                <p class="text-gray-400 text-sm">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Contact & Map Section -->
<section id="contact-section" class="py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-start">
            <!-- Contact Info -->
            <div data-aos="fade-right">
                <span class="text-yellow-500 font-semibold text-sm tracking-wider uppercase mb-4 block">Hubungi Kami</span>
                <h2 class="text-4xl lg:text-5xl font-bold mb-6">
                    Siap Melayani
                    <span class="gradient-text">Kebutuhan Anda</span>
                </h2>
                <p class="text-gray-400 mb-8">
                    Ada pertanyaan? Tim kami siap membantu Anda 24/7. Hubungi kami melalui kontak di bawah ini.
                </p>
                
                <!-- Contact Cards -->
                <div class="space-y-4">
                    <div class="glass-effect-dark rounded-xl p-4 flex items-center gap-4 hover:scale-105 transition-transform">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-black text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-sm text-gray-400">Alamat</h4>
                            <p class="font-semibold">Griya Selabumi Indah Blok H-18, Sukabumi</p>
                        </div>
                    </div>
                    
                    <div class="glass-effect-dark rounded-xl p-4 flex items-center gap-4 hover:scale-105 transition-transform">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-phone-alt text-black text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-sm text-gray-400">Telepon</h4>
                            <p class="font-semibold">+62 815 6363 6166</p>
                        </div>
                    </div>
                    
                    <div class="glass-effect-dark rounded-xl p-4 flex items-center gap-4 hover:scale-105 transition-transform">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-envelope text-black text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-sm text-gray-400">Email</h4>
                            <p class="font-semibold">DJVR@gmail.com</p>
                        </div>
                    </div>
                    
                    <div class="glass-effect-dark rounded-xl p-4 flex items-center gap-4 hover:scale-105 transition-transform">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-black text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-sm text-gray-400">Jam Operasional</h4>
                            <p class="font-semibold">Senin - Minggu, 24 Jam</p>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div class="mt-8">
                    <h4 class="font-semibold mb-4">Ikuti Kami</h4>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-yellow-500 hover:text-black transition-all hover:scale-110">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-yellow-500 hover:text-black transition-all hover:scale-110">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-yellow-500 hover:text-black transition-all hover:scale-110">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-yellow-500 hover:text-black transition-all hover:scale-110">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Map -->
            <div class="relative group" data-aos="fade-left">
                <div class="glass-effect-dark rounded-2xl p-2 overflow-hidden">
                    <div class="rounded-xl overflow-hidden">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.603494981789!2d106.922277!3d-6.913957!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e684b8b0b0b0b0b%3A0x0!2zNsKwNTUnMDEuMiJTIDEwNsKwNTUnMjQuNCJF!5e0!3m2!1sen!2sid!4v1634567890123!5m2!1sen!2sid"
                            width="100%" 
                            height="450" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy"
                            class="w-full h-[450px] filter grayscale hover:grayscale-0 transition-all duration-500">
                        </iframe>
                    </div>
                </div>
                
                <!-- Map Overlay -->
                <div class="absolute top-4 right-4 glass-effect rounded-lg px-4 py-2 text-sm">
                    <i class="fas fa-location-dot text-yellow-500 mr-2"></i>
                    Klik untuk rute
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 relative overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-effect-dark rounded-3xl p-12 relative overflow-hidden" data-aos="zoom-in">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-yellow-500 rounded-full"></div>
                <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-yellow-600 rounded-full"></div>
            </div>
            
            <div class="relative z-10 text-center max-w-3xl mx-auto">
                <h2 class="text-3xl lg:text-4xl font-bold mb-4">
                    Siap Untuk Perjalanan Anda?
                </h2>
                <p class="text-gray-300 mb-8">
                    Booking sekarang dan dapatkan promo spesial untuk penyewaan pertama Anda!
                </p>
                <div class="flex flex-wrap gap-4 justify-center">
                    <a href="/sewa" 
                       class="px-8 py-4 bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-semibold rounded-full hover:shadow-lg hover:shadow-yellow-500/50 transition-all hover:scale-105">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Booking Sekarang
                    </a>
                    <a href="/daftarmobil" 
                       class="px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-full border border-white/20 hover:bg-white/20 transition-all hover:scale-105">
                        <i class="fas fa-car mr-2"></i>
                        Lihat Mobil
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Typed.js Initialization
    document.addEventListener('DOMContentLoaded', function() {
        var options = {
            strings: ['DVJR RentCar', 'Premium Service', 'Your Trusted Partner'],
            typeSpeed: 50,
            backSpeed: 30,
            backDelay: 2000,
            startDelay: 500,
            loop: true,
            showCursor: true,
            cursorChar: '|',
            autoInsertCss: true
        };
        
        new Typed('#typed-output', options);
    });
    
    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>
@endpush
@endsection