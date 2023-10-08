<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mainimageproduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'mmainimageain',
        'product_id',
    ];

    /*-------------------- Scope --------------------*/
    public function scopeSelectmain(mixed $query)
    {
        return $query->select('id', 'mainimage', 'product_id')->with('product');
    }

    /*-------------------- Relations --------------------*/
    public function product()
    {
        return $this->belongsTo(product::class);
    }

}
