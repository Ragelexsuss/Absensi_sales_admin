<?php

namespace App\Livewire;

use App\Models\akun_sales;
use App\Models\SalesLocation;
use App\Models\SalesOrderReport;
use App\Models\SalesReport;
use App\Models\StoreVisit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Factory;
use Livewire\Component;

class LaporanSales extends Component
{
    public $searchtetap;
    public $userId;
    public $isProcessing = false;
    public $progress = 0;
    public $totalDocuments = 0;

    public  $idarea;
    public $role;
    public $processedDocuments = 0;
    public $message = '';
    public function mount(){
        $this->getdata();
        $user = \Illuminate\Support\Facades\Auth::user();
        $this->idarea = $user->id_area;
        $this->role = $user->nama_role;

    }
    public function closealert(){
        $this->message = '';
    }
    public function importData($userId)
    {
        $this->isProcessing = true;
        $this->message = 'Memulai proses import...';
        $this->progress = 0;
        $this->totalDocuments = 0; // Akan diupdate saat memproses
        $this->processedDocuments = 0;

        try {
            $factory = (new Factory())->withServiceAccount(storage_path('app/firebase_credentials.json'));
            $firestore = $factory->createFirestore();
            $database = $firestore->database();

            // Query documents where userId matches
            $documents = $database->collection('laporan_sales')
                ->where('userId', '=', $userId)
                ->documents();

            // Hitung total dokumen sambil memproses
            $count = 0;
            foreach ($documents as $document) {
                $count++;
                if ($document->exists()) {
                    $this->processDocument($document, $database);
                    $this->processedDocuments++;
                }
                $this->totalDocuments = $count;
                $this->progress = ($this->processedDocuments / max(1, $this->totalDocuments)) * 100;
            }

            $this->message = "Import selesai! {$this->processedDocuments} dokumen diproses.";
            session()->put('uidSales', $userId);
            return redirect()->route('home.detail_laporan_sales');
        } catch (\Exception $e) {
            $this->message = "Error: " . $e->getMessage();
        } finally {
            $this->isProcessing = false;
        }
    }

    private function processDocument($document, $database)
    {
        $data = $document->data();
        $documentId = $document->id();

        // Check if already exists in MySQL
        if (SalesReport::query()->where('id_document', $documentId)->exists()) {
            return;
        }

        // Create main report
        $report = SalesReport::query()->create([
            'id_document' => $documentId,
            'date' => $data['date'],
            'date_head'=> $data['tanggal_Dibuat'],
            'user_id' => $data['userId'],
            'sales_name' => $data['namaSales']
        ]);

        // Process tambah_lokasi subcollection
        $locations = $database->collection("laporan_sales/{$documentId}/tambah_lokasi")->documents();
        foreach ($locations as $location) {
            if ($location->exists()) {
                $locData = $location->data();
                SalesLocation::query()->create([
                    'id_document' => $locData['id'],
                    'namaLokasi' => $locData['namaLokasi'],
                    'url' => $locData['url'],
                ]);
            }
        }

        // Process sales_order subcollection
        $orders = $database->collection("laporan_sales/{$documentId}/sales_orders")->documents();
        foreach ($orders as $order) {
            if ($order->exists()) {
                $orderData = $order->data();
                SalesOrderReport::query()->create([
                    'id_document' => $orderData['id'],
                    'idOrder' => $orderData['idOrder'],
                    'total_amount' => $orderData['total_amount'],
                    'total_items' => $orderData['total_items'],
                ]);
            }
        }

        // Process kunjungan_toko subcollection
        $visits = $database->collection("laporan_sales/{$documentId}/Kunjungan_Toko")->documents();
        foreach ($visits as $visit) {
            if ($visit->exists()) {
                $visitData = $visit->data();
                StoreVisit::query()->create([
                    'id_document' => $visitData['id'],
                    'date' => $visitData['visitTime'],
                    'namaToko' => $visitData['namaToko'],
                    'notes' => $visitData['notes'],
                    'url' => $visitData['url'],
                ]);
            }
        }
    }
    public function getdata()
    {
        try {
            $firestore = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'))
                ->createFirestore();
            $database = $firestore->database();
            $salesCollection = $database->collection('users');
            $documents = $salesCollection->documents();
            if($documents->isEmpty()){
                $this->addError('firebase', 'tidak ada data yang dibuat');
                return;
            }
            foreach ($documents as $document) {
                if($document->exists()) {
                    $data = $document->data();
                    $this->id_sales = $document->id();

//          cek apakah data sudah ada di sql
                    $existingSales = akun_sales::query()->where('id_sales',$this->id_sales)->first();
                    if($existingSales){
                        $existingSales->update([
                            'id_sales' => $this->id_sales,
                            'email' => $data['email'],
                            'alamat' => $data['alamat'],
                            'kota' => $data['kota'],
                            'namaPanjang' => $data['namaPanjang'],
                            'noTelepon' => $data['noTelepon'],
                            'status' => $data['status']

                        ]);
                        session()->flash('message', 'Data sales berhasil diUpdate');

                    }else{
                        DB::beginTransaction();
                        akun_sales::query()->create([
                            'id_sales' => $this->id_sales,
                            'email' => $data['email'],
                            'alamat' => $data['alamat'],
                            'kota' => $data['kota'],
                            'namaPanjang' => $data['namaPanjang'],
                            'noTelepon' => $data['noTelepon'],
                            'status' => $data['status'],
                        ]);
                        DB::commit();
                        session()->flash('message', 'Data sales berhasil disinkronisasi');
                    }

                }
            }

        }catch (\Exception $e){
            $this->addError('firebase','Gagal Mengakses Firebase: ' .  $e->getMessage());
        }
    }
    public function render()
    {
        if ($this->role == 'admin'){
            $dataSales = akun_sales::query()->where('namaPanjang', 'like', '%' . $this->searchtetap . '%')->where('status', true)->orderBy('id', 'desc')->paginate(5);
        }else{
            $dataSales = akun_sales::query()->where('namaPanjang', 'like', '%' . $this->searchtetap . '%')->where('kota',$this->idarea)->where('status', true)->orderBy('id', 'desc')->paginate(5);
        }
        return view('livewire.laporan-sales', compact('dataSales'));
    }
}
