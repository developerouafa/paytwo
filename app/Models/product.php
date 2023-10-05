<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class product extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'status',
        'section_id',
        'parent_id',
        'user_id',
    ];
    public $translatable = ['name', 'description'];

        // Scopes
        public function scopeProductwith($query){
            return $query->with('section')->with('subsections');
        }

        public function scopeProductselect($query){
            return $query->select('id', 'name', 'description', 'price', 'status', 'section_id', 'parent_id', 'user_id');
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
        public function subsections(): BelongsTo
        {
            return $this->BelongsTo(section::class, 'parent_id')->child();
        }

        public function section(): BelongsTo
        {
            return $this->BelongsTo(section::class);
        }
}
