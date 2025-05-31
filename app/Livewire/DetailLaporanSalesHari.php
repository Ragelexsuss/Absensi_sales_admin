<?php

namespace App\Livewire;

use App\Models\SalesReport;
use Livewire\Component;

class DetailLaporanSalesHari extends Component
{
    public $idDocument;
    public function mount()
    {
        $this->idDocument = session()->get('id_document');
    }
    public function render()
    {
        $dataLaporan = SalesReport::query()->where('id_document', $this->idDocument)->paginate(5);
        return view('livewire.detail-laporan-sales-hari', compact('dataLaporan'));
    }
}
