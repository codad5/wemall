<?php
$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
$txt = "===================================";
fwrite($myfile, $txt);
$txt = json_encode($_SERVER);
$txt.="\n\n".rand();
fwrite($myfile, $txt);
fclose($myfile);
if(isset($_GET['image']) && isset($tel) && @$_SERVER['HTTP_REFERER'] === 'http://localhost:3000/'){
    header('Content-Type: image/png');
    include_once $_GET['image'];
    exit;
}

var_dump($_SERVER);