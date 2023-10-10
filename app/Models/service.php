<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class service extends Model
{
    use HasFactory, HasTranslations;

    public $fillable= ['name', 'price', 'description', 'status'];
    public $translatable = ['name'];

}
