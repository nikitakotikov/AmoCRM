<?php

namespace App;

class AmoCRMClient 
{
    private $subdomain;
    private $access_token;

    public function __construct($subdomain, $access_token) {
        $this->subdomain = $subdomain;
        $this->access_token = $access_token;
    }

    public function createLead($leadData) {
        $method = "/api/v4/leads";
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->access_token,
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'amoCRM-API-client/1.0',
            CURLOPT_URL => "https://{$this->subdomain}.amocrm.ru{$method}",
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($leadData),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HEADER => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);
        
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }
}