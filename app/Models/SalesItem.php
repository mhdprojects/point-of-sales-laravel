<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesItem extends Model{
    /** @use HasFactory<\Database\Factories\SalesItemFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'sales_id',
        'product_id',
        'qty',
        'price',
        'subtotal',
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo{
        return $this->belongsTo(Product::class);
    }
}
