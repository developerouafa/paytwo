<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class section extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'id',
        'name',
        'user_id',
        'parent_id',
    ];

    public $translatable = ['name'];

        /*-------------------- Scope --------------------*/

        public function scopeParent(mixed $query)
        {
            return $query->whereNull('parent_id');
        }

        public function scopeChild(mixed $query)
        {
            return $query->whereNotNull('parent_id');
        }

        public function scopeSelectsections(mixed $query)
        {
            return $query->select('id', 'name', 'user_id', 'status', 'parent_id');
        }

        public function scopeSelectchildrens(mixed $query)
        {
            return $query->select('id', 'name', 'description', 'user_id', 'parent_id');
        }

        public function scopeWithchildrens(mixed $query)
        {
            return $query->with('subsections');
        }

        public function scopeWithsections(mixed $query)
        {
            return $query->with('section');
        }

        public function scopeWithuser(mixed $query)
        {
            return $query->with('user');
        }
        // /*-------------------- Relations --------------------*/

        public function user()
        {
          return $this->belongsTo(user::class);
        }

        public function subsections(): HasMany
        {
            return $this->hasMany(section::class, 'parent_id')->child();
        }

        public function section(): BelongsTo
        {
            return $this->BelongsTo(section::class, 'parent_id')->parent();
        }

}
