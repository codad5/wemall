<?php
   if(!isset($_POST['submit'])){
       header('HTTP/1.1 503 Service Unavailable', true, 500);
    }
    require_once '../classes/Dbh.classes.php';

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    if ($email == false) {
        header('location:../login.php?error=wrongemail');
        exit;
        # code...
    }
    if(empty($email)) {
        header('location:../login.php?error=emptyinput&target=mail');
        exit;
    }
    if(empty($password)) {
        header('location:../login.php?error=emptyinput&target=password');
        exit;
    }
   
   $login_connect = new Dbh();
   
   $logged_in = $login_connect->check_account($email);
   if($logged_in === true){
       header('location:../login.php?error=wrongLogin');
   
   }
   else if ($logged_in == 'stmt Error'){
       header('location:../login.php?error=stmtfailed');

   }
   else{
       $logged_in = $logged_in[0];
       $hashedPassword = $logged_in['passwords'];
       if(password_verify($password, $hashedPassword) !== true){
           header('location:../login.php?error=wrongpassword');
           exit;

       }
       else{
           
           
           session_start();
           $_SESSION['admin_id'] = $logged_in['email'];
           header('location:../index.php');
           exit;
           # code...
        }

   }