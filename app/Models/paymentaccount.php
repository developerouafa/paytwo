<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paymentaccount extends Model
{
    use HasFactory;

    public function clients()
    {
        return $this->belongsTo(Client::class,'client_id');
    }
}
