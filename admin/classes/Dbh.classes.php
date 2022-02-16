<?php

    class Dbh{
        private $host= "localhost";
        private $user= "root";
        private $pwd= "";
        private $dbName= "wemall";

        protected function connect() {
            $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbName;
            $pdo = new PDO($dsn, $this->user, $this->pwd);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        }

        public function check_account($email){
        $stmt = $this->connect()->prepare("SELECT * FROM admins WHERE email = ?;");
        if(!$stmt->execute(array($email))){
            $stmt = null;
            return 'stmt Error';
            exit();

        }
        // return $stmt->rowCount();
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }
        else{
            return  true; 
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
    public function getProduct($refrence = null){
        switch ($refrence) {
            case 'value':
                # code...
                break;
                
                default:
                $sql = "SELECT * FROM products;";
                # code...
                break;
        }
        $stmt = $this->connect()->prepare($sql);
        if(!$stmt->execute()){
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
    
    
    }