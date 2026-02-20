<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Document</title>
    <style>
        nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background-color: black;
            padding: 10px 0;
            border-bottom: 2px solid white;
        }
    </style>
</head>

<body>
<nav class="top-0 z-100 fixed w-full bg-black py-3 px-5 border-b-2">
    <div class="container mx-auto px-6 md:px-12">
        <div class="flex items-center gap-5 justify-between">
            <div class="text-center">
                <a class="text-yellow-300 text-2xl font-semibold no-underline" href="/home">DVJR</a>
            </div>
            <div class="hidden md:flex items-center space-x-10">
                <a class="text-white no-underline hover:text-yellow-500" href="#home">Home</a>
                @if(auth()->check())
                    <a class="text-white no-underline hover:text-yellow-500" href="/sewa">Sewa</a>
                @else
                    <a class="text-white no-underline hover:text-yellow-500" href="{{ route('login') }}">Sewa</a>
                @endif
                <a class="text-white block no-underline hover:text-yellow-500" href="#about-section">About</a>
                <a class="text-white block no-underline hover:text-yellow-500" href="#contact-section">Contact</a>
            </div>
            <div class="md:hidden flex items-center">
                <button class="mobile-menu-button">
                    <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            <div class="ml-auto">
                @if(auth()->user())
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-800 hover:bg-red-700 text-white py-1 px-3 rounded-full">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-gray-800 hover:bg-gray-700 text-white  py-2 px-4 rounded-full">
                        Login
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="mobile-menu hidden md:hidden">
        <a href="#home" class="block py-2 px-4 text-sm text-white">Home</a>
        <a href="/sewa" class="block py-2 px-4 text-sm text-white">Sewa</a>
        <a href="#about-section" class="block py-2 px-4 text-sm text-white">About</a>
        <a href="#contact-section" class="block py-2 px-4 text-sm text-white">Contact</a>
    </div>
</nav>

<script>
    document.querySelector('.mobile-menu-button').addEventListener('click', function() {
    document.querySelector('.mobile-menu').classList.toggle('hidden');
});
</script>
</body>

</html>