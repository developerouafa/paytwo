<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class receipt_account extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    public $guarded=[];

    /*-------------------- Relations --------------------*/

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function clients()
    {
        return $this->belongsTo(Client::class,'client_id');
    }

    public function fundaccount()
    {
        return $this->hasMany(fund_account::class, 'receipt_id');
    }
}
