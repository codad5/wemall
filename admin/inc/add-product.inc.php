<?php
    session_start();
    if(!isset($_SESSION['admin_id'])){
        header('location:../index.php');
        
    }
    require_once '../classes/Dbh.classes.php';
    require_once '../classes/Admin.classes.php';
    require_once 'function.inc.php';
    $admin = new Admin($_SESSION['admin_id']);
    if(empty($_POST['product_name'])){
      header('Location:../product.php?error=emptyField&target=name');
      exit;
    }
    if(empty($_POST['product_size'])){
      header('Location:../product.php?error=emptyField&target=size');
      exit;
    }
    if(empty($_POST['product_price'])){
      header('Location:../product.php?error=emptyField&target=price');
      exit;
    }
    if(empty($_POST['product_quantity'])){
      header('Location:../product.php?error=emptyField&target=quantity');
      exit;
    }
    if(!isset($_POST['gender'])){
      header('Location:../product.php?error=nogender&target=quantity');
      exit;
    }
    if(!isset($_POST['discount_method'])){
      header('Location:../product.php?error=discountmethodmissing&target=quantity');
      exit;
    }
    $product_name = filter_var($_POST['product_name'], FILTER_SANITIZE_STRING);
    $product_size = filter_var($_POST['product_size'], FILTER_SANITIZE_STRING);
    $product_category = filter_var($_POST['product_category'], FILTER_SANITIZE_STRING);
    $product_price = filter_var($_POST['product_price'], FILTER_VALIDATE_INT) ?? 0;
    $discount_method = filter_var($_POST['discount_method'], FILTER_SANITIZE_STRING);
    $product_discount = filter_var($_POST['product_discount'], FILTER_VALIDATE_INT) ?? 0;
    $product_quantity = filter_var($_POST['product_quantity'], FILTER_VALIDATE_INT) ?? 0;
    $product_gender = filter_var($_POST['gender'], FILTER_SANITIZE_STRING) ?? 'u';
    $product_image = $_FILES['product_image'];
    $perm_link = '';
    $unqiue_id = uniqid('', true);
    $image_db_name = [];
    $validate_input = validate_input(['product_name' => $product_name,
                                     'product_size' => $product_size,
                                     'product_category' => $product_category,
                                     'product_price' => $product_price,
                                     'discount_method' => $discount_method, 
                                     'product_discount' => $product_discount,
                                     'product_quantity' => $product_quantity]);

    
    var_dump($product_image);
    if($validate_input['validate'] == false){
        
        header('Location:../product.php?error=invalidInput&validate_array='.$validate_input);

    }
    // to generate perm_link
    $perm_link = gen_perm_link($product_name, $unqiue_id);
    echo '<br/>'.$perm_link;

    // to generate sell price from discout method

    $sell_price_data = gen_sell_price($product_price, $product_discount, $discount_method);
    $sell_price = $sell_price_data['validate'];
    if($sell_price === false){
        header('Location:../product.php?error=invalidDiscount&errormsg='.$sell_price_data['error_msg']);
    }
    echo "<br/>".$sell_price;
    

    $files = arrange_product_image($product_image);
    $file_names = upload_files($files);
    var_dump($file_names);
    $product_details = [$unqiue_id, $product_name, $product_size, $product_category, $product_price, $discount_method, $product_discount, $product_quantity, $file_names, $perm_link, $product_gender];

    $added_product = $admin->add_product($product_details);
    if($added_product == true){
        echo '<b>Done</b>';
        header('location:../product.php?error=none');
    }