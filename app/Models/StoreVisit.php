<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreVisit extends Model
{
    use HasFactory;
    protected $table = 'store_visits';
    protected $keyType = 'string';
    protected $fillable = [
        'id_document',
        'date',
        'namaToko',
        'notes',
        'url'
    ];
    public function SalesReport(){
        return $this->hasMany(SalesReport::class, 'id_document', 'id_document');
    }

}
