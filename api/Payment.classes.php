<?php
namespace Api\payment;

class PayStack{
    public $email;
    public $price;
    protected $SECRET_KEY = "sk_test_4cfae9846fa16d47472c57be9d44be1f0a646b2e";
    protected $url = "https://api.paystack.co/transaction/";
    public function __construct($email, $price){
        $this->email = $email;
        $this->price = 100 * (int) $price;

    }
    public function init(){
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
        
        //execute post
        $result = json_decode(curl_exec($ch));
        return $result;
    }
}
