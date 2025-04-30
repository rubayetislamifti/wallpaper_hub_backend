<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    protected $fillable=[
        'payment_id',
        'payment_method',
        'amount',
        'fee',
        'charged_amount',
        'invoice_id',
        'sender_number',
        'transaction_id',
        'date',
        'status',
    ];
}
