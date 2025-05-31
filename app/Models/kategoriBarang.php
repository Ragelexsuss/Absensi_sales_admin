<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategoriBarang extends Model
{
    use HasFactory;
    protected $table = 't0kategori_barang';
    protected $keyType = 'string';
    protected $fillable = [
        'id_kategori',
       'nama_kategori'
    ];
    public function stokBarang()
    {
        return $this->hasMany(stokbarang::class, 'kategori', 'id_kategori');
    }
}
