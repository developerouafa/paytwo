<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class product extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'status',
        'section_id',
        'parent_id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public $translatable = ['name', 'description'];

        // Scopes
        public function scopeProductwith($query){
            return $query->with('section')->with('subsections')->with('user')->with('promotion')->with('stockproduct')->with('mainimageproduct')->with('multipimage');
        }

        public function scopeProductselect($query){
            return $query->select('id', 'name', 'description', 'price', 'status', 'section_id', 'parent_id', 'user_id', 'created_at', 'updated_at');
        }

        public function scopeParent(mixed $query)
        {
            return $query->whereNull('parent_id');
        }

        public function scopeChild(mixed $query): ?object
        {
            return $query->whereNotNull('parent_id');
        }

        /*-------------------- Relations --------------------*/

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function subsections(): BelongsTo
        {
            return $this->BelongsTo(section::class, 'parent_id')->child();
        }

        public function section(): BelongsTo
        {
            return $this->BelongsTo(section::class);
        }

        public function promotion()
        {
            return $this->hasMany(promotion::class);
        }

        public function stockproduct()
        {
            return $this->hasMany(stockproduct::class);
        }

        public function mainimageproduct()
        {
            return $this->hasMany(mainimageproduct::class);
        }

        public function multipimage()
        {
            return $this->hasMany(multipimage::class);
        }
}
