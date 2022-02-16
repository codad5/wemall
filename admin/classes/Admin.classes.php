<?php
 class Admin extends Dbh {
     public $email;
     public $admin_name;
     public function __construct($admin_id){
         $admin_details = $this->check_account($admin_id);
         switch ($admin_details) {
             case 'true':
             case 'false':
             case 'stmt Error':
                header('location:../inc/logout.inc.php');
                exit;
                 # code...
                 break;
             
             default:
             $admin_details = $admin_details[0];
             $this->email = $admin_details['email'];
             $this->admin_name = $admin_details['admin_name'];
                 # code...
                 break;
         }

     }
     public function add_product($product){
         $image0 = $product[8][0];
         $image1 = $product[8][1];
         $image2 = $product[8][2];
         $image3 = $product[8][3];
         $image4 = $product[8][4];
        $sql = "INSERT INTO products (product_id, product_name,  product_size , product_category,product_price,  discount_method, product_discount, product_quantity, product_image1, product_image2, product_image3, product_image4, product_image5,  product_perm_link,   addedby, product_gender) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, ?);";

        $stmt = $this->connect()->prepare($sql);
        $stmt_status = $stmt->execute([$product[0], $product[1], $product[2], $product[3], $product[4], $product[5], $product[6], $product[7], $image0, $image1, $image2, $image3, $image4, $product[9], $this->email, $product[10]]);

        if(!$stmt_status){
            return false;
        }
        else{
            return true;
        }

     }
 }