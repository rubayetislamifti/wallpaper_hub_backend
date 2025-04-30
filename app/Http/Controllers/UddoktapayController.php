<?php

namespace App\Http\Controllers;

use App\Library\UddoktaPay;
use App\Models\PaymentDetails;
use App\Models\PaymentInfo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UddoktapayController extends Controller
{

    /**
     * Show the payment view
     *
     * @return void
     */
    public function show(Request $request)
    {
//        dd($request->payment_id);
        $payment = PaymentInfo::find($request->payment_id);
        Session::put('payment_id', $request->payment_id);
        return view('payment',['payment' => $payment]);
    }

    /**
     * Initializes the payment
     *
     * @param Request $request
     * @return void
     */
    public function pay(Request $request)
    {
        $apiKey = config('uddoktapay.api_key');
        $apiBaseURL = config('uddoktapay.api_url');
        $uddoktaPay = new UddoktaPay($apiKey, $apiBaseURL);


        $amount = $request->input('amount');
        $name = $request->input('full_name');

        $invoice = rand(100000, 999999);

        Session::put('invoice', $invoice);

//        dd($name);
        $requestData = [
            'full_name'    => $name,
            'email'        => $request->input('email'),
            'amount'       => $amount,
            'metadata'     => [
                'invoice_id'   => $invoice,
            ],
            'redirect_url'  => route('uddoktapay.success'),
            'return_type'   => 'GET',
            'cancel_url'    => route('uddoktapay.cancel'),
//            'webhook_url'   => route('uddoktapay.webhook'),
        ];

        try {
            $paymentUrl = $uddoktaPay->initPayment($requestData);
            return redirect($paymentUrl);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Reponse from sever
     *
     * @param Request $request
     * @return void
     */
    public function webhook(Request $request)
    {

        $headerAPI = isset($_SERVER['HTTP_RT_UDDOKTAPAY_API_KEY']) ? $_SERVER['HTTP_RT_UDDOKTAPAY_API_KEY'] : NULL;

        if (empty($headerAPI)) {
            return response("Api key not found", 403);
        }

        if ($headerAPI != env("UDDOKTAPAY_API_KEY")) {
            return response("Unauthorized Action", 403);
        }

        $bodyContent = trim($request->getContent());
        $bodyData = json_decode($bodyContent);
        $data = UddoktaPay::verify_payment($bodyData->invoice_id);
        if (isset($data['status']) && $data['status'] == 'COMPLETED') {
            // Do action with $data
        }
    }

    /**
     * Success URL
     *
     * @return void
     */
    public function success(Request $request)
    {
        $invoiceId = $request->invoice_id;
        try{
            $apiKey = config('uddoktapay.api_key');
            $apiBaseURL = config('uddoktapay.api_url');
            $uddoktaPay = new UddoktaPay($apiKey, $apiBaseURL);

            $response = $uddoktaPay->verifyPayment($invoiceId);
        } catch (\Exception $e)
        {
            dd($e->getMessage());
        }
        if (empty($request->invoice_id)) {
            die('Invalid Request');
        }

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            // do action with $data
            PaymentInfo::where('id',Session::get('payment_id'))->update([
                'status' => $response['status'],
//                'transaction_id' => $response['transaction_id'],
                'payment_method' => $response['payment_method'],
                'invoice_id' => Session::get('invoice'),
                'payment_date' => date('Y-m-d'),
            ]);

            PaymentDetails::create([
                'payment_id' => Session::get('payment_id'),
                'payment_method' => $response['payment_method'],
                'amount' => $response['amount'],
                'fee' => $response['fee'],
                'charged_amount' => $response['charged_amount'],
                'invoice_id' => $response['invoice_id'],
                'sender_number' => $response['sender_number'],
                'transaction_id' => $response['transaction_id'],
                'date' => date('Y-m-d'),
                'status' => $response['status'],
            ]);

            return 'Payment is successful';
        } else {
            $paymentId = Session::get('payment_id');
            // pending payment
            if ($paymentId) {
                PaymentDetails::where('payment_id',Session::get('payment_id'))->delete();
            }
            PaymentInfo::where('id',Session::get('payment_id'))->delete();

            return 'Payment is failed';
        }
    }

    /**
     * Cancel URL
     *
     * @return void
     */
    public function cancel( Request $request)
    {
        $paymentId = Session::get('payment_id');
        // pending payment
        if ($paymentId) {
            PaymentDetails::where('payment_id',Session::get('payment_id'))->delete();
        }
        PaymentInfo::where('id',Session::get('payment_id'))->delete();

        return 'Payment is cancelled';
    }
}
