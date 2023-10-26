<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class section extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'name',
        'status',
        'user_id',
        'parent_id',
        'created_at',
        'updated_at',
        'deleted_at'
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
            return $query->select('id', 'name', 'user_id', 'status', 'parent_id', 'created_at', 'updated_at');
        }

        public function scopeSelectchildrens(mixed $query)
        {
            return $query->select('id', 'name', 'user_id', 'status', 'parent_id', 'created_at', 'updated_at');
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


        protected $casts = [
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
}
