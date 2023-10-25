<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_id', 'price', 'paid_at', 'delivered_at'];

    public function post()
    {
        return $this->belongsTo(post::class);
    }
}
