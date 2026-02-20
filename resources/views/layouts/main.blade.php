<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>DVJR Rent Cars | Premium Car Rental</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        
        /* Glassmorphism Effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .glass-effect-dark {
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        /* Smooth Transitions */
        .hover-scale {
            transition: transform 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.05);
        }
        
        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Animated Background */
        .animated-bg {
            background: linear-gradient(-45deg, #000000, #1a1a1a, #2d2d2d, #000000);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Floating Animation */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        /* Navbar Styles */
        nav {
            transition: all 0.3s ease;
        }
        
        nav.scrolled {
            background-color: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            border-bottom-color: rgba(251, 191, 36, 0.3);
        }
        
        /* Mobile menu animation */
        .mobile-menu {
            transition: all 0.3s ease-in-out;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            padding-top: 0;
            padding-bottom: 0;
        }
        
        .mobile-menu.open {
            max-height: 500px;
            opacity: 1;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        
        /* Active link indicator */
        .nav-link.active {
            color: #fbbf24;
        }
        
        .nav-link.active span {
            width: 100%;
        }
        
        /* Smooth scrolling for anchor links */
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px;
        }
        
        /* Footer Styles */
        .footer {
            position: relative;
            overflow: hidden;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            html {
                scroll-padding-top: 70px;
            }
        }
        
        /* Loading Animation */
        .loader {
            width: 48px;
            height: 48px;
            border: 5px solid #FFF;
            border-bottom-color: #fbbf24;
            border-radius: 50%;
            display: inline-block;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }
        
        @keyframes rotation {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Animation Delays */
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        
        /* Ken Burns Effect */
        @keyframes kenburns {
            0% { transform: scale(1); }
            100% { transform: scale(1.1); }
        }
        
        .animate-kenburns {
            animation: kenburns 20s ease alternate infinite;
        }
    </style>
</head>

<body class="bg-black text-white antialiased overflow-x-hidden">
    <!-- Animated Background -->
    <div class="animated-bg fixed inset-0 -z-10"></div>
    
    <!-- Floating Particles -->
    <div class="fixed inset-0 -z-5 opacity-20 pointer-events-none">
        <div class="absolute top-20 left-10 w-64 h-64 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-orange-500 rounded-full mix-blend-multiply filter blur-3xl animate-pulse animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-yellow-300 rounded-full mix-blend-multiply filter blur-3xl animate-pulse animation-delay-4000"></div>
    </div>
    
    <!-- Navigation -->
    @include('partials.navbar')
    
    <!-- Main Content -->
    <main class="relative z-10">
        @yield('container')
    </main>
    
    <!-- Footer (Inline - karena partials.footer tidak ada) -->
    <footer class="footer relative pt-24 pb-8 mt-24">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5 pointer-events-none">
            <div class="absolute top-0 left-0 w-64 h-64 bg-yellow-500 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-yellow-500 rounded-full filter blur-3xl"></div>
        </div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Main Footer -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Company Info -->
                <div data-aos="fade-up">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-car text-black text-xl"></i>
                        </div>
                        <span class="text-xl font-bold gradient-text">DVJR Rent Cars</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4">
                        Solusi terbaik untuk kebutuhan rental mobil Anda di Sukabumi. Pelayanan profesional dengan armada berkualitas.
                    </p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center hover:bg-yellow-500 hover:text-black transition-all">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center hover:bg-yellow-500 hover:text-black transition-all">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center hover:bg-yellow-500 hover:text-black transition-all">
                            <i class="fab fa-twitter text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center hover:bg-yellow-500 hover:text-black transition-all">
                            <i class="fab fa-whatsapp text-sm"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="/home" class="text-gray-400 hover:text-yellow-500 transition-colors flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-yellow-500"></i>
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#about-section" class="text-gray-400 hover:text-yellow-500 transition-colors flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-yellow-500"></i>
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="/daftarmobil" class="text-gray-400 hover:text-yellow-500 transition-colors flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-yellow-500"></i>
                                Our Cars
                            </a>
                        </li>
                        <li>
                            <a href="/sewa" class="text-gray-400 hover:text-yellow-500 transition-colors flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-yellow-500"></i>
                                Booking
                            </a>
                        </li>
                        <li>
                            <a href="#contact-section" class="text-gray-400 hover:text-yellow-500 transition-colors flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-yellow-500"></i>
                                Contact
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Services -->
                <div data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-lg font-semibold mb-4">Layanan</h3>
                    <ul class="space-y-2">
                        <li class="text-gray-400 flex items-center">
                            <i class="fas fa-check text-yellow-500 text-xs mr-2"></i>
                            Sewa Mobil Harian
                        </li>
                        <li class="text-gray-400 flex items-center">
                            <i class="fas fa-check text-yellow-500 text-xs mr-2"></i>
                            Sewa Mobil Mingguan
                        </li>
                        <li class="text-gray-400 flex items-center">
                            <i class="fas fa-check text-yellow-500 text-xs mr-2"></i>
                            Sewa Mobil Bulanan
                        </li>
                        <li class="text-gray-400 flex items-center">
                            <i class="fas fa-check text-yellow-500 text-xs mr-2"></i>
                            Sewa Mobil + Driver
                        </li>
                        <li class="text-gray-400 flex items-center">
                            <i class="fas fa-check text-yellow-500 text-xs mr-2"></i>
                            Sewa Mobil Lepas Kunci
                        </li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div data-aos="fade-up" data-aos-delay="300">
                    <h3 class="text-lg font-semibold mb-4">Kontak Kami</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start text-gray-400">
                            <i class="fas fa-map-marker-alt text-yellow-500 mt-1 mr-3"></i>
                            <span>Griya Selabumi Indah Blok H-18, Sukabumi</span>
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-phone-alt text-yellow-500 mr-3"></i>
                            <span>+62 815 6363 6166</span>
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-envelope text-yellow-500 mr-3"></i>
                            <span>DJVR@gmail.com</span>
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-clock text-yellow-500 mr-3"></i>
                            <span>24 Jam / 7 Hari</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="border-t border-white/10 pt-8 text-center">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} DVJR Rent Cars. All rights reserved. | 
                    <a href="#" class="hover:text-yellow-500 transition-colors">Privacy Policy</a> | 
                    <a href="#" class="hover:text-yellow-500 transition-colors">Terms of Service</a>
                </p>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100,
            easing: 'ease-in-out'
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (navbar) {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>