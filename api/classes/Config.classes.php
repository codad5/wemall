<?php
require_once $_SERVER['DOCUMENT_ROOT']."/wemall/vendor/autoload.php";

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key as JWT_KEY;
interface needAuth{
    public function validateAuth();
    // public function __construct($token, ...$extra);
}
Class Config{
    protected $api_key = 'wemall';

    public static function endrequest(Array $api_array,int  $headerresponse = 200,...$extraa){
            header('Content-Type: application/json', $headerresponse);
            echo json_encode($api_array);
            exit;
        }
        public function JWT_auth($user=""){
            if(empty($user)):
                return false;
            endif;
            $iat = time();
            $exp = $iat + 60 * 60;
            $payload = [
                'iss' => $this->base_url.'/api',
                'aud' => 'http://localhost:3000',
                'iat' => $iat,
                'exp' => $exp
            ];
            $jwt = JWT::encode($payload, $this->api_key.$user, 'HS512');
            return [
                'token' => $jwt,
                'expires' => $exp,
                'exptime' => gmstrftime("%a %e %b %Y %X ",$exp)
            ];
        }
        public function JWT_validate($token, $user=""){
            return JWT::decode($token, new JWT_KEY($this->api_key.$user, 'HS512'));
        }
}