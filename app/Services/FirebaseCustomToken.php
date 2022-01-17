<?php

namespace App\Services;

use Firebase\JWT\JWT;

class FirebaseCustomToken
{
    protected $service_account_email;
    protected $private_key;

    public function __construct()
    {
        $json_creds = json_decode(file_get_contents(env('FIREBASE_CREDENTIALS')));
        $this->service_account_email = $json_creds->client_email;
        $this->private_key = $json_creds->private_key;
    }

    public function create_custom_token($uid, $is_premium_account=true) {
        
      
        // $now_seconds = time();
        // $payload = array(
        //   "iss" => $this->service_account_email,
        //   "sub" => $this->service_account_email,
        //   "aud" => "https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit",
        //   "iat" => $now_seconds,
        //   "exp" => $now_seconds+(60*60),  // Maximum expiration time is one hour
        //   "uid" => $uid,
        //   "claims" => array(
        //     "premium_account" => $is_premium_account
        //   )
        // );
        // return JWT::encode($payload, $this->private_key, "RS256");
    }

}