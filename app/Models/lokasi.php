<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lokasi extends Model
{
    use HasFactory;
    protected $table = 't0lokasi';
    protected $keyType = 'string';
    protected $fillable = [
        'id_lokasi',
        'userSales',
        'userToko',
        'namaToko',
        'address',
        'radius',
        'latitude',
        'longitude',
        'image_url',
        'status',

    ];
    protected $casts = [
        'status' => 'boolean'
    ];
    public function missions()
    {
        return $this->hasMany(Mission::class, 'id_lokasi', 'id_lokasi');
    }
    public function SalesOrder()
    {
        return $this->hasMany(SalesOrder::class, 'idLokasi', 'id_lokasi');
    }
}
