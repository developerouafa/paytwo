<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class receiptdocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'invoice_id',
        'invoice',
        'client_id',
    ];
}
