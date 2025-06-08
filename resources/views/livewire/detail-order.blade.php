<div>
    <div class="grid grid-cols-1 m-2">
        @error('error')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded my-4">
            {{ $message }}
        </div>
        @enderror
        <div class="flex font-sans m-6  text-2xl font-bold text-gray-800 place-content-between">
            <div class="font-sans  text-2xl font-bold text-gray-800">
                <h1>Detail Order</h1>
            </div>
<div class="flex items-center justify-center ">
    <button type="button" wire:click = "validasi" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" wire:confirm="Apakah Anda Yakin Validasi Orderan Ini?">Validasi Order</button>
</div>
</div>

<div class="p-2 mb-8 mt-2 mr-4 ml-4">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 bg-gray-100 uppercase dark:bg-gray-700 dark:text-gray-400 text-center">
            <tr>
                <th scope="col" class="px-6 py-3">
                    product_id
                </th>
                <th scope="col" class="px-6 py-3">
                    User Id
                </th>
                <th scope="col" class="px-6 py-3">
                    Total_harga
                </th>
                <th scope="col" class="px-6 py-3">
                    Jumlah order (Box)
                </th>
            </tr>
            </thead>
            <tbody>
            @forelse($data as  $index => $item)
                <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{$item['product_id']}}
                    </th>
                    <td class="px-6 py-4">
                        {{$item['product_name']}}
                    </td>
                    <td class="px-6 py-4">
                        <p>Rp. {{$item['total_price']}}</p>
                    </td>
                    <td class="px-6 py-4">
                        {{$item['quantity_order']}}
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
</div>
<div class="flex font-sans m-6  text-2xl font-bold text-gray-800 place-content-between">
    <div>

    </div>
    <div>
        <h1>Total: Rp. {{$dataOrder->total_harga}}</h1>
    </div>
</div>
</div>

</div>
