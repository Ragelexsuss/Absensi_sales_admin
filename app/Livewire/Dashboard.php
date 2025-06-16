<?php

namespace App\Livewire;

use App\Models\akun_sales;
use GPBMetadata\Google\Api\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $jumlahakun;
    public $jumlahakunaktif;
    public $jumlahlaporan;

    public function mount(){
        // Kelola Akun
        $idarea = \Illuminate\Support\Facades\Auth::user()->id_area;
        $jumlahakun = akun_sales::query()->where('kota',$idarea)->where("status",false)->count();
        $jumlahakunaktif = akun_sales::query()->where('kota',$idarea)->where("status",true)->count();
        $this->jumlahakun = $jumlahakun;
        $this->jumlahakunaktif = $jumlahakunaktif;

    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
