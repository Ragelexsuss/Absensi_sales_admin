<?php

namespace App\Livewire;

use App\Models\lokasi;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Factory;
use Livewire\Component;

class SalesOrder extends Component
{
    public $loading = false;
    public $successMessage = '';
    public $errorMessage = '';
    public $startDate;
    public $endDate;
    public $filterApplied = false;

    public function mount()
    {
        // Set default dates (optional)
        $this->startDate = now()->subDays(7)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->addlokasi();
    }

    public function viewDetail($idOrder){
        try {
            session()->put('order_id', $idOrder);
            return redirect()->route('home.detail_order');
        }catch (\Exception $e){
            $this->errorMessage = "Error: " . $e->getMessage();
        }
        return redirect()->back();
    }
    public function getdata()
    {
        $this->loading = true;
        $this->successMessage = '';
        $this->errorMessage = '';
    DB::beginTransaction();
        try {
            // Inisialisasi Firestore
            $firestore = (new Factory())
                ->withServiceAccount(storage_path('app/firebase_credentials.json'))
                ->createFirestore();

            $database = $firestore->database();
            $usersRef = $database->collection('users');

            // Ambil semua dokumen user
            $userDocuments = $usersRef->documents();

            $totalOrders = 0;

            foreach ($userDocuments as $userDoc) {
                if ($userDoc->exists()) {
                    $userId = $userDoc->id();
                    $userData = $userDoc->data();

                    // Ambil koleksi orders untuk user ini
                    $ordersRef = $usersRef->document($userId)->collection('orders');
                    $orderDocuments = $ordersRef->documents();

                    foreach ($orderDocuments as $orderDoc) {
                        if ($orderDoc->exists()) {
                            $orderData = $orderDoc->data();

                            // Simpan ke MySQL
                            \App\Models\SalesOrder::query()->updateOrCreate(
                                ['order_id' => $orderDoc->id()], // Key untuk identifikasi unik
                                [
                                    'order_id' => $orderDoc->id(),
                                    'user_id' => $userId,
                                    'order_data' => json_encode($orderData['items']),
                                    // Simpan sebagai JSON jika strukturnya kompleks
                                    'idLokasi' => $orderData['idLokasi'],
                                    'total_harga'=> $orderData['total_amount'],
                                    'total_item'=> $orderData['total_items'],
                                    'order_date' => $orderData['order_date'],
                                    'status' => $orderData['status'],
                                ]
                            );

                            $totalOrders++;
                        }
                    }
                }
            }

            $this->successMessage = "Berhasil menyinkronkan $totalOrders orders dari Firestore ke MySQL";
            DB::commit();
            $this->loading = false;

        } catch (\Exception $e) {
            $this->errorMessage = "Error: " . $e->getMessage();
            $this->loading = false;
            DB::rollBack();
        }
    }

    public function HapusOrder($idOrder, $idSales)
    {
        try {
            DB::beginTransaction();
            // Update status di database lokal
            \App\Models\SalesOrder::query()
                ->where('order_id', $idOrder)
                ->update(['status' => false]);

            // Inisialisasi Firestore
            $firestore = (new Factory())
                ->withServiceAccount(storage_path('app/firebase_credentials.json'))
                ->createFirestore();

            $database = $firestore->database();

            // Referensi ke dokumen order di Firestore
            $orderDocRef = $database
                ->collection('users')
                ->document($idSales)
                ->collection('orders')
                ->document($idOrder);

            // Update status di Firestore
            $orderDocRef->update([
                ['path' => 'status', 'value' => false]
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

    public function applyFilter()
    {
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        $this->filterApplied = true;
    }

    public function resetFilter()
    {
        $this->startDate = now()->subDays(7)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->filterApplied = false;
    }
    public function addlokasi(){
        try {
            $firestore = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'))->createFirestore();
            $database = $firestore->database();
            $lokasiCollection = $database->collection('lokasi');
            $documentsLokasi = $lokasiCollection->documents();

            foreach ($documentsLokasi as $document) {
                if($document->exists()) {
                    $data = $document->data();
                    $this->id_lokasi = $document->id();

//          cek apakah data sudah ada di sql
                    $existingSales = lokasi::query()->where('id_lokasi',$data['id'])->first();
                    if($existingSales){
                        $existingSales->update([
                            'id_lokasi' => $data['id'],
                            'userSales' => $data['userSales'],
                            'userToko' => $data['userToko'],
                            'namaToko' => $data['namaToko'],
                            'address' => $data['addres'],
                            'radius' => $data['radius'],
                            'latitude' => $data['latitude'],
                            'longitude' => $data['longitude'],
                            'image_url' => $data['image_url'],
                            'status' => $data['status'],

                        ]);
                    }else{
                        DB::beginTransaction();
                        lokasi::query()->create([
                            'id_lokasi' => $data['id'],
                            'userSales' => $data['userSales'],
                            'userToko' => $data['userToko'],
                            'namaToko' => $data['namaToko'],
                            'address' => $data['addres'],
                            'radius' => $data['radius'],
                            'latitude' => $data['latitude'],
                            'longitude' => $data['longitude'],
                            'image_url' => $data['image_url'],
                            'status' => $data['status'],
                        ]);
                        DB::commit();
                        session()->flash('message', 'Data lokasi berhasil disinkronisasi');
                    }

                }
            }

        }catch (\Exception $e) {
            $this->addError('firebase', 'Gagal mengupdate data: '.$e->getMessage());
            return redirect()->back();
        }
    }

    public function render()
    {
        $pendingQuery = \App\Models\SalesOrder::query()
            ->where('status', false)
            ->orderBy('order_date', 'desc');

        $acceptedQuery = \App\Models\SalesOrder::query()
            ->where('status', true)
            ->orderBy('order_date', 'desc');

        if ($this->filterApplied) {
            $pendingQuery->whereBetween('order_date', [$this->startDate, $this->endDate]);
            $acceptedQuery->whereBetween('order_date', [$this->startDate, $this->endDate]);
        }

        $dataSalesOrder = $pendingQuery->paginate(5);
        $dataSalesOrderDiterima = $acceptedQuery->paginate(5);
        return view('livewire.sales-order', compact('dataSalesOrder','dataSalesOrderDiterima') );
    }
}
