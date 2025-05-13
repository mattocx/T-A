<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Beranda') }} - {{ config('app.name') ?? 'Laravel' }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div>
        <header class="sticky top-0 bg-white shadow">
            <div class="container flex flex-col sm:flex-row justify-between items-center mx-auto py-4 px-8">
                <div class="flex items-center text-2xl">
                    <div class="mr-3 w-16">
                        <img src="{{ asset('images/logo.png') }}" alt="">
                    </div>
                </div>
                <div class="flex mt-4 sm:mt-0">
                    <a class="px-4" href="#home">{{ __('Home') }}</a>
                    <a class="px-4" href="#about">{{ __('About') }}</a>
                    <a class="px-4" href="#stats">{{ __('Stats') }}</a>
                    <a class="px-4" href="#testimonials">{{ __('Testimonials') }}</a>
                </div>
                <div class="hidden md:block">
                    <button type="button"
                        class=" py-3 px-8 text-sm bg-pink-500 hover:bg-pink-600 rounded text-white ">
                        {{ __('Login') }}
                    </button>
                </div>
            </div>
        </header>

        <main class="text-pink-900">
            <section id="home" class="pt-20 md:pt-40">
                <div class="container mx-auto px-8 lg:flex">
                    <div class="text-center lg:text-left lg:w-1/2">
                        <h1 class="text-4xl lg:text-5xl xl:text-6xl font-bold leading-none">
                            {{ __('Selamat Datang Di Elsa Wifi Prioritas') }}
                        </h1>
                        <p class="text-xl lg:text-2xl mt-6 font-light">
                            {{ __('Solusi Internet Cepat & Stabil Untuk Kebutuhan Anda') }}
                        </p>
                        <div class="relative inline-block text-left mt-8 md:mt-12">
                            <button id="loginDropdownBtn" type="button"
                                class="py-4 px-12 bg-pink-500 hover:bg-pink-600 rounded text-white">
                                {{ __('Login Sekarang') }}
                            </button>

                            <div id="loginDropdownMenu"
                                class="hidden absolute z-10 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                <div class="py-1">
                                    <a href="{{ url('/dashboard/login') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-100 hover:text-pink-700">Admin</a>
                                    <a href="{{ url('/sales/login') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-100 hover:text-pink-700">Sales</a>
                                    <a href="{{ url('/customer/login') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-100 hover:text-pink-700">Customer</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:w-1/2">
                     <img src="{{ asset('images/1.svg') }}" alt="">
                    </div>
                </div>
            </section>

            <section id="about" class="py-20">
                <div class="container mx-auto px-16 items-center flex flex-col lg:flex-row">
                    <div class="lg:w-1/2">
                        <div class="lg:pr-32 xl:pr-48">
                            <h3 class="text-3xl font-semibold leading-tight">📶 Koneksi Tanpa Batas, Tanpa Drama</h3>
                            <p class="mt-8 text-xl font-light leading-relaxed"> Kami hadir untuk memastikan Anda tetap terhubung kapan saja, di mana saja. Mulai dari aktivitas rumah tangga hingga bisnis rumahan, semua lancar tanpa gangguan.
                            </p>
                        </div>
                    </div>
                    <div class="mt-10 lg:mt-0 w-full lg:w-1/2 undefined">
                        <img src="{{ asset('images/3.svg') }}" alt="">
                    </div>
                </div>
            </section>

            <section class="py-20">
                <div class="container mx-auto px-16 items-center flex flex-col lg:flex-row">
                    <div class="lg:w-1/2">
                        <div class="lg:pl-32 xl:pl-48">
                            <h3 class="text-3xl font-semibold leading-tight">🚀 Cepat, Stabil, Andal – Semua Dalam Genggaman
                                </h3>
                            <p class="mt-8 text-xl font-light leading-relaxed">Dirancang untuk memenuhi kebutuhan online harianmu dengan kecepatan tinggi dan layanan yang responsif.
                            </p>
                        </div>
                    </div>
                    <div class="mt-10 lg:mt-0 w-full lg:w-1/2 order-last lg:order-first">
                        <img src="{{ asset('images/2.svg') }}" alt="">
                    </div>
                </div>
            </section>

            <section class="py-20">
                <div class="container mx-auto px-16 items-center flex flex-col lg:flex-row">
                    <div class="lg:w-1/2">
                        <div class="lg:pr-32 xl:pr-48">
                            <h3 class="text-3xl font-semibold leading-tight">🌐 Internet Lokal, Rasa Profesional
                            </h3>
                            <p class="mt-8 text-xl font-light leading-relaxed">Dikelola oleh tim terpercaya di sekitarmu, E-Nettt hadir membawa internet berkualitas ke lingkungan tempat tinggalmu.
                            </p>
                        </div>
                    </div>
                    <div class="mt-10 lg:mt-0 w-full lg:w-1/2 undefined">
                        <img src="{{ asset('images/4.svg') }}" alt="">
                    </div>
                </div>
            </section>

            <section id="stats" class="py-20 lg:pt-32">
                <div class="container mx-auto text-center">
                    <p class="uppercase tracking-wider text-pink-600">📊 Data Pengguna Kami

                    </p>
                    <div class="flex flex-col sm:flex-row mt-8 lg:px-24">
                        <div class="w-full sm:w-1/3">
                            <p class="text-4xl lg:text-6xl font-semibold text-pink-500">+95%
                            </p>
                            <p class="font-semibold mb-6">Uptime sepanjang tahun
                            </p>
                        </div>
                        <div class="w-full sm:w-1/3">
                            <p class="text-4xl lg:text-6xl font-semibold text-pink-500">+98%
                            </p>
                            <p class="font-semibold mb-6">Pelanggan Puas
                            </p>
                        </div>
                        <div class="w-full sm:w-1/3">
                            <p class="text-4xl lg:text-6xl font-semibold text-pink-500">15+
                            </p>
                            <p class="font-semibold mb-6">Wilayah Cangkupan
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="testimonials" class="py-20 lg:py-40">
                <div class="container mx-auto">
                    <p class="uppercase tracking-wider mb-8 text-pink-600 text-center">Apa Kata Mereka yaa?
                    </p>
                    <div class="flex flex-col md:flex-row md:-mx-3">
                        <div class="flex-1 px-3">
                            <div class="p-12 rounded-lg border border-solid border-gray-200 mb-8"
                                style="box-shadow:0 10px 28px rgba(0,0,0,.08)">
                                <p class="text-xl font-semibold">💬 “Harga bersahabat, koneksi stabil. Instalasi juga cepat. Cocok banget buat mahasiswa kayak saya. Rekomen banget ayo kalian juga gabung”

                                </p>
                                <div class="flex items-center mt-8">
                                    <div>
                                        <p>-Jungkook
                                        </p>
                                        <p class="text-sm text-pink-600">BTS
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 px-3">
                            <div class="p-12 rounded-lg border border-solid border-gray-200 mb-8"
                                style="box-shadow:0 10px 28px rgba(0,0,0,.08)">
                                <p class="text-xl font-semibold">💬 “Dulu susah jualan online karena jaringan lemot. Sekarang pakai E-W-P, upload produk dan balas chat pelanggan jadi lebih cepat!”

                                </p>
                                <div class="flex items-center mt-8">
                                    <div>
                                        <p>-Elsa Cantik
                                        </p>
                                        <p class="text-sm text-pink-600">Pebisnis Sukses
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 px-3">
                            <div class="p-12 rounded-lg border border-solid border-gray-200 mb-8"
                                style="box-shadow:0 10px 28px rgba(0,0,0,.08)">
                                <p class="text-xl font-semibold">💬 “Sejak pakai E-Nettt, kerja remote jadi lancar tanpa mikirin sinyal putus-putus. Recommended banget buat yang kerja dari rumah!”

                                </p>
                                <div class="flex items-center mt-8">
                                    <div>
                                        <p>Elsa
                                        </p>
                                        <p class="text-sm text-pink-600">Web Dev
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="container mx-auto my-20 py-24 bg-pink-200 rounded-lg text-center">
                <h3 class="text-5xl font-semibold">📞 Hubungi Kami Sekarang!</h3>
                <p class="mt-8 text-xl font-light">📍 Alamat: Jl. Cinta No. 11, Tegal. || 🕐 Jam Operasional: Senin–Sabtu, 08.00–17.00 WIB
                </p>
                <p class="mt-8">
                    <button type="button"
                        class=" py-5 px-16 text-lg bg-pink-500 hover:bg-pink-600 rounded text-white ">
                        Tertarik?
                    </button>
                </p>
            </section>

        </main>

        <footer class="container mx-auto py-16 px-3 mt-48 mb-8 text-pink-800">
            <div class="flex flex-wrap -mx-3">
                <!-- Logo dan Nama Perusahaan -->
                <div class="w-full md:w-1/3 px-3 mb-8 md:mb-0 ml-auto">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo PT. EWP Media" style="height: 200px; width: auto;" class="mb-4">
                    <p class="text-lg font-semibold">PT. EWP Media</p>
                </div>

                <!-- Kami Cocok Untuk -->
                <div class="w-full md:w-1/3 px-3 mb-8 md:mb-0">
                    <h2 class="text-lg font-semibold">🎯 Kami Cocok Untuk:</h2>
                    <ul class="mt-4 leading-loose">
                        <li>Rumah tangga yang butuh internet stabil</li>
                        <li>UMKM yang mengandalkan digital</li>
                        <li>Pelajar & mahasiswa yang aktif belajar online</li>
                        <li>Freelancer & pekerja remote</li>
                    </ul>
                </div>

                <!-- Social Media -->
                <div class="w-full md:w-1/3 px-3">
                    <h2 class="text-lg font-semibold">Social Media</h2>
                    <ul class="mt-4 leading-loose space-y-2">
                        <li>
                            <a href="https://facebook.com/elsa.el" class="flex items-center space-x-2 text-blue-600 hover:underline">
                                <i class="fab fa-facebook-f"></i><span>Facebook</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://instagram.com/elsayosu" class="flex items-center space-x-2 text-pink-500 hover:underline">
                                <i class="fab fa-instagram"></i><span>Instagram</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com" class="flex items-center space-x-2 text-blue-400 hover:underline">
                                <i class="fab fa-twitter"></i><span>Twitter</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/6281234567890" class="flex items-center space-x-2 text-green-500 hover:underline">
                                <i class="fab fa-whatsapp"></i><span>WhatsApp</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://tiktok.com/veeloxa" class="flex items-center space-x-2 text-gray-800 hover:underline">
                                <i class="fab fa-tiktok"></i><span>TikTok</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Terms & Privacy -->
                    <div class="mt-6 space-y-2 text-sm text-gray-600">
                        <a href="javascript:void(0);" class="hover:underline">Terms & Conditions</a><br>
                        <a href="javascript:void(0);" class="hover:underline">Privacy Policy</a>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="mt-12 border-t pt-6 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} PT. EWP Media. All rights reserved.
            </div>
        </footer>



    </div>



    <script>
        document.getElementById('loginDropdownBtn').addEventListener('click', function () {
            const menu = document.getElementById('loginDropdownMenu');
            menu.classList.toggle('hidden');
        });
    </script>

</body>

</html>
