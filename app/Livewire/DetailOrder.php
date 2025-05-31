<?php

namespace App\Livewire;

use App\Models\t0area;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Factory;
use Livewire\Component;

class DetailOrder extends Component
{
    public $id_order;
    public $idsales;
    public $data = [];
    public $dataOrder;
    public function mount(){
        $this->id_order= session()->get('order_id');
        $data = \App\Models\SalesOrder::query()->where('order_id', $this->id_order)->first();
        $this->idsales = $data->user_id;
        $this->getdata();


    }
    public function getdata()
    {
        try {

            $data = \App\Models\SalesOrder::query()->where('order_id', $this->id_order)->first();
            $this->dataOrder = $data;
            $dataDecode = json_decode($data->order_data, true);
            $this->data = $dataDecode;
        }catch (\Exception $e){
            return $this->addError('error', $e->getMessage());
        }
        return $this->data;
    }
    public function validasi()
    {
        try {
            DB::beginTransaction();


            // Update status di database lokal
            \App\Models\SalesOrder::query()
                ->where('order_id', $this->id_order)
                ->update(['status' => true]);

            // Inisialisasi Firestore
            $firestore = (new Factory())
                ->withServiceAccount(storage_path('app/firebase_credentials.json'))
                ->createFirestore();

            $database = $firestore->database();

            // Referensi ke dokumen order di Firestore
            $orderDocRef = $database
                ->collection('users')
                ->document($this->idsales)
                ->collection('orders')
                ->document($this->id_order);

            // Update status di Firestore
            $orderDocRef->update([
                ['path' => 'status', 'value' => true]
            ]);

            // Commit transaksi lokal
            DB::commit();

            session()->flash('message', 'Order Berhasil Diproses');
            return redirect()->route('home.salesorder');
        } catch (\Throwable $e) {
            DB::rollBack(); // Rollback jika terjadi error
            return $this->addError('error', $e->getMessage());
        }

    }
    public function render()
    {
        return view('livewire.detail-order');
    }
}
