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
           <div class="flex items-center justify-center">
               <button type="button" wire:click = "viewmaps" class="mr-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5  dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">List Map Baru</button>
               <button type="button" wire:click = "viewmap" class="  text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5  dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">List Map Tetap</button>
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
                                   <button type="button" wire:click="editlokasibaru({{$item->id_lokasi}})" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" wire:click = "viewDetail('{{$item->order_id}}')"><i class="fa-solid fa-folder-open"></i></button>
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
                                   <button type="button" wire:click="editlokasitetap({{$item->id_lokasi}})" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" wire:click = "viewDetail('{{$item->order_id}}')"><i class="fa-solid fa-folder-open"></i></button>
                                   <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" wire:confirm="Apakah Anda Ingin Hapus Lokasi Ini {{$item->namaToko}}" wire:click="deleteLokasi('{{$item->id_lokasi}}','{{$item->namaToko}}')"><i class="fa-solid fa-trash"></i></button>
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
           @if($modaleditbaru)
               <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none bg-black bg-opacity-50">
                   <div class="relative w-auto max-w-3xl mx-auto my-6">
                       <!-- Modal content -->
                       <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                           <!-- Modal header -->
                           <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                               <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                   Edit Lokasi Baru
                               </h3>
                               <button wire:click="closemodalbaru" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                   <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                       <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                   </svg>
                               </button>
                           </div>
                           <!-- Modal body -->
                           <form wire:submit.prevent="editlokasifirebase" class="p-6 space-y-4">
                               <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                   <div>
                                       <label for="id_sales" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID Lokasi</label>
                                       <input type="text" wire:model="idlokasi" id="id_sales" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" readonly>
                                   </div>
                                   <div>
                                       <label for="namaPanjang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Toko</label>
                                       <input type="text" wire:model="namatoko" id="namaPanjang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                   </div>
                                   <div>
                                       <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                                       <input type="text" wire:model="alamat" id="alamat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                   </div>
                                   <div>
                                       <label for="radius" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Radius</label>
                                       <input type="number" wire:model="radius" id="radius" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                   </div>
                               </div>
                               <!-- Modal footer -->
                               <div class="flex items-center pt-4 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                   <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan Perubahan</button>
                                   <button type="button" wire:click="closemodalbaru" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
           @endif

           @if($modaledittetap)
               <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none bg-black bg-opacity-50">
                   <div class="relative w-auto max-w-3xl mx-auto my-6">
                       <!-- Modal content -->
                       <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                           <!-- Modal header -->
                           <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                               <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                   Edit Lokasi Tetap
                               </h3>
                               <button wire:click="closemodaltetap" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                   <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                       <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                   </svg>
                               </button>
                           </div>
                           <!-- Modal body -->
                           <form wire:submit.prevent="editlokasifirebase" class="p-6 space-y-4">
                               <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                   <div>
                                       <label for="id_sales" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID Lokasi</label>
                                       <input type="text" wire:model="idlokasi" id="id_sales" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" readonly>
                                   </div>
                                   <div>
                                       <label for="namaPanjang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Toko</label>
                                       <input type="text" wire:model="namatoko" id="namaPanjang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                   </div>
                                   <div>
                                       <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                                       <input type="text" wire:model="alamat" id="alamat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                   </div>
                                   <div>
                                       <label for="radius" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Radius</label>
                                       <input type="number" wire:model="radius" id="radius" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                   </div>
                               </div>
                               <!-- Modal footer -->
                               <div class="flex items-center pt-4 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                   <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan Perubahan</button>
                                   <button type="button" wire:click="closemodaltetap" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
           @endif
   </div>

</div>
