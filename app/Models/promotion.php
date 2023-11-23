<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class promotion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'start_time',
        'end_time',
        'price',
        'expired',
        'product_id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    /*-------------------- Scope --------------------*/
    public function scopeSelectpromotion(mixed $query)
    {
        return $query->select('id', 'start_time', 'end_time', 'price', 'expired', 'product_id', 'user_id', 'created_at', 'updated_at');
    }

    public function scopeWithpromotion(mixed $query)
    {
        return $query->with('product');
    }

    /*-------------------- Relations --------------------*/

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function product()
    {
        return $this->belongsTo(product::class);
    }
}
