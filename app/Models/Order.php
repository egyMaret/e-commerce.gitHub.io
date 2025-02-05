<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_date',
        'payment_receipt',
        'is_paid'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class);
    }

    // Accessor untuk total harga
    public function getTotalPriceAttribute()
    {
        $totalPrice = 0;
        foreach ($this->detailOrders as $detailOrder) {
            $totalPrice += $detailOrder->amount * $detailOrder->variant->product->price;
        }
        return $totalPrice;
    }
}
