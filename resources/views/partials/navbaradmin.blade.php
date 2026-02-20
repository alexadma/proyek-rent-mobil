<!-- component -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/dist/tailwind.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900">
    <!-- <span class="absolute text-white text-4xl top-5 left-4 cursor-pointer" onclick="openSidebar()">
        <i class="bi bi-filter-left px-2 bg-gray-900 rounded-md"></i>
    </span> -->

    <!-- Sidebar awal -->
    <div class="sidebar fixed top-0 bottom-0 lg:left-0 p-2 w-[300px] overflow-y-auto text-center bg-gray-900">
        <div class="text-gray-100 text-xl">
            <div class="p-2.5 mt-1 flex items-center">
                <i class="bi bi-app-indicator px-2 py-1 rounded-md bg-blue-600"></i>
                <h1 class="font-bold text-yellow-300 text-[15px] ml-3">DVJR</h1>
                <i class="bi bi-x cursor-pointer ml-28 lg:hidden" onclick="openSidebar()"></i>
            </div>
            <div class="my-2 bg-gray-600 h-[1px]"></div>
        </div>
        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-gray-800 text-white">
            <i class="fas fa-home"></i>
            <li class="nav-item list-none">
                <a href="{{ route('home.admin') }}" class="nav-link hover:bg-gray-800 text-white font-bold py-2 px-4 rounded inline-block transition duration-300 text-xl">
                    <span class="text-[15px] text-gray-200 font-bold text-lg">
                        {{ __('Dasbor') }}
                    </span>
                </a>
            </li>
        </div>
        <div class="my-2 bg-gray-600 h-[1px]"></div>
        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-gray-800 text-xl" onclick="dropdown('sewa')">
            <i class="fas fa-book text-white"></i>
            <div class="flex justify-between w-full items-center">
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Sewa</span>
                <span class="text-sm rotate-180" id="arrow-sewa">
                    <i class="bi bi-chevron-down text-white"></i>
                </span>
            </div>
        </div>
        <div class="text-left text-sm mt-2 w-full mx-auto text-gray-200 font-bold" id="submenu-sewa">
            <li class="nav-item list-none">
                <a href="{{ route('transaksi') }}" class="nav-link bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block transition duration-300 text-xl">
                    <span class="text-[15px] ml-4 text-gray-200 font-bold text-lg">
                        <i class="nav-icon fas fa-check-circle"></i>
                        {{ __('Daftar Transaksi') }}
                    </span>
                </a>
            </li>
            <li class="nav-item list-none">
                <a href="{{ route('pengembalian') }}" class="nav-link bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block transition duration-300 text-xl">
                    <span class="text-[15px] ml-4 text-gray-200 font-bold text-lg">
                        <i class="nav-icon fas fa-arrow-left"></i>
                        {{ __('Pengembalian') }}
                    </span>
                </a>
            </li>
        </div>

        <div class="my-2 bg-gray-600 h-[1px]"></div>
        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer text-white hover:bg-gray-800" onclick="dropdown('edit')">
            <i class="fas fa-pencil-alt"></i>
            <div class="flex justify-between w-full items-center">
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Edit</span>
                <span class="text-sm rotate-180" id="arrow-edit">
                    <i class="bi bi-chevron-down text-white "></i>
                </span>
            </div>
        </div>
        <div class="text-left text-sm mt-2 w-full mx-auto text-gray-200 font-bold" id="submenu-edit">
            <li class="nav-item list-none">
                <a href="/supir" class="nav-link bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block transition duration-300 text-xl">
                    <span class="text-[15px] ml-4 text-gray-200 font-bold text-lg">
                        <i class="nav-icon fa fa-user"></i>
                        {{ __('Supir') }}
                    </span>
                </a>
            </li>
            <li class="nav-item list-none">
                <a href="/mobil" class="nav-link bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block transition duration-300 text-xl">
                    <span class="text-[15px] ml-4 text-gray-200 font-bold text-lg">
                        <i class="nav-icon fa fa-car"></i>
                        {{ __('Mobil') }}
                    </span>
                </a>
            </li>
        </div>
        <div class="my-2 bg-gray-600 h-[1px]"></div>
        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-gray-800" onclick="dropdown('keuangan')">
            <i class="fas fa-money-bill-wave text-white"></i>
            <div class="flex justify-between w-full items-center">
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Keuangan</span>
                <span class="text-sm rotate-180" id="arrow-keuangan">
                    <i class="bi bi-chevron-down text-white"></i>
                </span>
            </div>
        </div>
        <div class="w-full text-left text-sm mt-2 ml-3 mx-auto text-gray-200 font-bold" id="submenu-keuangan">
            <li class="nav-item list-none">
                <a href="{{ route('keuangan') }}" class="nav-link bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block transition duration-300 text-xl">
                    <span class="text-[15px] ml-4 text-gray-200 font-bold text-lg">
                        <i class="nav-icon fas fa-calendar"></i>
                        {{ __('Pemasukan') }}
                    </span>
                </a>
            </li>     
        </div>
        <!-- Tombol Logout -->
        <div class="absolute bottom-0 left-0 w-full">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center rounded-md px-3 py-3 duration-300 cursor-pointer hover:bg-red-600 text-white">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="text-sm ml-2 text-gray-200 font-bold">Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Akhir Sidebar -->


    <script type="text/javascript">
        function dropdown(menu) {
            const submenu = document.querySelector(`#submenu-${menu}`);
            const arrow = document.querySelector(`#arrow-${menu}`);
            submenu.classList.toggle("hidden");
            arrow.classList.toggle("rotate-180");
        }

        // Hide all submenus when the page loads
        document.addEventListener("DOMContentLoaded", function() {
            const allSubmenus = document.querySelectorAll('[id^="submenu-"]');
            allSubmenus.forEach((submenu) => {
                submenu.classList.add("hidden");
            });
        });

        // function openSidebar() {
        //     document.querySelector(".sidebar").classList.toggle("hidden");
        // }
    </script>
</body>

</html>