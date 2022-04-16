<?php

    class Signup extends Dbh{
        private $name;
        private $email;
        private $phone;
        private $password;

        public function __construct($name, $email, $phone, $password){
            $this->name = $name;
            $this->email = $email;
            $this->phone = $phone;
            $this->password = $password;

            $emptyData = $this->check_empty(["name"=>$this->name, "phone"=>$this->phone, "password"=>$this->password, "email" => $this->email]);
            if($emptyData['error']):
                $this->endrequest($emptyData);
            endif;
            filter_var("uhrf", FILTER_SANITIZE_NUMBER_INT);
            $validate_data_type = $this->validate_data([$this->name, FILTER_SANITIZE_STRING],[$this->phone, FILTER_SANITIZE_NUMBER_INT],[$this->email, FILTER_VALIDATE_EMAIL],[$this->password, FILTER_SANITIZE_STRING]);
            if($validate_data_type['error']):
                $this->endrequest($validate_data_type);
            endif;

            




        }

        
    }