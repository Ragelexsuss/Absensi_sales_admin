<div>
    <div class="grid grid-cols-1">
        @if (session()->has('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif
            <div class="flex items-center space-x-3 m-4 place-content-between">
                <div class="flex items-center space-x-3">
                    <div class="h-9 w-1 bg-indigo-600 rounded-full"></div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Kelola Stock</h1>
                </div>
                <div>
                    <button type="button" wire:click="openKategoriModal"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" ><i class="fa-solid fa-plus"></i> Add Kategori</button>
                    <button type="button" wire:click="openmodalgudang" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add Gudang</button>
                </div>
                </div>

            <div class="p-4 rounded-xl bg-gray-200 shadow-lg m-2">
            <div class="flex px-6 py-3 bg-gray-50 rounded-lg mx-4 place-content-between">
                <div class="flex items-center space-x-3">
                    <div class="h-6 w-1 bg-indigo-400 rounded-full"></div>
                    <h2 class="text-lg font-semibold text-gray-800 tracking-tight">List Gudang</h2>
                </div>
                <div>
                    <div>
                        <div class="max-w-md mx-auto">
                            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="search" wire:model.live="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Gudang" required />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="p-2 mb-8 mt-2 mr-4 ml-4">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 bg-gray-100 uppercase dark:bg-gray-700 dark:text-gray-400 text-center">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ID Gudang
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Gudang
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Lokasi Gudang
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Created At
                            </th>
                            <th scope="col" class="px-6 py-3">
                                action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($gudang as $item)
                            <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$item->id_gudang}}
                                </th>
                                <td class="px-6 py-4">
                                    {{$item->nama_gudang}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$item->area->nama_area}}
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->status === true)
                                        Area Aktif
                                    @else
                                        Area Tidak Aktif
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    {{$item->created_at}}
                                </td>
                                <td class="px-6 py-4">
                                    <button type="button" wire:click="viewproduct('{{$item->id_gudang}}')" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><i class="fa-solid fa-folder"></i></button>

                                @if($item->status === false)
                                        <button type="button" wire:click="validasigudang('{{$item->id_gudang}}')" wire:confirm="Apakah Anda Yakin Aktifkan Gudang: {{$item->nama_gudang}}" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><i class="fa-solid fa-check"></i></button>
                                    @else
                                        <button type="button" wire:click="hapusgudang('{{$item->id_gudang}}')" wire:confirm="Apakah Anda Yakin Menghapus Gudang: {{$item->nama_gudang}}" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"><i class="fa-solid fa-trash-can"></i></button>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th colspan="6" scope="row" class="px-6 py-4 font-medium text-gray-500 whitespace-nowrap bg-gray-200  ">
                                    Maaf Data Tidak Ditemukan
                                </th>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="mt-2 mr-5 ml-5">
                    {{$gudang->links()}}
                </div>
            </div>
                <div class="flex px-6 py-3 bg-gray-50 rounded-lg mx-4 place-content-between">
                    <div class="flex items-center space-x-3">
                        <div class="h-6 w-1 bg-indigo-400 rounded-full"></div>
                        <h2 class="text-lg font-semibold text-gray-800 tracking-tight">List Kategori</h2>
                    </div>
                    <div>
                        <div>
                            <div class="max-w-md mx-auto">
                                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </div>
                                    <input type="search" wire:model.live="searchkategori" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Kategori" required />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="p-2 mb-8 mt-2 mr-4 ml-4">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 bg-gray-100 uppercase dark:bg-gray-700 dark:text-gray-400 text-center">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    ID Kategori
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama Kategori
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Created at
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($dataKategori as $item)
                                <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$item->id_kategori}}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{$item->nama_kategori}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$item->created_at}}
                                    </td>
                                    <td class="px-4 py-4 ">

                                        {{--                                    @if (in_array($item->t0level->nama_level, $allowedlevel))--}}
                                        <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" wire:confirm="Apakah Anda Yakin Hapus Kategori {{$item->nama_kategori}} ?" wire:click="validasi"><i class="fa-solid fa-trash"></i></button>
                                        {{--                                        <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" wire:click="deletetabel({{$item->id}})" wire:confirm="Apakah anda yakin ingin menghapus Hapus Akun: {{$item->namaPanjang}}"><i class="fa-solid fa-trash"></i></button>--}}
                                        {{--                                    @else--}}
                                        {{--                                        <h1>Disabled</h1>--}}
                                        {{--                                    @endif--}}
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <th colspan="6" scope="row" class="px-6 py-4 font-medium text-gray-500 whitespace-nowrap bg-gray-200  ">
                                        Maaf Data Tidak Ditemukan
                                    </th>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>

                    </div>
                    <div class="mt-2 mr-5 ml-5">
                        {{$dataKategori->links()}}
                    </div>
                </div>
    </div>


            @if($modalgudang)
                <div tabindex="-1" aria-hidden="true"  class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none bg-black bg-opacity-50">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Tambah Gudang Baru
                                </h3>
                                <button type="button" wire:click="closemodalgudang" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" >
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <form wire:submit.prevent="addgudang" class="p-4 md:p-5">
                                @csrf
                                <div class="grid gap-4 mb-4 grid-cols-2">
                                    <div class="col-span-2">
                                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Gudang</label>
                                        <input wire:model="namagudang" type="text" name="area" id="area" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukan Nama Gudang" required="">
                                    </div>
                                </div>
                                <div class="flex justify-end ">
                                    <button type="submit" @if($statusbutton === false) disabled @endif class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                        Tambah Gudang
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            @endif
            <!-- Kategori Modal -->
            @if($showKategoriModal)
                <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none bg-black bg-opacity-50">
                    <div class="relative w-full max-w-md mx-auto my-6">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600 ">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Tambah Kategori Baru
                                </h3>
                                <button wire:click="closeKategoriModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <form wire:submit.prevent="addKategori" class="p-6 space-y-4">
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label for="kategori" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Kategori</label>
                                        <input type="text" wire:model="kategori" id="kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan nama kategori" required>
                                        @error('kategori') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="flex items-center pt-4 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600 place-content-between">
                                    <button type="button" wire:click="closeKategoriModal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <i class="fa-solid fa-plus"></i>  add Kategori
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
    </div>
</div>
