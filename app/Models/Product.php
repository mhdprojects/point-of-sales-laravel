<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'category_id',
        'unit_id',
        'stock',
        'price',
        'description',
        'image',
        'is_active',
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function unit(): \Illuminate\Database\Eloquent\Relations\BelongsTo{
        return $this->belongsTo(Unit::class);
    }
}
