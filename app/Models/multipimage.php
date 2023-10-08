<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class multipimage extends Model
{
    use HasFactory;

    protected $fillable = [
        'multipimage',
        'product_id',
    ];

    /*-------------------- Scope --------------------*/
    public function scopeSelectmainimage(mixed $query)
    {
        return $query->select('id', 'multipimage', 'product_id')->with('product');
    }

    /*-------------------- Relations --------------------*/
    public function product()
    {
        return $this->belongsTo(product::class);
    }
}
