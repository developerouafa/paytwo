<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pivot_product_group extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_id',
        'groupprodcut_id',
        'quantity',
    ];

    public function product()
    {
        return $this->BelongsTo(product::class);
    }

    public function groupprodcut()
    {
        return $this->BelongsTo(groupprodcut::class);
    }
}
