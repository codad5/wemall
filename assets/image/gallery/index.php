<?php
$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
$txt = "===================================";
fwrite($myfile, $txt);
$txt = json_encode($_SERVER);
$txt.="\n\n".rand();
fwrite($myfile, $txt);
fclose($myfile);
// include_once 'ipic.php';
if(isset($_GET['image']) && isset($tel)){
    header('Content-Type: image/jpeg');
    include_once $_GET['image'];
    exit;
}

var_dump($_SERVER);