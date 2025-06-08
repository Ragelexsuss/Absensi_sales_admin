<?php

namespace App\Livewire;

use App\Models\t0area;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Kreait\Firebase\Factory;
use Livewire\Component;
use function Laravel\Prompts\error;

class KelolaAkunAdmin extends Component
{
    public $openModalAddAkun = false;
    public $openModalAddkota = false;
    public $username;
    public $alamat;
    public $namaLengkap;
    public $password;
    public $repeatPassword;


    public $edit_userId;
    public $edit_nama_lengkap;
    public $edit_username;
    public $edit_id_admin;
    public $edit_id_area;
    public $edit_nama_area;
    public $edit_alamat;
    public $edit_nama_role;
    public $edit_status;
    public $modaleditadmin = false;




    public $idArea;
    public $namaArea;
    public $dataArea;
    public $statusbutton=true;
    public $dataareas;
    public $dataareass;



    public function closeModalAddAkun()
    {
        $this->openModalAddAkun = false;
    }
    public function openModalAddAkuns()
    {
        $this->openModalAddAkun = true;
    }
    public function openModalAddKota()
    {
        $this->openModalAddkota = true;
    }
    public function closeModalAddKota()
    {
        $this->openModalAddkota = false;
    }
    public function mount()
    {
        $this->dataArea = t0area::all();
    }
    protected $rules = [
        'nama_lengkap' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username',
        'id_admin' => 'required',
        'id_area' => 'required',
        'alamat' => 'required|string',
//        'nama_role' => 'required|string',
        'status' => 'required|string',
    ];
    public function openmodaleditadmin($idAdmin){
        $this->modaleditadmin = true;
        try {

            $data = User::query()->where('id_admin', $idAdmin)->first();
            $this->dataareas= t0area::query()->where('idarea','!=', $data->id_area)->get();


//           $this->edit_userId = $data->id;
            $this->edit_nama_lengkap = $data->nama_lengkap;
            $this->edit_username = $data->username;
            $this->edit_id_admin = $data->id_admin;
            $this->edit_id_area = $data->t0_area->idarea;
            $this->edit_nama_area = $data->t0_area->nama_area;
            $this->edit_alamat = $data->alamat;
//            $this->edit_nama_role = $data->nama_role;
            $this->edit_status = $data->status;

        }catch (\Exception $e){
            $this->addError('error', $e->getMessage());
        }

    }
    public function closemodaleditadmin(){
        $this->modaleditadmin = false;

    }
    public function updateakun()
    {
        DB::beginTransaction();
        try {
            if ($this->edit_status == '1'){
                $this->edit_status =true;
            }else{
                $this->edit_status =false;
            }
            // Initialize Firestore
            $firestore = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'))
                ->createFirestore();
            $database = $firestore->database();
            $usersRef = $database->collection('user_admin');

            // Update MySQL
            $admin = User::where('id_admin', $this->edit_id_admin)->first();
            if (!$admin) {
                throw new \Exception("Admin tidak ditemukan");
            }

            $updateData = [
                'nama_lengkap' => $this->edit_nama_lengkap,
                'username' => $this->edit_username,
                'alamat' => $this->edit_alamat,
                'status' => $this->edit_status,
                'id_area' => $this->edit_id_area, // Pastikan konsisten dengan Firestore
            ];

            $admin->update($updateData);

            // Update Firestore
            $query = $usersRef->where('id_admin', '=', $this->edit_id_admin);
            $snapshot = $query->documents();

            if ($snapshot->isEmpty()) {
                throw new \Exception('Akun tidak ditemukan di Firestore');
            }

            // Prepare Firestore update data
            $firestoreUpdateData = [
                'status' => $this->edit_status,
                'nama_lengkap' => $this->edit_nama_lengkap,
                'alamat' => $this->edit_alamat,
                'id_area' => $this->edit_id_area,
                'username' => $this->edit_username,// Tambahkan timestamp update
            ];

            foreach ($snapshot as $document) {
                if ($document->exists()) {
                    $documentRef = $usersRef->document($document->id());
                    $documentRef->set($firestoreUpdateData, ['merge' => true]);
                    break;
                }
            }

            DB::commit();
            session()->flash('success', 'Data Supervisor berhasil diperbarui');
            $this->closemodaleditadmin();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->closemodaleditadmin();
            session()->flash('error', 'Gagal memperbarui data: ' . $e->getMessage());
            // Jika menggunakan Livewire, bisa juga:
            $this->addError('updateError', $e->getMessage());
        }
    }
    public function addarea()
    {
        $this->validate([
            'namaArea' => 'required|string|max:255|'
        ]);
        $this->statusbutton=false;
        DB::beginTransaction();

        try {
            $check = t0area::query()->where('nama_area', $this->namaArea)->first();
            if ($check) {
                return redirect()->back()->with('error', 'area sudah ada');
            }
            $kategorid = 'ARE-'. now()->format('YmdHis') . Str::random(4);;

            // Save to MySQL
            $kategori = t0area::query()->create([
                'idarea' => $kategorid,
                'nama_area' => $this->namaArea,
                'status' => true,
            ]);

            // Save to Firestore
            $firestore = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'))->createFirestore();
            $database = $firestore->database();
            $kategoriRef = $database->collection('area')->newDocument();
            $kategoriRef->set([
                'id' => $kategorid,
                'nama_area' => $this->namaArea,
                'status' => true,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ]);
            DB::commit();
            $this->closeModalAddKota();
            $this->statusbutton = true;
            session()->flash('success', 'Area berhasil ditambahkan!');


        } catch (\Exception $e) {
            DB::rollBack();
            $this->statusbutton=true;
            session()->flash('error', 'Gagal menambahkan Area: ' . $e->getMessage());
        }
    }
    public function addakun()
    {
        $this->validate([
            'username' => 'required|string|max:255|',
            'alamat' => 'required|string|max:255|',
            'namaLengkap' => 'required|string|max:255|',
            'password' => 'required|string|min:4|',
            'repeatPassword' => 'required|string|min:4|',

        ]);
        if ($this->password !== $this->repeatPassword) {
            return $this->addError('password', 'Password tidak sama!');
        }
        DB::beginTransaction();

        try {
            $checkakun = User::query()->where('username', $this->username)->first();
            if ($checkakun) {
                return $this->addError('username', 'Username sudah ada');
            }
            $id_admin = 'ADM-'. now()->format('YmdHis') . Str::random(4);
            $hashPassword = Hash::make($this->password);

            // Save to MySQL
            User::query()->create([
                'id_admin' => $id_admin,
                'id_area' => $this->idArea,
                'nama_role'=> 'supervisor',
                'alamat' => $this->alamat,
                'password' => $hashPassword,
                'nama_lengkap' => $this->namaLengkap,
                'username' => $this->username,
                'status'=> true
            ]);

            // Save to Firestore
            $firestore = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'))->createFirestore();
            $database = $firestore->database();
            $kategoriRef = $database->collection('user_admin')->newDocument();
            $kategoriRef->set([
                'id_admin' => $id_admin,
                'id_area' => $this->idArea,
                'nama'=>$this->namaLengkap,
                'nama_role'=>'supervisor',
                'password'=>$hashPassword,
                'username'=>$this->username,
                'alamat'=>$this->alamat,
                'status'=>true,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ]);
            DB::commit();
            $this->closeModalAddAkun();
            session()->flash('success', 'Akun berhasil ditambahkan!');


        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal menambahkan Akun: ' . $e->getMessage());
        }
    }

