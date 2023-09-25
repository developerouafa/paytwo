<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class singleinvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'price',
        'discount_value',
        'tax_rate',
        'tax_value',
        'total_with_tax',
        'Payment_type',
        'Payment_date'
    ];

}
