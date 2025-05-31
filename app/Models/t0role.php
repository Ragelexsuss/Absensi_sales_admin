<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t0role extends Model
{
    use HasFactory;
    protected $table = 't0roles';
    protected $keyType = 'string';
    protected $fillable = [
        'nama_role'
    ];
    public function users(){
        return $this->hasMany(User::class, 'nama_role', 'nama_role');
    }
}