    public function importdata()
    {
        try {
            $factory = (new Factory())->withServiceAccount(storage_path('app/firebase_credentials.json'));
            $firestore = $factory->createFirestore();
            $database = $firestore->database();

            // Get all documents from Firestore collection
            $documents = $database->collection('area')->documents();

            foreach ($documents as $document) {
                if ($document->exists()) {
                    $data = $document->data();

                    // Update or create record in MySQL
                    t0area::query()->updateOrCreate(
                        ['idarea' => $data['id']],
                        [
                            'idarea' => $data['id'],
                            'nama_area' => $data['nama_area'] ?? null,
                            'status' => $data['status'],
                        ]
                    );
                }
            }
             session()->flash('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
           return $this->addError('error', $e->getMessage());
        }
    }

    public function hapusarea($idarea)
    {
        DB::beginTransaction();
        try {
            $data = t0area::query()->where('idarea', $idarea)->first();
            $data->update(['status' => false]);

            $factory = (new Factory())->withServiceAccount(storage_path('app/firebase_credentials.json'));
            $firestore = $factory->createFirestore();
            $database = $firestore->database();
            $areaCollection = $database->collection('area');

            // Cari dokumen yang sesuai di Firestore
            $documents = $areaCollection->where('id', '=', $idarea)->documents();

            foreach ($documents as $document) {
                if ($document->exists()) {
                    $documentRef = $areaCollection->document($document->id());
                    $documentRef->update([
                        ['path' => 'status', 'value' => false],
                        ['path' => 'updated_at', 'value' => new \DateTime()]
                    ]);
                }
            }


            DB::commit();
            session()->flash('success', 'Area berhasil dinonaktifkan!');
        }catch (\Exception $e) {
            return $this->addError('error', $e->getMessage());

        }
    }

    public function validasiarea($idarea)
    {
        try {
            DB::beginTransaction();
            $data = t0area::query()->where('idarea', $idarea)->first();
            $data->update(['status' => true]);

            // 2. Update status di Firestore
            $factory = (new Factory())->withServiceAccount(storage_path('app/firebase_credentials.json'));
            $firestore = $factory->createFirestore();
            $database = $firestore->database();
            $areaCollection = $database->collection('area');

            // Cari dokumen yang sesuai di Firestore
            $documents = $areaCollection->where('id', '=', $idarea)->documents();

            foreach ($documents as $document) {
                if ($document->exists()) {
                    $documentRef = $areaCollection->document($document->id());
                    $documentRef->update([
                        ['path' => 'status', 'value' => true],
                        ['path' => 'updated_at', 'value' => new \DateTime()]
                    ]);
                }
            }


            DB::commit();
            session()->flash('success', 'Area berhasil Aktifkan!');
        }catch (\Exception $e) {
            return $this->addError('error', $e->getMessage());

        }
    }


    public function render()
    {
        $dataarea = t0area::query()->orderBy('status', 'desc')->paginate(5);
        $dataakun = User::query()->orderBy('status', 'desc')->paginate(5);
        return view('livewire.kelola-akun-admin', compact('dataakun', 'dataarea'));
    }
}
