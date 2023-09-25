<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product',
        'description',
        'section_id'
    ];

    public function section()
    {
    return $this->belongsTo(section::class);
    }
}
