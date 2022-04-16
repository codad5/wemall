<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: XMLHttpRequest');
header('Access-Control-Allow-Headers: ');
header('Access-Control-Allow-Headers: x-rapidapi-key, x-rapidapi-host');
header('Access-Control-Allow-Headers: content-type');
header('Content-Type: application/json');
    require_once $_SERVER['DOCUMENT_ROOT']."/wemall/vendor/autoload.php";
    require_once 'class.autoload.php';
    use \Firebase\JWT\JWT;
    require_once 'Dbh.classes.php';

if (!isset($_GET['filter']) || !isset($_GET['base'])) {
    # code...
    echo json_encode(['error' => true, 'message' => 'bad Url read doc @ ']);
    exit;
}


$filter = filter_var($_GET['filter'], FILTER_SANITIZE_STRING);
$keyword = @filter_var($_GET['keyword'], FILTER_SANITIZE_STRING);
switch ($_GET['base']) {
    case 'list':
        # code...
        
        $api = new getList($filter, $keyword);
        break;
    case 'product':
        # code...
        
        $api = new Dbh();
        $api = new getProduct($filter, $keyword);
        break;
    case 'rate':
        $api = new Rate($filter, $keyword);

    break;
    case 'signup':
        $_POST = json_decode(file_get_contents('php://input'), true);
        if($_SERVER['REQUEST_METHOD'] == 'GET'):
              Dbh::endrequest(["error" => true,
                               'message' => 'This is a invalid request type ',
                               'request_method' => $_SERVER['REQUEST_METHOD'],
                               'avaliable_request_type' => ['POST']
                                ], 500);
             
        endif;
        if(!isset($_POST['name']) ||  !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['phone'])):
            Dbh::endrequest(array(
                'message' => "Some Param are Missing",
                'param_given' => $_POST,
                'error' => true,
                'param_needed' => ['name' => (isset($_POST['name']))  ,
                                  'email' => (isset($_POST['email'])),
                                  'password' => (isset($_POST['password'])) , 
                                  'phone' => (isset($_POST['phone']))  
                                 ]
                                )
                            );
        
        endif;
        $api = new Signup($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['password']);

        
    break;
    default:
    var_dump($_GET);
        # code...
        break;
}




