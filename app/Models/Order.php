<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'invoice_number',
        'type',
        'full_name',
        'email',
        'phone',
        'province',
        'city',
        'district',
        'address',
        'postal_code',
        'rent_start',
        'rent_end',
        'payment_method_id',
        'total',
        'status',
        'return_status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}