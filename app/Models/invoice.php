<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'invoice_number',
        'invoice_date',
        'invoice_type',
        'invoice_status',
        'user_id',
        'singleinvoice_id',
        'groupinvoice_id'
    ];

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function singleinvoice()
    {
        return $this->belongsTo(singleinvoice::class);
    }

    public function groupinvoice()
    {
        return $this->belongsTo(groupinvoice::class);
    }
}
