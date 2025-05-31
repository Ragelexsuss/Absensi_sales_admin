<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t0gudang extends Model
{
    use HasFactory;
    protected $table = 't0gudangs';
    protected $keyType = 'string';
    protected $fillable = [
        'id_gudang',
        'nama_gudang',
        'idarea',
        'status'
    ];
    protected $casts =[
        'status'=>'boolean'
    ];

    public function area()
    {
        return $this->belongsTo(t0area::class, 'idarea', 'idarea');
    }
}
