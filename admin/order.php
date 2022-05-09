<?php
    include_once 'header.php';

    // var_dump($admin);
?>
    <table class="table table-striped table-hover table-responsive">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>UserName</th>
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
                          include_once 'inc/orderTable.inc.php';
                        ?>
                        
                        
                    </tbody>
                    </table>
<?php
    include_once 'footer.php';
    
?>