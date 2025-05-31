<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class akun_sales extends Model
{
    use HasFactory;
    protected $table = 't0akunSales';
    protected $keyType = 'string';
    protected $fillable = [
        'id_sales',
        'email',
        'alamat',
        'kota',
        'namaPanjang',
        'noTelepon',
        'status'

    ];
    protected $casts = [
        'status' => 'boolean'
    ];

    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class, 'user_id', 'id_sales');
        // Parameter:
        // 1. Model terkait (SalesOrder)
        // 2. Foreign key di tabel orders (user_id)
        // 3. Primary key lokal di tabel sales (id_sales)
    }
}
