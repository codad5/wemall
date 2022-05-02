<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/wemall/vendor/autoload.php";
    use \Firebase\JWT\JWT;
    use \Firebase\JWT\Key as JWT_KEY;

    class Validate {
        public static function return_error_array(...$data) : Array {
            $newData = [];
            foreach ($data as $key => $value) {
                # code...
                $newData[$key] = $value;
            }
            return $newData;

        }
    }
    class Dbh extends Config{
        
        private $host= "localhost";
        private $user= "root"; // "murpcwti_murpcwti";
        private $pwd= ""; //"macon35798642";
        private $dbName= 'wemall'; //"murpcwti_wemall";
        public $api_array = [];
        public $base_url = "";
        protected $api_key = 'wemall';

        public function __construct(){
            $isLocalHost = ($_SERVER['HTTP_HOST'] == 'localhost');
             
            $this->base_url = ($_SERVER['HTTP_HOST'] == 'localhost') ? 'http://localhost/wemall/' : $_SERVER['HTTP_HOST']."/";
            
            try{
                $this->connect();
                
            }catch(PDOException $e){
                
                $message = "SQLSTATE[HY000] [1049] Unknown database '".$this->dbName."'";
                echo $e->getMessage() === $message;
                
                if($e->getMessage() === $message){
                    
                    // $this>prepareDbConnection();
                    $conn = new mysqli($this->host, $this->user, $this->pwd);
                        // Check connection     
                    
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        
                        // Create database
                        $sql = "CREATE DATABASE ".$this->dbName.";";
                        
                    
                        if ($conn->query($sql) === TRUE) {
                           
                            
                        
                        $this->initializeDb();
                        } else {
                            
                            
                        
                            exit();
                        }

                        $conn->close();

                }else {
                        
                            exit();
                        }
                

            }
        }

        protected function initializeDb(){
            require_once "sql.php";
            $stmt = $this->connect()->prepare($setup_sql);
            if(!$stmt->execute(array())){
                $stmt = null;
                return false;

            }
        }

        protected function connect() {
            $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbName;
            $pdo = new PDO($dsn, $this->user, $this->pwd);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        }
        
        public function get_product($filter, $keyword, ...$extra){
            $res = "";
            $stmt = $this->connect()->prepare("SELECT * FROM products WHERE product_id = ? AND active_status != 'deleted';");
            $res = $stmt->execute(array($keyword));

            if(!$res){
                $stmt = null;
                throw new Exception('Server error');

            }
            // return $stmt->rowCount();
            if($stmt->rowCount() > 0){
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $data = $this->prepare_product_array($data);
                switch ($filter) {
                case 'detail':
                    $data = $data[0];
                    # code...
                    
                    break;
                case 'details':
                    $data = $data[0];
                    # code...
                    
                    break;
                case 'category':
                    $data = $data[0]['product_category'];

                    break;
                case 'discount':
                    $data = ["discount"=> $data[0]['product_discount'], "discount_method"=>$data[0]['discount_method'],"original_price" => $data[0]['product_price'], "sell_price" => $this->gen_sell_price($data[0]['product_price'],$data[0]['product_discount'],$data[0]['discount_method'] )['validate']];
                    // $data = $data[0]['discount_method'];

                    break;
                case 'price':
                    $data = ["discount"=> $data[0]['product_discount'], "discount_method"=>$data[0]['discount_method'],"original_price" => $data[0]['product_price'], "sell_price" => $this->gen_sell_price($data[0]['product_price'],$data[0]['product_discount'],$data[0]['discount_method'] )['validate']];
                    // $data = $data[0]['discount_method'];

                    break;
                    
                    default:
                    
                    $data = @$data[0]['product_'.$filter];
                
                    if(!has_value($data)){
                        $data = @$data[0][$filter];

                    }
                    # code...
                    
                    # code...
                    break;
                }
                
                return   $data;
            }
            else{
                
                
                return  [];
                #$stmt->rowCount();
            }
       

        }

        public static function get_users(Dbh $user, $param, $filter, $strict = true) : Array{
            $return_array = [];
            $return_array['error'] = true;
            $return_array['message'] = "";
            $symbol = '=';
            $unknown = "?";
            if(!$strict){
                $unknown = "%".$unknown."%";
                $symbol = 'LIKE';
            }
            
            try{

                $stmt = $user->connect()->prepare("SELECT * FROM users WHERE ".$filter." ".$symbol." ".$unknown.";");
                $res = $stmt->execute(array($param));
                if(!$res){
                    $stmt = null;
                    throw new Exception('Server error');

                }
                if($stmt->rowCount() > 0){
                    $return_array['error'] = false;
                    $return_array['message'] = "Users with ".$filter." Related to ".$param; 
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $return_array['data'] = $data;
                }
                else{
                    $return_array['error'] = true;
                    $return_array['message'] = "No Users with ".$filter." Related to ".$param; 
                    $data = [];
                    $return_array['data'] = $data;
                }
            }
            catch(Exception $e){
                $return_array['message'] = $e->getMessage(); 
                $return_array['error'] = true;
                
                
            }
            
            
            
            return $return_array;

            
        }
        
        protected function checkWebsite($domain){
            $stmt = $this->connect()->prepare("SELECT * FROM websites WHERE website_domain  = ?;");
            if(!$stmt->execute(array($domain))){
                $stmt = null;
                header("location: ../index.php?error=stmtfailed");
                exit();

            }
            // return $stmt->rowCount();
            if($stmt->rowCount() < 1){
                // echo $stmt->rowCount();
                return  false; #$stmt->rowCount();
                
            }
            else{
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                // return false;
            }
        

        }
        protected function getPayment($refrence){
            $stmt = $this->connect()->prepare("SELECT * FROM request_orders WHERE refrence_key  = ?;");
            if(!$stmt->execute(array($refrence))){
                $stmt = null;
                return false;

            }
            // return $stmt->rowCount();
            if($stmt->rowCount() < 1){
                // echo $stmt->rowCount();
                return  false; #$stmt->rowCount();
                
            }
            else{
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                // return false;
            }
        

        }
        // this is to generate the sell price base on the discount factor
        public static function gen_sell_price($product_price, $product_discount, $discount_method){
            $sell_price = $product_price;
            switch ($discount_method) {
                case 'price_cut':
                    if($product_discount > $product_price){
                        return ['validate' =>false, 'error_msg' => 'Discount can not be greater than ' . $product_price];
                    }
                    $sell_price = $product_price - $product_discount; 
                    # code...
                    break;
                
                
                case 'percentage':
                    if($product_discount > 100){
                        return ['validate' =>false, 'error_msg' => 'Discount can not be greater than 100'];
                    }
                    $price_cut = $product_discount / 100;
                    $price_cut = $price_cut * $product_price;
                    $sell_price = $product_price - $price_cut;
                    
                    break;
                    default:
                    
                    # code...
                    break;
            }
            return ['validate' => $sell_price, 'error_msg' => 'success'];
        }
        public function productCat($cat_array){
                return explode(',',$cat_array);
        }
        public  function prepare_product_array($products){
            $isLocalHost = ($_SERVER['HTTP_HOST'] == 'localhost');
            $this->base_url = ($_SERVER['HTTP_HOST'] == 'localhost') ? 'http://localhost/wemall/' : "https://".$_SERVER['HTTP_HOST']."/";
            for ($i=0; $i < count($products); $i++) { 
                            $products[$i]['product_id_private'] = $i;
                            $products[$i]['product_category'] = $this->productCat($products[$i]['product_category']);
                            $products[$i]['sell_price'] = $this->gen_sell_price($products[$i]['product_price'], $products[$i]['product_discount'], $products[$i]['discount_method'])['validate'];
                            $products[$i]['product_image1'] = $this->base_url.'assets/image/gallery/'.$products[$i]['product_image1'];
                            $products[$i]['product_image2'] = $this->base_url.'assets/image/gallery/'.$products[$i]['product_image2'];
                            $products[$i]['product_image3'] = $this->base_url.'assets/image/gallery/'.$products[$i]['product_image3'];
                            $products[$i]['product_image4'] = $this->base_url.'assets/image/gallery/'.$products[$i]['product_image4'];
                            $products[$i]['product_image5'] = $this->base_url.'assets/image/gallery/'.$products[$i]['product_image5'];
                            $products[$i]['product_price'] = (int)$products[$i]['product_price'];
                            $products[$i]['product_quantity'] = (int)$products[$i]['product_quantity'];
                            $products[$i]['product_discount'] = (int)$products[$i]['product_discount'];
                            $products[$i]['total_delivery'] = (int)$products[$i]['total_delivery'];
                            $products[$i]['api_perm_link'] = $this->base_url.'api/product/detail/'.$products[$i]['product_id'];
                            # code...
                            


                        }

                        return $products;
        }

        public function check_empty(Array $values, ...$extra) : Validate|bool|Array{
            $newMessage = [];
            $anyError = false;
            foreach ($values as $key => $value) {
                # code...
                if(empty($key) || empty($value)){
                    $anyError = true;
                    $newMessage['message'][] = $key." is empty";
                }
            }
            if($anyError) {
                $newMessage['error'] = $anyError;
                return  Validate::return_error_array($newMessage)[0];
            }
            $newMessage['error'] = $anyError;
            return $newMessage;
        }
        
        public static function validate_data(...$data){
            $error = false;
            $_message = array();
            foreach ($data as $key => $value) {
                $validate = filter_var($value[0], $value[1]);
                if($validate == false){
                    $error = true;
                    $_message[$key] = $value[0]." is a invalid data type for ".$value[1];
                    // $message[] = $value;


                }
                # code...
            }
            $return_array = ['error' => $error, 'message' => $_message];
            return $return_array;
        }
        
    }