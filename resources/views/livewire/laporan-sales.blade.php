<div>
    <div class="grid grid-cols-1">
        @if($message)
                <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="ms-3 text-sm font-medium text-black">
                        {{$message}}
                    </div>
                    <button type="button" wire:click="closealert" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-black rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-red-400 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            @endif

        @error('error')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded my-4">
            {{ $message }}
        </div>
        @enderror
            <div class="flex items-center space-x-3 m-6  text-2xl place-content-between">
                <div class="flex items-center space-x-3">
                    <div class="h-9 w-1 bg-indigo-600 rounded-full"></div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Laporan Sales</h1>
                </div>
            </div>
            <div class="p-4 m-2 rounded-xl bg-gray-200 shadow-lg">
                <div class="flex px-6 py-3 bg-gray-50 rounded-lg mx-4 place-content-between mt-2">
                    <div class="flex items-center space-x-3">
                        <div class="h-6 w-1 bg-indigo-400 rounded-full"></div>
                        <h2 class="text-lg font-semibold text-gray-800 tracking-tight">List Sales</h2>
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
                                    <input type="search" wire:model.live="searchtetap" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Sales Tetap" required />
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
                                    ID Sales
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama Panjang
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Alamat
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($dataSales as $item)
                                <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$item->id_sales}}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{$item->namaPanjang}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$item->alamat}}
                                    </td>
                                    <td class="px-6 py-4">
                                        <p>Akun Aktif</p>
                                    </td>
                                    <td class="px-4 py-4 ">
                                        <button type="button" class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900" wire:click="importData('{{$item->id_sales}}')"><i class="fa-solid fa-file"></i></button>
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
                        {{$dataSales->links()}}
                    </div>
                </div>
            </div>
    </div>
</div>
