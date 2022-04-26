<?php


Class Login extends Dbh{
    public $login_detail;
    private $password;
    public function __construct($login_detail, $password){
        $this->login_detail = $login_detail;
        $this->password = $password;
        
        $emptyData = $this->check_empty(["username"=> $login_detail, "password"=>$this->password]);
        // $emptyData['data_sent'] = $_POST;
        if($emptyData['error']):
                $this->endrequest($emptyData);
            endif;
        $validate_data_type = $this->validate_data([$this->login_detail, FILTER_SANITIZE_STRING],[$this->password, FILTER_SANITIZE_STRING]);
            if($validate_data_type['error']):
                $validate_data_type['coco']  = 'IHQ9UF';
                $this->endrequest($validate_data_type);
            endif;
    }
    public function login(){
            $return_array = [];
            $return_array['message'] = "";
            $return_array['error'] = true;
            // to check if the login details is avaliable for either emeil or phone
            $duplicate_email = $this->get_users($this, $this->login_detail, "email");
            $duplicate_phone = $this->get_users($this, $this->login_detail, "phone");
            if($duplicate_phone['error'] == true && $duplicate_email['error'] == true){
                $await_message = [];
                if($duplicate_phone['error']):
                    $await_message[] = $this->login_detail." does not exist.";
                endif;
                if ($duplicate_email['error']) :
                    $await_message[] = $this->login_detail." does not exist.";
                endif;
                $return_array['message'] = implode("<br> ", $await_message)."";
                // $return_array[] = $duplicate_phone;
                // $return_array[] = $duplicate_email;
                
                return $return_array;
            }
            if($duplicate_phone['error'] == false):
                    $return_array['data'] = $duplicate_phone['data'][0];
            elseif($duplicate_email['error'] == false): 
                    $return_array['data'] = $duplicate_email['data'][0];
            endif;
            // var_dump($duplicate_phone['data']);
            if(password_verify($this->password, $return_array['data']['passwords'])):
                $return_array['message'] = "login successful.";
                $return_array['error'] = false;
                $return_array['login_token'] = $this->JWT_auth($return_array['data']['email']);
                $return_array['data']['passwords'] = "321*34*452*";

            else:
                $return_array['data'] =  [];
                $return_array['message'] = "wrong password provided";

            endif;
                return $return_array;
            }
}