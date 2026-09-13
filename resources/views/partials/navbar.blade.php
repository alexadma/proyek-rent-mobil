<nav class="fixed top-0 left-0 right-0 z-[100] bg-black border-b-2 border-white/20 transition-all duration-300" id="navbar">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center justify-between gap-5">
            <!-- Logo -->
            <div class="text-center">
                <a class="text-yellow-300 text-2xl font-semibold no-underline hover:text-yellow-400 transition-colors relative group" href="/home">
                    DVJR
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-yellow-500 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a class="text-white no-underline hover:text-yellow-500 transition-colors relative group" href="{{ request()->routeIs('home') ? '#home' : '/home#home' }}">
                    Home
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-yellow-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                
                @if(auth()->check())
                    <a class="text-white no-underline hover:text-yellow-500 transition-colors relative group" href="/sewa">
                        Sewa
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-yellow-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                @else
                    <a class="text-white no-underline hover:text-yellow-500 transition-colors relative group" href="{{ route('login') }}">
                        Sewa
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-yellow-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                @endif
                
                <a class="text-white no-underline hover:text-yellow-500 transition-colors relative group" href="{{ request()->routeIs('home') ? '#about-section' : '/home#about-section' }}">
                    About
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-yellow-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                
                <a class="text-white no-underline hover:text-yellow-500 transition-colors relative group" href="{{ request()->routeIs('home') ? '#contact-section' : '/home#contact-section' }}">
                    Contact
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-yellow-500 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>
            
            <!-- Right Menu -->
            <div class="flex items-center gap-4">
                @if(auth()->check() && auth()->user())
                    <!-- User Dropdown -->
                    <div class="relative hidden md:block" id="userDropdown">
                        <button type="button" id="userDropdownButton" aria-expanded="false" class="flex items-center space-x-2 text-white hover:text-yellow-500 transition-colors">
                            <div class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center">
                                <span class="text-black font-semibold text-sm">{{ substr(auth()->user()->nama ?? auth()->user()->username, 0, 1) }}</span>
                            </div>
                            <span class="text-sm hidden lg:inline">{{ auth()->user()->nama ?? auth()->user()->username }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="userDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-black/90 backdrop-blur-sm border border-white/10 rounded-xl py-2 shadow-xl">
                            <a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-white/10 transition-colors text-white">
                                <i class="fas fa-user mr-2 text-yellow-500"></i>
                                Profile
                            </a>
                            <a href="{{ url('/riwayat') }}" class="block px-4 py-2 hover:bg-white/10 transition-colors text-white">
                                <i class="fas fa-history mr-2 text-yellow-500"></i>
                                Transaksi
                            </a>
                            <hr class="border-white/10 my-2">
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-white/10 transition-colors text-red-400">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Mobile Logout Button -->
                    <form action="{{ route('logout') }}" method="POST" class="md:hidden">
                        @csrf
                        <button type="submit" class="bg-red-800 hover:bg-red-700 text-white py-1.5 px-3 rounded-full text-sm transition-colors">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-gray-800 hover:bg-gray-700 text-white py-2 px-4 rounded-full text-sm transition-all hover:scale-105 hidden md:inline-block">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-semibold py-2 px-4 rounded-full text-sm hover:shadow-lg hover:shadow-yellow-500/50 transition-all hover:scale-105 hidden md:inline-block">
                        Register
                    </a>
                @endif
                
                <!-- Mobile Menu Button -->
                <button class="md:hidden text-white text-2xl focus:outline-none" id="mobileMenuButton">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu hidden md:hidden bg-black/95 backdrop-blur-sm border-t border-white/10 py-4 px-6" id="mobileMenu">
        <div class="flex flex-col space-y-3">
            <a href="{{ request()->routeIs('home') ? '#home' : '/home#home' }}" class="text-white hover:text-yellow-500 transition-colors py-2 px-4 hover:bg-white/5 rounded-lg" onclick="closeMobileMenu()">
                <i class="fas fa-home mr-3 text-yellow-500 w-5"></i>Home
            </a>
            
            @if(auth()->check())
                <a href="/sewa" class="text-white hover:text-yellow-500 transition-colors py-2 px-4 hover:bg-white/5 rounded-lg" onclick="closeMobileMenu()">
                    <i class="fas fa-car mr-3 text-yellow-500 w-5"></i>Sewa
                </a>
            @else
                <a href="{{ route('login') }}" class="text-white hover:text-yellow-500 transition-colors py-2 px-4 hover:bg-white/5 rounded-lg" onclick="closeMobileMenu()">
                    <i class="fas fa-car mr-3 text-yellow-500 w-5"></i>Sewa
                </a>
            @endif
            
            <a href="{{ request()->routeIs('home') ? '#about-section' : '/home#about-section' }}" class="text-white hover:text-yellow-500 transition-colors py-2 px-4 hover:bg-white/5 rounded-lg" onclick="closeMobileMenu()">
                <i class="fas fa-info-circle mr-3 text-yellow-500 w-5"></i>About
            </a>
            
            <a href="{{ request()->routeIs('home') ? '#contact-section' : '/home#contact-section' }}" class="text-white hover:text-yellow-500 transition-colors py-2 px-4 hover:bg-white/5 rounded-lg" onclick="closeMobileMenu()">
                <i class="fas fa-envelope mr-3 text-yellow-500 w-5"></i>Contact
            </a>
            
            @if(!auth()->check())
                <hr class="border-white/10 my-2">
                <a href="{{ route('login') }}" class="text-white hover:text-yellow-500 transition-colors py-2 px-4 hover:bg-white/5 rounded-lg" onclick="closeMobileMenu()">
                    <i class="fas fa-sign-in-alt mr-3 text-yellow-500 w-5"></i>Login
                </a>
                <a href="{{ route('register') }}" class="text-white hover:text-yellow-500 transition-colors py-2 px-4 hover:bg-white/5 rounded-lg" onclick="closeMobileMenu()">
                    <i class="fas fa-user-plus mr-3 text-yellow-500 w-5"></i>Register
                </a>
            @else
                <hr class="border-white/10 my-2">
                <a href="{{ route('profile') }}" class="text-white hover:text-yellow-500 transition-colors py-2 px-4 hover:bg-white/5 rounded-lg" onclick="closeMobileMenu()">
                    <i class="fas fa-user mr-3 text-yellow-500 w-5"></i>Profile
                </a>
                <a href="{{ url('/riwayat') }}" class="text-white hover:text-yellow-500 transition-colors py-2 px-4 hover:bg-white/5 rounded-lg" onclick="closeMobileMenu()">
                    <i class="fas fa-history mr-3 text-yellow-500 w-5"></i>Transaksi
                </a>
                <form action="{{ route('logout') }}" method="POST" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left text-white hover:text-red-400 transition-colors py-2 px-4 hover:bg-white/5 rounded-lg">
                        <i class="fas fa-sign-out-alt mr-3 text-red-500 w-5"></i>Logout
                    </button>
                </form>
            @endif
        </div>
    </div>
</nav>

<!-- Add Font Awesome if not already included -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
/* Navbar scroll effect */
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

/* Responsive adjustments */
@media (max-width: 768px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}

/* Smooth scrolling for anchor links */
html {
    scroll-behavior: smooth;
    scroll-padding-top: 80px; /* Account for fixed navbar */
}
</style>

<script>
// Navbar scroll effect
window.addEventListener('scroll', function() {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Mobile menu toggle
const mobileMenuButton = document.getElementById('mobileMenuButton');
const mobileMenu = document.getElementById('mobileMenu');

// User menu toggle
const userDropdown = document.getElementById('userDropdown');
const userDropdownButton = document.getElementById('userDropdownButton');
const userDropdownMenu = document.getElementById('userDropdownMenu');

if (userDropdown && userDropdownButton && userDropdownMenu) {
    userDropdownButton.addEventListener('click', function (event) {
        event.stopPropagation();
        const isOpen = !userDropdownMenu.classList.contains('hidden');
        userDropdownMenu.classList.toggle('hidden', isOpen);
        userDropdownButton.setAttribute('aria-expanded', String(!isOpen));
    });

    document.addEventListener('click', function (event) {
        if (!userDropdown.contains(event.target)) {
            userDropdownMenu.classList.add('hidden');
            userDropdownButton.setAttribute('aria-expanded', 'false');
        }
    });
}

function toggleMobileMenu() {
    mobileMenu.classList.toggle('open');
    
    // Change icon based on menu state
    const icon = mobileMenuButton.querySelector('i');
    if (mobileMenu.classList.contains('open')) {
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-times');
    } else {
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
    }
}

function closeMobileMenu() {
    mobileMenu.classList.remove('open');
    const icon = mobileMenuButton.querySelector('i');
    icon.classList.remove('fa-times');
    icon.classList.add('fa-bars');
}

mobileMenuButton.addEventListener('click', toggleMobileMenu);

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const isClickInsideNav = event.target.closest('nav');
    const isMobileMenuOpen = mobileMenu.classList.contains('open');
    
    if (!isClickInsideNav && isMobileMenuOpen) {
        closeMobileMenu();
    }
});

// Handle active link highlighting
const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('.nav-link');

function highlightActiveLink() {
    const scrollY = window.pageYOffset;
    
    sections.forEach(section => {
        const sectionHeight = section.offsetHeight;
        const sectionTop = section.offsetTop - 100;
        const sectionId = section.getAttribute('id');
        
        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${sectionId}`) {
                    link.classList.add('active');
                }
            });
        }
    });
}

window.addEventListener('scroll', highlightActiveLink);

// Prevent default anchor click behavior and add smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            
            // Close mobile menu if open
            closeMobileMenu();
        }
    });
});

// Initial check for active link
highlightActiveLink();
</script>