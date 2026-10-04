<?php

namespace App\Library;

use Illuminate\Support\Facades\Http;

class UddoktaPay {
    
    /**
     * UDDOKTAPAY constructor.
     */
    public function __construct()
    {
        
    }
    
    /**
     * Send payment request
     *
     * @param array $requestData
     * @return void
     */
    public static function init_payment($apiKey,$apiUrl,$requestData) {
        $response = Http::withHeaders( [
            'Content-Type'          => 'application/json',
            'RT-UDDOKTAPAY-API-KEY' => $apiKey,
        ] )
            ->asJson()
            ->withBody( json_encode( $requestData ), "JSON" )
            ->post( $apiUrl . "/api/checkout-v2" );
            
        if ( $response->successful() ) {
            return $response->collect()['payment_url'];
        } else {
            dd( $response->body() );
        }
    }
}
