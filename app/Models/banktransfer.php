<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class banktransfer extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    public $guarded=[];

    /*-------------------- Relations --------------------*/

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }

    public function invoice()
    {
        return $this->belongsTo(invoice::class,'invoice_id');
    }

    public function fundaccount()
    {
        return $this->hasMany(fund_account::class, 'bank_id');
    }
}
