<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 p-4">
        <!-- Card 1 - Kelola Akun -->
        <form action="{{ route('home.kelola_akun') }}" method="GET" class="h-full">
            <button type="submit" class="w-full h-full bg-white rounded-lg shadow-md p-6 flex flex-col items-center justify-center transition-all duration-300 hover:scale-105 hover:shadow-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                <div class="bg-blue-100 p-3 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Kelola Akun</h3>
                <p class="text-2xl font-bold text-gray-900">{{$jumlahakunaktif}}</p>
                <p class="text-sm text-gray-500 mt-2">{{$jumlahakun}} Sales Baru</p>
            </button>
        </form>
        <!-- Card 2 - Laporan Sales -->
        <form action="{{ route('home.laporan_sales') }}" method="GET" class="h-full">
            <button type="submit" class="w-full h-full bg-white rounded-lg shadow-md p-6 flex flex-col items-center justify-center transition-all duration-300 hover:scale-105 hover:shadow-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                <div class="bg-green-100 p-3 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Laporan Sales</h3>
                <p class="text-2xl font-bold text-gray-900">156</p>
                <p class="text-sm text-gray-500 mt-2">30 hari terakhir</p>
            </button>
        </form>

        <form action="{{ route('home.gudang') }}" method="GET" class="h-full">
        <!-- Card 3 - Stock Barang -->
        <button type="submit" class="w-full h-full bg-white rounded-lg shadow-md p-6 flex flex-col items-center justify-center transition-all duration-300 hover:scale-105 hover:shadow-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            <div class="bg-purple-100 p-3 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-1">Stock Barang</h3>
            <p class="text-2xl font-bold text-gray-900">100</p>
            <p class="text-sm text-gray-500 mt-2">Kelola Produk</p>
        </button>
        </form>

        <form action="{{ route('home.salesorder') }}" method="GET" class="h-full">
        <!-- Card 4 - Sales Order -->
        <button type="submit" class="w-full h-full bg-white rounded-lg shadow-md p-6 flex flex-col items-center justify-center transition-all duration-300 hover:scale-105 hover:shadow-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            <div class="bg-yellow-100 p-3 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-1">Sales Order</h3>
            <p class="text-2xl font-bold text-gray-900">89</p>
            <p class="text-sm text-gray-500 mt-2">12 menunggu konfirmasi</p>
        </button>
        </form>

        <form action="{{ route('home.kelola_map') }}" method="GET" class="h-full">
        <!-- Card 5 - Kelola Map -->
        <button type="submit" class="w-full h-full bg-white rounded-lg shadow-md p-6 flex flex-col items-center justify-center transition-all duration-300 hover:scale-105 hover:shadow-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            <div class="bg-red-100 p-3 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-1">Kelola Map</h3>
            <p class="text-2xl font-bold text-gray-900">15</p>
            <p class="text-sm text-gray-500 mt-2">3 lokasi baru</p>
        </button>
        </form>
    </div>
</div>
