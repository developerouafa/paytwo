<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class client_account extends Model
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

    public function ReceiptAccount()
    {
        return $this->belongsTo(receipt_account::class,'receipt_id');
    }

    public function PaymentAccount()
    {
        return $this->belongsTo(paymentaccount::class,'Payment_id');
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
