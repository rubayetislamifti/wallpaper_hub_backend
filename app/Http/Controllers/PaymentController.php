<?php

namespace App\Http\Controllers;

use App\Models\PaymentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id'=> 'required|integer',
            'email'=> 'required|email',
           'phone'=> 'required|string',
            'name'=> 'required|string',
            'amount'=> 'required|numeric',
            'product_id'=> 'required|integer',
            'product_name'=> 'required|string',
        ]);

        $data = PaymentInfo::create([
            'user_id' => Auth::id(),
            'email' => Auth::user()->email,
            'phone' => $request->phone,
            'name' => Auth::user()->name,
            'amount' => $request->amount,
            'product_id' => $request->product_id,
            'product_name' => $request->product_name,
        ]);


        return response()->json([
            'message' => 'Payment info saved',
            'redirect_url' => route('uddoktapay.payment-form',['payment_id' => $data->id]),
        ]);

    }
}
