<?php
use \Api\Payment;
    Class Order extends Dbh {
        protected $email;
        protected $product_id;
        protected $order_quantity;
        protected $order_price;
        public function __construct($email, $product_id, $order_quantity, $order_price){
            $this->email = $email;
            $this->product_id = $product_id;
            $this->order_quantity = $order_quantity;
            $this->order_price = $order_price;
            
            $emptyData = $this->check_empty(["email"=>$this->email, "product_id"=>$this->product_id, "order_quantity"=>$this->order_quantity, "order_price" => $this->order_price]);
            if($emptyData['error']):
                $this->endrequest($emptyData);
            endif;
            $validate_data_type = $this->validate_data([$this->product_id, FILTER_SANITIZE_STRING],[(int) $this->order_quantity, FILTER_VALIDATE_INT],[$this->email, FILTER_VALIDATE_EMAIL],[(int) $this->order_price, FILTER_VALIDATE_INT]);
            if($validate_data_type['error']):
                $this->endrequest($validate_data_type);
            endif;
        }

        public function registerOrder(){
            $sql = "INSERT INTO orders (name, email, product_name,  product_id) VALUES(?,?,?,?)";

        }

        public function test(){
            $payStack = new Payment\PayStack($this->email, 100);
            var_dump($payStack->init());
        }
    }