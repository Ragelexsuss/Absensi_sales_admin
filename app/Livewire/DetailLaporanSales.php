<?php

namespace App\Livewire;

use App\Models\SalesReport;
use Livewire\Component;

class DetailLaporanSales extends Component
{
    public $id_sales;
    public $startDate;
    public $endDate;
    public $formattedStartDate;
    public $formattedEndDate;
    public $datalaporan;


    public function mount()
    {
        $this->id_sales = session()->get('uidSales');
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($this->startDate && $this->endDate) {
            $this->formatDates();
        }
    }

    private function formatDates()
    {
        try {
            $start = \Carbon\Carbon::parse($this->startDate);
            $end = \Carbon\Carbon::parse($this->endDate);

            $this->formattedStartDate = $start->format('y-m-d');
            $this->formattedEndDate = $end->format('y-m-d');

        } catch (\Exception $e) {
            $this->formattedStartDate = null;
            $this->formattedEndDate = null;
        }
    }
    protected $rules = [
        'startDate' => 'required|date',
        'endDate' => 'required|date|after_or_equal:startDate'
    ];

    public function submit()
    {
        $this->validate();
        $this->formatDates();

        // Emit event dengan data yang diformat
        $this->dispatch('datesSelected', [
            'start' => $this->formattedStartDate,
            'end' => $this->formattedEndDate
        ]);

        // Atau bisa langsung digunakan
        session()->flash('message', 'Range tanggal dipilih: ' .
            $this->formattedStartDate . ' sampai ' . $this->formattedEndDate);

    }
    public function viewlaporanHarian($id_document)
    {
        session()->put('id_document', $id_document);
        return redirect()->route('home.detail_laporan_sales_hari');
    }
    public function render()
    {
        $datalaporans = $this->datalaporan = SalesReport::query()->whereBetween('date', [$this->formattedStartDate, $this->formattedEndDate])->where('user_id', $this->id_sales)->get();
        return view('livewire.detail-laporan-sales', compact('datalaporans'));
    }
}
