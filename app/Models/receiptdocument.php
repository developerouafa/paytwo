<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class receiptdocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'invoice_number',
        'invoice',
        'client_id',
    ];

    public function Client()
    {
        return $this->belongsTo(Client::class,'client_id');
    }

    public function Invoice()
    {
        return $this->belongsTo(invoice::class,'invoice_number');
    }
}
