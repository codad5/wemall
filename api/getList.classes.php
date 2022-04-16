<?php
Class getList extends Dbh{
        public $message;
        public $error;
        public $datasent;
        public $dataLimit = 80;
        public function __construct($filter, $keyword, $limit = 80, ...$extra){
            $this->dataLimit = $limit;
            switch ($filter) {
                case 'category':
                    # code...
                    $result = $this->getCategory($keyword, $extra);
                    $result['data'] = $this->prepare_product_array($result['data']);
                    $this->message = $result['message'];
                    $this->error = false;
                    $this->datasent = $_GET;
                    $this->endrequest($this->prepareArray($result['data']));
                    break;
                case 'gender' :
                    $result = $this->getGender($keyword, $extra);
                    $result['data'] = $this->prepare_product_array($result['data']);
                    $this->message = $result['message'];
                    $this->error = false;
                    $this->datasent = $_GET;
                    $this->endrequest($this->prepareArray($result['data']));

                    break;
                
                
                    default:
                    # code...
                    $this->message = 'Invalid Action';
                    $this->error = true;
                    $this->datasent = $_GET;
                    $this->endrequest($this->prepareArray());
                    break;
            }

            // var_dump($extra);
        }
        
        public function getCategory($keyword, ...$extra){
            if($keyword !== 'all'){
                $sql = "SELECT * FROM products where product_category LIKE ? AND active_status != ?;";
                $stmt = $this->connect()->prepare($sql);
                if(!$stmt->execute(array("%".$keyword."%", "deleted"))){
                    $stmt = null;
                    return false;

                }
                
            }
            else{
                $sql = "SELECT * FROM products where  active_status != ?;";
                $stmt = $this->connect()->prepare($sql);
                if(!$stmt->execute(array("deleted"))){
                    $stmt = null;
                    return false;

                }

            }
            
        // return $stmt->rowCount();
                if($stmt->rowCount() < 1){
                    // echo $stmt->rowCount();
                    return  ['message' => "No product tied to such category", 'data' => []]; #$stmt->rowCount();
                    
                }
                else{
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return  ['message' => "Product with category ".$keyword, 'data' => $data];
                    // return $stmt->fetchAll(PDO::FETCH_ASSOC);
                    // return false;
                }
            }
        public function getGender($keyword, ...$extra){
            if($keyword !== 'all'){
                $sql = "SELECT * FROM products where product_gender = ? AND active_status != ?;";
                $stmt = $this->connect()->prepare($sql);
                if(!$stmt->execute(array($keyword, "deleted"))){
                    $stmt = null;
                    return false;

                }
                
            }
            else{
                $sql = "SELECT * FROM products where product_gender in (?, ?) AND active_status != ?;";
                $stmt = $this->connect()->prepare($sql);
                if(!$stmt->execute(array("unisex", $keyword, "deleted"))){
                    $stmt = null;
                    return false;

                }

            }
            
        // return $stmt->rowCount();
                if($stmt->rowCount() < 1){
                    // echo $stmt->rowCount();
                    return  ['message' => "No product tied to such Gender", 'data' => []]; #$stmt->rowCount();
                    
                }
                else{
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return  ['message' => "Product with Gender ".$keyword, 'data' => $data];
                    // return $stmt->fetchAll(PDO::FETCH_ASSOC);
                    // return false;
                }
            }

        public function prepareArray($dataneed = [], ...$extra){
            return $api_array = [
                'message' => $this->message,
                'error' => $this->error,
                'datasent' => $this->datasent,
                'data' => $dataneed,
                'extra' => $extra
            ];
            
        }

       

        
    }