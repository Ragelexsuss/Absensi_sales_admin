<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stokbarang extends Model
{
    use HasFactory;
    protected $table = 't0stokbarang';
    protected $keyType = 'string';
    protected $fillable = [
        'idbarang',
        'nama_barang',
        'harga',
        'jumlah_per_box',
        'harga_format',
        'stok_barang',
        'status',
        'kategori',
        'id_gudang'

    ];
    protected $casts = [
        'tanggal' => 'datetime',
        'status' => 'boolean',
    ];
    public function kategoris()
    {
        return $this->belongsTo(kategoriBarang::class, 'kategori', 'id_kategori');
    }
}
