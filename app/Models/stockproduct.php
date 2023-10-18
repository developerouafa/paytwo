<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class stockproduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id', 'product_id', 'stock', 'user_id', 'created_at', 'updated_at'];

    /*-------------------- Scope --------------------*/
    public function scopeSelectstock(mixed $query)
    {
        return $query->select('id', 'product_id', 'stock', 'created_at', 'updated_at')->with('product');
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
