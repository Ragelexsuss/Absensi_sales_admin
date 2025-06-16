<div>
    <div class="grid grid-cols-1">
        <!-- Pesan Sukses/Error -->
        @if($successMessage)
            <div class="mt-2 text-green-600">{{ $successMessage }}</div>
        @endif

        @if($errorMessage)
            <div class="mt-2 text-red-600">{{ $errorMessage }}</div>
        @endif
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded m-4">
                {{ session('message') }}
            </div>
        @endif
        <div class="flex font-sans m-6   font-bold text-gray-800 place-content-between">
            <div class="font-sans  text-2xl font-bold text-gray-800">
                <h1>Sales Order</h1>
            </div>
            <div class="flex items-center justify-center ">
                <!-- Tombol Sync -->
                <button wire:click="getdata"
                        wire:loading.attr="disabled"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">

                    <span wire:loading.remove>Sinkronkan Orders</span>
                    <span wire:loading>
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Memproses...
        </span>
                </button>
            </div>
        </div>
        <div class="flex flex-col md:flex-row gap-4 m-6">
            <div class="flex-1">
                <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" wire:model="startDate" id="startDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div class="flex-1">
                <label for="endDate" class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" wire:model="endDate" id="endDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div class="flex items-end gap-2">
                <button wire:click="applyFilter" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Apply Filter
                </button>
                <button wire:click="resetFilter" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Reset
                </button>
            </div>
        </div>

        @error('startDate') <span class="text-red-500 text-sm ml-6">{{ $message }}</span> @enderror
        @error('endDate') <span class="text-red-500 text-sm ml-6">{{ $message }}</span> @enderror

        <div class="flex px-6 py-3 bg-gray-50 rounded-lg mx-4 place-content-between mt-2">
            <div class="flex items-center space-x-3">
                <div class="h-6 w-1 bg-indigo-400 rounded-full"></div>
                <h2 class="text-xl font-semibold text-gray-800 tracking-tight">Order Pending</h2>
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
                            <input type="search" wire:model.live="searchOrderPending" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Order Pending" required />
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
                            order_id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Sales
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Toko
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total_harga
                        </th>
                        <th scope="col" class="px-6 py-3">
                            order_date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($dataSalesOrder as $item)
                        <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$item->order_id}}
                            </th>
                            <td class="px-6 py-4">
                                {{$item->sales->namaPanjang}}
                            </td>
                            <td class="px-6 py-4">
                                {{$item->lokasi->namaToko}}
                            </td>

                            <td class="px-6 py-4">
                                Rp. {{$item->total_harga}}
                            </td>
                            <td class="px-6 py-4">
                                {{$item->order_date}}
                            </td>
                            <td class="px-4 py-4 ">
                                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" wire:click = "viewDetail('{{$item->order_id}}')"><i class="fa-solid fa-folder-open"></i></button>
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
                {{$dataSalesOrder->links()}}
            </div>
        </div>

            <div class="flex px-6 py-3 bg-gray-50 rounded-lg mx-4 place-content-between mt-2">
                <div class="flex items-center space-x-3">
                    <div class="h-6 w-1 bg-indigo-400 rounded-full"></div>
                    <h2 class="text-xl font-semibold text-gray-800 tracking-tight">Order Diterima</h2>
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
                                <input type="search" wire:model.live="searchOrderDiterima" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Order Pending" required />
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
                            order_id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Sales
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Toko
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total_harga
                        </th>
                        <th scope="col" class="px-6 py-3">
                            order_date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($dataSalesOrderDiterima as $item)
                        <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$item->order_id}}
                            </th>
                            <td class="px-6 py-4">
                                {{$item->sales->namaPanjang}}
                            </td>
                            <td class="px-6 py-4">
                                {{$item->lokasi->namaToko}}
                            </td>
                            <td class="px-6 py-4">
                                <p>Rp. {{$item->total_harga}}</p>
                            </td>
                            <td class="px-6 py-4">
                                {{$item->order_date}}
                            </td>
                            <td class="px-4 py-4 ">
                                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" wire:click = "viewDetail('{{$item->order_id}}')"><i class="fa-solid fa-folder-open"></i></button>
{{--                                <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" wire:confirm="Apakah Anda Ingin Hapus Order Ini {{$item->order_id}}" wire:click="HapusOrder('{{$item->order_id}}','{{$item->user_id}}')"><i class="fa-solid fa-trash"></i></button>--}}
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th colspan="5" scope="row" class="px-6 py-4 font-medium text-gray-500 whitespace-nowrap bg-gray-200  ">
                                Maaf Data Tidak Ditemukan
                            </th>
                        </tr>
                    @endforelse

                    </tbody>
                </table>

            </div>
            <div class="mt-2 mr-5 ml-5">
                {{$dataSalesOrderDiterima->links()}}
            </div>
        </div>
    </div>
</div>
