<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t0area extends Model
{
    use HasFactory;

    protected $table = 't0areas';
    protected $keyType = 'string';
    protected $fillable = [
        'idarea',
        'nama_area',
        'status'
    ];
    protected $casts =[
        'status'=>'boolean'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'idarea', 'id_area');
    }

    public function gudang()
    {
        return $this->hasMany(t0gudang::class, 'idarea', 'idarea');
    }
}
