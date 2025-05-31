<div>
    <div class="grid grid-cols-1 gap-6">
        <!-- Judul Utama -->
        <div class="px-6 pt-6 pb-2">
            <div class="flex items-center space-x-3">
                <div class="h-9 w-1 bg-indigo-600 rounded-full"></div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Detail Laporan Sales</h1>
            </div>
        </div>

        <!-- Section Lokasi Ditambahkan -->
        <div class="px-6 py-3 bg-gray-50 rounded-lg mx-4">
            <div class="flex items-center space-x-3">
                <div class="h-6 w-1 bg-indigo-400 rounded-full"></div>
                <h2 class="text-lg font-semibold text-gray-800 tracking-tight">Lokasi Ditambahkan</h2>
            </div>
            <div class="p-2 mb-8 mt-2 mr-4 ml-4">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 bg-gray-100 uppercase dark:bg-gray-700 dark:text-gray-400 text-center">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                id_document
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Gambar Lokasi
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Lokasi
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($dataLaporan as $item)
                            <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$item->tambahLokasi->id_document ?? '-'}}
                                </th>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center">
                                        @if($item->tambahLokasi->url ?? false)
                                            <img src="{{$item->tambahLokasi->url}}" class="w-20 h-auto rounded object-cover" />
                                            @else
                                            <p>-</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    {{$item->tambahLokasi->namaLokasi ?? '-'}}
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
                    {{$dataLaporan->links()}}
                </div>
            </div>
        </div>

        <!-- Section Sales Order -->
        <div class="px-6 py-3 bg-gray-50 rounded-lg mx-4">
            <div class="flex items-center space-x-3">
                <div class="h-6 w-1 bg-indigo-400 rounded-full"></div>
                <h2 class="text-lg font-semibold text-gray-800 tracking-tight">Sales Order</h2>
            </div>
            <div class="p-2 mb-8 mt-2 mr-4 ml-4">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 bg-gray-100 uppercase dark:bg-gray-700 dark:text-gray-400 text-center">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ID Document
                            </th>
                            <th scope="col" class="px-6 py-3">
                                ID Order
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total Item
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total Harga
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($dataLaporan as $item)
                            <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$item->orderreport->id_document ?? '-'}}
                                </th>
                                <td class="px-6 py-4">
                                    {{$item->orderreport->idOrder ?? '-'}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$item->orderreport->total_items ?? '-'}} Box
                                </td>
                                <td class="px-6 py-4">
                                   Rp. {{$item->orderreport->total_amount ?? '-'}}
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
                    {{$dataLaporan->links()}}
                </div>
             </div>
        </div>

        <!-- Section Kunjungan Toko -->
        <div class="px-6 py-3 bg-gray-50 rounded-lg mx-4">
            <div class="flex items-center space-x-3">
                <div class="h-6 w-1 bg-indigo-400 rounded-full"></div>
                <h2 class="text-lg font-semibold text-gray-800 tracking-tight">Kunjungan Toko</h2>
            </div>
            <div class="p-2  mr-4 ml-4">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 bg-gray-100 uppercase dark:bg-gray-700 dark:text-gray-400 text-center">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ID Document
                            </th>
                            <th>
                                Gambar
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Toko
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Notes
                            </th>
                            <th scope="col" class="px-6 py-3">
                                created_at
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($dataLaporan as $item)
                            <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$item->storevisit->id_document ?? '-'}}
                                </th>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center">
                                        @if($item->storevisit->url ?? false)
                                            <img src="{{$item->storevisit->url}}" class="w-20 h-auto rounded object-cover" />
                                        @else
                                            <p>-</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    {{$item->storevisit->namaToko ?? '-'}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$item->storevisit->notes ?? '-'}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$item->storevisit->date ?? '-'}}
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
                    {{$dataLaporan->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
