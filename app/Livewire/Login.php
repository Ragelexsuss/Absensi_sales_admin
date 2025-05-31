<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Kreait\Firebase\Factory;
use Livewire\Component;

class Login extends Component
{
    public $showPassword = false;
    public $email = '';
    public $password = '';
    public $remember = false;
    public $error = '';

    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required|min:6',
        ];
    }

    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function login()
    {
        $this->validate();

        try {
            $firestore = (new Factory)
                ->withServiceAccount(storage_path('app/firebase_credentials.json'))
                ->createFirestore();

            $database = $firestore->database();
            $usersRef = $database->collection('user_admin');

            // Cari user di Firestore
            $query = $usersRef->where('username', '=', $this->email);
            $snapshot = $query->documents();

            if ($snapshot->isEmpty()) {
                $this->addError('email', 'Username Tidak Ditemukan');
                return;
            }

            $firestoreUser = null;
            foreach ($snapshot as $document) {
                if ($document->exists()) {
                    $firestoreUser = $document->data();
                    $firestoreUser['id'] = $document->id();
                    break;
                }
            }

//            if (!isset($firestoreUser['password']) || !Hash::check($this->password, $firestoreUser['password'])) {
//                $this->addError('password', 'Password salah');
//                return;
//            }

            $user = \App\Models\User::updateOrCreate(
                ['username' => $this->email],
                [
                    'nama_lengkap' => $firestoreUser['nama'] ?? $this->email,
                    'password' => Hash::make($this->password),
                    'id_admin' => $firestoreUser['id_admin'],
                    'id_area' => $firestoreUser['id_area'],
                    'alamat' => $firestoreUser['alamat'],
                    'nama_role' => $firestoreUser['nama_role'],
                    'status'=>true
                ]
            );

            Auth::login($user, $this->remember);

            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            $this->addError('email', $e->getMessage());
            logger()->error('Login error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.login')->layout('layouts.guest');
    }
}
