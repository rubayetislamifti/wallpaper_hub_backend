<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentInfo extends Model
{
    protected $fillable =[
        'user_id',
        'email',
        'phone',
        'name',
        'amount',
        'payment_method',
        'status',
        'invoice_id',
        'product_id',
        'product_name',
        'payment_date',
    ];
}
