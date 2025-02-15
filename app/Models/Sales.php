<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model{
    /** @use HasFactory<\Database\Factories\SalesFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'code',
        'customer_name',
        'payment_method_id',
        'subtotal',
        'disc_percent',
        'disc_amount',
        'total',
    ];

    public function payment_method(): \Illuminate\Database\Eloquent\Relations\BelongsTo{
        return $this->belongsTo(PaymentMethod::class);
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany{
        return $this->hasMany(SalesItem::class);
    }
}
