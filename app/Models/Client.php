<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'phone',
        'UserStatus',
        'Status',
        'user_id'
    ];

    /*-------------------- Scopes --------------------*/
        public function scopeClientwith($query){
            return $query->with('user')->with('profileclient');
        }

        public function scopeClientselect($query){
            return $query->select('id', 'phone', 'Status', 'UserStatus', 'user_id');
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
}
