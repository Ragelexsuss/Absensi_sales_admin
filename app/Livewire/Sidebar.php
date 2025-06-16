<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public $nama = "";
    public $role = "";
    public function mount()
    {
        $user = Auth::user();
        if($user){
            $this->nama = $user->nama_lengkap;
            $this->role = $user->nama_role;
        }
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.sidebar');
    }
}
