<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Translatable\HasTranslations;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasTranslations, Billable, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'phone',
        'email',
        'password',
        'roles_name',
        'UserStatus',
        'Status',
        'created_at',
        'updated_at'
    ];

    public $translatable = ['name'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'roles_name' => 'array',
    ];

    /*-------------------- Start Relations --------------------*/
        public function image()
        {
            return $this->hasOne(imageuser::class);
        }

        public function client()
        {
            return $this->hasOne(client::class);
        }

        public function orders()
        {
            return $this->hasMany(order::class);
        }
    /*-------------------- End Relations --------------------*/

    
    //* Rest omitted for brevity (Jwt)
    
        public function getJWTIdentifier()
        {
            return $this->getKey();
        }

        public function getJWTCustomClaims()
        {
            return [];
        }
}
