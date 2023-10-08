<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stockproduct extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'product_id', 'stock'];

    /*-------------------- Scope --------------------*/
    public function scopeSelectstock(mixed $query)
    {
        return $query->select('id', 'product_id', 'stock')->with('product');
    }

    /*-------------------- Relations --------------------*/
    public function product()
    {
        return $this->belongsTo(product::class);
    }
}
