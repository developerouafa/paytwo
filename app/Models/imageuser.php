<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class imageuser extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'image', 'user_id', 'created_at', 'updated_at'];

    /*-------------------- Relations --------------------*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
