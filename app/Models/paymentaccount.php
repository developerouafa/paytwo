<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paymentaccount extends Model
{
    use HasFactory;

    /*-------------------- Relations --------------------*/

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function clients()
    {
        return $this->belongsTo(Client::class,'client_id');
    }
}
