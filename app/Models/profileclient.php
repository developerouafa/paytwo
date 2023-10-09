<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profileclient extends Model
{
    use HasFactory;

    protected $fillable = [
        'clienType',
        'nationalIdNumber',
        'commercialRegistrationNumber',
        'taxNumber',
        'adderss',
        'client_id'
    ];

    /*-------------------- Relations --------------------*/
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
