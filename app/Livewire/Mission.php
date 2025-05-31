<?php

namespace App\Livewire;

use App\Models\akun_sales;
use App\Models\lokasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Factory;
use Livewire\Component;

class Mission extends Component
{
public $user;

    public $idSales = "";
    public $openModal = false;
    public $locationSearch = '';
    public $selectedLocation = null;
    public $lokasi;

    public function mount()
    {
        $this->idSales = session()->get("selected_sales_id");
        $this->loadLocations();
    }

    public function loadLocations()
    {
        $this->lokasi = lokasi::all();
        $this->filterLocations();
        $this->user = Auth::user();
    }

    public function filterLocations()
    {
        $this->filteredLocations = $this->lokasi->filter(function($location) {
            return empty($this->locationSearch) ||
                str_contains(strtolower($location->name), strtolower($this->locationSearch)) ||
                str_contains(strtolower($location->address), strtolower($this->locationSearch));
        });
    }

    public function updatedLocationSearch()
    {
        $this->lokasi = lokasi::query()
            ->where(function($query) {
                $query->where('namaToko', 'like', '%' . $this->locationSearch . '%')
                    ->orWhere('address', 'like', '%' . $this->locationSearch . '%');
            })
            ->get();
    }

    public function show_addMission()
    {
        $sales = akun_sales::query()->where('id_sales', $this->idSales)->first();
        if($sales) {
            $this->openModal = true;
            $this->selectedLocation = null;
        }
    }

    public function selectLocation($locationId)
    {
        $this->selectedLocation = $locationId;
    }

    public function addMission()
    {
        $data = lokasi::query()->where('id_lokasi', $this->selectedLocation)->first();
        if (!$this->selectedLocation) {
            return;
        }

        try {
            DB::beginTransaction();
            // Check if location already exists in sales' missions
            $existingMission = \App\Models\mission::query()->where('id_sales', $this->idSales)
                ->where('id_lokasi', $this->selectedLocation)
                ->first();

            if ($existingMission) {
                $this->openModal = false;
                throw new \Exception('Lokasi ini sudah ada dalam mission sales');
            }
            if ($data->status === false){
                $this->openModal = false;
                throw new \Exception('Lokasi Ini Tidak Valid');
            }

            // Get count from MySQL
            $hitungIdMission = \App\Models\mission::query()->where('id_sales', $this->idSales)->count();
            $newMissionId = $hitungIdMission + 1;

            // Initialize Firestore
            $firestore = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'))->createFirestore();
            $database = $firestore->database();

            // Create document in Firestore
            $missionCollection = $database->collection('users')
                ->document($this->idSales)
                ->collection('mission');

            // Count existing Firestore documents
            $existingMissions = $missionCollection->documents()->size();
            $firestoreMissionId = $existingMissions + 1;

            // Create new mission document in Firestore
            $missionCollection->document('mission' . $firestoreMissionId)->set([
                'idMission' => $newMissionId,
                'idSales' => $this->idSales,
                'idLokasi' => $this->selectedLocation,
                'status' => false,
                'createdAt' => new \DateTime(),
                'updatedAt' => new \DateTime()
            ]);

            // Create record in MySQL
            \App\Models\mission::query()->create([
                'id_sales' => $this->idSales,
                'id_lokasi' => $this->selectedLocation,
                'id_mission' => $newMissionId,
                'status' => false
            ]);

            DB::commit();
            $this->closeModal();
            session()->flash('message', 'Mission berhasil ditambahkan');

        } catch (\Exception $e) {
            $this->openModal = false;
            DB::rollback();
            $this->addError('error', 'Gagal menambahkan mission: '.$e->getMessage());
            logger()->error('Failed to add mission: '.$e->getMessage(), [
                'sales_id' => $this->idSales,
                'location_id' => $this->selectedLocation
            ]);
        }
    }
    public function validasi_mission(string $missionId, bool $valid)
    {
        try {
            DB::beginTransaction();

            // Initialize Firestore
            $firestore = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'))->createFirestore();
            $database = $firestore->database();

            // Get Firestore mission reference
            $missionRef = $database->collection('users')
                ->document($this->idSales)
                ->collection('mission')
                ->where('idMission', '=', $missionId);
            $snapshot = $missionRef->documents();
            foreach ($snapshot as $document) {
                if ($document->exists()) {
                    $documentref = $database->collection('users')->document($this->idSales)->collection('mission')->document($document->id());
                    // Update Firestore mission status
                    $documentref->update([
                        ['path' => 'status', 'value' => $valid],
                    ]);
                    break;
                }else{
                    return $this->addError('error', 'Gagal memperbarui status mission: ' . 'Data Tidak Ditemukan');
                }
            }
            // Update MySQL mission status
            \App\Models\mission::query()->where('id', $missionId)
                ->orWhere('id_mission', $missionId) // Depending on your ID field
                ->update([
                    'status' => $valid,
                    'updated_at' => now()
                ]);

            DB::commit();

            session()->flash('message', 'Status mission berhasil diperbarui');
            $this->dispatch('mission-updated'); // Optional: emit event for Livewire

        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('error', 'Gagal memperbarui status mission: ' . $e->getMessage());
            logger()->error('Failed to update mission status', [
                'mission_id' => $missionId,
                'status' => $valid,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function closeModal()
    {
        $this->openModal = false;
        $this->locationSearch = '';
        $this->selectedLocation = null;
    }

    public function render()
    {
        $missions = \App\Models\mission::with('lokasi')
            ->where('id_sales', $this->idSales)
            ->paginate(5);
        return view('livewire.mission', compact('missions'));
    }

}
