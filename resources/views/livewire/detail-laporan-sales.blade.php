<div>
    <div class=" grid grid-cols-1">
    <div class="px-6 py-5">
        <div class="flex items-center space-x-3">
            <div class="h-9 w-1 bg-indigo-600 rounded-full"></div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Analisis Performa Sales</h1>
        </div>
        <div class="m-4">
            <form wire:submit.prevent="submit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="startDate" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input
                            type="date"
                            id="startDate"
                            wire:model="startDate"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                        @error('startDate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="endDate" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                        <input
                            type="date"
                            id="endDate"
                            wire:model="endDate"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                        @error('endDate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                    <button
                        type="submit"
                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>Pilih Tanggal</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </form>

            @if($formattedStartDate && $formattedEndDate)
                <div class="mt-4 p-3 bg-blue-50 rounded-md">
                    <p class="text-sm text-blue-800">
                        Format yang dipilih:
                        <br>
                        <strong>Mulai:</strong> {{ $formattedStartDate }}
                        <br>
                        <strong>Akhir:</strong> {{ $formattedEndDate }}
                    </p>
                </div>
            @endif
        </div>

            @foreach($datalaporans as $item)
            <div class="bg-white shadow-sm rounded-lg m-2">
                <div class="px-6 py-5 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Detail Laporan Sales</h1>
                                <p class="text-sm text-gray-500 mt-1">Ringkasan lengkap aktivitas sales harian</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-500">{{$item->date_head}}</p>
                                <p class="text-lg font-semibold text-gray-800">{{$item->sales_name}}</p>
                            </div>
                            <button type="button" wire:click="viewlaporanHarian('{{$item->id_document}}')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

    </div>
    </div>
</div>
