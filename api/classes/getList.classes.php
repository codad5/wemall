<?php
Class getList extends Dbh{
        /**
         * @param String $message
         * This is where the purpose error message is been stored
         */
        public $message;
        /**
         * @param bool $error
         * This stores the current object possible error status
         * 
         * `true` if there is any possible error within the object, `false` otherwise
         * 
         */
        public $error;
        /**
         * 
         */
        public $datasent;
        /**
         * @param int $dataLimit
         * This is thr data limit output
         * 
         */
        public $dataLimit = 80;
        /**
         * @param Array $list
         * This is the list of data gotten from the given partition
         * 
         */
        public $list;
        /**
         * @param String $filter
         * this is the search filter parameter (eg gender, category)'
         * 
         * @param String $keyword  
         * this is the search keyword parameter (eg male, luxury)
         * `NOTE` :- when searching for all item in a given filter use tbe keyword `all`
         * 
         * @param int $limit
         * This is output data limit for the search keyword parameter
         * `default` = `80`
         * 
         * @param mixed $extra
         * This is any extra parameters
         * 
         * @return void
         */
        public function __construct($filter, $keyword, $limit = 80, ...$extra){
            $this->dataLimit = $limit;
            $this->filter = $filter;
            $this->keyword = $keyword;
            $this->extra = $extra;
            

            // var_dump($extra);
        }

        /**
         * This is where the data `$list` is assigned
         * 
         * @return bool
         * return `true` if an error was encountered, `false` otherwise
         * 
         */
        public function setList() : bool{
            switch ($this->filter) {
                case 'category':
                    $this->list = $this->getCategory();
                break;
                case 'gender' :
                    $this->list = $this->getGender();
                break;
                case 'search':
                    $this->list = $this->search();
                break;
                case 'price':
                    $this->list = $this->getPrice();
                break;
                default:
                    $this->message = 'Invalid Action';
                    $this->error = true;
                    $this->list = [];
                    return false;
                break;
            }
            return true;
        }
        /**
         * this is a method used to get end product of the object
         * @return Array
         * 
         */
        public function get_data() : Array{
                    $result = $this->prepare_product_array($this->list);
                    
                    return $this->prepareArray($result);
        }
        /**
         * This is a method used to fetch array of product for certain category based on the given search query
         * 
         * @return Array
         */
        public function getCategory( ...$extra) : Array{
            if($this->keyword !== 'all'){
                $sql = "SELECT * FROM products where product_category LIKE ? AND active_status != ?;";
                $stmt = $this->connect()->prepare($sql);
                if(!$stmt->execute(array("%".$this->keyword."%", "deleted"))){
                    $stmt = null;
                    $this->message = "Request Error";
                    $this->error = true;
                    return [];

                }
                
            }
            else{
                $sql = "SELECT * FROM products where  active_status != ?;";
                $stmt = $this->connect()->prepare($sql);
                if(!$stmt->execute(array("deleted"))){
                    $stmt = null;
                    $this->message = "Request Error";
                    $this->error = true;
                    return [];

                }

            }
            
            // return $stmt->rowCount();
                if($stmt->rowCount() < 1){
                    // echo $stmt->rowCount();
                    $this->message = "No product tied to such ".$this->filter;
                    $this->error = false;
                    return [];
                    // return  ['message' => "No product tied to such category", 'data' => []]; #$stmt->rowCount();
                    
                }
                else{
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->message = "Product with category ".$this->keyword;
                    $this->error = false;
                    return $data;
                    // return  ['message' => "Product with category ".$this->keyword, 'data' => $data];
                    // return $stmt->fetchAll(PDO::FETCH_ASSOC);
                    // return false;
                }
        }
        /**
         * This is a method used to fetch array of product for certain gender based on the given search query
         * 
         * @return Array
         */
        public function getGender( ...$extra){
            if($this->keyword !== 'all'){
                $sql = "SELECT * FROM products where product_gender = ? AND active_status != ?;";
                $stmt = $this->connect()->prepare($sql);
                if(!$stmt->execute(array($this->keyword, "deleted"))){
                    $stmt = null;
                    $this->message = "Request Error";
                    $this->error = true;
                    return [];

                }
                
            }
            else{
                $sql = "SELECT * FROM products where product_gender in (?, ?) AND active_status != ?;";
                $stmt = $this->connect()->prepare($sql);
                if(!$stmt->execute(array("unisex", $this->keyword, "deleted"))){
                    $stmt = null;
                    $this->message = "Request Error";
                    $this->error = true;
                    return [];

                }

            }
            
            // return $stmt->rowCount();
            if($stmt->rowCount() < 1){
                    // echo $stmt->rowCount();
                    $this->message = "No product tied to such Gender";
                    $this->error = false;
                    return [];
                    // return  ['message' => "No product tied to such Gender", 'data' => []]; #$stmt->rowCount();
                    
            }
            else{
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->message = "Product with Gender ".$this->keyword;
                    $this->error = false;
                    return $data;
                    // return  ['message' => "Product with Gender ".$keyword, 'data' => $data];
                    // return $stmt->fetchAll(PDO::FETCH_ASSOC);
                    // return false;
            }
        }
        /**
         * This is a method used to search query of a particular keyword 
         * 
         * @return Array
         */
        public function search( ...$extra){
                $keyword = '%'.$this->keyword."%";
                $sql = "SELECT * FROM products where product_gender LIKE ? OR product_name LIKE ? OR product_category LIKE ? OR product_price LIKE ? AND active_status != ?;";
                $stmt = $this->connect()->prepare($sql);
                if(!$stmt->execute(array($keyword,$keyword, $keyword, $keyword, "deleted"))){
                    $stmt = null;
                    $this->message = "Request Error";
                    $this->error = true;
                    return [];

                }

            
            
            // return $stmt->rowCount();
            if($stmt->rowCount() < 1){
                    // echo $stmt->rowCount();
                    $this->message = "No product tied to such Search query >> ".$this->keyword;
                    $this->error = false;
                    return [];
                    // return  ['message' => "No product tied to such Gender", 'data' => []]; #$stmt->rowCount();
                    
            }
            else{
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->message = "Product with Gender ".$this->keyword;
                    $this->error = false;
                    return $data;
                    // return  ['message' => "Product with Gender ".$keyword, 'data' => $data];
                    // return $stmt->fetchAll(PDO::FETCH_ASSOC);
                    // return false;
            }
        }
        /**
         * This is a method used to price query of a particular keyword 
         * 
         * @return Array
         */
        public function getPrice( ...$extra){

                $keyword = $this->keyword;
                $equator = "=";
                if(strpos($keyword, '>') == 0):
                    $keyword = explode('>', $keyword)[0];
                    $equator = ">";
                elseif(strpos('<', $keyword) == 0):
                    $keyword = explode('<', $keyword)[0];
                    $equator = "<";
                endif;
                $sql = "SELECT * FROM products where product_price ".$equator." ? AND active_status != ?;";
                $stmt = $this->connect()->prepare($sql);
                if(!$stmt->execute(array($keyword, "deleted"))){
                    $stmt = null;
                    $this->message = "Request Error";
                    $this->error = true;
                    return [];

                }

            
            
            // return $stmt->rowCount();
            if($stmt->rowCount() < 1){
                    // echo $stmt->rowCount();
                    $this->message = "No product tied to such Search query >> ".$keyword;
                    $this->error = false;
                    return [];
                    // return  ['message' => "No product tied to such Gender", 'data' => []]; #$stmt->rowCount();
                    
            }
            else{
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->message = "Product with Gender ".$keyword." ".implode(" ", explode('<', $this->keyword));
                    $this->error = false;
                    return $data;
                    // return  ['message' => "Product with Gender ".$keyword, 'data' => $data];
                    // return $stmt->fetchAll(PDO::FETCH_ASSOC);
                    // return false;
            }
        }

        /**
         * This pepare the final product for this object  
         * @param Array $dataneed
         * this is the  array of the list of products gotten from the search results
         * 
         * @return Array 
         */
        

        public function prepareArray(Array $dataneed = [], ...$extra) : Array{
            return  [
                'message' => $this->message,
                'error' => $this->error,
                'datasent' => $this->datasent,
                'data' => $dataneed,
                'extra' => $extra
            ];
            
        }

       

        
    }