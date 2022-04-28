<?php
    Class getProduct extends Dbh {
        public $message;
        public $error;
        public $datasent;
        public $dataLimit = 80;
        public $filter;
        public $keyword;
        public $extra;
        public $list;
        public function __construct($filter, $keyword, $limit = 80, ...$extra){
            $this->dataLimit = $limit;
            $this->filter = $filter;
            $this->keyword = $keyword;
            $this->extra = $extra;
            
            
                
                    
           
        }
        public function setList()
        {
            try{
                $this->list = $this->get_product($this->filter, $this->keyword);
                
                if(count($this->list) > 0):

                    $this->message = "Product with item id ".$this->keyword;
                    $this->error = false;
                else:
                    $this->message = "No Product with item id ".$this->keyword;
                    $this->error = false;
                endif;

            }catch(Exception $e){
                $this->message = $e->getMessage();
                $this->error = true;
                $this->list = [];
            }
            
            
                    # code...
                    
                    
                    
                
        }
        
        public function get_data() : Array
        {
            
                    
            return $this->prepareArray($this->list);
            
        }

        public function prepareArray($dataneed, ...$extra) : Array
        {
            return  [
                'message' => $this->message,
                'error' => $this->error,
                'datasent' => $this->datasent,
                'data' => $dataneed,
                'extra' => $extra
            ];
            
        }
    }