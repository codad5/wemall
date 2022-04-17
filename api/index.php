<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: XMLHttpRequest');
header('Access-Control-Allow-Headers: ');
header('Access-Control-Allow-Headers: x-rapidapi-key, x-rapidapi-host');
header('Access-Control-Allow-Headers: content-type');
header('Content-Type: application/json');
$_POST = json_decode(file_get_contents('php://input'), true);
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
        $api_array = [];
        $api_array['param_given'] = $_POST;
        $api_array['param_given']['password']  = '*********';
        $api = new Signup($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['password']);
        $duplicate_email = $api->get_users($api, $api->email, "email");
            $duplicate_phone = $api->get_users($api, $api->phone, "phone");
            if($duplicate_phone['error'] !== true || $duplicate_email['error'] !== true){
                $api_array['error'] = true;
                $await_message = [];
                if(!$duplicate_phone['error']):
                    $await_message[] = $api->phone." already taken";
                endif;
                if (!$duplicate_email['error']) :
                    $await_message[] = $api->email." already taken";
                endif;
                $api_array['message'] = implode(" <br/> ", $await_message)."";
                // $api_array[] = $duplicate_phone;
                // $api_array[] = $duplicate_email;
                $api->endrequest($api_array);
            }
        $signup = $api->signUp();
        if($signup === false){
            $api_array['error'] = true;
            $api_array['message'] = "signup failed";
            // $api_array['status'] = $duplicate_email;
            


        }
        else{
            $api_array['error'] = false;
            $api_array['message'] = "signup Success";
            // $api_array['status'] = $duplicate_email;
            
        }
        $api->endrequest($api_array);

        
    break;
    case 'login':
        if($_SERVER['REQUEST_METHOD'] == 'GET'):
              Dbh::endrequest(["error" => true,
                               'message' => 'This is a invalid request type ',
                               'request_method' => $_SERVER['REQUEST_METHOD'],
                               'avaliable_request_type' => ['POST']
                                ], 500);
             
        endif;
        if(!isset($_POST['username']) ||   !isset($_POST['password'])):
            Dbh::endrequest(array(
                'message' => "Some Param are Missing",
                'param_given' => $_POST,
                'error' => true,
                'param_needed' => ['username' => (isset($_POST['username']))  ,
                                   'password' => (isset($_POST['password']))
                                 ]
                                )
                            );
        
        endif;
        $api = new Login($_POST['username'], $_POST['password']);
        $api_array = $api->login();
        // $api_array['data_sent'] = $_POST;

        $api->endrequest($api_array);
    break;
    default:
    var_dump($_GET);
        # code...
        break;
}




