<?php
namespace Api\payment;

interface Payment_method{
    public function init($price);
}
class PayStack implements Payment_method{
    public $email;
    public $price;
    protected $SECRET_KEY = "sk_test_4cfae9846fa16d47472c57be9d44be1f0a646b2e";
    protected $url = "https://api.paystack.co/transaction/";
    public $refrence;
    public function __construct($email){
        $this->email = $email;
        
    }
    public function init($price){
        // echo $price;
        $this->price = 100 * (int) $price;
        $url = $this->url.'initialize';
        $fields = [
            'email' => $this->email,
            'amount' => $this->price
        ];
        $fields_string = http_build_query($fields);
        $ch = curl_init();
  
  //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer ".$this->SECRET_KEY,
            "Cache-Control: no-cache",
        ));
        
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        // echo $response."hello > ".$this->price;
        // exit;
        if ($err) {
            throw new \Exception("Error Connecting to payStack");
            return false;
        } else {
            $response = json_decode($response, true);
            // var_dump($response);
            if($response['status']){

                $this->refrence = $response['data']['reference'];
                return $response;
            }
            else{
                throw new \Exception("Error processing payStack");
                return false;
            }

        }
        
        //execute post
       
    }
}

