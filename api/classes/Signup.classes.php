<?php

    class Signup extends Dbh{
        public $name;
        public $email;
        public $phone;
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
            filter_var("uhrf", FILTER_VALIDATE_EMAIL);
            $validate_data_type = $this->validate_data([$this->name, FILTER_SANITIZE_STRING],[(int) $this->phone, FILTER_VALIDATE_INT],[$this->email, FILTER_VALIDATE_EMAIL],[$this->password, FILTER_SANITIZE_STRING]);
            if($validate_data_type['error']):
                $this->endrequest($validate_data_type);
            endif;



            




        }

        public function signUp() : bool|array{
            
            $sql = "INSERT INTO users (name, email, phone,  passwords) VALUES(?,?,?,?)";
            $stmt = $this->connect()->prepare($sql);
            if(!$stmt->execute(array($this->name, $this->email, $this->phone, password_hash($this->password, PASSWORD_DEFAULT)))){
                $stmt = null;
                return false;
                

            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
    }