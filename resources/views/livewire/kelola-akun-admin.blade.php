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
        <div class="flex items-center space-x-3 m-4">
            <div class="h-9 w-1 bg-indigo-600 rounded-full"></div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Kelola Akun Supervisor</h1>
        </div>
        <div class="flex px-6 py-3 bg-gray-50 rounded-lg mx-4 place-content-between">
            <div class="flex items-center space-x-3">
                <div class="h-6 w-1 bg-indigo-400 rounded-full"></div>
                <h2 class="text-lg font-semibold text-gray-800 tracking-tight">List Akun</h2>
            </div>
            <div>
                <button type="button" wire:click="openModalAddAkuns" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Tambah Akun</button>

            </div>
        </div>
            <div class="p-2 mb-8 mt-2 mr-4 ml-4">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 bg-gray-100 uppercase dark:bg-gray-700 dark:text-gray-400 text-center">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ID Admin
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Panjang
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Alamat
                            </th>
                            <th scope="col" class="px-6 py-3">
                               id_area
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($dataakun as $item)
                            <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$item->id_admin}}
                                </th>
                                <td class="px-6 py-4">
                                    {{$item->nama_lengkap}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$item->alamat}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$item->id_area}}
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->status === true)
                                        Akun Aktif
                                    @else
                                        Akun Tidak Aktif
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <button type="button" wire:click="openmodaleditadmin('{{$item->id_admin}}')"  class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900"><i class="fa-solid fa-pen-to-square"></i></button>

                                </td>

                            </tr>
                        @empty
                            <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th colspan="4" scope="row" class="px-6 py-4 font-medium text-gray-500 whitespace-nowrap bg-gray-200  ">
                                    Maaf Data Tidak Ditemukan
                                </th>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="mt-2 mr-5 ml-5">
                    {{$dataakun->links()}}
                </div>
            </div>

            <div class="flex px-6 py-3 bg-gray-50 rounded-lg mx-4 place-content-between">
                <div class="flex items-center space-x-3">
                    <div class="h-6 w-1 bg-indigo-400 rounded-full"></div>
                    <h2 class="text-lg font-semibold text-gray-800 tracking-tight">List Area</h2>
                </div>
                <div>
                    <button type="button" wire:click="openModalAddKota" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Tambah Area</button>
                    <button type="button" wire:click = "importdata" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Fetch Data Firestore</button>

                </div>
            </div>
            <div class="p-2 mb-8 mt-2 mr-4 ml-4">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 bg-gray-100 uppercase dark:bg-gray-700 dark:text-gray-400 text-center">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ID Area
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Area
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
                        @forelse($dataarea as $item)
                            <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$item->idarea}}
                                </th>
                                <td class="px-6 py-4">
                                    {{$item->nama_area}}
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
                                    @if($item->status === false)
                                        <button type="button" wire:click="validasiarea('{{$item->idarea}}')" wire:confirm="Apakah Anda Yakin Aktifkan Area {{$item->nama_area}}" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><i class="fa-solid fa-check"></i></button>
                                    @else
                                        <button type="button" wire:click="hapusarea('{{$item->idarea}}')" wire:confirm="Apakah Anda Yakin Menghapus Area {{$item->nama_area}}" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"><i class="fa-solid fa-trash-can"></i></button>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th colspan="4" scope="row" class="px-6 py-4 font-medium text-gray-500 whitespace-nowrap bg-gray-200  ">
                                    Maaf Data Tidak Ditemukan
                                </th>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="mt-2 mr-5 ml-5">
                    {{$dataarea->links()}}
                </div>
            </div>



            @if($openModalAddAkun)
                <!-- Main modal -->
                <div tabindex="-1" aria-hidden="true"  class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none bg-black bg-opacity-50">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Tambah Akun Admin
                                </h3>
                                <button type="button" wire:click="closeModalAddAkun" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <form wire:submit.prevent="addakun" class="p-4 md:p-5">
                                @error('password')
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div class="grid gap-4 mb-4 grid-cols-2">
                                    <div class="col-span-2">
                                        <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                                        <input type="text" wire:model="username" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukan Username" required="">
                                    </div>
                                    <div class="col-span-2">
                                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                        <input type="password" wire:model="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukan Password" required="">
                                    </div>
                                    <div class="col-span-2">
                                        <label for="repeatpassword" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Repeat Password</label>
                                        <input type="password" wire:model="repeatPassword" name="repeatpassword" id="repeatpassword" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukan Ulang Password" required="">
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="NamaLengkap" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                                        <input type="text" wire:model="namaLengkap" name="NamaLengkap" id="NamaLengkap" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nama Lengkap" required="">
                                    </div>
                                    <div class="col-span-1 sm:col-span-1">
                                        <label for="Alamat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                                        <input type="text" wire:model="alamat" name="Alamat" id="Alamat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Alamat" required="">
                                    </div>
                                    <div class="col-span-2">
                                        <label for="area" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                                        <select wire:model="idArea" id="area" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                            <option value="">Pilih Area</option>
                                            @forelse($dataArea as $item)
                                                <option value="{{$item->idarea}}">{{$item->nama_area}}</option>
                                            @empty
                                                <option value="">Maaf Data Tidak Ditemukan</option>
                                            @endforelse
                                        </select>
                                        @error('username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="flex justify-end ">
                                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                        Tambah Akun
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @if($modaleditadmin)
                <!-- Main modal -->
                <div tabindex="-1" aria-hidden="true"  class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none bg-black bg-opacity-50">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                   Edit Akun Admin
                                </h3>
                                <button type="button" wire:click="closemodaleditadmin" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <form wire:submit.prevent="updateakun" class="p-4 md:p-5">
                                @csrf
                                @error('password')
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div class="grid gap-4 mb-4 grid-cols-2">
                                    <div class="col-span-2">
                                        <label for="idadmin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID_Admin</label>
                                        <input type="text" wire:model="edit_id_admin" name="edit_id_admin" id="edit_id_admin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="ID Admin" readonly>
                                    </div>
                                    <div class="col-span-2">
                                        <label for="edit_username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                                        <input type="text" wire:model="edit_username" name="edit_username" id="edit_username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Username" required="">
                                    </div>
                                    <div class="col-span-2">
                                        <label for="edit_nama_lengkap" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                                        <input type="text" wire:model="edit_nama_lengkap" name="edit_nama_lengkap" id="edit_nama_lengkap" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nama Lengkap" required="">
                                    </div>
                                    <div class="col-span-2">
                                        <label for="edit_alamat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                                        <input type="text" wire:model="edit_alamat" name="edit_alamat" id="edit_alamat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Alamat" required="">
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="edit_nama_lengkap" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                                        <input type="text" wire:model="edit_nama_lengkap" name="edit_nama_lengkap" id="edit_nama_lengkap" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nama Lengkap" required="">
                                    </div>
                                    <div class="col-span-1">
                                        <label for="edit_status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                        <select wire:model="edit_status" id="edit_status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                            @if($edit_status)
                                                <option value='1' >Valid</option>
                                                <option value='0'>Invalid</option>
                                            @else
                                                <option value='0'>Invalid</option>
                                                <option value='1' >Valid</option>
                                            @endif

                                        </select>
                                        @error('username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-2">
                                        <label for="area" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Area</label>
                                        <select wire:model="idArea" id="area" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                            <option selected value="{{$edit_id_area}}">{{$edit_nama_area}}</option>
                                            @forelse($dataareas as $item)
                                                <option value="{{$item->idarea}}">{{$item->nama_area}}</option>
                                            @empty
                                                <option value="">Maaf Data Tidak Ditemukan</option>
                                            @endforelse
                                        </select>
                                        @error('username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="flex justify-end ">
                                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                        Edit Akun
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif


            @if($openModalAddkota)
            <div tabindex="-1" aria-hidden="true"  class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none bg-black bg-opacity-50">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Tambah Area Baru
                            </h3>
                            <button type="button" wire:click="closeModalAddKota" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" >
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form wire:submit.prevent="addarea" class="p-4 md:p-5">
                            @csrf
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Area</label>
                                    <input wire:model="namaArea" type="text" name="area" id="area" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukan Nama Area" required="">
                                </div>
                            </div>
                            <div class="flex justify-end ">
                                <button type="submit" @if($statusbutton === false) disabled @endif class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                    Tambah Area
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        @endif



    </div>
</div>
