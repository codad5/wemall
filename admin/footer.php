
 </main>
  </div>
</div>
<?php
      try{
        if(isset($_GET['error'])){
          throw new Exception($_GET['error']);
          
        }
        
      }
      catch(Exception $e){
        $msg = explode("-",$e->getMessage());
        $messages = "";
        foreach($msg as $word){
          $messages .= $word." ";
        }
        if(isset($_GET['target'])){
          echo "<script>
              let targeted_input_div = document.getElementById('" . $_GET['target'] ."_cnt');
              let targeted_input = document.getElementById('" . $_GET['target'] ."');
                    targeted_input_div.querySelector('.invalid-feedback').innerHTML = '".$messages."';
                    targeted_input_div.querySelector(`input`).classList.add('is-invalid');
                    setTimeout(() => {

                      document.querySelector('#accordion_add_product_btn').click();
                    },500);
                </script>";
          $messages .= "target => ".$_GET['target'];
        }
        if(isset($_GET['errormsg'])){
          $messages .= "(Message => ".$_GET['errormsg'].")";
        }
        if($e->getMessage() =="none" || $e->getMessage() == "success"){
          ?>
          <script>
            notificationAdd('Success', 'alert-success');

          </script>

          <?php
        }
        else{
          ?>
          <script>
            notificationAdd('<?php echo $messages; ?>', 'alert-warning');

          </script>


          <?php
        }
      }

    ?>

    <script src="../javascripts/bootstrap.bundle.min.js"></script> 
    <script src="../javascripts/jquery-3.6.0.min.js"></script> 

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="javascripts/dashboard.js"></script>
  </body>
</html>
<?php
 require_once 'header.php';
 ?>