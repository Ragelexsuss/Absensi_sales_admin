<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mission extends Model
{
    use HasFactory;
    protected $table = 't0mission';
    protected $keyType = 'string';
    protected $fillable = [
        'id_sales',
        'id_mission',
        'id_lokasi',
        'status',
    ];
    protected $casts = [
        'status' => 'boolean'
    ];
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi', 'id_lokasi');
        // Parameter:
        // 1. Model tujuan (Lokasi)
        // 2. Foreign key di tabel missions (id_lokasi)
        // 3. Primary key di tabel lokasi (id)
    }

}
