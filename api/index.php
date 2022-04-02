<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: XMLHttpRequest');
header('Access-Control-Allow-Headers: ');
header('Access-Control-Allow-Headers: x-rapidapi-key, x-rapidapi-host');
header('Access-Control-Allow-Headers: content-type');
header('Content-Type: application/json');
    require_once 'Dbh.classes.php';
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

            var_dump($extra);
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

    Class getProduct extends Dbh {
        public $message;
        public $error;
        public $datasent;
        public $dataLimit = 80;
        public function __construct($filter, $keyword, $limit = 80, ...$extra){
            $this->dataLimit = $limit;
            $result = ['data' => []];
            try{
                $result = $this->get_product($filter, $keyword);
                
                
                $this->message = $result['message'];
                $this->error = false;

            }catch(Exception $e){
                $this->message = $e->getMessage();
                $this->error = true;
                $result['data'] = [];
            }
            
            
                    # code...
                    
                    $this->datasent = $_GET;
                    $this->endrequest($this->prepareArray($result['data']), "CDYRSDTYD");
                    
                
                
                    
           
        }

        

        public function prepareArray($dataneed, ...$extra){
            return $api_array = [
                'message' => $this->message,
                'error' => $this->error,
                'datasent' => $this->datasent,
                'data' => $dataneed,
                'extra' => []
            ];
            
        }
    }
    class Rate extends Dbh{
        public $product;
        public $rating;
        public function __construct($rating, $product){

        }
    }

if (!isset($_GET['filter']) || !isset($_GET['base'])) {
    # code...
    echo json_encode(['error' => true, 'message' => 'bad Url read doc @ ']);
    exit;
}


$filter = filter_var($_GET['filter'], FILTER_SANITIZE_STRING);
$keyword = filter_var($_GET['keyword'], FILTER_SANITIZE_STRING);
switch ($_GET['base']) {
    case 'list':
        # code...
        
        $api = new getList($filter, $keyword);
        break;
    case 'product':
        # code...
        
        $api = new Dbh();
        $api = new getProduct($filter, $keyword);
        break;
    case 'rate':
        $api = new Rate($filter, $keyword);

    
    default:
        # code...
        break;
}




