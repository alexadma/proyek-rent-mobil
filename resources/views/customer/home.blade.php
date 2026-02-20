@extends('layouts.main')

@section('container')

<section class="" id="home">
    <div class=" text-white min-h-screen">
        <div class="mx-auto flex flex-col md:flex-row items-center py-32 my-0 md:my-24">
            <div class="mx-auto flex flex-col w-full lg:w-2/3 justify-start items-start p-0">
                <h1 id="typed-output" class="text-3xl md:text-6xl text-yellow-300 tracking-loose"><span id="insertion-point"></span></h1>
                <h2 id="animated-h2" class="text-3xl md:text-5xl leading-relaxed md:leading-snug mb-2">Solusi Sewa Mobil Cepat Untuk Kebutuhan Anda</h2>

                <div data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="3000" data-aos-offset="0">
                    <p class="text-sm md:text-base text-gray-50 mb-4">Klik di bawah ini untuk melihat Daftar Mobil</p>
                    <a href="/daftarmobil" class="bg-transparent no-underline hover:bg-yellow-300 text-yellow-300 hover:text-white rounded shadow hover:shadow-lg py-2 px-4 border border-yellow-300 hover:border-transparent">
                        Daftar Mobil</a>
                </div>
            </div>
            <div class="p-1  mb-6 md:mb-0 md:mt-0 mt-0 ml-0 md:ml-0 lg:w-2/3 justify-center">
                <div class="h-70 flex flex-row-reverse content-center">
                    <div>
                        <img class="top-0 rounded-es-full" src="https://i.pinimg.com/564x/34/49/10/344910343716de41e27f92a6c0320708.jpg">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="about-section" class="about-section">
    <div id="about-section-content" data-aos="zoom-in-left">
        <h1 class="text-3x1 font-semibold text-center">Tentang Kami</h1>
        <p class="mt-10 text-lg">
            Kami adalah sebuah perusahaan yang berdedikasi untuk memberikan solusi terbaik kepada pelanggan kami. Dengan pengalaman bertahun-tahun, kami siap melayani Anda dengan sepenuh hati.
            Solusi atas semua kebutuhan transportasi dalam perjalanan wisata atupun bisnis anda di seluruh kota Sukabumi. dengan berbagai Jenis unit mobil yang sangat nyaman ketika anda pakai akan memanjakan anda saat melakukan perjalanan. Rental Mobil Murah yang kami sewakan pun sangat ber-variasi.
            Ini akan memudahkan anda sebagai penyewa saat menentukan kendaraan terbaik menurut selera anda atau kendaraan yang biasa anda gunakan dalam keseharian. Pelayanan DJVR.com mencakup sewa rental mobil dalam kota Sukabumi dan luar kota Sukabumi. Terutama destinasi Wisata dalam kota maupun luar kota di provinsi Jawa Barat.
            Tidak perlu hawatir kami pun memenuhi kebutuhan akan perjalanan jauh keluar provinsi.
        </p>
    </div>
</section>

<div class="flex">
    <!-- Bagian Kiri -->
    <section id="contact-section" class="flex-1">
        <div class="flex items-top justify-center min-h-screen sm:items-center sm:pt-0 py-0 my-0" data-aos="zoom-out">
            <div class="max-w-full mx-auto sm:px-4 lg:px-6">
                <div class="overflow-hidden">
                    <div class="text-center grid grid-cols-1 md:grid-cols-1">
                        <div class="p-6 bg-gray-100 dark:bg-gray-800 sm:rounded-lg">
                            <h1 class="text-4xl sm:text-5xl text-gray-800 dark:text-white font-extrabold tracking-tight">
                                Hubungi Kami
                            </h1>
                            <p class="text-normal  text-lg sm:text-2xl font-medium text-gray-600 dark:text-gray-400 mt-2 ">
                                Untuk Pertanyaan lebih lanjut
                            </p>
                            <div class="flex justify-center items-center flex-direction-row">
                                <div class="flex justify-center items-center  text-gray-600 dark:text-gray-400">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <div class="ml-4 text-md tracking-wide font-semibold w-40">
                                        Griya Selabumi Indah Blok H-18, SKIP, 14345
                                    </div>
                                </div>
                                <!-- TELEPON -->
                                <div class="flex justify-end items-center text-center">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <div class="ml-4 text-md tracking-wide font-semibold w-40">
                                        +62 81563636166
                                    </div>
                                </div>
                                <div class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <div class="ml-4 text-md tracking-wide font-semibold w-40">
                                        DJVR@gmail.com
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bagian Kanan -->
    <div class="flex-1 bg-gray- dark:bg-gray-" data-aos="zoom-out">
        <div class="kanan" id="max-w-3xl mx-auto sm:px-4 lg:px-6">
            <div class="overflow-hidden">
                <div class="text-center grid grid-cols-1 md:grid-cols-1">
                    <div class="p-6 bg-gray-100 dark:bg-gray-800 sm:rounded-lg">
                        <a href="https://www.google.com/maps/@-6.913957,106.9243981,3a,75y,115.66h,90.31t/data=!3m6!1e1!3m4!1sZys4ZloIa56ly31-KLWGXQ!2e0!7i16384!8i8192?entry=ttu" target="_blank">
                            <img src="image/PetaDJVR.png" alt="Peta DJVR" style="width: 100%; height: auto;" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<script>
    // Fungsi untuk menangani pengguliran ke bagian yang sesuai
    function scrollToSection(sectionId) {
        const section = document.getElementById(sectionId);
        if (section) {
            section.scrollIntoView({
                behavior: 'smooth'
            });
        }
    }

    // Tambahkan event listener untuk tautan "home"
    document.querySelector('a[href="#home"]').addEventListener('click', function(event) {
        event.preventDefault();
        scrollToSection('home');
    });

    // Tambahkan event listener untuk tautan "About"
    document.querySelector('a[href="#about-section"]').addEventListener('click', function(event) {
        event.preventDefault();
        scrollToSection('about-section');
    });

    // Tambahkan event listener untuk tautan "Contact"
    document.querySelector('a[href="#contact-section"]').addEventListener('click', function(event) {
        event.preventDefault();
        scrollToSection('contact-section');
    });
</script>
@endsection