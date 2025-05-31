<div class="flex flex-col h-full bg-cyan-900 pt-4 pl-4 pr-4">
    <div class="w-auto bg-blue-500 h-14 shadow-lg rounded-lg flex items-center justify-center">
        <h1 class="text-white font-sans text-xl font-semibold">
            Absensi Sales
        </h1>
    </div>
    <div class="grid grid-cols-6 items-center w-auto bg-white rounded-md h-24 mt-5 px-2">
        <!-- Kiri: Logo Akun -->
        <div class="flex items-center justify-center col-span-2 h-full">
            <i class="fas fa-user-circle text-5xl text-gray-600"></i>
        </div>

        <!-- Kanan: Informasi Nama -->
        <div class="flex justify-start items-center text-start col-span-4">
            <div class="w-full px-2 break-words">
                <p class="text-md font-semibold text-gray-800">{{$nama}}</p>
                <p class="text-sm text-gray-500">Role: {{$role}}</p>
            </div>
        </div>
    </div>

{{--    Dashboard Button    --}}
    <div class="grid grid-cols-6 items-center w-full h-auto rounded-lg mt-5">
        <!-- Button inside div -->
        <button class="col-span-6 flex items-center bg-transparent hover:bg-white transition-all duration-300 group hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 active:scale-95 rounded-lg p-2">
            <!-- Kolom Ikon -->
            <div class="flex items-center justify-center col-span-2 h-auto">
                <div class="w-20">
                    <div class="w-auto bg-white rounded-lg p-4 group-hover:p-5 transition-all duration-300 group-hover:bg-blue-50">
                        <i class="fa-solid fa-house text-2xl text-gray-600 group-hover:text-3xl group-hover:text-blue-600 transition-all duration-300"></i>
                    </div>
                </div>
            </div>

            <!-- Kolom Teks -->
            <div class="col-span-4 px-4 text-left">
                <p class="text-white font-medium group-hover:text-lg group-hover:text-blue-700 transition-all duration-300">
                    Menu Utama
                </p>
                <p class="text-sm text-white group-hover:text-md group-hover:text-gray-600 transition-all duration-300 mt-1">
                    Kembali ke halaman dashboard
                </p>
            </div>
        </button>
    </div>
    @if(Auth::user()&& Auth::user()->t0_role->nama_role==='admin')
    <div class=" w-full h-auto rounded-lg mt-5">
        <!-- Button inside div -->
        <form action="{{route('home.kelola_akun_admin')}}" method="get" class="grid grid-cols-6 items-center">
            <button class="col-span-6 flex items-center bg-transparent hover:bg-white transition-all duration-300 group hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 active:scale-95 rounded-lg p-2">
                <!-- Kolom Ikon -->
                <div class="flex items-center justify-center col-span-2 h-auto">
                    <div class="w-20">
                        <div class="w-auto bg-white rounded-lg p-4 group-hover:p-5 transition-all duration-300 group-hover:bg-blue-50">
                            <i class="fa-solid fa-user text-2xl text-gray-600 group-hover:text-3xl group-hover:text-blue-600 transition-all duration-300"></i>
                        </div>
                    </div>

                </div>

                <!-- Kolom Teks -->
                <div class="col-span-4 px-4 text-left">
                    <p class="text-white font-medium group-hover:text-lg group-hover:text-blue-700 transition-all duration-300">
                        Kelola Akun
                    </p>
                    <p class="text-sm text-white group-hover:text-md group-hover:text-gray-600 transition-all duration-300 mt-1">
                        Kelola Akun Admin
                    </p>
                </div>
            </button>
        </form>
    </div>
    @endif

    @if(Auth::user()&& Auth::user()->t0_role->nama_role==='supervisor')
        {{--    Kelola Akun Button    --}}
        <div class=" w-full h-auto rounded-lg mt-5">
            <!-- Button inside div -->
            <form action="{{route('home.kelola_akun')}}" method="get" class="grid grid-cols-6 items-center">
                <button class="col-span-6 flex items-center bg-transparent hover:bg-white transition-all duration-300 group hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 active:scale-95 rounded-lg p-2">
                    <!-- Kolom Ikon -->
                    <div class="flex items-center justify-center col-span-2 h-auto">
                        <div class="w-20">
                            <div class="w-auto bg-white rounded-lg p-4 group-hover:p-5 transition-all duration-300 group-hover:bg-blue-50">
                                <i class="fa-solid fa-user text-2xl text-gray-600 group-hover:text-3xl group-hover:text-blue-600 transition-all duration-300"></i>
                            </div>
                        </div>

                    </div>

                    <!-- Kolom Teks -->
                    <div class="col-span-4 px-4 text-left">
                        <p class="text-white font-medium group-hover:text-lg group-hover:text-blue-700 transition-all duration-300">
                            Kelola Akun
                        </p>
                        <p class="text-sm text-white group-hover:text-md group-hover:text-gray-600 transition-all duration-300 mt-1">
                            Kelola Akun Sales
                        </p>
                    </div>
                </button>
            </form>
        </div>
        {{--    Kelola Laporan Sales Button    --}}
        <div class="w-full h-auto rounded-lg mt-5">
            <form action="{{route('home.laporan_sales')}}" method="get" class="grid grid-cols-6 items-center">

                <!-- Button inside div -->
                <button class="col-span-6 flex items-center bg-transparent hover:bg-white transition-all duration-300 group hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 active:scale-95 rounded-lg p-2">
                    <!-- Kolom Ikon -->
                    <div class="flex items-center justify-center col-span-2 h-auto">
                        <div class="w-20">
                            <div class="w-auto bg-white rounded-lg p-4 group-hover:p-5 transition-all duration-300 group-hover:bg-blue-50">
                                <i class="fa-regular fa-newspaper text-2xl text-gray-600 group-hover:text-3xl group-hover:text-blue-600 transition-all duration-300"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Teks -->
                    <div class="col-span-4 px-4 text-left">
                        <p class="text-white font-medium group-hover:text-lg group-hover:text-blue-700 transition-all duration-300">
                            Laporan Sales
                        </p>
                        <p class="text-sm text-white group-hover:text-md group-hover:text-gray-600 transition-all duration-300 mt-1">
                            Detail Laporan Sales
                        </p>
                    </div>
                </button>
            </form>
        </div>

        {{--    Kelola Stock    --}}
        <div class="w-full h-auto rounded-lg mt-5">
            <form action="{{route('home.gudang')}}" method="get" class="grid grid-cols-6 items-center">
                <!-- Button inside div -->
                <button class="col-span-6 flex items-center bg-transparent hover:bg-white transition-all duration-300 group hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 active:scale-95 rounded-lg p-2">
                    <!-- Kolom Ikon -->
                    <div class="flex items-center justify-center col-span-2 h-auto">
                        <div class="w-20">
                            <div class="w-auto bg-white rounded-lg p-4 group-hover:p-5 transition-all duration-300 group-hover:bg-blue-50">
                                <i class="fa-solid fa-box text-2xl text-gray-600 group-hover:text-3xl group-hover:text-blue-600 transition-all duration-300"></i>
                            </div>
                        </div>

                    </div>

                    <!-- Kolom Teks -->
                    <div class="col-span-4 px-4 text-left">
                        <p class="text-white font-medium group-hover:text-lg group-hover:text-blue-700 transition-all duration-300">
                            Stock Barang
                        </p>
                        <p class="text-sm text-white group-hover:text-md group-hover:text-gray-600 transition-all duration-300 mt-1">
                            Kelola Stock Barang Pt Eloda Mitra
                        </p>
                    </div>
                </button>
            </form>
        </div>
        {{--    Sales Order Button    --}}
        <div class="w-full h-auto rounded-lg mt-5">
            <!-- Button inside div -->
            <form action="{{route('home.salesorder')}}" method="get" class="grid grid-cols-6 items-center">
                <button class="col-span-6 flex items-center bg-transparent hover:bg-white transition-all duration-300 group hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 active:scale-95 rounded-lg p-2">
                    <!-- Kolom Ikon -->

                    <div class="flex items-center justify-center col-span-2 h-auto">
                        <div class="w-20">
                            <div class="w-auto bg-white rounded-lg p-4 group-hover:p-5 transition-all duration-300 group-hover:bg-blue-50">
                                <i class="fa-solid fa-dolly text-2xl text-gray-600 group-hover:text-3xl group-hover:text-blue-600 transition-all duration-300"></i>
                            </div>
                        </div>

                    </div>

                    <!-- Kolom Teks -->
                    <div class="col-span-4 px-4 text-left">
                        <p class="text-white font-medium group-hover:text-lg group-hover:text-blue-700 transition-all duration-300">
                            Sales Order
                        </p>
                        <p class="text-sm text-white group-hover:text-md group-hover:text-gray-600 transition-all duration-300 mt-1">
                            Sales Order Sales
                        </p>
                    </div>
                </button>
            </form>
        </div>

    @endif
    {{--    Kelola Lokasi Button    --}}
    <div class="w-full h-auto rounded-lg mt-5">
        <!-- Button inside div -->
        <form action="{{route('home.kelola_map')}}" method="get" class="grid grid-cols-6 items-center">
            <button class="col-span-6 flex items-center bg-transparent hover:bg-white transition-all duration-300 group hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 active:scale-95 rounded-lg p-2">
                <!-- Kolom Ikon -->
                <div class="flex items-center justify-center col-span-2 h-auto">
                    <div class="w-20">
                        <div class="w-auto bg-white rounded-lg p-4 group-hover:p-5 transition-all duration-300 group-hover:bg-blue-50">
                            <i class="fa-solid fa-map-pin text-2xl text-gray-600 group-hover:text-3xl group-hover:text-blue-600 transition-all duration-300"></i>
                        </div>
                    </div>

                </div>

                <!-- Kolom Teks -->
                <div class="col-span-4 px-4 text-left">
                    <p class="text-white font-medium group-hover:text-lg group-hover:text-blue-700 transition-all duration-300">
                        Kelola Map
                    </p>
                    <p class="text-sm text-white group-hover:text-md group-hover:text-gray-600 transition-all duration-300 mt-1">
                        Kelola Map Toko
                    </p>
                </div>
            </button>
        </form>

    </div>


</div>
