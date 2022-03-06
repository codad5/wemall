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
              <button class="accordion-button collapsed" type="button" id="accordion_add_product_btn" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
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
          <div class="col-md-4" id="product_name_cnt">
            <label for="product_name" class="form-label">Product name</label>
            <input type="text" class="form-control  " name='product_name' id="product_name"  >
            <div class="invalid-feedback">
              This field is required
            </div>
          </div>
          <div class="col-md-4" id="product_size_cnt">
            <label for="product_size" class="form-label">Product Size</label>
            <input type="text" class="form-control" name="product_size" id="product_size"  >
            <div class="invalid-feedback">
              This field is required
            </div>
          </div>
          
          <div class="col-md-5" id="product_category_cnt">
            <label for="product_category" class="form-label">Category : use comma to separate</label>
            <input type="text" class="form-control" id="product_category" name='product_category'>
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
          <div class="col-md-4" id="product_price_cnt">
            <label for="product_price" class="form-label">Price</label>
            <input type="Number" class="form-control" name='product_price' id="product_price" required="">
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
            <div class="col-md-3" id="product_discount_cnt">
            <label for="product_discount" class="form-label">Discount</label>
            <input type="text" class="form-control" id="product_discount" name="product_discount" value='0'>
            <div class="invalid-feedback">
              Please provide a valid zip.
            </div>
            
          </fieldset>
          <div class="col-md-3" id="product_quantity_cnt">
            <label for="product_quantity" class="form-label">Quantity Added</label>
            <input type="number" class="form-control " id="product_quantity" required="" min='0' name='product_quantity'>
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
              <button class="accordion-button collapsed" id='product_table' type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
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
                    <tbody class="product_table_body">
                        <?php
                          include_once 'inc/productTable.inc.php';
                        ?>
                        
                        
                    </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h4 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" id='product_edit' type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Edit Product
              </button>
            </h4>
            <div id="collapseThree" class="accordion-collapse collapse"  aria-labelledby="headingThree" data-bs-parent="#accordionExample">
              <div class="accordion-body" id="edit_product_cnt">
                <?php
                          include_once 'inc/edit-product.inc.php';
                        ?>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
</section>
<script>
                          const product_elements_edit = document.querySelectorAll('.alter_product_btn');
                          const product_elements_edit_btn = document.querySelectorAll('.edit_product_btn');
                          let product_id= null, action = null;
                          Array.prototype.forEach.call(product_elements_edit, elem => {
                            elem.addEventListener('click', (e) => {
                              console.log(elem.dataset);
                              product_id = elem.dataset.productId;
                              action = elem.dataset.productAction;
                            });
                          })
                          

                          $(document).ready(function() {
                          var searchcount = 10;
                          $(".delete_product_btn").click(function(event) {
                            // product_id = $(".edit_product_btn");
                              console.log(product_id);
                              
                              if(product_id !== null && action != null && confirm("Are you sure you want to proceed ?")){

                                $(".product_table_body").load("inc/productTable.inc.php", {
                                  product_id:product_id,
                                  action: action
                                });
                                
                              }
                              else{
                               
                              }
                          });
                         
                          $(".edit_product_btn").click(function(event) {
                            document.querySelector('#product_table').click();
                              
                              setTimeout(() => {
                                document.querySelector('#product_edit').click();

                              }, 500)
                            // product_id = $(".edit_product_btn");
                              
                              
                              if(product_id !== null && action != null){
                                
                                $("#edit_product_cnt").load("inc/edit-product.inc.php", {
                                  product_id:product_id,
                                  action: action
                                });
                                
                              }
                              else{
                                
                              }
                          });
                      });
                        </script>
    <script>
        let file_input = document.getElementById('product_image');
        let add_product = document.querySelector('#add_product');
        let edit_product_btn = document.querySelector('.edit_product_btn');
        let valid = true;

        // edit_product_btn.addEventListener('click', () => {
        //   console.log('edit_product_btn');
        //   document.querySelector('#product_table').click();
        //   document.querySelector('#product_edit').click();

        // })
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