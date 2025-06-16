<?php

namespace App\Livewire;

use App\Models\Lokasi;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Factory;
use Livewire\Component;

class KelolaMap extends Component
{
    public $searchbaru;
    public $searchtetap;
    public $modaleditbaru = false;
    public $modaledittetap = false;



    public $idlokasi;
    public $namatoko;
    public $tempnamatoko;
    public $alamat;
    public $notelepon;
    public $email;
    public $radius;


    public function viewmap()
    {
        return redirect()->route('home.map');
    }
    public function viewmaps()
    {
        return redirect()->route('home.maps');
    }
    public function mount(){
        $this->addlokasi();

    }
    public  function closemodalbaru(){
        $this->modaleditbaru = false;
    }

    public  function closemodaltetap(){
        $this->modaledittetap = false;
    }


    public function editlokasibaru($idlokasi)
    {
        try {
            $this->modaleditbaru = true;
            $datalokasi = lokasi::query()->where('id_lokasi',$idlokasi)->first();
            $this->idlokasi = $datalokasi->id_lokasi;
            $this->namatoko = $datalokasi->namaToko;
            $this->tempnamatoko = $datalokasi->namaToko;
            $this->alamat = $datalokasi->address;
            $this->radius = $datalokasi->radius;
        }catch(\exception $e){
            $this->addError('firebase', 'Gagal Ambil Data: '.$e->getMessage());
            return redirect()->back();
        }
    }

    public function editlokasitetap($idlokasi)
    {
        try {
            $this->modaledittetap = true;
            $datalokasi = lokasi::query()->where('id_lokasi',$idlokasi)->first();
            $this->idlokasi = $datalokasi->id_lokasi;
            $this->namatoko = $datalokasi->namaToko;
            $this->tempnamatoko = $datalokasi->namaToko;
            $this->alamat = $datalokasi->address;
            $this->radius = $datalokasi->radius;
        }catch(\exception $e){
            $this->addError('firebase', 'Gagal Ambil Data: '.$e->getMessage());
            return redirect()->back();
        }
    }

    public function editlokasifirebase()
    {
        try {
            DB::beginTransaction();
            // Update status di database lokal
            \App\Models\lokasi::query()
                ->where('id_lokasi', $this->idlokasi)
                ->update([
                    'namaToko' => $this->namatoko,
                    'address' => $this->alamat,
                    'radius' => $this->radius,
                    ]);

            // Inisialisasi Firestore
            $firestore = (new Factory())
                ->withServiceAccount(storage_path('app/firebase_credentials.json'))
                ->createFirestore();

            $database = $firestore->database();

            // Referensi ke dokumen order di Firestore
            $orderDocRef = $database
                ->collection('lokasi')
                ->document($this->tempnamatoko);

            // Update status di Firestore
            $orderDocRef->update([
                ['path' => 'namaToko', 'value' => $this->namatoko],
                ['path' => 'addres', 'value' => $this->alamat],
                ['path' => 'radius', 'value' => $this->radius],
            ]);

            // Commit transaksi lokal
            DB::commit();
            $this->modaleditbaru = false;
            $this->modaledittetap = false;

            session()->flash('message', 'Lokasi Berhasil Diupdate');
            return redirect()->route('home.kelola_map');
        } catch (\Throwable $e) {
            DB::rollBack(); // Rollback jika terjadi error
            return $this->addError('error', $e->getMessage());
        }
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

    public function validasiLokasi($idLokasi, $namaLokasi)
    {
        try {
            DB::beginTransaction();
            // Update status di database lokal
            \App\Models\lokasi::query()
                ->where('id_lokasi', $idLokasi)
                ->update(['status' => true]);

            // Inisialisasi Firestore
            $firestore = (new Factory())
                ->withServiceAccount(storage_path('app/firebase_credentials.json'))
                ->createFirestore();

            $firestore = $firestore->database();
            $collection = $firestore->collection('lokasi');
            // Referensi ke dokumen order di Firestore
            $orderDocRef = $collection->where('namaToko', '=',$namaLokasi);
            $documents = $orderDocRef->documents();

            foreach ($documents as $document) {
                if($document->exists()) {
                    $documentRef = $collection->document($document->id());
                    $documentRef->update([
                        ['path' => 'status', 'value' => true]
                    ]);
                }
            }
            // Commit transaksi lokal
            DB::commit();

            session()->flash('message', 'Lokasi Berhasil Divalidasi');
            return redirect()->route('home.kelola_map');
        } catch (\Throwable $e) {
            DB::rollBack(); // Rollback jika terjadi error
            return $this->addError('error', $e->getMessage());
        }
    }
    public function deleteLokasi($idLokasi, $namaLokasi)
    {
        try {
            DB::beginTransaction();
            // Update status di database lokal
            \App\Models\lokasi::query()
                ->where('id_lokasi', $idLokasi)
                ->update(['status' => true]);

            // Inisialisasi Firestore
            $firestore = (new Factory())
                ->withServiceAccount(storage_path('app/firebase_credentials.json'))
                ->createFirestore();

            $firestore = $firestore->database();
            $collection = $firestore->collection('lokasi');
            // Referensi ke dokumen order di Firestore
            $orderDocRef = $collection->where('namaToko', '=',$namaLokasi);
            $documents = $orderDocRef->documents();

            foreach ($documents as $document) {
                if($document->exists()) {
                    $documentRef = $collection->document($document->id());
                    $documentRef->update([
                        ['path' => 'status', 'value' => false]
                    ]);
                }
            }
            // Commit transaksi lokal
            DB::commit();

            session()->flash('message', 'Lokasi Berhasil Dinonaktifkan');
            return redirect()->route('home.kelola_map');
        } catch (\Throwable $e) {
            DB::rollBack(); // Rollback jika terjadi error
            return $this->addError('error', $e->getMessage());
        }
    }

    public function render()
    {
        $databaru = Lokasi::query()
            ->where('namaToko', 'like', '%' . $this->searchbaru . '%')
            ->where('status', false)
            ->paginate(5, ['*'], 'pagebaru');  // Gunakan custom page name

        $datatetap = Lokasi::query()
            ->where('namaToko', 'like', '%' . $this->searchtetap . '%')
            ->where('status', true)
            ->paginate(5, ['*'], 'pagetetap'); // Gunakan custom page name

        return view('livewire.kelola-map', compact('databaru', 'datatetap'));
    }
}
