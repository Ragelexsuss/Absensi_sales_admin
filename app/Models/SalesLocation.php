<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesLocation extends Model
{
    use HasFactory;
    protected $table = 't0sales_locations';
    protected $keyType = 'string';
    protected $fillable = [
        'id_document',
        'namaLokasi',
        'url',
    ];
    public function SalesReport(){
        return $this->hasMany(SalesReport::class, 'id_document', 'id_document');
    }
}
