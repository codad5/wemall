<?php
   
   
    if(!isset($_SESSION['admin_id'])){
        session_start();
        if(!isset($_SESSION['admin_id'])){
        header('HTTP/1.1 404 Not Found', true, 403);
        exit;
        }
    }
    if(isset($_POST['product_id'])){
         require_once '../classes/Dbh.classes.php';
        require_once '../classes/Admin.classes.php';
        require_once 'function.inc.php';
        $admin = new Admin($_SESSION['admin_id']);
        
        

          if(isset($_POST['action']) && $_POST['action'] == 'edit_now'){
      // edit_name : name,
      //         edit_size : size,
      //         edit_category : category,
      //         edit_price : price,
      //         edit_discount_method : discount_method,
      //         edit_discount : discount,
      //         edit_quantity : quantity,
      //         edit_gender : gender,
      //         product_id : product_id,
      //         action : 'edit'
      $needArray = array('edit_name', 'edit_size', 'edit_discount', 'edit_quantity', 'edit_gender', 'edit_category', 'edit_discount_method' , 'edit_price');
      

      if(areAvailable($_POST, $needArray) === true){
        // echo $_POST['action'];

      

      

        $edit_name = filter_var($_POST['edit_name'], FILTER_SANITIZE_STRING);
        $edit_size = filter_var($_POST['edit_size'], FILTER_SANITIZE_STRING);
        $edit_category = filter_var($_POST['edit_category'], FILTER_SANITIZE_STRING);
        $edit_price = filter_var($_POST['edit_price'], FILTER_VALIDATE_INT);
        $edit_discount_method = filter_var($_POST['edit_discount_method'], FILTER_SANITIZE_STRING);
        $edit_discount = filter_var($_POST['edit_discount'], FILTER_VALIDATE_INT);
        $edit_quantity = filter_var($_POST['edit_quantity'], FILTER_VALIDATE_INT);
        $edit_gender = filter_var($_POST['edit_gender'], FILTER_SANITIZE_STRING);
        $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_STRING);



      $validate_input = validate_input(['edit_name' => $edit_name,
                                     'edit_size' => $edit_size,
                                     'edit_category' => $edit_category,
                                     'edit_price' => $edit_price,
                                     'edit_discount_method' => $edit_discount_method, 
                                     'edit_gender' => $edit_gender,
                                     'edit_discount' => $edit_discount,
                                     'edit_quantity' => $edit_quantity]);

        if($validate_input['validate'] != false){
        
           
            $sell_price_data = gen_sell_price($edit_price, $edit_discount, $edit_discount_method);
            $sell_price = $sell_price_data['validate'];
            if($sell_price != false){

                $edit_result = $admin->editProduct($validate_input, $product_id);
                if($edit_result === true){
                     echo "<script>
                  notificationAdd(`Successfully Edited`, 'alert-success'); </script>";
                }
                else{
                  echo "<script>
                  notificationAdd(` Edit Fails`, 'alert-danger'); </script>";
                }
                
            }
            else{
                echo "<script>
                  notificationAdd(`Invalid Discount Validate Error check ".$sell_price_data['error_msg']."`); </script>";
            }

        }
        else{
           echo "<script>
              notificationAdd(`Input Validate Error check ".$validate_input['error_msg']."`); </script>";

        }


          }
    }
    

    


        
        
    $product = $admin->get_product($_POST['product_id']);
        
        try{
            if($product == false){
                throw new Exception('Product dont Exist');
            }
            $product = $product[0];
    
?> 
<div>
        <div class="bd-example">
        <form class="row g-3" id='edit_product_form' action="inc/edit-product.inc.php" method='post' enctype="multipart/form-data">
          <div class="col-md-4">
            <label for="validationServer01" class="form-label">Product name</label>
            <input type="text" class="form-control" name='product_name' id="edit_name" value="<?php echo $product['product_name']; ?>" required="">
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>
          <div class="col-md-4">
            <label for="validationServer02" class="form-label">Product Size</label>
            <input type="text" class="form-control" name="product_size" id="edit_size" value="<?php echo $product['product_size']; ?>" required="">
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>
          
          <div class="col-md-5">
            <label for="validationServer03" class="form-label">Category : use comma to separate</label>
            <input type="text" class="form-control" id="edit_category" value="<?php echo $product['product_category']; ?>" name='product_category'>
            <div class="invalid-feedback">
              Please provide a valid city.
            </div>
          </div>
          <!-- <div class="col-md-3">
            <label for="validationServer04" class="form-label">State</label>
            <select class="form-select is-invalid" id="validationServer04" required="">
              <option selected="" disabled="" value="">Choose...</option>
              <option>...</option>
            </select>
            <div class="invalid-feedback">
              Please select a valid state.
            </div>
          </div> -->
          <div class="col-md-4">
            <label for="validationServer05" class="form-label">Price</label>
            <input type="Number" class="form-control" name='product_price' id="edit_price" required="" value="<?php echo $product['product_price']; ?>">
            <div class="invalid-feedback">
              Invalid Price
            </div>
          </div>
          <div class="col-md-3">
            <label for="edit_discount_method" class="form-label">Discount Methods</label>
              <select name="" class="form-select is-invalid" id="edit_discount_method" >
                  <?php
            $discount_methods = ['price_cut', "percentage"];
            foreach($discount_methods as $method){
                if ($product['discount_method'] == $method){
                    echo "<option value='$method' selected>$method</option>";
                }
                else{
                    echo "<option value='$method' >$method</option>";
                }
            }
            
            ?>

            </select>
        </div>
          <div class="col-md-3">
            <label for="edit_discount" class="form-label">Discount Amount</label>
            <input type="number" class="form-control " id="edit_discount" value="<?php echo $product['product_discount']; ?>" required="" min='0' name='product_quantity'>
            <div class="invalid-feedback">
              Please provide a valid input.
            </div>
          </div>
          <div class="col-md-3">
            <label for="edit_quantity" class="form-label">Quantity Left</label>
            <input type="number" class="form-control " value="<?php echo $product['product_quantity'] - $product['total_delivery']; ?>" id="edit_quantity" required="" min='0' name='product_quantity'>
            <div class="invalid-feedback">
              Please provide a valid input.
            </div>
          </div>
          <div class="col-md-3">
            <label for="edit_gender" class="form-label">Gender</label>
            <select name="" class="form-select is-valid" id="edit_gender">
                <?php
                $genders = ['male', "female", 'unisex'];
                foreach($genders as $gender){
                    if ($product['product_gender'] == $gender){
                        echo "<option value='$gender' selected>$gender</option>";
                    }
                    else{
                        echo "<option value='$gender' >$gender</option>";
                    }
                }

                ?>

             </select>
        </div>
          <div class="col-md-4">
            <label for="" class="form-label">Edited By</label>
            <div class="input-group">
              <span class="input-group-text" id="inputGroupPrepend3">@</span>
              <input type="text" class="form-control" id="edited_by"  value = '<?php echo $admin->email; ?>'aria-describedby="inputGroupPrepend3" required="" readonly>
              <div class="invalid-feedback">
                Please choose a username.
              </div>
            </div>
          </div>
          
          <div class="col-12">
            <button class="btn btn-primary" name='product_add' type="submit">Submit form</button>
          </div>
        </form>
        </div>
      </div>
      <script>
        $(document).ready(() => {
          $('#edit_product_form').submit((event)=>{
            event.preventDefault();
            let name = $('#edit_name').val(),
            size = $('#edit_size').val(),
            category = $('#edit_category').val(),
            price = $('#edit_price').val(),
            discount_method = $('#edit_discount_method').val(),
            discount = $('#edit_discount').val(),
            quantity = $('#edit_quantity').val(),
            gender = $('#edit_gender').val(),
            product_id = `<?php echo $product['product_id'] ?>`,
            json = {
              edit_name : name,
              edit_size : size,
              edit_category : category,
              edit_price : price,
              edit_discount_method : discount_method,
              edit_discount : discount,
              edit_quantity : quantity,
              edit_gender : gender,
              product_id : product_id,
              action : 'edit_now'
            }

            console.log(json);



            $('#edit_product_cnt').load('inc/edit-product.inc.php', json)
          })
        })
      </script>
      <?php
        }
      catch(Exception $e) {
          echo "<script>
              notificationAdd('".$e->getMessage()." ');
              document.querySelector('#product_edit').click();
              
              setTimeout(() => {
                  document.querySelector('#product_table').click();
                  
                }, 1000)
                </script>";

      }
        
      
      }
      else{
          if(isset($_POST['action'])){

              echo "<script>
              notificationAdd('Select a product to Edit ');
              document.querySelector('#product_edit').click();
              
              setTimeout(() => {
                  document.querySelector('#product_table').click();
                  
                }, 1000)
                </script>";
            }
            else{
                echo "Select a product above to be edited";
            }
      }
      
      ?>