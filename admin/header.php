<?php
session_start();
    if(!isset($_SESSION['admin_id'])){
        header('location:login.php');
        exit;
    }
    require_once 'classes/Dbh.classes.php';
    require_once 'classes/Admin.classes.php';
    require_once 'inc/function.inc.php';
   $g_website_name = 'wemall';
   
   $admin = new Admin($_SESSION['admin_id']);
   
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <title><?php echo $g_website_name.' '; ?></title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
    <script src="../javascripts/jquery-3.6.0.min.js"></script> 
    <script>
      const notifications_box = document.querySelector('.notifications-box');

    </script>

    

    <!-- Bootstrap core CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#"><?php echo $g_website_name; ?></a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="inc/logout.inc.php">Sign out</a>
    </li>
  </ul>
</header>
<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">
              <span data-feather="home"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="order">
              <span data-feather="file"></span>
              Orders
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="product.php">
              <span data-feather="shopping-cart"></span>
              Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="users"></span>
              Customers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="bar-chart-2"></span>
              Reports
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="layers"></span>
              Integrations
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Saved reports</span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Current month
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Last quarter
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Social engagement
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Year-end sale
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="notifications-box-cnt">
      <div class="alert alert-info alert-dismissible fade show"> HEllo <button type="button" class="btn-close noti-btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    </div>

    <script>
      
      const notificationbox = document.querySelector('.notifications-box-cnt');
      const notification_close_btn = document.querySelectorAll('.noti-btn-close');
      const notificationAdd = (message, noti_type = 'alert-info') => {
        const new_notification = document.createElement("div");
        const notification_close_btn = document.createElement("button");
        new_notification.className = `alert alert-dismissible fade show ${noti_type}`;
        notification_close_btn.className = `btn-close noti-btn-close`;
        notification_close_btn.dataset.bsDismiss = `alert`;
        let node = document.createTextNode(message);
        new_notification.appendChild(node);
        
        new_notification.appendChild(node);
        new_notification.appendChild(notification_close_btn);

        
        notificationbox.appendChild(new_notification);
      }
      Array.prototype.forEach.call(notification_close_btn, elem => {
        setTimeout(() => {
          elem.click();
          console.log('hello');
        }, 2000)
      });
    </script>
    
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">