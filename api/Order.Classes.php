<?php
use \Api\Payment;
    Class Order extends Dbh implements needAuth {
        protected $email;
        // protected $product_id;
        protected $order_quantity;
        protected $order_price;
        public $order_id;
        public Payment\Payment_method $payment_method;
        public $order_details;
        protected $JWT_token;
        /**
         * The Constructor any Class With implementation needAuth needs to have a $token
         * @param String $token
         * @param String $email
         * @return void
         */
        public function __construct($token, $email,  $order_quantity, Payment\Payment_method $payment_method){
            $this->email = $email;
            $this->order_quantity = $order_quantity;
            $this->JWT_token = $token;
            $this->order_id = uniqid('', true);
            $this->payment_method = $payment_method;
            
            
            $emptyData = $this->check_empty(["email"=>$this->email, "product_id"=>$this->order_id, "order_quantity"=>$this->order_quantity, "JWT_token" => $this->JWT_token]);
            if($emptyData['error']):
                $this->endrequest($emptyData);
            endif;
            $validate_data_type = $this->validate_data([$this->order_id, FILTER_SANITIZE_STRING],[(int) $this->order_quantity, FILTER_VALIDATE_INT],[$this->email, FILTER_VALIDATE_EMAIL],[ $this->JWT_token, FILTER_SANITIZE_STRING]);
            if($validate_data_type['error']):
                $this->endrequest($validate_data_type);
            endif;
        }

        public function validateAuth(){
            try{
                $this->JWT_validate($this->JWT_token, $this->email);
            }catch(\Exception $e){
                return false;
            }
            return true;
        }

        public function registerProduct($product_detail) {
            try{

                $product = $this->get_product('detail',$product_detail['data']['product_id'])['data'];
                $product['sell_price'] = $this->gen_sell_price($product['product_price'], $product['product_discount'], $product['discount_method'])['validate'];
                $quantity = $product_detail['quantity'];
                // $sale_price = $product['data'][''];
                $sql = "INSERT INTO ordersItems (email, product_name, product_id,  quantity, sales_price,  total_price, order_id) VALUES(?,?,?,?,?,?,?)";
                $stmt = $this->connect()->prepare($sql);
                if(!$stmt->execute(array($this->email, $product['product_name'],$product['product_id'], $quantity, $product['sell_price'], (int) ($product['sell_price'] * $quantity) , $this->order_id))){
                    $stmt = null;
                    return false;
                    

                }
            }catch(Exception $e){
                // $this->message = $e->getMessage();
                // $this->error = true;
                $result['error'] = true;
                $result['product_id'] = $product['product_id'];
               $result['message'] = $e->getMessage();
                return $result;
            }
            $this->order_price =  (int) ($product['sell_price'] * $quantity);
            return true;

        }

        public function implementOrder(){
            try{
                $this->order_details = $this->payment_method->init($this->order_price);}
            catch(Exception $e){
                return ['error' => true ,"message" => $e->getMessage()];
            }
            $sql = "INSERT INTO orders (email, quantity,  total_price, order_id,  payment_id) VALUES(?,?,?,?,?)";
            $stmt = $this->connect()->prepare($sql);
                if(!$stmt->execute(array($this->email, $this->order_quantity,$this->order_price, $this->order_id, $this->payment_method->refrence))){
                    $stmt = null;
                    return ['error' => true, 'message' => 'Database error'];
                    

                }
            return true;
        }

        public function test(){
            $payStack = new Payment\PayStack($this->email, 100);
            // var_dump($this->payment_method->init());
        }
    }