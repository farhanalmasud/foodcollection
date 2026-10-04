<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');

use App\CentralLogics\Helpers;
use App\CentralLogics\OrderLogic;
use App\Models\Order;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Library\UddoktaPay;

class UddoktapayController extends Controller {

    /**
     * Show the payment view
     *
     * @return void
     */

    /**
     * Initializes the payment
     *
     * @param Request $request
     * @return void
     */
    public function pay( Request $request ) {
        $order = Order::with(['details'])->where(['id' => $request->order_id])->first();
        $tr_ref = Str::random(6) . '-' . rand(1, 1000);

        $post_data = array();
        $post_data['total_amount'] = $order->order_amount;
        $post_data['currency'] = Helpers::currency_code();
        $post_data['tran_id'] = $tr_ref;

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $order->customer['f_name'];
        $post_data['cus_email'] = $order->customer['email'] == null ? "example@example.com" : $order->customer['email'];
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $order->customer['phone'] == null ? '0000000000' : $order->customer['phone'];
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Shipping";
        $post_data['ship_add1'] = "address 1";
        $post_data['ship_add2'] = "address 2";
        $post_data['ship_city'] = "City";
        $post_data['ship_state'] = "State";
        $post_data['ship_postcode'] = "ZIP";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Country";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        DB::table('orders')
            ->where('id', $order['id'])
            ->update([
                'transaction_reference' => $tr_ref,
                'payment_method' => 'uddoktapay',
                'order_status' => 'failed',
                'failed' => now(),
                'updated_at' => now(),
            ]);

        $requestData = [
            'full_name'    => $order->customer['f_name'],
            'email'        => $order->customer['email'] == null ? "example@example.com" : $order->customer['email'],
            'amount'       => $order->order_amount,
            'metadata'     => [
                'order_id'   => $order['id'],
                'tran_id' => $tr_ref,
                'metadata_2' => 'bar',
            ],
            'redirect_url' => route( 'uddoktapay.success' ),
            'cancel_url'   => route( 'uddoktapay.cancel' ),
            'webhook_url'  => 'https://foodcollections.com/api/v1/webhook',
        ];
        
        
            $config = Helpers::get_business_settings('uddoktapay');
            
            $uddokta = new UddoktaPay();
            
            $paymentUrl = $uddokta->init_payment($config['api_key'],$config['payment_url'],$requestData);
            
            return redirect( $paymentUrl );
            
        

        
    }

    /**
     * Reponse from sever
     *
     * @param Request $request
     * @return void
     */
    public function webhook( Request $request ) {

        $headerApi = isset( $_SERVER['RT_UDDOKTAPAY_API_KEY'] ) ? $_SERVER['RT_UDDOKTAPAY_API_KEY'] : null;

        if ( $headerApi == null ) {
            return response( "Api key not found", 403 );
        }

        if ( $headerApi != env( "UDDOKTAPAY_API_KEY" ) ) {
            return response( "Unauthorized Action", 403 );
        }

        $validatedData = $request->validate( [
            'full_name'      => 'required',
            'email'          => 'required',
            'amount'         => 'required',
            'invoice_id'     => 'required',
            'metadata'       => 'required',
            'payment_method' => 'required',
            'sender_number'  => 'required',
            'transaction_id' => 'required',
            'status'         => 'required',
        ] );

        Order::findOrFail( $validatedData['metadata']['order_id'] )->update( [
            'status'         => $validatedData['status'],
            'payment_method' => $validatedData['payment_method'],
            'sender_number'  => $validatedData['sender_number'],
            'transaction_id' => $validatedData['transaction_id'],
            'invoice_id'     => $validatedData['invoice_id'],
        ] );

        return response( 'Database Updated' );
    }

    /**
     * Success URL
     *
     * @return void
     */
    public function success(Request $request) {
        $data = $request->all();
        return view('uddoktapay-payment-verification', compact('data'));
    }

    /**
     * Cancel URL
     *
     * @return void
     */
    public function cancel() {
        return \redirect()->route('payment-fail');
    }
    
    public function verifyPayment(Request $request)
    {
        $invoiceID = $request->invoice_id;
        
        $config = Helpers::get_business_settings('uddoktapay');
        $apiKey = $config['api_key'];
        $payUrl = $config['payment_url'];
        
        $requestData = ["invoice_id" => $invoiceID];
            
        $url = curl_init($payUrl."/api/verify-payment");
        $header = array(
            "RT-UDDOKTAPAY-API-KEY: $apiKey",
            "accept: application/json",
            "content-type: application/json"
        );
        
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_POSTFIELDS, json_encode($requestData));
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_MAXREDIRS, 10);
        curl_setopt($url, CURLOPT_TIMEOUT, 30);
        $resultdata = curl_exec($url);
        curl_close($url);
        return json_decode($resultdata,true);
    }
    
     public function completePayment(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order = Order::where('transaction_reference', $tran_id)->first();

        
        $order->order_status='confirmed';
        $order->payment_method='uddoktapay';
        $order->transaction_reference=$tran_id;
        $order->payment_status='paid';
        $order->confirmed=now();
        $order->save();
        try {
                Helpers::send_order_notification($order);
                
            } catch (\Exception $e) {
                
            }

        if ($order->callback != null) {
            return redirect($order->callback . '&status=success');
        }

        return \redirect()->route('payment-success');

        
    }
    
     public function failedPayment(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order = Order::where('transaction_reference', $tran_id)->first();

        DB::table('orders')
                ->where('transaction_reference', $tran_id)
                ->update(['order_status' => 'failed', 'payment_status' => 'unpaid', 'failed'=>now()]);
        if ($order->callback != null) {
            return redirect($order->callback . '&status=fail');
        }
        return \redirect()->route('payment-fail');
        
    }

}
