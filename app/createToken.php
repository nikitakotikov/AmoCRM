<?php

namespace App;

class CreateToken
{
    private $url;
    private $requestData = [];
    private $out;
    private $code;
    
    public function __construct($url, $requestData) {
        $this->url = $url;
        $this->requestData = $requestData;
    }
    
    public function sendRequest() {
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'amoCRM-oAuth-client/1.0',
            CURLOPT_URL => $this->url,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_HEADER => false,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($this->requestData),
            CURLOPT_SSL_VERIFYPEER => 1,
            CURLOPT_SSL_VERIFYHOST => 2,
        ]);
        
        $this ->out = curl_exec($curl);
        $this ->code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        
    }

    public function getCode() {
        return $this ->code;
    }
    public function getOut() {
        return $this ->out;
    }
}
