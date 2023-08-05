<?php
namespace App;

class TokenManager 
{
    private $filename;
    private $tokenData;

    public function __construct($filename) {
        $this->filename = $filename;

        $this->tokenData = json_decode(file_get_contents($this->filename), true);

    }

    public function getAccessToken() {

        return $this->tokenData['access_token'];
    }

    public function getSubDomain() {
        return $this->tokenData['subdomain'];
    }
}
