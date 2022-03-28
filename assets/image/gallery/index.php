<?php

if(isset($_GET['image'])){
    header('Content-Type: image/png');
    include_once $_GET['image'];
}
