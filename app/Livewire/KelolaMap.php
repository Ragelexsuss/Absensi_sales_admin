<?php

namespace App\Livewire;

use App\Models\Lokasi;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Factory;
use Livewire\Component;

class KelolaMap extends Component
{
    public $searchbaru;
    public $searchtetap;
    public function viewmap()
    {
        return redirect()->route('home.map');
    }
    public function mount(){
        $this->addlokasi();

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

            $database = $firestore->database();

            // Referensi ke dokumen order di Firestore
            $orderDocRef = $database
                ->collection('lokasi')
                ->document($namaLokasi);

            // Update status di Firestore
            $orderDocRef->update([
                ['path' => 'status', 'value' => true]
            ]);

            // Commit transaksi lokal
            DB::commit();

            session()->flash('message', 'Lokasi Berhasil Divalidasi');
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
