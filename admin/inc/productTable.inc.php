<?php
$notification = "";
if(!isset($_SESSION['admin_id'])){
    session_start();
    if(!isset($_SESSION['admin_id'])){
        header('location:../');
    }
}
if(!isset($admin)){

    require_once '../classes/Dbh.classes.php';
    require_once '../classes/Admin.classes.php';
    require_once 'function.inc.php';
    $admin = new Admin($_SESSION['admin_id']);
}

if(isset($_POST['product_id']) && isset($_POST['action'])) {

    $action = $_POST['action'];
    $product_id = $_POST['product_id'];
    

    switch($action) {
        case 'delete':
            if($admin->delete_product($product_id)) {
                $notification =  "<script>
                        notificationAdd('Success fully Deleted ', 'alert-success');
                     </script>";
                
            }
            # code...
            break;
    }



}


?>


<?php
    $product = $admin->getProduct();
    // var_dump($product);
    $n = 0;
    if($product != false){
    foreach ($product as $item) {
        $n++;

            $sell_price_data = gen_sell_price($item['product_price'], $item['product_discount'], $item['discount_method']);
            $sell_price = $sell_price_data['validate'];

            echo "<tr>
                    <td>".$n."</td>
                    <td>".$item['product_name']."</td>
                    <td>".$item['product_price']."</td>
                    <td>".$sell_price."</td>
                    <td>".$item['product_quantity']."</td>
                    <td>".$item['addedby']."</td>
                    <td><button type='button' class='alter_product_btn edit_product_btn btn btn-primary'data-product-action='edit' data-product-id='".$item['product_id']."'>EDIT</button></td>
                    <td><button type='button' class='alter_product_btn delete_product_btn btn btn-danger' data-product-action='delete' data-product-id='".$item['product_id']."'>DELETE</button></td>
                </tr>";

                
            }
            echo $notification;
}
?>