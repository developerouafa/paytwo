<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'phone',
        'password',
        'ClientStatus',
        'Status',
        'user_id',
        'created_at',
        'updated_at'
    ];

    /*-------------------- Scopes --------------------*/
        public function scopeClientwith($query){
            return $query->with('user')->with('profileclient');
        }

        public function scopeClientselect($query){
            return $query->select('id', 'name', 'phone', 'Status', 'ClientStatus', 'user_id', 'created_at', 'updated_at');
        }
    /*-------------------- Relations --------------------*/
        public function user()
        {
            return $this->belongsTo(user::class);
        }

        public function profileclient()
        {
            return $this->hasOne(profileclient::class);
        }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'phone_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
