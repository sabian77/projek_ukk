<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PKL - Platform Pelaporan Praktik Kerja Lapangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0D47A1',
                        secondary: '#FFFFFF',
                        tertiary: '#B0BEC5',
                        base: '#000000',
                    },
                },
            },
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-base text-secondary min-h-screen">
    <!-- Navbar -->
    <header class="fixed w-full z-10 bg-base">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="flex items-center">
                    <!-- Logo Anda -->
                    <img src="{{ asset('logo.png') }}" 
                        alt="Logo Lapor PKL" 
                        class="h-8 w-auto mr-2"> <!-- Sesuaikan ukuran sesuai kebutuhan -->
                    
                    <!-- Teks "Lapor PKL" -->
                    <span class="text-secondary font-bold text-xl">Lapor PKL</span>
                </a>
            </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="#" class="text-secondary hover:text-tertiary">Beranda</a>
                    <a href="#features" class="text-secondary hover:text-tertiary">Fitur</a>
                    <a href="#process" class="text-secondary hover:text-tertiary">Proses</a>
                    <a href="#testimonials" class="text-secondary hover:text-tertiary">Review</a>
                </nav>

                <!-- Auth Buttons Desktop -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="/login" class="px-4 py-2 border border-secondary rounded-md text-secondary hover:text-tertiary hover:border-tertiary transition-colors">
                        Login
                    </a>
                    <a href="/register" class="px-4 py-2 bg-primary rounded-md text-secondary hover:bg-opacity-90 transition-colors">
                        Register
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-secondary hover:text-tertiary focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="#" class="block px-3 py-2 text-secondary hover:text-tertiary">Beranda</a>
                    <a href="#features" class="block px-3 py-2 text-secondary hover:text-tertiary">Fitur</a>
                    <a href="#process" class="block px-3 py-2 text-secondary hover:text-tertiary">Proses</a>
                    <a href="#testimonials" class="block px-3 py-2 text-secondary hover:text-tertiary">Review</a>
                </div>
                <div class="px-2 pt-2 pb-3 space-y-3">
                    <a href="/login" class="block w-full px-4 py-2 text-center border border-secondary rounded-md text-secondary hover:text-tertiary hover:border-tertiary transition-colors">
                        Login
                    </a>
                    <a href="/register" class="block w-full px-4 py-2 text-center bg-primary rounded-md text-secondary hover:bg-opacity-90 transition-colors">
                        Register
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="pt-32 pb-16 md:pt-40 md:pb-24 bg-base">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 text-center md:text-left">
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6">
                        Lapor PKL Jadi Lebih Mudah dan Terpantau
                    </h1>
                    <p class="text-tertiary text-lg mb-8 max-w-md mx-auto md:mx-0">
                        Satu platform bagi siswa untuk melapor PKL dan guru untuk memantau siswa bimbingannya.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="/login" class="w-full sm:w-auto px-6 py-3 bg-primary rounded-md text-center text-secondary hover:bg-opacity-90 transition-colors">
                            Login Sekarang
                        </a>
                        <a href="/register" class="w-full sm:w-auto px-6 py-3 border border-secondary rounded-md text-center text-secondary hover:text-tertiary hover:border-tertiary transition-colors">
                            Register Gratis
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 mt-12 md:mt-0 flex justify-center">
                    <img 
                        src="https://images.pexels.com/photos/3183183/pexels-photo-3183183.jpeg?auto=compress&cs=tinysrgb&w=600" 
                        alt="Siswa menggunakan laptop" 
                        class="w-full max-w-md rounded-lg shadow-lg"
                    />
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 md:py-24 bg-base bg-opacity-95">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-2xl md:text-3xl font-bold mb-4">Fitur Unggulan Website PKL</h2>
                <p class="text-tertiary max-w-2xl mx-auto">
                    Platform kami menyediakan fitur-fitur yang dirancang khusus untuk memudahkan pelaporan dan pemantauan PKL.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Feature 1: Lapor PKL -->
                <div class="bg-base bg-opacity-50 p-8 rounded-lg border border-tertiary border-opacity-20">
                    <div class="flex items-start mb-6">
                        <div class="flex-shrink-0 bg-primary p-3 rounded-lg">
                            <svg class="h-6 w-6 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="ml-4 text-xl font-semibold">Lapor PKL</h3>
                    </div>
                    <ul class="space-y-3 text-tertiary">
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-primary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Input tempat PKL dengan detail lengkap</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-primary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Input waktu pelaksanaan dengan pengingat otomatis</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-primary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Status PKL terupdate secara real-time</span>
                        </li>
                    </ul>
                </div>

                <!-- Feature 2: Tambah Industri -->
                <div class="bg-base bg-opacity-50 p-8 rounded-lg border border-tertiary border-opacity-20">
                    <div class="flex items-start mb-6">
                        <div class="flex-shrink-0 bg-primary p-3 rounded-lg">
                            <svg class="h-6 w-6 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="ml-4 text-xl font-semibold">Tambah Industri</h3>
                    </div>
                    <ul class="space-y-3 text-tertiary">
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-primary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Siswa dapat menambahkan detail industri baru</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-primary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Form input yang simpel untuk nama, alamat, dan kontak</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-primary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Integrasi dengan peta lokasi industri</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section id="process" class="py-16 md:py-24 bg-base bg-opacity-95">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-2xl md:text-3xl font-bold mb-4">Cara Menggunakan Platform PKL</h2>
                <p class="text-tertiary max-w-2xl mx-auto">
                    Proses sederhana untuk memulai dan menggunakan platform pelaporan PKL.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="flex flex-col items-center text-center">
                    <div class="relative mb-6">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center text-white text-xl font-bold">
                            1
                        </div>
                        <div class="hidden md:block absolute top-1/2 left-full w-full h-0.5 bg-primary bg-opacity-30"></div>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Login ke Akun</h3>
                    <p class="text-tertiary">
                        Masuk menggunakan akun yang telah terdaftar atau buat akun baru melalui halaman register.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center text-center">
                    <div class="relative mb-6">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center text-white text-xl font-bold">
                            2
                        </div>
                        <div class="hidden md:block absolute top-1/2 left-full w-full h-0.5 bg-primary bg-opacity-30"></div>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Isi Laporan PKL</h3>
                    <p class="text-tertiary">
                        Lengkapi informasi tentang tempat PKL, waktu pelaksanaan, dan kegiatan yang dilakukan.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center text-center">
                    <div class="relative mb-6">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center text-white text-xl font-bold">
                            3
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Tambah Industri (Opsional)</h3>
                    <p class="text-tertiary">
                        Jika industri belum terdaftar, tambahkan detail industri baru ke dalam sistem.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-16 md:py-24 bg-base">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-2xl md:text-3xl font-bold mb-4">Testimoni Siswa & Guru</h2>
                <p class="text-tertiary max-w-2xl mx-auto">
                    Apa kata pengguna tentang platform pelaporan PKL kami.
                </p>
            </div>

            <div class="testimonial-slider overflow-x-auto pb-8">
                <div class="flex space-x-6 min-w-max">
                    <!-- Testimonial 1 -->
                    <div class="bg-base bg-opacity-50 p-6 rounded-lg border border-tertiary border-opacity-20 shadow-lg min-w-[300px] max-w-[350px]">
                        <div class="flex items-center mb-4">
                            <img 
                                src="https://images.pexels.com/photos/1222271/pexels-photo-1222271.jpeg?auto=compress&cs=tinysrgb&w=100" 
                                alt="User Avatar" 
                                class="w-12 h-12 rounded-full object-cover"
                            />
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold">Budiman</h4>
                                <p class="text-tertiary text-sm">Siswa</p>
                            </div>
                        </div>
                        <p class="text-tertiary">
                            "Aplikasinya bagus sekali. Aplikasinya bagus sekali. Aplikasinya bagus sekali."
                        </p>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="bg-base bg-opacity-50 p-6 rounded-lg border border-tertiary border-opacity-20 shadow-lg min-w-[300px] max-w-[350px]">
                        <div class="flex items-center mb-4">
                            <img 
                                src="https://images.pexels.com/photos/3763188/pexels-photo-3763188.jpeg?auto=compress&cs=tinysrgb&w=100" 
                                alt="User Avatar" 
                                class="w-12 h-12 rounded-full object-cover"
                            />
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold">Ani Wijaya</h4>
                                <p class="text-tertiary text-sm">Guru Pembimbing</p>
                            </div>
                        </div>
                        <p class="text-tertiary">
                            "Memudahkan saya dalam mengetahui siswa bimbingan saya. Dashboard yang informatif dan update realtime."
                        </p>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="bg-base bg-opacity-50 p-6 rounded-lg border border-tertiary border-opacity-20 shadow-lg min-w-[300px] max-w-[350px]">
                        <div class="flex items-center mb-4">
                            <img 
                                src="https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg?auto=compress&cs=tinysrgb&w=100" 
                                alt="User Avatar" 
                                class="w-12 h-12 rounded-full object-cover"
                            />
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold">Deni Supriyadi</h4>
                                <p class="text-tertiary text-sm">Siswa</p>
                            </div>
                        </div>
                        <p class="text-tertiary">
                            "Fitur tambah industri sangat berguna. Saya bisa menambahkan detail tempat PKL saya dengan mudah dan lengkap."
                        </p>
                    </div>

                    <!-- Testimonial 4 -->
                    <div class="bg-base bg-opacity-50 p-6 rounded-lg border border-tertiary border-opacity-20 shadow-lg min-w-[300px] max-w-[350px]">
                        <div class="flex items-center mb-4">
                            <img 
                                src="https://images.pexels.com/photos/774909/pexels-photo-774909.jpeg?auto=compress&cs=tinysrgb&w=100" 
                                alt="User Avatar" 
                                class="w-12 h-12 rounded-full object-cover"
                            />
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold">Siti Rahayu</h4>
                                <p class="text-tertiary text-sm">Guru Pembimbing</p>
                            </div>
                        </div>
                        <p class="text-tertiary">
                            "Saya jadi lebih mudah dalam mengetahui anak bimbingan saya."
                        </p>
                    </div>
                </div>
            </div>

            <!-- Mobile Indicators -->
            <div class="flex justify-center space-x-2 mt-6 md:hidden">
                <button class="w-2 h-2 rounded-full bg-primary"></button>
                <button class="w-2 h-2 rounded-full bg-tertiary"></button>
                <button class="w-2 h-2 rounded-full bg-tertiary"></button>
                <button class="w-2 h-2 rounded-full bg-tertiary"></button>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 md:py-24 bg-base bg-opacity-95">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-primary bg-opacity-10 border border-primary border-opacity-20 rounded-xl p-8 md:p-12">
                <div class="text-center max-w-3xl mx-auto">
                    <h2 class="text-2xl md:text-3xl font-bold mb-4">
                        Login Sekarang dan Laporkan tempat PKL anda
                    </h2>
                    <p class="text-tertiary text-lg mb-8">
                        Akses cepat untuk siswa dan guru pembimbing
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="/login" class="w-full sm:w-auto px-6 py-3 bg-primary rounded-md text-center text-secondary hover:bg-opacity-90 transition-colors">
                            Login Sekarang
                        </a>
                        <a href="/register" class="w-full sm:w-auto px-6 py-3 border border-secondary rounded-md text-center text-secondary hover:text-tertiary hover:border-tertiary transition-colors">
                            Register
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 bg-base border-t border-tertiary border-opacity-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">PKL</h3>
                    <p class="text-tertiary">
                        Platform pelaporan Praktik Kerja Lapangan untuk siswa dan guru pembimbing.
                    </p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Tautan</h3>
                    <ul class="space-y-2 text-tertiary">
                        <li><a href="#" class="hover:text-secondary transition-colors">Beranda</a></li>
                        <li><a href="#features" class="hover:text-secondary transition-colors">Fitur</a></li>
                        <li><a href="#process" class="hover:text-secondary transition-colors">Proses</a></li>
                        <li><a href="#testimonials" class="hover:text-secondary transition-colors">Review</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Bantuan</h3>
                    <ul class="space-y-2 text-tertiary">
                        <li><a href="#" class="hover:text-secondary transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-secondary transition-colors">Kontak</a></li>
                        <li><a href="#" class="hover:text-secondary transition-colors">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-tertiary hover:text-secondary transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-tertiary hover:text-secondary transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-tertiary hover:text-secondary transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-tertiary hover:text-secondary transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 pt-8 border-t border-tertiary border-opacity-20 text-center text-tertiary">
                <p>© 2024 PKL Platform. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', () => {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton?.addEventListener('click', () => {
                mobileMenu?.classList.toggle('hidden');
            });
        });

        // Simple auto-scroll for desktop testimonials
        document.addEventListener('DOMContentLoaded', () => {
            if (window.innerWidth >= 768) {
                const testimonialSlider = document.querySelector('.testimonial-slider');
                const testimonials = document.querySelectorAll('.testimonial-slider > div > div');
                
                if (testimonialSlider && testimonials.length > 0) {
                    let currentIndex = 0;
                    
                    setInterval(() => {
                        currentIndex = (currentIndex + 1) % (testimonials.length - 2);
                        const scrollAmount = testimonials[0].offsetWidth + 24; // width + gap
                        testimonialSlider.scrollTo({
                            left: currentIndex * scrollAmount,
                            behavior: 'smooth'
                        });
                    }, 5000);
                }
            }
        });
    </script>
</body>
</html>