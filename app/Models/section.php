<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class section extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'section',
        'description',
        'user_id'
    ];

    public function user()
    {
    return $this->belongsTo(user::class);
    }
}
