<?php

namespace App;

class OAuthDataBuilder
{
    private $clientId;
    private $clientSecret;
    private $code;
    private $redirectUri;

    public function __construct($clientId, $clientSecret, $code, $redirectUri) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->code = $code;
        $this->redirectUri = $redirectUri;
    }

    public function buildData() {
        return [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'authorization_code',
            'code' => $this->code,
            'redirect_uri' => $this->redirectUri,
        ];
    }
}