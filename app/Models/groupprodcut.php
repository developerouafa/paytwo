<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class groupprodcut extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    protected $dates = ['deleted_at'];

    public $fillable= ['name', 'notes', 'Total_before_discount','discount_value','Total_after_discount','tax_rate','Total_with_tax', 'user_id', 'created_at', 'updated_at'];
    public $translatable = ['name', 'notes'];

    /*-------------------- Relations --------------------*/

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function product_group()
    {
        return $this->belongsToMany(product::class,'Product_Group')->withPivot('quantity');
    }

}
