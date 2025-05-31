<div class="flex flex-col h-screen">
    <p>{{$user->t0_role->nama_role}}</p>
    <!-- Header Section (Fixed) -->
    <div class="bg-white shadow-sm lg:sticky top-0 z-10">
        <div class="grid grid-cols-1">
            <div class="flex font-sans m-6 text-2xl font-bold text-gray-800 place-content-between">
                <div class="font-sans text-2xl font-bold text-gray-800">
                    <h1>Detail Mission</h1>
                </div>
                <div class="flex items-center justify-center ">
                    <button type="button" wire:click = "show_addMission" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5  dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Tambah Mission</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scrollable Content Section -->
    <div class="flex-1 overflow-y-auto px-4 pb-4 py-4">
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
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 bg-gray-100 uppercase dark:bg-gray-700 dark:text-gray-400 text-center sticky top-0">
                <tr>
                    <th scope="col" class="px-6 py-3">ID Mission</th>
                    <th scope="col" class="px-6 py-3">Foto Toko</th>
                    <th scope="col" class="px-6 py-3">Nama Toko</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($missions as $item)
                    <tr class="text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$item->id_mission}}
                        </td>
                        <td class="px-6 py-4">
                            <div class="w-20 h-20 mx-auto overflow-hidden rounded">
                                @if($item->lokasi->image_url)
                                    <img src="{{ $item->lokasi->image_url }}"
                                         alt="Foto Toko"
                                         class="object-cover w-full h-full">
                                @else
                                    <div class="bg-gray-200 w-full h-full flex items-center justify-center">
                                        <i class="fas fa-store text-gray-400 text-xl"></i>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">{{$item->lokasi->address}}</td>
                        <td class="px-6 py-4">
                            @if($item->status === true)
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Aktif</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <button type="button" wire:click="validasi_mission('{{ $item->id_mission }}', true)"  class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                <i class="fa-solid fa-check"></i>
                            </button>

                            <button type="button" wire:click="validasi_mission('{{ $item->id_mission }}', false)" wire:confirm="Apakah Anda Yakin Ingin Menonaktifkan Lokasi Mission Ini?" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 bg-gray-100">
                            Maaf Data Tidak Ditemukan
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{$missions->links()}}
        </div>
            <!-- Location Selection Modal -->
            @if($openModal)
                <div class="fixed inset-0 z-50 overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <!-- Background Overlay -->
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>

                        <!-- Modal Content -->
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                    Daftar Lokasi
                                </h3>

                                <!-- Search Box -->
                                <div class="mb-4">
                                    <input type="text"
                                           wire:model.live="locationSearch"
                                           placeholder="Cari lokasi..."
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <!-- Location List -->
                                <div class="max-h-96 overflow-y-auto">
                                    <ul class="divide-y divide-gray-200">
                                        @forelse($lokasi as $location)
                                            <li wire:click="selectLocation({{ $location->id }})"
                                                class="px-4 py-4 cursor-pointer hover:bg-gray-50 transition-colors
                                {{ $selectedLocation == $location->id ? 'bg-gray-100' : '' }}">
                                                <div class="flex items-center">
                                                    <!-- Location Photo -->
                                                    <div class="flex-shrink-0 h-16 w-16">
                                                        @if($location->image_url)
                                                            <img class="h-full w-full rounded-md object-cover"
                                                                 src="{{ $location->image_url }}"
                                                                 alt="{{ $location->name }}">
                                                        @else
                                                            <div class="h-full w-full rounded-md bg-gray-200 flex items-center justify-center">
                                                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Location Details -->
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $location->name }}
                                                            @if($selectedLocation == $location->id)
                                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Dipilih
                                            </span>
                                                            @endif
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $location->namaToko }}
                                                        </div>
                                                        <div class="mt-1 text-xs text-gray-500">
                                                            Kode: {{ $location->code }} |
                                                            Status:
                                                            <span class="{{ $location->status ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $location->status ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="px-4 py-4 text-center text-gray-500">
                                                Tidak ada lokasi ditemukan
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button wire:click="addMission"
                                        type="button"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm
                        {{ !$selectedLocation ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ !$selectedLocation ? 'disabled' : '' }}>
                                    Tambah Mission
                                </button>
                                <button wire:click="closeModal"
                                        type="button"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
    </div>
</div>
