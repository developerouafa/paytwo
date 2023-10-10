<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class groupprodcut extends Model
{
    use HasFactory, HasTranslations;

    public $fillable= ['name', 'notes', 'Total_before_discount','discount_value','Total_after_discount','tax_rate','Total_with_tax'];
    public $translatable = ['name', 'notes'];

}
