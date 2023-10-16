<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mainimageproduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'mainimage',
        'product_id',
        'user_id'
    ];

    /*-------------------- Scope --------------------*/
    public function scopeSelectmainimage(mixed $query)
    {
        return $query->select('id', 'mainimage', 'product_id')->with('product');
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
