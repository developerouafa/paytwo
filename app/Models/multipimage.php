<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class multipimage extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'multipimage',
        'product_id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    /*-------------------- Scope --------------------*/
    public function scopeSelectmultipimage(mixed $query)
    {
        return $query->select('id', 'multipimage', 'product_id', 'created_at', 'updated_at')->with('product');
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
