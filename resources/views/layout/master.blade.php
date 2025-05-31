<!doctype html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>Absensi Sales</title>
    @stack('styles')
</head>
<body class="font-sans bg-gray-50">
<!-- Grid Utama -->
<div class="flex flex-col lg:flex-row min-h-screen ">
    <!-- Sidebar (Fixed) -->
    <div class="hidden lg:block lg:w-72 fixed h-screen bg-white shadow">
        @livewire('sidebar')
    </div>

    <!-- Konten Kanan (Navbar + Main Content) -->
    <div class="lg:ml-72 flex-1 flex flex-col">
        <!-- Navbar (Fixed) -->
        <header class="fixed top-0 left-0 right-0 lg:left-72 bg-white shadow z-50">
            @livewire('navbar')
        </header>

        <!-- Main Content (Scrollable) -->
        <main class="flex-1 pt-8 pb-4 px-4 mt-16 overflow-y-auto">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white rounded-lg shadow dark:bg-gray-800 mx-4 mb-2">
            <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
                    <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">
                        © 2023 <a href="#" class="hover:underline">Flowbite™</a>. All Rights Reserved.
                    </span>
                <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                    <li><a href="#" class="hover:underline me-4 md:me-6">About</a></li>
                    <li><a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a></li>
                    <li><a href="#" class="hover:underline me-4 md:me-6">Licensing</a></li>
                    <li><a href="#" class="hover:underline">Contact</a></li>
                </ul>
            </div>
        </footer>
    </div>
</div>

<script src="https://unpkg.com/maplibre-gl@2.1.9/dist/maplibre-gl.js"></script>
@stack('script')
</body>
</html>
