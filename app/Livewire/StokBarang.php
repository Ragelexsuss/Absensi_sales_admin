<?php

namespace App\Livewire;

use App\Models\kategoriBarang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Kreait\Firebase\Factory;
use Livewire\Component;

class StokBarang extends Component
{
    public $showKategoriModal = false;
    public $showProductModal = false;

    public $showeditModal = false;
    public $idbarang;
    public $nama_barang;
    public $harga;
    public $jumlah_per_box;
    public $stok_barang;
    public $kategori_barang;

    public $edit_idbarang;
    public $edit_nama_barang;
    public $edit_harga;
    public $edit_jumlah_per_box;
    public $edit_stok_barang;
    public $edit_kategori_barang;

    public $dataEdit;

    public $tanggal;
    public $idgudang;

    public $kategori = '';
    public $search = '';

    public function mount()
    {
       $this->idgudang= session()->get('id_gudang');
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
    public function openProdukModal()
    {
        $this->showProductModal = true;
    }

    public function closeProdukModal()
    {
        $this->showProductModal = false;
        $this->reset([
            'idbarang',
            'nama_barang',
            'harga',
            'jumlah_per_box',
            'stok_barang',
            'kategori_barang'
        ]);
        $this->resetErrorBag();
    }

    public function openEditModal($idbarang)
    {
        $this->dataEdit = \App\Models\stokbarang::query()->where('idbarang', $idbarang)->first();
        $this->edit_idbarang = $this->dataEdit->idbarang;
        $this->edit_nama_barang = $this->dataEdit->nama_barang;
        $this->edit_harga = $this->dataEdit->harga;
        $this->edit_jumlah_per_box = $this->dataEdit->jumlah_per_box;
        $this->edit_stok_barang = $this->dataEdit->stok_barang;
        $this->edit_kategori_barang = $this->dataEdit->kategori;
        $this->showeditModal = true;
    }

    public function closeEditModal()
    {
        $this->showeditModal = false;
        $this->reset([
            'edit_idbarang',
            'edit_nama_barang',
            'edit_harga',
            'edit_jumlah_per_box',
            'edit_stok_barang',
            'edit_kategori_barang'
        ]);
        $this->resetErrorBag();
    }

    public function addproduct(){
        $this->validate([
            'idbarang' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'jumlah_per_box' => 'required|numeric',
            'stok_barang' => 'required|numeric',
            'kategori_barang' => 'required|string|max:255'
        ]);

        try {
            $check = \App\Models\stokbarang::query()
                ->where('nama_barang', $this->nama_barang)
                ->orWhere('idbarang', $this->idbarang)
                ->first();

            if ($check) {
                session()->flash('error', 'Produk sudah ada atau ID Barang sudah digunakan');
                return;
            }

            // Save to MySQL
            $product = \App\Models\stokbarang::query()->create([
                'idbarang' => $this->idbarang,
                'nama_barang' => $this->nama_barang,
                'harga' => $this->harga,
                'harga_format' => number_format($this->harga, 0, ',', '.'),
                'jumlah_per_box' => $this->jumlah_per_box,
                'stok_barang' => $this->stok_barang,
                'status' => true,
                'kategori' => $this->kategori_barang,
                'id_gudang' => $this->idgudang,
            ]);

            // Save to Firestore
            $firestore = (new Factory)
                ->withServiceAccount(storage_path('app/firebase_credentials.json'))
                ->createFirestore();

            $database = $firestore->database();
            $productRef = $database->collection('product')->document($this->idbarang);
            $productRef->set([
                'idBarang' => $this->idbarang,
                'idGudang' => $this->idgudang,
                'NamaBarang' => $this->nama_barang,
                'harga' => (int)$this->harga,
                'harga_format' => number_format($this->harga, 0, ',', '.'),
                'jumlahPerBox' => (int)$this->jumlah_per_box,
                'stokBarang' => (int)$this->stok_barang,
                'status' => true,
                'kategori' => $this->kategori_barang,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ]);

            $this->closeProdukModal();
            session()->flash('success', 'Produk berhasil ditambahkan!');
            $this->dispatch('refreshProducts');

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menambahkan produk: ' . $e->getMessage());
        }
    }

    public function updateproduct(){
        $this->validate([
            'edit_idbarang' => 'required|string|max:255',
            'edit_nama_barang' => 'required|string|max:255',
            'edit_harga' => 'required|numeric',
            'edit_jumlah_per_box' => 'required|numeric',
            'edit_stok_barang' => 'required|numeric',
            'edit_kategori_barang' => 'required|string|max:255'
        ]);
        DB::beginTransaction();

        try {
            $check = \App\Models\stokbarang::query()
                ->where('nama_barang', $this->edit_nama_barang)
                ->orWhere('idbarang', $this->edit_idbarang)
                ->first();

            if ($check == false) {
                session()->flash('error', 'Produk tidak ditemukan atau koneksi anda bermasalah');
                return;
            }

            // Save to MySQL
            $product = $check->update([
                'idbarang' => $this->edit_idbarang,
                'nama_barang' => $this->edit_nama_barang,
                'harga' => $this->edit_harga,
                'harga_format' => number_format($this->edit_harga, 0, ',', '.'),
                'jumlah_per_box' => $this->edit_jumlah_per_box,
                'stok_barang' => $this->edit_stok_barang,
                'status' => true,
                'kategori' => $this->edit_kategori_barang,
                'id_gudang' => $this->idgudang,
            ]);

            // Save to Firestore
            $firestore = (new Factory)
                ->withServiceAccount(storage_path('app/firebase_credentials.json'))
                ->createFirestore();

            $database = $firestore->database();
            $productRef = $database->collection('product');
            $query = $productRef->where('idBarang', '=', $this->edit_idbarang);
            $snapshot = $query->documents();
            if ($snapshot->isEmpty()) {
                throw new \Exception('Produk tidak ditemukan di Firestore');
            }
            foreach ($snapshot as $document) {
                if ($document->exists()) {
                    $documentRef = $productRef->document($document->id());
                    $documentRef->update([
                        ['path' => 'idBarang', 'value' => $this->edit_idbarang],
                        ['path' => 'idGudang', 'value' => $this->idgudang],
                        ['path' => 'NamaBarang', 'value' => $this->edit_nama_barang],
                        ['path' => 'harga', 'value' => (int)$this->edit_harga],
                        ['path' => 'harga_format', 'value' => number_format($this->edit_harga, 0, ',', '.')],
                        ['path' => 'jumlahPerBox', 'value' => $this->edit_jumlah_per_box],
                        ['path' => 'stokBarang', 'value' =>  (int)$this->edit_stok_barang],
                        ['path' => 'status', 'value' =>  true],
                        ['path' => 'kategori', 'value' => $this->edit_kategori_barang],
                        ['path' => 'updated_at', 'value' => now()->toDateTimeString()],
                    ]);
                    break;
                }
            }
            DB::commit();
            $this->closeEditModal();
            session()->flash('success', 'Produk berhasil Diedit!');
            $this->dispatch('refreshProducts');

        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Gagal Edit Produk: ' . $e->getMessage());
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

    public function render()
    {
        $dataStok = \App\Models\stokbarang::query()->orderBy('id', 'desc')->where('nama_barang', 'like', '%' . $this->search . '%')->where('id_gudang', $this->idgudang)->paginate(8);
        $dataKategori = kategoriBarang::query()->orderBy('id', 'desc')->paginate(8);
        return view('livewire.stok-barang', compact('dataStok','dataKategori'));
    }
}
