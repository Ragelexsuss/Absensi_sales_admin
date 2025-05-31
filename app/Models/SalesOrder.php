<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;
    protected $table = 't0sales_orders';
    protected $keyType = 'string';
    protected $fillable = [
        'order_id',
        'user_id',
        'order_data',
        'idLokasi',
        'total_harga',
        'total_item',
        'order_date',
        'status',

    ];
    protected $casts = [
        'order_data' => 'array',
        'order_date' => 'datetime',
        'status' => 'boolean',
    ];
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'idLokasi', 'id_lokasi');
        // Parameter:
        // 1. Model tujuan (Lokasi)
        // 2. Foreign key di tabel missions (id_lokasi)
        // 3. Primary key di tabel lokasi (id)
    }
    public function sales()
    {
        return $this->belongsTo(akun_sales::class, 'user_id', 'id_sales');
        // Parameter:
        // 1. Model terkait (akun_sales)
        // 2. Foreign key di tabel orders (user_id)
        // 3. Primary key yang dituju di tabel sales (id_sales)
    }
}
