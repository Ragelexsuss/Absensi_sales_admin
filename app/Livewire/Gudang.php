<?php

namespace App\Livewire;

use App\Models\kategoriBarang;
use App\Models\t0gudang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Kreait\Firebase\Factory;
use Livewire\Component;

class Gudang extends Component
{
    public $modalgudang = false;
    public $showKategoriModal = false;
    public $kategori_barang;
    public $kategori = '';
    public $namagudang;
    public $id_area;

    public $dataArea;
    public $statusbutton = true;
    public $search;
    public $searchkategori;


    public function mount()
    {
        $datauser = Auth::user();
        $this->id_area= $datauser->id_area;
    }

    public function openmodalgudang(){
        $this->modalgudang = true;
    }
    public function  closemodalgudang()
    {
        $this->modalgudang = false;
    }
    public function openKategoriModal()
    {
        $this->showKategoriModal = true;
    }

    public function closeKategoriModal()
    {
        $this->showKategoriModal = false;
        $this->reset('kategori');
        $this->resetErrorBag();

    }

    public function addgudang()
    {

        $this->statusbutton=false;
        DB::beginTransaction();

        try {
            $check = t0gudang::query()->where('nama_gudang', $this->namagudang)->first();
            if ($check) {
                return redirect()->back()->with('error', 'gudang sudah ada');
            }
            $gudangid= 'GDG-'. now()->format('YmdHis') . Str::random(4);;

            // Save to MySQL
            t0gudang::query()->create([
                'id_gudang' => $gudangid,
                'nama_gudang' => $this->namagudang,
                'idarea' => $this->id_area,
                'status' => true,
            ]);

            // Save to Firestore
            $firestore = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'))->createFirestore();
            $database = $firestore->database();
            $kategoriRef = $database->collection('gudang')->newDocument();
            $kategoriRef->set([
                'id_gudang' => $gudangid,
                'nama_gudang' => $this->namagudang,
                'id_area' => $this->id_area,
                'status' => true,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ]);
            DB::commit();
            $this->closemodalgudang();
            $this->statusbutton = true;
            session()->flash('success', 'Gudang berhasil ditambahkan!');


        } catch (\Exception $e) {
            DB::rollBack();
            $this->statusbutton=true;
            session()->flash('error', 'Gagal menambahkan Gudang: ' . $e->getMessage());
        }
    }
    public function validasigudang($idgudang)
    {
        try {
            DB::beginTransaction();
            $data = t0gudang::query()->where('id_gudang', $idgudang)->first();
            $data->update(['status' => true]);

            // 2. Update status di Firestore
            $factory = (new Factory())->withServiceAccount(storage_path('app/firebase_credentials.json'));
            $firestore = $factory->createFirestore();
            $database = $firestore->database();
            $gudangCollection = $database->collection('gudang');

            // Cari dokumen yang sesuai di Firestore
            $documents = $gudangCollection->where('id_gudang', '=', $idgudang)->documents();

            foreach ($documents as $document) {
                if ($document->exists()) {
                    $documentRef = $gudangCollection->document($document->id());
                    $documentRef->update([
                        ['path' => 'status', 'value' => true],
                        ['path' => 'updated_at', 'value' => new \DateTime()]
                    ]);
                }
            }


            DB::commit();
            session()->flash('success', 'Gudang berhasil Diaktifkan!');
        }catch (\Exception $e) {
            return $this->addError('error', $e->getMessage());

        }
    }
    public function hapusgudang($idgudang)
    {
        try {
            DB::beginTransaction();
            $data = t0gudang::query()->where('id_gudang', $idgudang)->first();
            $data->update(['status' => false]);

            // 2. Update status di Firestore
            $factory = (new Factory())->withServiceAccount(storage_path('app/firebase_credentials.json'));
            $firestore = $factory->createFirestore();
            $database = $firestore->database();
            $gudangCollection = $database->collection('gudang');

            // Cari dokumen yang sesuai di Firestore
            $documents = $gudangCollection->where('id_gudang', '=', $idgudang)->documents();

            foreach ($documents as $document) {
                if ($document->exists()) {
                    $documentRef = $gudangCollection->document($document->id());
                    $documentRef->update([
                        ['path' => 'status', 'value' => false],
                        ['path' => 'updated_at', 'value' => new \DateTime()]
                    ]);
                }
            }


            DB::commit();
            session()->flash('success', 'Gudang berhasil di nonaktifkan!');
        }catch (\Exception $e) {
            return $this->addError('error', $e->getMessage());

        }
    }

    public function addKategori()
    {
        $this->validate([
            'kategori' => 'required|string|max:255|'
        ]);

        try {
            $check = kategoriBarang::query()->where('nama_kategori', $this->kategori)->first();
            if ($check) {
                return redirect()->back()->with('error', 'Kategori sudah ada');
            }
            $kategorid = 'KTG-'. now()->format('YmdHis') . Str::random(4);;

            // Save to MySQL
            $kategori = kategoriBarang::query()->create([
                'id_kategori' => $kategorid,
                'nama_kategori' => $this->kategori,
            ]);

            // Save to Firestore
            $firestore = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'))->createFirestore();
            $database = $firestore->database();
            $kategoriRef = $database->collection('kategori')->newDocument();
            $kategoriRef->set([
                'id' => $kategorid,
                'nama_kategori' => $this->kategori,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ]);

            $this->closeKategoriModal();
            session()->flash('success', 'Kategori berhasil ditambahkan!');

            // Refresh data jika perlu
            $this->dispatch('refreshKategori');

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    public function viewproduct($idgudang)
    {
        session()->put('id_gudang', $idgudang);
        return redirect()->route('home.stokbarang');
    }

    public function render()
    {
        $gudang = t0gudang::query()->where('nama_gudang', 'like', '%' . $this->search . '%')->where('idarea', $this->id_area)->orderBy('status', 'desc')->paginate(8);
        $dataKategori = kategoriBarang::query()->where('nama_kategori', 'like', '%' . $this->searchkategori . '%')->orderBy('id', 'desc')->paginate(8);
        return view('livewire.gudang', compact('gudang', 'dataKategori'));
    }
}
