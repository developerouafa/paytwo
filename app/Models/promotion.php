<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'price',
        'expired',
        'product_id',
    ];

    /*-------------------- Scope --------------------*/
    public function scopeSelectpromotion(mixed $query)
    {
        return $query->select('id', 'start_time', 'end_time', 'price', 'expired', 'product_id');
    }

    public function scopeWithpromotion(mixed $query)
    {
        return $query->with('product');
    }

    /*-------------------- Relations --------------------*/
    public function product()
    {
        return $this->belongsTo(product::class);
    }
}
