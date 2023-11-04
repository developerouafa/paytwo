<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'invoice_id', 'price', 'nameincard', 'paid_at', 'delivered_at'];

    public function invoice()
    {
        return $this->belongsTo(invoice::class);
    }
}
