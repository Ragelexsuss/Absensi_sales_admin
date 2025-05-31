<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderReport extends Model
{
    use HasFactory;
    protected $table = 't0sales_order_reports';
    protected $keyType = 'string';
    protected $fillable = [
        'id_document',
        'idOrder',
        'total_amount',
        'total_items',
    ];

    public function SalesReport(){
        return $this->hasMany(SalesReport::class, 'id_document', 'id_document');
    }
}
