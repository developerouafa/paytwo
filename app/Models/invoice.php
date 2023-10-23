<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];


        protected $fillable =[
            'id',
            'invoice_number',
            'invoice_classify',
            'invoice_date',
            'type',
            'invoice_type',
            'invoice_status',
            'client_id',
            'groupprodcut_id',
            'product_id',
            'price',
            'discount_value',
            'tax_rate',
            'tax_value',
            'total_with_tax',
            'user_id',
            'created_at',
            'updated_at'
        ];

        /*-------------------- Relations --------------------*/

            public function user()
            {
                return $this->belongsTo(user::class);
            }

            public function Group()
            {
                return $this->belongsTo(groupprodcut::class,'groupprodcut_id');
            }

            public function Service()
            {
                return $this->belongsTo(product::class,'product_id');
            }

            public function Client()
            {
                return $this->belongsTo(Client::class,'client_id');
            }

}
