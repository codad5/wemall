<?php
    include_once 'header.php';
?>
 <section class="my-3" id="accordion">
      <div class="bd-heading sticky-xl-top align-self-start mt-5 mb-3 mt-xl-0 mb-xl-2">
        <h3>Products Settings</h3>
        <a class="d-flex align-items-center" href="">Products Settings</a>
      </div>

      <div>
        <div class="bd-example">
        <div class="accordion" id="accordionExample">
          <div class="accordion-item">
            <h4 class="accordion-header" id="headingOne">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
               Add New Product
              </button>
            </h4>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
              <div class="accordion-body">
                <article class="my-3" id="validation">
      <div class="bd-heading sticky-xl-top align-self-start mt-5 mb-3 mt-xl-0 mb-xl-2">
        <h3>Add New Product</h3>
        <!-- <a class="d-flex align-items-center" href="../forms/validation/">Documentation</a> -->
      </div>

      <div>
        <div class="bd-example">
        <form class="row g-3" id='add_product' action="inc/add-product.inc.php" method='post' enctype="multipart/form-data">
          <div class="col-md-4">
            <label for="validationServer01" class="form-label">Product name</label>
            <input type="text" class="form-control" name='product_name' id="validationServer01" value="Mark" required="">
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>
          <div class="col-md-4">
            <label for="validationServer02" class="form-label">Product Size</label>
            <input type="text" class="form-control" name="product_size" id="validationServer02" value="Otto" required="">
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>
          
          <div class="col-md-5">
            <label for="validationServer03" class="form-label">Category : use comma to separate</label>
            <input type="text" class="form-control" id="validationServer03" name='product_category'>
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
            <input type="Number" class="form-control" name='product_price' id="validationServer05" required="">
            <div class="invalid-feedback">
              Invalid Price
            </div>
          </div>
          <fieldset class="col-mb-3">
            <legend>Discount Methods</legend>
            <div class="col-mb-3 form-check">
              <input type="radio" name="discount_method" value="percentage" class="form-check-input" id="exampleRadio1">
              <label class="form-check-label" for="exampleRadio1">Percentage</label>
            </div>
            <div class="col-mb-3 form-check">
              <input type="radio" name="discount_method" value="price_cut" class="form-check-input" id="exampleRadio2">
              <label class="form-check-label" for="exampleRadio2">Price Cut</label>
            </div>
            <div class="col-md-3">
            <label for="validationServer05" class="form-label">Discount</label>
            <input type="text" class="form-control" id="validationServer05" name="product_discount" value='0'>
            <div class="invalid-feedback">
              Please provide a valid zip.
            </div>
            
          </fieldset>
          <div class="col-md-3">
            <label for="validationServer05" class="form-label">Quantity Added</label>
            <input type="number" class="form-control " id="validationServer05" required="" min='0' name='product_quantity'>
            <div class="invalid-feedback">
              Please provide a valid zip.
            </div>
          </div>
          <div class="col-mb-3">
              <input type="file" class="form-control" id='product_image' name='product_image[]' multiple maxlength="5" aria-label="Large file input example">
                <div class="invalid-feedback">
                Max of 5 images
                </div>
        </div>
        <fieldset class="col-mb-3" >
            <legend>Gender</legend>
            <div class="form-check">
              <input type="radio" name="gender" value="male" class="form-check-input" id="exampleRadio1" >
              <label class="form-check-label" for="exampleRadio1">Male</label>
            </div>
            <div class="mb-3 form-check">
              <input type="radio" name="gender" value="female" class="form-check-input" id="exampleRadio2">
              <label class="form-check-label" for="exampleRadio2">Female</label>
            </div>
            <div class="mb-3 form-check">
              <input type="radio" name="gender" value="unisex" class="form-check-input" id="exampleRadio2">
              <label class="form-check-label" for="exampleRadio2" selected>unisex</label>
            </div>
          </fieldset>
          <div class="col-md-4">
            <label for="validationServerUsername" class="form-label">Added By</label>
            <div class="input-group">
              <span class="input-group-text" id="inputGroupPrepend3">@</span>
              <input type="text" class="form-control" id="validationServerUsername"  value = '<?php echo $admin->email; ?>'aria-describedby="inputGroupPrepend3" required="" readonly>
              <div class="invalid-feedback">
                Please choose a username.
              </div>
            </div>
          </div>
          <!-- <div class="col-12">
            <div class="form-check">
              <input class="form-check-input is-invalid" type="checkbox" value="" id="invalidCheck3" required="">
              <label class="form-check-label" for="invalidCheck3">
                Agree to terms and conditions
              </label>
              <div class="invalid-feedback">
                You must agree before submitting.
              </div>
            </div>
          </div> -->
          <div class="col-12">
            <button class="btn btn-primary" name='product_add' type="submit">Submit form</button>
          </div>
        </form>
        </div>
      </div>
    </article>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h4 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                All Products
              </button>
            </h4>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-responsive">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Currenct Sell price</th>
                        <th>Total quantity</th>
                        <th>added by</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $product = $admin->getProduct();
                            // var_dump($product);
                            $n = 0;
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
                                            <td><button type='button' class='btn btn-primary'>EDIT</button></td>
                                            <td><button type='button' class='btn btn-danger'>DELETE</button></td>
                                        </tr>";
                                
                            }
                        ?>
                        
                    </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h4 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Edit Product
              </button>
            </h4>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
</section>
    <script>
        let file_input = document.getElementById('product_image');
        let add_product = document.querySelector('#add_product');
        let valid = true;
        add_product.addEventListener('submit', (e) => {
            e.preventDefault();
            Array.prototype.forEach.call(add_product, elem => {
                let input = elem.querySelector('input');
                if(input !== null){
                    if(input.classList.contains('is-invalid') == true){
                        valid = false;
                    }
                    else{
                        input.classList.add('is-valid');

                    }

                    
                }
                if(valid == true){
                    add_product.submit();
                }

                
            });
            
        })
        file_input.addEventListener('change', (e) => {
            console.log(e);
            console.log(file_input);
            if(file_input.files.length > 5){
                
                file_input.classList.add('is-invalid');
                e.preventDefault();
            }
        })
    </script>
    <?php
     include_once 'footer.php';
     ?>