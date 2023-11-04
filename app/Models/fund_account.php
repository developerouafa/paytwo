<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class fund_account extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    public $guarded=[];

    /*-------------------- Relations --------------------*/

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function invoice()
    {
        return $this->belongsTo(invoice::class);
    }

    public function receiptaccount()
    {
        return $this->belongsTo(receipt_account::class, 'receipt_id');
    }

    public function paymentaccount()
    {
        return $this->belongsTo(paymentaccount::class, 'Payment_id');
    }

    public function banktransfer()
    {
        return $this->belongsTo(banktransfer::class, 'bank_id');
    }

    public function paymentgateway()
    {
        return $this->belongsTo(paymentgateway::class, 'Gateway_id');
    }
}
