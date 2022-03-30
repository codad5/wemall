<?php

    class Dbh{
        private $host= "localhost";
        private $user= "root";
        private $pwd= "";
        private $dbName= "wemall";
        public $api_array = [];
        public $base_url = "";

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
                case 'category':
                    $data = $data[0]['product_category'];

                    break;
                    
                    default:
                    
                    $data = @$data[0]['product_'.$filter];
                
                    if(empty($data) || $data==null || !$data){
                        $data = @$data[0][$filter];

                    }
                    # code...
                    
                    # code...
                    break;
                }
                
                return  ['message' => " ".$keyword." is avaliable", 'data' => $data];
            }
            else{
                throw new Exception('No item found for key ' . $keyword);
                
                return  ['message' => " ".$keyword."is unavaliable", 'data' => []];
                #$stmt->rowCount();
            }
       

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
            $this->base_url = ($_SERVER['HTTP_HOST'] == 'localhost') ? 'http://localhost/wemall/' : $_SERVER['HTTP_HOST']."/";
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
        
        public static function endrequest(Array $api_array, ...$extraa){
            
            echo json_encode($api_array);
            exit;
        }
    }