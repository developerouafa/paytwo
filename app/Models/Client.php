<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'phone',
        'UserStatus',
        'Status'
    ];

    /*-------------------- Relations --------------------*/
    public function profileclient()
    {
        return $this->hasOne(profileclient::class);
    }
}
