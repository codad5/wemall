<?php
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
                    $this->endrequest($this->prepareArray($result['data'], $_SERVER), "CDYRSDTYD");
                    
                
                
                    
           
        }

        

        public function prepareArray($dataneed, ...$extra){
            return $api_array = [
                'message' => $this->message,
                'error' => $this->error,
                'datasent' => $this->datasent,
                'data' => $dataneed,
                'extra' => $extra
            ];
            
        }
    }