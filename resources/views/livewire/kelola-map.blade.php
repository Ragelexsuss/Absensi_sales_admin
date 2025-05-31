<div>
   <div class="grid grid-cols-1">
       @if (session()->has('message'))
           <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded m-4">
               {{ session('message') }}
           </div>
       @endif

       @error('error')
       <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded my-4">
           {{ $message }}
       </div>
       @enderror
       <div class="flex font-sans m-6  text-2xl font-bold text-gray-800 place-content-between">
           <div class="font-sans  text-3xl font-bold text-gray-800">
               <h1>Kelola Map</h1>
           </div>
           <div class="flex items-center justify-center ">
               <button type="button" wire:click = "viewmap" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5  dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">List Map</button>
           </div>
       </div>
           <div class="flex font-sans mr-4 ml-4  text-2xl font-bold text-gray-800 place-content-between">
               <div class="font-sans  text-2xl font-bold text-gray-800">
                   <h1>Lokasi Baru</h1>
               </div>
               <div>
                   <div class="max-w-md mx-auto">
                       <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                       <div class="relative">
                           <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                               <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                   <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                               </svg>
                           </div>
                           <input type="search" wire:model.live="searchbaru" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Lokasi Baru" required />
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
                               ID Lokasi
                           </th>
                           <th scope="col" class="px-6 py-3">
                               Foto Toko
                           </th>
                           <th scope="col" class="px-6 py-3">
                               Nama Toko
                           </th>
                           <th scope="col" class="px-6 py-3">
                               Alamat
                           </th>
                           <th scope="col" class="px-6 py-3">
                               radius
                           </th>
                           <th scope="col" class="px-6 py-3">
                               User Sales
                           </th>
                           <th scope="col" class="px-6 py-3">
                               Action
                           </th>
                       </tr>
                       </thead>
                       <tbody>
                       @forelse($databaru as $item)
                           <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                               <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                   {{$item->id_lokasi}}
                               </th>
                               <td class="px-6 py-4">
                                   <div class="w-20 h-20 mx-auto overflow-hidden rounded">
                                       @if($item->image_url)
                                           <img src="{{ $item->image_url }}"
                                                alt="Foto Toko"
                                                class="object-cover w-full h-full">
                                       @else
                                           <div class="bg-gray-200 w-full h-full flex items-center justify-center">
                                               <i class="fas fa-store text-gray-400 text-xl"></i>
                                           </div>
                                       @endif
                                   </div>
                               </td>
                               <td class="px-6 py-4">
                                   {{$item->namaToko}}
                               </td>
                               <td class="px-6 py-4">
                                   {{$item->address}}
                               </td>
                               <td class="px-6 py-4">
                                   {{$item->radius}}
                               </td>
                               <td class="px-6 py-4">
                                   {{$item->userSales}}
                               </td>
                               <td class="px-4 py-4 ">
                                   <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" wire:click = "viewDetail('{{$item->order_id}}')"><i class="fa-solid fa-folder-open"></i></button>
                                   <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" wire:click="validasiLokasi('{{$item->id_lokasi}}','{{$item->namaToko}}')"><i class="fa-solid fa-check"></i></button>
                               </td>
                           </tr>
                       @empty
                           <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                               <th colspan="7" scope="row" class="px-6 py-4 font-medium text-gray-500 whitespace-nowrap bg-gray-200  ">
                                   Maaf Data Tidak Ditemukan
                               </th>
                           </tr>
                       @endforelse

                       </tbody>
                   </table>
                   <div class="mt-2 mr-5 ml-5 p-4">
                       {{ $databaru->withQueryString()->links('pagination::tailwind', ['pageName' => 'pagebaru']) }}
                   </div>

               </div>
           </div>

           <div class="flex font-sans mr-4 ml-4  text-2xl font-bold text-gray-800 place-content-between">
               <div class="font-sans  text-2xl font-bold text-gray-800">
                   <h1>Lokasi Tetap</h1>
               </div>
               <div>
                   <div class="max-w-md mx-auto">
                       <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                       <div class="relative">
                           <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                               <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                   <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                               </svg>
                           </div>
                           <input type="search" wire:model.live="searchtetap" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Lokasi Baru" required />
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
                               ID Lokasi
                           </th>
                           <th scope="col" class="px-6 py-3">
                               Foto Toko
                           </th>
                           <th scope="col" class="px-6 py-3">
                               Nama Toko
                           </th>
                           <th scope="col" class="px-6 py-3">
                               Alamat
                           </th>
                           <th scope="col" class="px-6 py-3">
                               radius
                           </th>
                           <th scope="col" class="px-6 py-3">
                               User Sales
                           </th>
                           <th scope="col" class="px-6 py-3">
                               Action
                           </th>
                       </tr>
                       </thead>
                       <tbody>
                       @forelse($datatetap as $item)
                           <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                               <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                   {{$item->id_lokasi}}
                               </th>
                               <td class="px-6 py-4">
                                   <div class="w-20 h-20 mx-auto overflow-hidden rounded">
                                       @if($item->image_url)
                                           <img src="{{ $item->image_url }}"
                                                alt="Foto Toko"
                                                class="object-cover w-full h-full">
                                       @else
                                           <div class="bg-gray-200 w-full h-full flex items-center justify-center">
                                               <i class="fas fa-store text-gray-400 text-xl"></i>
                                           </div>
                                       @endif
                                   </div>
                               </td>
                               <td class="px-6 py-4">
                                   {{$item->namaToko}}
                               </td>
                               <td class="px-6 py-4">
                                   {{$item->address}}
                               </td>
                               <td class="px-6 py-4">
                                   {{$item->radius}}
                               </td>
                               <td class="px-6 py-4">
                                   {{$item->userSales}}
                               </td>
                               <td class="px-4 py-4 ">
                                   <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" wire:click = "viewDetail('{{$item->order_id}}')"><i class="fa-solid fa-folder-open"></i></button>
                                   <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" wire:confirm="Apakah Anda Ingin Hapus Order Ini {{$item->order_id}}" wire:click="HapusOrder('{{$item->order_id}}','{{$item->user_id}}')"><i class="fa-solid fa-trash"></i></button>
                               </td>
                           </tr>
                       @empty
                           <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                               <th colspan="7" scope="row" class="px-6 py-4 font-medium text-gray-500 whitespace-nowrap bg-gray-200  ">
                                   Maaf Data Tidak Ditemukan
                               </th>
                           </tr>
                       @endforelse

                       </tbody>
                   </table>

               </div>
               <div class="mt-2 mr-5 ml-5 p-4">
                   {{ $datatetap->withQueryString()->links('pagination::tailwind', ['pageName' => 'pagetetap']) }}
               </div>
           </div>
   </div>

</div>
