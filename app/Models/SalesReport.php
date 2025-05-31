<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReport extends Model
{
    use HasFactory;
    protected $table = 't0sales_reports';
    protected $keyType = 'string';
    protected $fillable = [
        'id_document',
        'date',
        'date_head',
        'user_id',
        'sales_name',
    ];

    public function orderreport()
    {
        return $this->belongsTo(SalesOrderReport::class, 'id_document', 'id_document');
    }
    public function storevisit()
    {
        return $this->belongsTo(StoreVisit::class, 'id_document', 'id_document');
    }
    public function tambahLokasi()
    {
        return $this->belongsTo(SalesLocation::class, 'id_document', 'id_document');
    }
}
