<?php
    spl_autoload_register("myAutoLoader");
    function myAutoLoader($classname){
        // $passClass = ['Api\Payment\PayStack'];
        // if(in_array($classname, $passClass)):
        //     return true;
        // endif;
        $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        if(strpos($url, 'inc') !== false){
            $path = "../classes/";
        }
        elseif(strpos($url, 'api') !== false){
            $path = "../classes/";

        }
        else{
            $path = "classes/";

        }
        $extension = ".classes.php";
        if (str_contains($classname, 'Api\Payment')) { 
            // echo 'true';
            require_once "Payment".$extension;
        }
        else{
            require_once $classname.$extension;
            
        }
    }