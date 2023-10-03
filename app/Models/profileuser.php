<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profileuser extends Model
{
    use HasFactory;

    protected $fillable = [
        'clienType',
        'nationalIdNumber',
        'commercialRegistrationNumber',
        'taxNumber',
        'adderss',
    ];

    /*-------------------- Relations --------------------*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
