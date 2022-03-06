<?php
    function validate_input(Array $inputs) {
        $return_array = ['validate' => true];
        $return_array['error_msg'] = null;
        $i = 0;
        foreach ($inputs as $input => $value) {
            $i++;
            if ($value == false) {
                $return_array['validate'] = false;
                $return_array['error_msg'] = $inputs[$i];
                $return_array[$input] = $value;
                
                # code...
            }
            else{
                // $return_array['validate'] = true;
                $return_array[$input] = $value;



            }

        }
        return $return_array;
    }

    function gen_perm_link($product_name, $unquie_id){
        $perm_array = explode(' ', $product_name, 11);
        $temp_perm_link = $unquie_id.'/';
        foreach($perm_array as $word){
            $temp_perm_link .= ''.$word.'-';

        }
        return $temp_perm_link;
    }

    function gen_sell_price($product_price, $product_discount, $discount_method){
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

    function arrange_product_image($image){
        
        if(count($image['name']) <= 0 || empty($image['name'][0])){
            // echo 'meme<br>';
            header("location:../product.php?error=no-image");
            exit;
        }
        $img = [];
        for ($i=0; $i < count($image); $i++) { 
            $img[$i] = ['name' => $image['name'][$i] ?? '', 'type' => $image['type'][$i] ?? '', 'tmp_name' =>  $image['tmp_name'][$i] ?? '', 'error' => $image['error'][$i] ?? 0, 'size' => $image['size'][$i]  ?? 0];
            # code...
        }
        
        return $img;
    }

    function prepare_file($file){
        $fileName =  $file['name'];
        $fileTmpName =  $file['tmp_name'];
        $fileSize =  $file['size'];
        $fileError =  $file['error'];
        $fileType =  $file['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        $fileNameNew = "";
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 10000000) {
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = "../../assets/image/gallery/".$fileNameNew;
                
                return [true, 'file_tmp_name' => $fileTmpName, 'file_destination' => $fileDestination, 'file_name' => $fileNameNew];
                


                }
                else {
                header("location:../admin/?error=filetobig&file=".$fileName);
                }
            }

            else {
            header("location:../admin/?fileerror&file=".$fileName);
            }
        }
        else {
            if(empty($fileName)){
                return [false, 'file_tmp_name' => $fileTmpName, 'file_destination' => '', 'file_name' => $fileNameNew];

            }
            else{
                
                header("location:../admin/?fileerror=wrongfiletype&file=".$fileName);
            }
        }
    }

    function upload_files($files){
        
        // $i = 0;
        $a = -1;
        $file_names_array = [];
        
        for ($i=0; $i < 5; $i++) { 
            # code...
        
        
            $file_prepare = prepare_file($files[$i]);
            if ($file_prepare[0] == true) {
                move_uploaded_file($file_prepare['file_tmp_name'], $file_prepare['file_destination']);
                $file_names_array[$i] = $file_prepare['file_name'];
                
                $a++;

                # code...
            }
            else{
                $file_names_array[$i] = $file_names_array[$a];
                
                $a++;

            }


        }
        return $file_names_array;
    }

    function areAvailable($globalVariableName, $needArray) {
        
        
        if(isset($globalVariableName)){

            
            foreach ($needArray as $item) {
                if(!isset($globalVariableName[$item])){
                    return false;
                }
            }
            return true;
        }
        return false;
    }