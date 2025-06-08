<?php

namespace App\Livewire;

use App\Models\akun_sales;
use App\Models\lokasi;
use GPBMetadata\Google\Api\Auth;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Factory;
use Livewire\Component;

class KelolaAkun extends Component
{
   public $id_sales='' ;
   public $id_lokasi ='';
   public $id_mission ='';
   public $email='' ;
   public $alamat='' ;
   public $kota='';
   public $namaPanjang ='';
   public $noTelepon='';
   public $searchbaru;
    public $searchtetap;
    public $idarea;
    public $status;
    public  $firestoreStatus;

   public $showModal =  false;
    public $selectedSales = [
        'id_sales' => '',
        'namaPanjang' => '',
        'alamat' => '',
        'noTelepon' => '',
        'email' => '',
        'status' => true
    ];
    public function mount()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $this->idarea = $user->id_area;
    }

    public function showSales($idSales)
    {
        // Fetch the sales data from your database or wherever it's stored
        $sales = akun_sales::query()->where('id_sales', $idSales)->first();

        if ($sales) {
            $this->selectedSales = $sales->toArray();
            $this->showModal = true;
        }
    }
    public function updateSales()
    {
        $validatedData = $this->validate([
            'selectedSales.id_sales' => 'required',
            'selectedSales.namaPanjang' => 'required',
            'selectedSales.alamat' => 'required',
            'selectedSales.noTelepon' => 'required',
            'selectedSales.email' => 'required|email',
             // Ensure status is either Aktif or Nonaktif
        ]);

        DB::beginTransaction();
        try {
            $firestore = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'))->createFirestore();
            $database = $firestore->database();
            $usersRef = $database->collection('users');



            // Find and update MySQL first
            $sales = akun_sales::query()->where('id_sales', $this->selectedSales['id_sales'])->first();
            // Convert status to boolean for Firestore
            if ($this->status == "Aktif"){
                $this->firestoreStatus = true;
            } else if ($this->status == "Nonaktif"){
                $this->firestoreStatus = false;
            } else{
                $this->firestoreStatus = true;
            }


            if (!$sales) {
                throw new \Exception('Akun sales tidak ditemukan di database');
            }

            // Update MySQL - including status
            $sales->update([
                'namaPanjang' => $validatedData['selectedSales']['namaPanjang'],
                'alamat' => $validatedData['selectedSales']['alamat'],
                'noTelepon' => $validatedData['selectedSales']['noTelepon'],
                'email' => $validatedData['selectedSales']['email'],
                'status' => $this->firestoreStatus // This ensures MySQL gets the same boolean value
            ]);

            // Find and update Firestore
            $query = $usersRef->where('uid', '=', $this->selectedSales['id_sales']);
            $snapshot = $query->documents();

            if ($snapshot->isEmpty()) {
                throw new \Exception('Akun tidak ditemukan di Firestore');
            }

            foreach ($snapshot as $document) {
                if ($document->exists()) {
                    $documentRef = $usersRef->document($document->id());
                    $documentRef->update([
                        ['path' => 'status', 'value' => $this->firestoreStatus],
                        ['path' => 'namaPanjang', 'value' => $this->selectedSales['namaPanjang']],
                        ['path' => 'alamat', 'value' => $this->selectedSales['alamat']],
                        ['path' => 'noTelepon', 'value' => $this->selectedSales['noTelepon']],
                        ['path' => 'email', 'value' => $this->selectedSales['email']]
                    ]);
                    break;
                }
            }

            DB::commit();
            session()->flash('message', 'Data sales '.$this->selectedSales['namaPanjang'].' berhasil diperbarui');
            $this->closeModal();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->closeModal();
            $this->reset($this->status);
            $this->addError('firebase', 'Gagal mengupdate data: '.$e->getMessage());
            return false;
        }
    }
    public function viewMission($idSales)
    {
        session()->put('selected_sales_id', $idSales);
// ini create data mission
        try {
            $firestore = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'))->createFirestore();
            $database = $firestore->database();
            $missionCollection = $database->collection('users')->document($idSales)->collection('mission');
            $documents = $missionCollection->documents();

            foreach ($documents as $document) {
                if($document->exists()) {
                    $data = $document->data();
                    $this->id_mission = $document->id();

//          cek apakah data sudah ada di sql
                    $existingSales = \App\Models\mission::query()->where('id_mission',$data['idMission'])->where('id_sales', $idSales)->first();
                    if($existingSales){
                        $existingSales->update([
                            'id_sales' => $idSales,
                            'id_mission' => $data['idMission'],
                            'id_lokasi' => $data['idLokasi'],
                            'status' => $data['status'],
                        ]);
                        session()->flash('message', 'Data Mission berhasil diUpdate');

                    }else{
                        DB::beginTransaction();
                        \App\Models\mission::query()->create([
                            'id_sales' => $idSales,
                            'id_mission' => $data['idMission'],
                            'id_lokasi' => $data['idLokasi'],
                            'status' => $data['status'],
                        ]);
                        DB::commit();
                        session()->flash('message', 'Data Mission berhasil disinkronisasi');
                    }

                }
            }

        }catch (\Exception $e) {
            $this->addError('firebase', 'Gagal mengupdate data: '.$e->getMessage());
            return redirect()->back();
        }
// ini create data lokasi
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
                        session()->flash('message', 'Data Lokasi berhasil diUpdate');

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


        return redirect()->route('home.mission');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedSales = [];
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
   public function validasi_Akun($uid, $namapanjang)
    {
        try {
            $firestore = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'))->createFirestore();

            $database = $firestore->database();
            $usersRef = $database->collection('users');

//            Cari User Sales
            $query = $usersRef->where('uid','=',$uid);
            $snapshot = $query->documents();

            if ($snapshot->isEmpty()) {
                $this->addError('sales', 'Akun tidak ditemukan');
                return;
            }
            // Mulai transaksi database lokal (MySQL)
            DB::beginTransaction();

            foreach ($snapshot as $document) {
                if ($document->exists()) {
                    // 1. Update status di Firestore (false → true)
                    $documentRef = $usersRef->document($document->id());
                    $documentRef->update([
                        ['path' => 'status', 'value' => true]
                    ]);

                    // 2. Update status di tabel `akun_sales` (MySQL)
                    akun_sales::query()->where('id_sales', $uid)->update([
                        'status' => true
                    ]);

                    // Commit transaksi jika berhasil
                    DB::commit();
                    session()->flash('message', 'Data Sales '.$namapanjang.' Berhasil Divalidasi');
                    return true; // Berhasil update di Firestore & MySQL
                }
            }

            // Rollback jika gagal
            DB::rollBack();

            $this->addError('sales', 'Gagal mengupdate status');
            return false;
        }catch (\Exception $e){
            $this->addError('firebase','Gagal Mengakses Firebase: '.$e->getMessage());
        }

    }

    public function render()
    {
        $dataSalesValidate = akun_sales::query()->where('namaPanjang', 'like', '%' . $this->searchbaru . '%')->where('status', false)->where('kota', $this->idarea)->orderBy('id', 'desc')->paginate(8);
        $dataSales = akun_sales::query()->where('namaPanjang', 'like', '%' . $this->searchtetap . '%')->where('kota',$this->idarea)->where('status', true)->orderBy('id', 'desc')->paginate(8);

        return view('livewire.kelola-akun', compact('dataSales', 'dataSalesValidate'));
    }
}
