<?php
require_once $_SERVER['DOCUMENT_ROOT']."/wemall/vendor/autoload.php";
require_once 'includes/class.autoload.php';
require_once 'includes/functions.inc.php';
// require_once 'Dbh.classes.php';

// this is to disable error report on deployment mode
$_SERVER['HTTP_HOST'] !== 'localhost' ? error_reporting(0) : error_reporting(E_ALL);


// this are all the CORS policy allowed 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: XMLHttpRequest');
header('Access-Control-Allow-Headers: ');
header('Access-Control-Allow-Headers: x-rapidapi-key, x-rapidapi-host');
header('Access-Control-Allow-Headers: content-type');
header('Content-Type: application/json');

// allowing namespace for all the payment classes
use \Api\Payment;

// use \Firebase\JWT\Key;
$_POST = json_decode(file_get_contents('php://input'), true);

$config = new Config();

if (has_value($_GET['filter'], $_GET['base']) === false) {
    # code...
    echo json_encode(['error' => true, 'message' => 'bad Url read doc @ ']);
    exit;
}

$api_array = [];
$filter = filter_var($_GET['filter'], FILTER_SANITIZE_STRING);
$keyword = @filter_var($_GET['keyword'], FILTER_SANITIZE_STRING);
switch ($_GET['base']) {
    case 'list':
        $api = new getList($filter, $keyword);
        $api->setList();
        $api_array = $api->get_data();
        $api->endrequest($api_array);

    break;
    case 'product':
        $api = new getProduct($filter, $keyword);
        $api->setList();
        $api_array = $api->get_data();
        $api->endrequest($api_array);
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
        if(!has_value($_POST['name'], $_POST['email'], $_POST['password'], $_POST['phone'])):
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
        if(!has_value(@$_POST['username'], @$_POST['password'])):
            Dbh::endrequest(array(
                'message' => "Some Param are Missing",
                'param_given' => $_POST,
                'error' => true,
                'param_needed' => ['username' => (has_value(@$_POST['username']))  ,
                                   'password' => (has_value(@$_POST['password']))
                                 ]
                                )
                            );
        
        endif;
        $api = new Login($_POST['username'], $_POST['password']);
        $api_array = $api->login();
        // $api_array['data_sent'] = $_POST;

        $api->endrequest($api_array);
    break;
    case 'order':
        // var_dump(json_encode($_POST, true));
        if($_SERVER['REQUEST_METHOD'] == 'GET'):
              Dbh::endrequest(["error" => true,
                               'message' => 'This is a invalid request type ',
                               'request_method' => $_SERVER['REQUEST_METHOD'],
                               'avaliable_request_type' => ['POST']
                                ], 500);
             
        endif;
        $_POST['login_detail'] = json_decode($_POST['login_detail']);
        
        // $data = $_POST['login_detail']['data'];
        // var_dump($_POST['login_detail']->message); 
        if(!has_value($_POST['login_detail'], $_POST['cart'], $_POST['payment_method'], $_POST['login_detail']->login_token->token, $_POST['login_detail']->data->email)):
            Dbh::endrequest(array(
                'message' => "Some Param are Missing",
                'param_given' => $_POST,
                'param_give' => $_POST['cart']['items'][1],
                'error' => true,
                'param_needed' => ['login_detail' => (has_value($_POST['login_detail']))  ,
                                  'cart' => (has_value($_POST['cart'])),
                                  'jwt' => (has_value($_POST['login_detail']->login_token->token)),
                                  'email' => (has_value($_POST['login_detail']->data->email)),
                                  'payment_method' => (has_value($_POST['payment_method'])),
                                   
                                 ]
                                )
                            );
        
        endif;
        $payment_method = $_POST['payment_method'];

        switch ($payment_method):
            case 'payStack':
                $payment_method = new Payment\PayStack($_POST['login_detail']->data->email);
            break;
            default:
                Dbh::endrequest([
                    'message' => 'invalid payment method => '.$payment_method,
                    'error' => true,
                    'paran_given' => $_POST,
                    'valid_payment_type'=> [
                                    'payStack'
                    ]
                ]);
            break;
        endswitch;
        $api_array = [];
        $newOrder = new Order($_POST['login_detail']->login_token->token, $_POST['login_detail']->data->email, 100, $payment_method);
        if($newOrder->validateAuth() !== true):
            Dbh::endrequest(array(
                'message' => "Some Bad Jwt",
                'param_given' => $_POST,
                'param_give' => $_POST['login_detail']->login_token->token,
                // 'param_gived' => $newOrder->JWT_validate($_POST['login_detail']->login_token->token, "yai@hbdv.com"),
                'error' => true,
                'param_needed' => ['login_detail' => (isset($_POST['login_detail']))  ,
                                  'cart' => (isset($_POST['cart'])),
                                   
                                 ]
                                )
                            );
        endif;

        $cart = $_POST['cart']['items'];
        foreach($cart as $item){
            $newOrderItems = $newOrder->registerProduct($item);
            if($newOrderItems !== true):
                $return_array['error'] = true;
                $return_array['message'] = 'An error occur with product '.$item['data']['product_name'];
                $return_array['target'] = $item['data']['product_id'];
                $newOrder->endrequest($return_array);
                
            endif;
            }
            $implement_order = $newOrder->implementOrder();
            if($implement_order !== true){
                $api_array['error'] = true;
                $api_array['message'] = $implement_order['message'];
                $newOrder->endrequest($api_array);
                
            }
            else{
                $api_array['error'] = false;
                $api_array['message'] = "Begin payment with paystack";
                $api_array['data']['payment_id'] = $newOrder->payment_details['data'];
                $newOrder->endrequest($api_array);

            }

        

    break;
    default:
        Dbh::endrequest([
            'message' => 'bad request',
            'error' => true,
            'time' => getdate(time()),
            'time_zone' => gmstrftime("%a %e %b %Y %X ",time()),
            'data_sent' => $_REQUEST
        ], 400);
    
    break;
}






