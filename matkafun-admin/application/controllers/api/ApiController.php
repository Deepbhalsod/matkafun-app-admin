<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('apache_request_headers')) {
    function apache_request_headers()
    {
        if (function_exists('getallheaders')) {
            return getallheaders();
        }

        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) === 'HTTP_') {
                $headerName = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
                $headers[$headerName] = $value;
            }
        }
        return $headers;
    }
}

class ApiController extends CI_Controller
{
    public function __construct()

    {

        parent::__construct();
        $this->load->helper(["url", "valid"]);
        $this->load->library(['session']);

        $this->load->model([
            'BidModel', 'AccountModel', 'UsersModel', 'UserTransModel', 'TransactionTypeModel', 'FundTransactionModel', 'WithdrawReqModel', 'UserWallet', 'TransferPointModel', 'WinModel', 'PagesModel', 'GamesModel', 'GameMarketDayWise', 'ResultsModel', 'GameRateModel', 'SettingsModel', 'StarlineGameRateModel', 'StarlineBidModel', 'StarlineGamesModel', 'StarlineResultsModel', 'StarlineWinPredictionModel', 'SlidersModel', 'GalidisawarBidModel', 'GalidisawarGameModel', 'GalidisawarGameRateModel', 'GalidisawarResultModel'
        ]);
    }

    public function init()
    {
        $_REQUEST = $this->request();
        $method_name = $_REQUEST['method_name'];
        log_message('debug', '---------------- API START ---------------');
        log_message('debug', $method_name);
        $this->$method_name();
    }



    public function sendNotification($token, $fields)
    {


        $FCM_SERVER_KEY = 'AAAA7x1l58s:APA91bGq2yBW84mjvpNylV4LWkGCYd6ZdLwMxT2ofgTOgIXKp_uverW6TlkE2vP2V-phG7G7hSwAzptEUCGqdM27hyyTyftOTSwStyjrahm6iyjLOpragEyVxgf1NY0xF7I-GehAiE5N';

        // $msg = array(
        //                  'message'   => 'You have new request',
        //                  'title'     => 'You have new request',
        //                  'subtitle'  => 'This is subtitle',
        //                  'body'      => ucfirst($con['username']) . " has booked a new ride, Don't keep them waiting.",
        //                  'ride_id'   => $ride,
        //                 // 'vibrate'   => 1,
        //                 // 'sound'     => 1,
        //                 // 'largeIcon' => 'large_icon',
        //);


        // $fields = [
        //   'to'            => $token,
        //    'notification'   => $msg

        //        ];

        $array = json_encode($fields);
        //      _ddd($array);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Authorization:key=' . $FCM_SERVER_KEY
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $array);

        $result = curl_exec($ch);

        if ($result === FALSE) {
            return false;
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }


    public function shootMsg($otp, $mobile)
{
    $dv_key = "qEK8UmQluw"; // Your new API key

    $arrContextOptions = array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
        ),
    );

    $otp_url = "https://dvhosting.in/api-sms-v3.php?api_key=$dv_key&number=$mobile&otp=$otp";

    $response = file_get_contents($otp_url, false, stream_context_create($arrContextOptions));

    // Optional: log or handle $response if needed
    // e.g., return $response or log it for debugging
}


    public function decodeBase64Image($img, $path)
    {

        $destinationPath = FCPATH . 'uploads/' . $path;
        $image_type = 'png';
        $image_base64 = base64_decode($img);
        $fileName = uniqid() . '.' . $image_type;
        $file = $destinationPath . $fileName;

        file_put_contents($file, $image_base64);

        return $fileName;
    }

    public function response($data, $message = false, $code = false)
    {
        $fff = new stdClass();

        $fff->message = $message;
        $fff->code = $code;
        $fff->status = "success";

        if ($code >= 400) {
            $fff->status = "error";
        }

        $fff->data  = $data;
        log_message('debug', json_encode($fff));
        log_message('debug', '--------------- API ENDED --------------');

        echo json_encode($fff);
    }

    public function withoutdata_res($message = false, $code = false)
    {
        $fff = new stdClass();
        $fff = new stdClass();
        //$fff-&gt;response-&gt;message = false;
        $fff->message = $message;
        $fff->code = $code;
        if ($code >= 400) {
            $fff->status = "error";
        } else {
            $fff->status = "success";
        }

        log_message('debug', json_encode($fff));
        log_message('debug', '--------------- API ENDED --------------');

        echo json_encode($fff);
    }

    public function list_response($data, $message = false, $code = false)
    {
        $fff = new stdClass();
        $fff = new stdClass();
        //$fff-&gt;response-&gt;message = false;
        $fff->message = $message;
        $fff->code = $code;
        $fff->status = "success";
        $fff->data  = $data;
        log_message('debug', json_encode($fff));
        log_message('debug', '--------------- API ENDED --------------');

        echo json_encode($fff);
    }

    public function acc_response($data, $message = false, $code = false, $status = false)
    {
        $fff = new stdClass();
        $fff = new stdClass();
        //$fff-&gt;response-&gt;message = false;
        $fff->message = $message;
        $fff->code = $code;
        $fff->status = $status;
        $fff->data  = $data;
        log_message('debug', json_encode($fff));
        log_message('debug', '--------------- API ENDED --------------');

        echo json_encode($fff);
    }

    public function getOTP()
    {
        $otp = rand(1111, 9999);
        return 1234;
    }

    public function getRequestToken()
    {
        $getHeaders = apache_request_headers();
        foreach (['token', 'Token', 'TOKEN'] as $key) {
            if (isset($getHeaders[$key]) && !empty($getHeaders[$key])) {
                return $getHeaders[$key];
            }
        }

        if (!empty($_SERVER['HTTP_TOKEN'])) {
            return $_SERVER['HTTP_TOKEN'];
        }

        if (!empty($_SERVER['REDIRECT_HTTP_TOKEN'])) {
            return $_SERVER['REDIRECT_HTTP_TOKEN'];
        }

        if (!empty($_SERVER['HTTP_X_TOKEN'])) {
            return $_SERVER['HTTP_X_TOKEN'];
        }

        if (!empty($_SERVER['REDIRECT_HTTP_X_TOKEN'])) {
            return $_SERVER['REDIRECT_HTTP_X_TOKEN'];
        }

        if (!empty($_REQUEST['token'])) {
            return $_REQUEST['token'];
        }

        if (!empty($_POST['token'])) {
            return $_POST['token'];
        }

        if (!empty($_GET['token'])) {
            return $_GET['token'];
        }

        log_message('debug', 'No token found in headers or request; headers=' . json_encode($getHeaders) . ', server=' . json_encode(array_intersect_key($_SERVER, array_flip(['HTTP_TOKEN', 'REDIRECT_HTTP_TOKEN', 'HTTP_X_TOKEN', 'REDIRECT_HTTP_X_TOKEN']))));
        return null;
    }


    public function request()
    {
        $json = file_get_contents('php://input', true);

        //print_r($json); die;

        log_message('debug', json_encode($json, JSON_PRETTY_PRINT));

        //$json = stripslashes($json);
        //echo $json;

        //$data_      = json_decode($json);
        $data_      = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json), true);

        foreach ($data_ as $key => $value) {
            $data[$key] = $value;
        }


        return $data;
    }


    // USER LOGIN
    public function login()
    {
        if (!isset($_REQUEST['mobile']) || empty($_REQUEST['mobile'])) {
            return $this->withoutdata_res('Please select mobile', 400);
        }
        if (!isset($_REQUEST['password']) || empty($_REQUEST['password'])) {
            return $this->withoutdata_res('Please select password', 400);
        }

        $hash_pass = base64_encode($_REQUEST['password']);
        // $hash_pass = hash_hmac('sha1', ($_REQUEST['password']), '');
        $mobile = $_REQUEST['mobile'];

        if (strlen($mobile) != 10 || !is_numeric($mobile) || $mobile < 1000000000) {
            return $this->withoutdata_res('Please use a valid mobile number', 400);
        }

        $whr = ['conditions' => ['mobile' => $mobile, 'is_delete' => '2', 'mobile_verified' => '1']];
        $query  = $this->UsersModel->first($whr);
        if ($query) {
            $pass_check = [
                'conditions' => ['mobile' => $mobile, 'password' => $hash_pass]
            ];
            $pass_query  = $this->UsersModel->first($pass_check);
            if ($pass_query) {
                $token     = generateRandomString();
                $update_arr = ['token' => $token, 'is_login' => '1', 'otp' => '0'];
                $update  = $this->UsersModel->updateTable($update_arr, ['mobile' => $mobile]);

                $whr_usr = [
                    'conditions' => ['mobile' => $mobile, 'password' => $hash_pass],
                    'fields' => ['token']
                ];
                $token_query  = $this->UsersModel->first($whr_usr);
                $code = '101';
                $this->response($token_query, "Login Successfully", $code);
            } else {
                $code = '400';
                $x = new stdClass();
                $this->withoutdata_res("Wrong Credentials", $code);
            }
        } else {
            $code = '400';
            $x = new stdClass();
            $this->withoutdata_res("You are not registered", $code);
        }
    }
    
    //Imb Webhoook dont remove
    public function imb_webhook()
    {

    $raw = file_get_contents("php://input");
    $json = json_decode($raw, true);

    if (!empty($json)) {
        $data = $json;
    } else {
        $data = $_POST;
    }

    log_message('error', 'IMB WEBHOOK RAW: ' . $raw);
    log_message('error', 'IMB WEBHOOK DATA: ' . json_encode($data));

   
    if (empty($data)) {
        echo "no data";
        exit;
    }

 
    if (!isset($data['order_id']) || !isset($data['status'])) {
        echo "invalid";
        exit;
    }

    $order_id = $data['order_id'];
    $status = strtoupper($data['status']);


    if ($status != "SUCCESS") {
        echo "ignored";
        exit;
    }

 
    $result = isset($data['result']) ? $data['result'] : [];

    if (!isset($result['txnStatus']) || $result['txnStatus'] != "COMPLETED") {
        echo "not completed";
        exit;
    }

    $amount = isset($result['amount']) ? $result['amount'] : 0;
    $mobile = isset($result['remark2']) ? $result['remark2'] : '';

    if (empty($mobile)) {
        echo "mobile missing";
        exit;
    }

    $check = $this->UserTransModel->first([
        'conditions' => ['trans_det' => $order_id]
    ]);

    if ($check) {
        echo "already done";
        exit;
    }

    
    $user = $this->UsersModel->first([
        'conditions' => ['mobile' => $mobile]
    ]);

    if (!$user) {
        echo "user not found";
        exit;
    }

    
    $this->UserTransModel->save([
        'user_id' => $user['id'],
        'points' => $amount,
        'trans_type' => 1,
        'trans_status' => 'SUCCESS',
        'admin_status' => 'APPROVED',
        'trans_det' => $order_id,
        'created_at' => date('Y-m-d H:i:s')
    ]);
    
    
    $this->UsersModel->updateTable([
        'available_points' => $user['available_points'] + $amount
    ], ['id' => $user['id']]);

    echo "success";
    exit;
        
    }

    // Login with pin
    public function login_pin()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }
        if (!isset($_REQUEST['pin']) || empty($_REQUEST['pin'])) {
            return $this->withoutdata_res('Please input pin', 400);
        }

        $token = $getHeaders['token'];
        $pin = $_REQUEST['pin'];

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $query  = $this->UsersModel->first($whr_arr);
        if ($query) {
            $pin_check = [
                'conditions' => ['pin' => $pin, 'token' => $token]
            ];
            $pin_query  = $this->UsersModel->first($pin_check);
            if ($pin_query) {
                $new_token     = generateRandomString();
                $update_arr = ['token' => $new_token, 'is_login' => '1', 'otp' => '0'];
                $update  = $this->UsersModel->updateTable($update_arr, ['token' => $token]);

                $whr_usr = [
                    'conditions' => ['token' => $new_token, 'pin' => $pin],
                    'fields' => ['token']
                ];
                $token_query  = $this->UsersModel->first($whr_usr);
                $code = '101';
                $this->response($token_query, "Login Successfully", $code);
            } else {
                $code = '400';
                $this->withoutdata_res("Wrong Pin", $code);
            }
        } else {
            $code = '505';
            $this->withoutdata_res("Invaild access", $code);
        }
    }

    public function verify_user()
    {
        if (!isset($_REQUEST['mobile']) || empty($_REQUEST['mobile'])) {
            return $this->withoutdata_res('Please select mobile', 400);
        }
        if (!isset($_REQUEST['mobile_token']) || empty($_REQUEST['mobile_token'])) {
            return $this->withoutdata_res('Please select mobile token', 400);
        }
        if (!isset($_REQUEST['otp']) || empty($_REQUEST['otp'])) {
            return $this->withoutdata_res('Please select otp', 400);
        }

        $mobile = $_REQUEST['mobile'];
        $mobile_token = $_REQUEST['mobile_token'];
        $otp = $_REQUEST['otp'];

        if (strlen($mobile) != 10 || !is_numeric($mobile) || $mobile < 1000000000) {
            return $this->withoutdata_res('Please use a valid mobile number', 400);
        }
        if (strlen($otp) != 4 || !is_numeric($otp)) {
            return $this->withoutdata_res('Please use a valid otp', 400);
        }

        $pass_check = ['conditions' => ['mobile' => $mobile, 'otp' => $otp]];
        $pass_query  = $this->UsersModel->first($pass_check);

        if ($pass_query) {
            $token     = generateRandomString();
            $update_arr = [];

            $update_arr = ['token' => $token, 'mobile_verified' => 1, 'is_login' => 1, 'mobile_token' => $mobile_token];
            $whr_arr = ['mobile' => $mobile];
            $token_upd = $this->UsersModel->updateTable($update_arr, $whr_arr);
            if ($token_upd) {
                $code = '100';
                $whr_user = ['conditions' => ['mobile' => $mobile], 'fields' => ['token']];
                $user  = $this->UsersModel->first($whr_user);
                $this->response($user, "successful verify", $code);
            } else {
                $code = '400';
                $this->withoutdata_res("Not verify", $code);
            }
        } else {
            $code = '400';
            $this->withoutdata_res("Wrong otp", $code);
        }
    }

    // USER REGISTRATION
    public function signup()
    {
        if (!isset($_REQUEST['full_name']) || empty($_REQUEST['full_name'])) {
            return $this->withoutdata_res('Please select full_name', 400);
        }
        if (!isset($_REQUEST['mobile']) || empty($_REQUEST['mobile'])) {
            return $this->withoutdata_res('Please select mobile', 400);
        }
        if ((!isset($_REQUEST['pin'])) || (empty($_REQUEST['pin']))) {
            return $this->withoutdata_res('Please select pin', 400);
        }
        if (!isset($_REQUEST['password']) || empty($_REQUEST['password'])) {
            return $this->withoutdata_res('Please select password', 400);
        }


        $full_name = $_REQUEST['full_name'];
        $mobile = $_REQUEST['mobile'];
        $pin = $_REQUEST['pin'];
        $pass = $_REQUEST['password'];
        $date = $date = Date('Y-m-d H:i:s');

        if (strlen($mobile) != 10 || !is_numeric($mobile) || $mobile < 1000000000) {
            return $this->withoutdata_res('Please use a valid mobile number', 400);
        }

        $hash_pass = base64_encode($pass);
        // $hash_pass = hash_hmac('sha1', $pass, '');

        $whr = ['conditions' => "`mobile` = '$mobile' "];
        $query  = $this->UsersModel->first($whr);

        $con_sett  = [
            'conditions' => ['option_key' => 'auto_active']
        ];
        $settingData = $this->SettingsModel->first($con_sett);

        $userStatus = '2';
        if ($settingData['option_value'] == 'Auto Activation') {
            $userStatus = '1';
        }

        if ($query) {
            if ($query['mobile_verified']) {
                $code = '400';
                $this->withoutdata_res("You are already Registered", $code);
            } else {
                $token     = generateRandomString();
                $otp       = $this->getOTP();
                $update_arr = [
                    'mobile' => $mobile,
                    'username' => $full_name,
                    'pin' => $pin,
                    'token' => $token,
                    'password' => $hash_pass,
                    'is_delete' => '2',
                    'status' => $userStatus,
                    'otp' => $otp
                ];

                $whr_cnd = ['id' => $query['id']];
                $query = $this->UsersModel->updateTable($update_arr, $whr_cnd);

                if ($query) {
                    $this->shootMsg($otp, $mobile);
                    $code = '100';
                    $this->withoutdata_res("New Registration successful", $code);
                } else {
                    $code = '400';
                    $this->withoutdata_res("Please Try Again", $code);
                }
            }
        } else {
            $token     = generateRandomString();
            $otp       = $this->getOTP();
            $arr = [
                'mobile' => $mobile,
                'username' => $full_name,
                'pin' => $pin,
                'token' => $token,
                'password' => $hash_pass,
                'status' => $userStatus,
                'registred_date' => $date,
                'otp' => $otp
            ];

            $user = $this->UsersModel->save($arr);
            $this->shootMsg($otp, $mobile);
            $code = '100';
            $this->withoutdata_res("New Registration successful", $code);
        }
    }

    //Create password after forgot password
    public function forgot_password()
    {
        if (!isset($_REQUEST['mobile']) || empty($_REQUEST['mobile'])) {
            return $this->withoutdata_res('Please select mobile', 400);
        }
        $mobile = $_REQUEST['mobile'];

        if (strlen($mobile) != 10 || !is_numeric($mobile) || $mobile < 1000000000) {
            return $this->withoutdata_res('Please use a valid mobile number', 400);
        }



        $whr_arr  = ['conditions' => ['mobile' => $mobile]];
        $user = $this->UsersModel->first($whr_arr);

        if (empty($user) or $user['is_delete'] == '1') {
            $code = '505';
            $this->withoutdata_res("User doesn't exist", $code);
        } else {
            $otp       = $this->getOTP();
            $update_arr = ['otp' => $otp];
            $whr_cnd = ['mobile' => $mobile];
            $query = $this->UsersModel->updateTable($update_arr, $whr_cnd);
            if ($query) {
                $this->shootMsg($otp, $mobile);
                $this->withoutdata_res("forgot password otp sent", '100');
            } else {
                $this->withoutdata_res("Try Again", '400');
            }
        }
    }


    //Create password after forgot password
    public function forgot_password_verify()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        if (!isset($_REQUEST['mobile']) || empty($_REQUEST['mobile'])) {
            return $this->withoutdata_res('Please select mobile', 400);
        }

        if (!isset($_REQUEST['mobile_token']) || empty($_REQUEST['mobile_token'])) {
            return $this->withoutdata_res('Please select mobile token', 400);
        }

        if (!isset($_REQUEST['password']) || empty($_REQUEST['password'])) {
            return $this->withoutdata_res('Please select password', 400);
        }

        $mobile = $_REQUEST['mobile'];
        $mobile_token = $_REQUEST['mobile_token'];
        $token = $getHeaders['token'];

        if (strlen($mobile) != 10 || !is_numeric($mobile) || $mobile < 1000000000) {
            return $this->withoutdata_res('Please use a valid mobile number', 400);
        }

        $whr_arr  = ['conditions' => ['mobile' => $mobile, 'token'  => $token]];
        $user = $this->UsersModel->first($whr_arr);
        if (empty($user) or $user['is_delete'] == '1') {
            return $this->withoutdata_res('Invalid data', 505);
        }

        if ($user) {
            $pass = $_REQUEST['password'];

            $hash_pass = base64_encode($pass);

            // $hash_pass = hash_hmac('sha1', $pass, '');
            $token     = generateRandomString();

            $arr = ['password' => $hash_pass, 'token' => $token, 'mobile_token' => $mobile_token, 'is_login' => 1, 'mobile_verified' => 1];
            $password_update  = $this->UsersModel->updateTable($arr, ['mobile' => $_REQUEST['mobile']]);

            $whr_usr = [
                'conditions' => ['mobile' => $mobile, 'password' => $hash_pass],
                'fields' => ['token']
            ];
            $token_query  = $this->UsersModel->first($whr_usr);

            $code = '100';
            $this->response($token_query, "Successfully", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("UnSuccess", $code);
        }
    }

    // forgot pin
    public function forgot_pin()
    {
        if (!isset($_REQUEST['mobile']) || empty($_REQUEST['mobile'])) {
            return $this->withoutdata_res('Please select mobile', 400);
        }
        $mobile = $_REQUEST['mobile'];

        if (strlen($mobile) != 10 || !is_numeric($mobile) || $mobile < 1000000000) {
            return $this->withoutdata_res('Please use a valid mobile number', 400);
        }


        $whr_arr  = ['conditions' => ['mobile' => $mobile]];
        $user = $this->UsersModel->first($whr_arr);

        if (empty($user) or $user['is_delete'] == '1') {
            $code = '505';
            $this->withoutdata_res("User doesn't exist", $code);
        } else {
            $otp       = $this->getOTP();
            $update_arr = ['otp' => $otp];
            $whr_cnd = ['mobile' => $mobile];
            $query = $this->UsersModel->updateTable($update_arr, $whr_cnd);
            if ($query) {
                $this->shootMsg($otp, $mobile);
                $this->withoutdata_res("forgot pin otp sent", '100');
            } else {
                $this->withoutdata_res("Try Again", '400');
            }
        }
    }

    //Create password after forgot password
    public function create_pin()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        if (!isset($_REQUEST['pin']) || empty($_REQUEST['pin'])) {
            return $this->withoutdata_res('Please select pin', 400);
        }

        if (!isset($_REQUEST['mobile_token']) || empty($_REQUEST['mobile_token'])) {
            return $this->withoutdata_res('Please select mobile token', 400);
        }

        if (!isset($_REQUEST['mobile']) || empty($_REQUEST['mobile'])) {
            return $this->withoutdata_res('Please select otp', 400);
        }

        $pin = $_REQUEST['pin'];
        $mobile_token = $_REQUEST['mobile_token'];
        $mobile = $_REQUEST['mobile'];
        $token = $getHeaders['token'];


        $whr_arr  = ['conditions' => ['mobile' => $mobile, 'token' => $token]];
        $user = $this->UsersModel->first($whr_arr);
        if (empty($user) or $user['is_delete'] == '1') {
            return $this->withoutdata_res('Invalid data', 505);
        }

        if ($user) {
            $token     = generateRandomString();

            $arr = ['pin' => $pin, 'token' => $token, 'is_login' => 1, 'mobile_token' => $mobile_token, 'mobile_verified' => 1];
            $pin_update  = $this->UsersModel->updateTable($arr, ['mobile' => $user['mobile']]);

            $whr_usr = [
                'conditions' => ['mobile' => $user['mobile'], 'pin' => $pin],
                'fields' => ['token']
            ];
            $token_query  = $this->UsersModel->first($whr_usr);

            $code = '100';
            $this->response($token_query, "Successfully", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("Invalid Data", $code);
        }
    }

    //otp verify

    public function verify_otp()
    {
        if (!isset($_REQUEST['mobile']) || empty($_REQUEST['mobile'])) {
            return $this->withoutdata_res('Please select mobile number', 505);
        }

        if (!isset($_REQUEST['otp']) || empty($_REQUEST['otp'])) {
            return $this->withoutdata_res('Please select otp', 400);
        }

        $mobile = $_REQUEST['mobile'];
        $otp = $_REQUEST['otp'];


        $whr_arr  = ['conditions' => ['mobile' => $mobile, 'otp' => $otp]];
        $user = $this->UsersModel->first($whr_arr);
        if (empty($user) or $user['is_delete'] == '1') {
            return $this->withoutdata_res('Invalid data', 505);
        }

        if ($user) {
            $token     = generateRandomString();

            $arr = ['token' => $token, 'mobile_verified' => 1];
            $pin_update  = $this->UsersModel->updateTable($arr, ['mobile' => $user['mobile']]);

            $whr_usr = [
                'conditions' => ['mobile' => $user['mobile']],
                'fields' => ['token']
            ];
            $token_query  = $this->UsersModel->first($whr_usr);

            $code = '100';
            $this->response($token_query, "Successfully", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("Invalid Token", $code);
        }
    }

    public function resend_otp()
    {
        if (!isset($_REQUEST['mobile']) || empty($_REQUEST['mobile'])) {
            return $this->withoutdata_res('Please select mobile', 400);
        }
        $mobile = $_REQUEST['mobile'];

        if (strlen($mobile) != 10 || !is_numeric($mobile) || $mobile < 1000000000) {
            return $this->withoutdata_res('Please use a valid mobile number', 400);
        }


        $whr_arr  = ['conditions' => ['mobile' => $mobile]];
        $user = $this->UsersModel->first($whr_arr);

        if (empty($user) or $user['is_delete'] == '1') {
            $code = '505';
            $this->withoutdata_res("User doesn't exist", $code);
        } else {
            $otp = $user['otp'];
            $this->shootMsg($otp, $mobile);
            $this->withoutdata_res("otp resent successfully", '100');
        }
    }


    //user status
    public function user_status()
    {
        $token = $this->getRequestToken();
        if (empty($token)) {
            return $this->withoutdata_res('Please select token', 505);
        }
        $whr_arr  = [
            'conditions' => ['token' => $token],
        ];
        $user = $this->UsersModel->first($whr_arr);
        $whr_acc  = [
            'conditions' => ['id' => 1]
        ];
        $acc = $this->AccountModel->first($whr_acc);

        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }
        if ($user['status'] == '1' && $user['is_delete'] == '2') {
            $ava_point['available_points'] = $user['available_points'];
            $ava_point['transfer'] = $user['transfer'];
            $ava_point['upi_name'] = $acc['upi_name'];
            $ava_point['upi_payment_id'] = $acc['upi_payment_id'];
            $ava_point['maximum_deposit'] = $acc['maximum_deposit'];
            $ava_point['minimum_deposit'] = $acc['minimum_deposit'];
            $ava_point['maximum_withdraw'] = $acc['maximum_withdraw'];
            $ava_point['minimum_withdraw'] = $acc['minimum_withdraw'];
            $ava_point['maximum_transfer'] = $acc['maximum_transfer'];
            $ava_point['minimum_transfer'] = $acc['minimum_transfer'];
            $ava_point['maximum_bid_amount'] = $acc['maximum_bid_amount'];
            $ava_point['minimum_bid_amount'] = $acc['minimum_bid_amount'];
            $ava_point['visibilityOfSection'] = $acc['visibilityOfSection'];

            $code = '100';
            $this->response($ava_point, "User Verified", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("Not Verified", $code);
        }
    }

    public function app_live_status()
    {
        $whracc  = [
            'conditions' => ['id' => 1],
            'fields' => ['app_live_status']
        ];
        $accSetting = $this->AccountModel->first($whracc);
        if (!empty($accSetting)) {
            $app_status = $accSetting['app_live_status'];
            $data =  "";
            $code = '';
            if ($app_status == "Live") {
                $data =  "";
                $code = '100';
            } else {
                $whr_arr  = [
                    'conditions' => ['status' => 4]
                ];
                $user  = $this->UsersModel->first($whr_arr);
                if (!empty($user)) {

                    $data =  $user['token'];
                    $code = '200';
                }
            }
        }

        if (!empty($app_status)) {
            $this->response($data, "App status found", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("Banner Not Available", $code);
        }
    }

    // banner
    public function banners()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        $token = $getHeaders['token'];

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $con  = $this->UsersModel->first($whr_arr);
        if (empty($con) or $con['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $whr_acc  = [
            'conditions' => ['status' => 1],
            'fields' => ['image']
        ];
        $banner = $this->SlidersModel->all($whr_acc);
        foreach ($banner as $key => $val) {
            $img_bnr = ($val['image']);
            $decoded = $this->decodeBase64Image($img_bnr, 'slider/');
            // _ddd($decoded);
            $full_path_decode = SITE_URL . "uploads/slider/" . $decoded;
            $banner[$key]['image'] = $img_bnr;
        }

        if (!empty($banner)) {
            $code = '100';
            $this->response($banner, "Banner Available", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("Banner Not Available", $code);
        }
    }

    // upi_details
    public function upi_details()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        $token = $getHeaders['token'];

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $con  = $this->UsersModel->first($whr_arr);
        if (empty($con) or $con['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $whr_acc  = [
            'conditions' => ['id' => 1]
        ];
        $acc = $this->AccountModel->first($whr_acc);
        $data = [];
        $data['google_pay_upi'] = $acc['g_pay_upi'];
        $data['phonepe_upi'] = $acc['phonepe_upi'];
        $data['paytm_upi'] = $acc['paytm_upi'];
        $data['others_upi'] = $acc['others_upi'];

        if (!empty($acc)) {
            $code = '100';
            $this->response($data, "Upi Details Available", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("Upi Details Not Available", $code);
        }
    }

    //Get user details
    public function get_user_details()
    {

        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        $token = $getHeaders['token'];

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $con  = $this->UsersModel->first($whr_arr);
        if (empty($con) or $con['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $whr_arr  = [
            'conditions' => ['token' => $token],
            'fields' => ['username', 'mobile', 'email', 'bank_name', 'account_holder_name', 'ifsc_code', 'branch_address', 'bank_account_no', 'paytm_mobile_no', 'phonepe_mobile_no', 'gpay_mobile_no']
        ];
        $fetch_data  = $this->UsersModel->first($whr_arr);
        if ($fetch_data) {
            $code = '100';
            $this->response($fetch_data, "User profile updated successfully", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("UnSuccess", $code);
        }
    }

    //Update Profile
    public function update_profile()
    {

        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        if (!isset($_REQUEST['email']) || empty($_REQUEST['email'])) {
            return $this->withoutdata_res('Please select email', 400);
        }
        if (!isset($_REQUEST['name']) || empty($_REQUEST['name'])) {
            return $this->withoutdata_res('Please select name', 400);
        }

        $token = $getHeaders['token'];
        $name = $_REQUEST['name'];
        $email = $_REQUEST['email'];

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $con  = $this->UsersModel->first($whr_arr);
        if (empty($con) or $con['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }


        $update_arr = ['email' => $email, 'username' => $name];
        $whrr = ['id' => $con['id']];

        $query = $this->UsersModel->updateTable($update_arr, $whrr);

        $whr_arr  = [
            'conditions' => ['token' => $token],
            'fields' => ['username', 'email']
        ];
        $fetch_data  = $this->UsersModel->first($whr_arr);
        if ($query) {
            $code = '100';
            $this->response($fetch_data, "User profile updated successfully", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("UnSuccess", $code);
        }
    }


    //update phonepe
    public function update_phonepe()
    {

        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        if (!isset($_REQUEST['phonepe']) || empty($_REQUEST['phonepe'])) {
            return $this->withoutdata_res('Please select PhonePe number', 400);
        }

        $token = $getHeaders['token'];

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $con  = $this->UsersModel->first($whr_arr);
        if (empty($con) or $con['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $update_arr =
            [
                'phonepe_mobile_no' => $_REQUEST['phonepe']
            ];

        $whrr = ['id' => $con['id']];
        $query = $this->UsersModel->updateTable($update_arr, $whrr);

        if ($query) {
            $code = '100';
            $this->withoutdata_res("User PhonePe details updated successfully", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("Not Successful", $code);
        }
    }

    //update GPay
    public function update_gpay()
    {

        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        if (!isset($_REQUEST['gpay']) || empty($_REQUEST['gpay'])) {
            return $this->withoutdata_res('Please GPay number', 400);
        }

        $token = $getHeaders['token'];

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $con  = $this->UsersModel->first($whr_arr);
        if (empty($con) or $con['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $update_arr =
            [
                'gpay_mobile_no' => $_REQUEST['gpay']
            ];

        $whrr = ['id' => $con['id']];
        $query = $this->UsersModel->updateTable($update_arr, $whrr);

        if ($query) {
            $code = '100';
            $this->withoutdata_res("User GPay details updated successfully", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("Not Successful", $code);
        }
    }

    //update Paytm
    public function update_paytm()
    {

        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        if (!isset($_REQUEST['paytm']) || empty($_REQUEST['paytm'])) {
            return $this->withoutdata_res('Please Paytm Number', 400);
        }

        $token = $getHeaders['token'];

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $con  = $this->UsersModel->first($whr_arr);
        if (empty($con) or $con['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $update_arr =
            [
                'paytm_mobile_no' => $_REQUEST['paytm']
            ];

        $whrr = ['id' => $con['id']];
        $query = $this->UsersModel->updateTable($update_arr, $whrr);

        if ($query) {
            $code = '100';
            $this->withoutdata_res("User Paytm details updated successfully", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("Not Successful", $code);
        }
    }

    //update bank details
    public function update_bank_details()
    {

        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        if (!isset($_REQUEST['account_holder_name']) || empty($_REQUEST['account_holder_name'])) {
            return $this->withoutdata_res('Please select account holder name', 400);
        }
        if (!isset($_REQUEST['account_no']) || empty($_REQUEST['account_no'])) {
            return $this->withoutdata_res('Please select account no', 400);
        }
        if (!isset($_REQUEST['ifsc_code']) || empty($_REQUEST['ifsc_code'])) {
            return $this->withoutdata_res('Please select ifsc code', 400);
        }
        if (!isset($_REQUEST['bank_name']) || empty($_REQUEST['bank_name'])) {
            return $this->withoutdata_res('Please select bank name', 400);
        }
        if (!isset($_REQUEST['branch_address']) || empty($_REQUEST['branch_address'])) {
            return $this->withoutdata_res('Please select branch address', 400);
        }

        $token = $getHeaders['token'];

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $con  = $this->UsersModel->first($whr_arr);
        if (empty($con) or $con['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $update_arr =
            [
                'bank_name' => $_REQUEST['bank_name'],
                'ifsc_code' => $_REQUEST['ifsc_code'],
                'bank_account_no' => $_REQUEST['account_no'],
                'account_holder_name' => $_REQUEST['account_holder_name'],
                'branch_address' => $_REQUEST['branch_address']
            ];

        $whrr = ['id' => $con['id']];
        $query = $this->UsersModel->updateTable($update_arr, $whrr);

        if ($query) {
            $code = '100';
            $this->withoutdata_res("User bank details updated successfully", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("Not Successful", $code);
        }
    }

    //update Firebase token
    public function update_firebase_token()
    {

        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        if (!isset($_REQUEST['token_id']) || empty($_REQUEST['token_id'])) {
            return $this->withoutdata_res('Please select firebase token id', 400);
        }

        $token = $getHeaders['token'];

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $con  = $this->UsersModel->first($whr_arr);
        if (empty($con) or $con['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $update_arr =
            [
                'token_id' => $_REQUEST['token_id']
            ];

        $whrr = ['id' => $con['id']];
        $query = $this->UsersModel->updateTable($update_arr, $whrr);

        if ($query) {
            $code = '100';
            $this->withoutdata_res("User Firebase details updated successfully", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("Not Successful", $code);
        }
    }

    // add fund
    public function add_fund()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        if (!isset($_REQUEST['points']) || empty($_REQUEST['points'])) {
            return $this->withoutdata_res('Please select points', 400);
        }

        if (!isset($_REQUEST['trans_status']) && empty($_REQUEST['trans_status'])) {
            return $this->withoutdata_res('Please select trans status', 400);
        }

        if (!isset($_REQUEST['trans_id']) && empty($_REQUEST['trans_id'])) {
            return $this->withoutdata_res('Please select a trans id', 400);
        }

        $token = $getHeaders['token'];
        $points = $_REQUEST['points'];
        $trans_status = $_REQUEST['trans_status'];
        $trans_id = $_REQUEST['trans_id'];
        $date = Date('Y-m-d H:i:s');

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $con  = $this->UsersModel->first($whr_arr);
        if (empty($con) or $con['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }



        $arr = [
            'user_id' => $con['id'],
            'points' => $points,
            'trans_type' => 1,
            'trans_status' => $trans_status,
            'admin_status' => 'APPROVED',
            'trans_det' => $trans_id,
            'created_at' => $date
        ];

        $query  = $this->UserTransModel->save($arr);

        if ($query) {
            $updated_points = $points + $con['available_points'];

            $update_arr =
                [
                    'available_points' => $updated_points
                ];

            $whrr = ['token' => $token];
            $query = $this->UsersModel->updateTable($update_arr, $whrr);

            $code = '100';
            $this->withoutdata_res("successfully requested", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("Error", $code);
        }
    }


    //withdraw points
    public function withdraw()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        if (!isset($_REQUEST['points']) || empty($_REQUEST['points'])) {
            return $this->withoutdata_res('Please select points', 400);
        }

        if (!isset($_REQUEST['method']) || empty($_REQUEST['method'])) {
            return $this->withoutdata_res('Please select method', 400);
        }


        $token = $getHeaders['token'];
        $points = $_REQUEST['points'];
        $method = $_REQUEST['method'];
        $date = Date('Y-m-d H:i:s');
        $time = strtotime(date('H:i:s'));

        $whracc  = [
            'conditions' => ['id' => 1],
            'fields' => ['withdraw_open_time', 'withdraw_close_time']
        ];

        $accSetting = $this->AccountModel->first($whracc);

        $withOpenTime = strtotime($accSetting['withdraw_open_time']);
        $withCloseTime = strtotime($accSetting['withdraw_close_time']);

        if ($time < $withOpenTime || $time > $withCloseTime) {
            return $this->withoutdata_res('Withdraw time is not active', 400);
        }

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $con  = $this->UsersModel->first($whr_arr);
        if (empty($con) or $con['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }
        if (empty($con['available_points']) or $con['available_points'] < $points) {
            return $this->withoutdata_res('insufficient points', 400);
        }
        if (empty($con[$method]) or $con[$method] == "") {
            return $this->withoutdata_res($method . ' details do not exist', 400);
        }

        $whr_arr_withdraw  = [
            'conditions' => ['trans_status' => 'PENDING', 'admin_status' => 'PENDING', 'user_id' => $con['id'], 'trans_type' => 6]
        ];
        $check_withdraw = $this->UserTransModel->first($whr_arr_withdraw);

        if (!empty($check_withdraw)) {
            return $this->withoutdata_res('Your previous withdraw request still pending.', 400);
        }

        $arr = [
            'user_id' => $con['id'],
            'points' => $points,
            'trans_type' => 6,
            'request_no' => uniqid(),
            'trans_status' => 'PENDING',
            'admin_status' => 'PENDING',
            'trans_det' => $method,
            'created_at' => $date
        ];

        $query  = $this->UserTransModel->save($arr);

        if ($query) {

            $updated_points = $con['available_points'] - $points;

            $update_arr =
                [
                    'available_points' => $updated_points
                ];

            $whrr = ['token' => $token];
            $query = $this->UsersModel->updateTable($update_arr, $whrr);

            $code = '100';
            $this->withoutdata_res("successfully requested", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("Error", $code);
        }
    }

    //withdraw history
    public function withdraw_statement()
    {

        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        $token    = $getHeaders['token'];

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $user = $this->UsersModel->first($whr_arr);

        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $data = [];
        $data['available_points'] = $user['available_points'];
        $data['withdraw_open_time'] = "";
        $data['withdraw_close_time'] = "";


        $whracc  = [
            'conditions' => ['user_id' => $user['id'], 'trans_type' => 6],
            'fields' => ['points', 'trans_type', 'trans_det', 'trans_status', 'created_at'],
            'order' => ['by' => 'id', 'type' => 'DESC']
        ];
        $acc = $this->UserTransModel->all($whracc);

        foreach ($acc as $key => $statement) {


            $whrtran  = [
                'conditions' => ['id' => $acc[$key]['trans_type']],
                'fields' => ['trans_msg', 'trans_type'],
                'order' => ['by' => 'id', 'type' => 'DESC']
            ];
            $trans = $this->TransactionTypeModel->first($whrtran);
            $acc[$key]['trans_type'] = $trans['trans_type'];
            $acc[$key]['trans_msg'] = $trans['trans_msg'];
        }



        if ($acc) {
            $data['statement'] = $acc;
            $code = '100';
            $this->response($data, "successfully fetched", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("No Data", $code);
        }
    }

    //wallet statement
    public function wallet_statement()
    {

        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        $token    = $getHeaders['token'];

        $whr_arr  = [
            'conditions' => ['token' => $token],
            'fields' => ['id', 'is_login', 'available_points']
        ];
        $user = $this->UsersModel->first($whr_arr);

        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $data = [];
        $data['available_points'] = $user['available_points'];

        $whracc  = [
            'conditions' => ['id' => 1],
            'fields' => ['withdraw_open_time', 'withdraw_close_time']
        ];
        $acc = $this->AccountModel->first($whracc);

        $data['withdraw_open_time'] = date('h:i A', strtotime($acc['withdraw_open_time']));
        $data['withdraw_close_time'] = date('h:i A', strtotime($acc['withdraw_close_time']));

        $whracc  = [
            'conditions' => ['user_id' => $user['id']],
            'fields' => ['points', 'trans_type', 'trans_det', 'trans_status', 'created_at'],
            'order' => ['by' => 'id', 'type' => 'DESC']
        ];
        $wallet = $this->UserTransModel->all($whracc);

        foreach ($wallet as $key => $statement) {
            $whracc  = [
                'conditions' => ['id' => $wallet[$key]['trans_type']],
                'fields' => ['trans_msg', 'trans_type']
            ];
            $trans = $this->TransactionTypeModel->first($whracc);
            $wallet[$key]['trans_type'] = $trans['trans_type'];
            $wallet[$key]['trans_msg'] = $trans['trans_msg'];
        }
        $data['statement'] = $wallet;


        if ($data) {
            $code = '100';
            $this->response($data, "successfully fetched", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("No Record Found", $code);
        }
    }

    //transefer point
    public function transfer_verify()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        if (!isset($_REQUEST['user_number']) && empty($_REQUEST['user_number'])) {
            return $this->withoutdata_res('Please select user_number', 400);
        }

        $token = $getHeaders['token'];
        $user_number = $_REQUEST['user_number'];
        $date = date("Y-m-d H:i:s");

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $whr_rec  = [
            'conditions' => ['mobile' => $user_number]
        ];
        $con  = $this->UsersModel->first($whr_arr);
        $con_rec  = $this->UsersModel->first($whr_rec);


        if (empty($con) or $con['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }
        if ($con['transfer'] == false) {
            return $this->withoutdata_res("Don't have transfer permission", 400);
        }



        if ($con['mobile'] == $user_number) {
            return $this->withoutdata_res('Cannot transfer points to yourself', 400);
        }

        if (empty($con_rec) or $con_rec['is_delete'] == '1') {
            return $this->withoutdata_res('Receiver not found', 400);
        } else {
            $data = array();
            $code = '100';
            $data['name'] = $con_rec['username'];
            $this->response($data, "Receiver Found", $code);
        }
    }

    //transefer point
    public function transfer_points()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        if (!isset($_REQUEST['points']) || empty($_REQUEST['points'])) {
            return $this->withoutdata_res('Please select points', 400);
        }

        if (!isset($_REQUEST['user_number']) && empty($_REQUEST['user_number'])) {
            return $this->withoutdata_res('Please select user_number', 400);
        }

        $token = $getHeaders['token'];
        $user_number = $_REQUEST['user_number'];
        $points = $_REQUEST['points'];
        $date = date("Y-m-d H:i:s");

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $whr_rec  = [
            'conditions' => ['mobile' => $user_number]
        ];
        $con  = $this->UsersModel->first($whr_arr);
        $con_rec  = $this->UsersModel->first($whr_rec);


        if (empty($con) or $con['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }
        if ($con['transfer'] == false) {
            return $this->withoutdata_res("Don't have transfer permission", 400);
        }



        if ($con['mobile'] == $user_number) {
            return $this->withoutdata_res('Cannot transfer points to yourself', 400);
        }

        if (empty($con_rec) or $con_rec['is_delete'] == '1') {
            return $this->withoutdata_res('Receiver not found', 400);
        }
        if (empty($con['available_points']) or $con['available_points'] < $points) {
            return $this->withoutdata_res('insufficient points', 400);
        }


        $arr_send = [
            'user_id' => $con['id'],
            'points' => $points,
            'trans_type' => 8,
            'trans_status' => 'SUCCESSFUL',
            'admin_status' => 'APPROVED',
            'trans_det' => $con_rec['id'],
            'created_at' => $date
        ];

        $query  = $this->UserTransModel->save($arr_send);

        $arr_rec = [
            'user_id' => $con_rec['id'],
            'points' => $points,
            'trans_type' => 4,
            'trans_status' => 'SUCCESSFUL',
            'admin_status' => 'APPROVED',
            'trans_det' => $con['id'],
            'created_at' => $date
        ];

        $query  = $this->UserTransModel->save($arr_rec);


        if ($query) {
            $updated_points_send = $con['available_points'] - $points;
            $updated_points_rec = $con_rec['available_points'] + $points;

            $update_arr_send =
                [
                    'available_points' => $updated_points_send
                ];

            $update_arr_rec =
                [
                    'available_points' => $updated_points_rec
                ];

            $whrr_send = ['token' => $token];
            $whrr_rec = ['mobile' => $con_rec['mobile']];

            $query = $this->UsersModel->updateTable($update_arr_send, $whrr_send);
            $query = $this->UsersModel->updateTable($update_arr_rec, $whrr_rec);

            $code = '100';
            $this->withoutdata_res("successfully transferred", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("Error", $code);
        }
    }

    //win history
    public function win_history()
    {

        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        $token    = $getHeaders['token'];
        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $user = $this->UsersModel->first($whr_arr);
        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }
        if (isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date'])) {
            $par['conditions']['bidded_at>='] = $_REQUEST['from_date'];
        }
        if (isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date'])) {
            $par['conditions']['bidded_at<='] = $_REQUEST['to_date'];
        }
        $par['conditions']['user_id'] = $user['id'];
        $par['conditions']['won'] = true;
        $par['fields'] = ['game_id', 'session', 'game_type', 'game_type', 'open_digit', 'close_digit', 'open_panna', 'close_panna', 'win_points', 'bid_points', 'won_at'];
        $par['order'] = ['by' => 'id', 'type' => 'DESC'];

        $acc = $this->BidModel->all($par);

        foreach ($acc as $key => $val) {
            $whrgamearr  = [
                'conditions' => ['id' => $val['game_id']]
            ];
            $game = $this->GamesModel->first($whrgamearr);

            $acc[$key]['game_name'] = $game['name'];
        }




        if ($acc) {
            $code = '100';
            $this->response($acc, "successfully fetched", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("No Record Found", $code);
        }
    }

    //bid history
    public function bid_history()
    {

        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        $token    = $getHeaders['token'];
        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $user = $this->UsersModel->first($whr_arr);


        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }
        if (isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date'])) {
            $par['conditions']['bidded_at>='] = $_REQUEST['from_date'];
        }
        if (isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date'])) {
            $par['conditions']['bidded_at<='] = $_REQUEST['to_date'];
        }

        $par['conditions']['user_id'] = $user['id'];

        $par['fields'] = ['game_id', 'game_type', 'session', 'open_digit', 'close_digit', 'open_panna', 'close_panna', 'bid_points', 'bidded_at'];
        $par['order'] = ['by' => 'id', 'type' => 'DESC'];

        $acc = $this->BidModel->all($par);
        foreach ($acc as $key => $val) {
            $whrgamearr  = [
                'conditions' => ['id' => $val['game_id']]
            ];
            $game = $this->GamesModel->first($whrgamearr);

            $acc[$key]['game_name'] = $game['name'];
        }


        if ($acc) {
            $code = '100';
            $this->response($acc, "successfully fetched", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("No Record Found", $code);
        }
    }

    //main game list
    public function main_game_list()
    {

        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        $token    = $getHeaders['token'];
        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $user = $this->UsersModel->first($whr_arr);


        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $whracc  = [
            'conditions' => ['id' => 1],
            'fields' => ['market_open_time']
        ];

        $accSetting = $this->AccountModel->first($whracc);


        $whr_arr  = [
            'conditions' => ['status' => '1'],
            'fields' => ['id', 'name'],
            'order' => ['by' => 'open_time', 'type' => 'ASC']
        ];
        $gameList = $this->GamesModel->all($whr_arr);



        $currentTimeStamp = time();
        $date = date('Y-m-d', $currentTimeStamp);
        $time = date('H:i:s', $currentTimeStamp);
        $day = strtolower(date('l', $currentTimeStamp));
        $day3 = substr($day, 0, 3);

        $marketTime = strtotime($accSetting['market_open_time']);
        $currentTime = strtotime($time);

        if ($currentTime < $marketTime) {
            $date = date('Y-m-d', strtotime($date . ' -1 day'));
            $day = strtolower(date('l', strtotime($date)));
            $day3 = substr($day, 0, 3);
        }

        $start_date = $date . " 00:00:00";
        $end_date = $date . " 23:59:59";

        foreach ($gameList as $key => $game) {
            $gameList[$key]['chart_url'] = Main_Chart . $game['name'];
            $gameList[$key]['play'] = false;
            $gameList[$key]['open'] = false;
            $gameList[$key]['market_open'] = true;

            $whr_day  = [
                'conditions' => ['game_id' => $game['id']],
                'fields' => [$day, $day3 . '_open', $day3 . '_close'],
            ];

            $day_market = $this->GameMarketDayWise->first($whr_day);

            if (time() < strtotime($date . ' ' . $day_market[$day3 . '_close']))
                $gameList[$key]['play'] = true;
            if (time() < strtotime($date . ' ' . $day_market[$day3 . '_open']))
                $gameList[$key]['open'] = true;
            if ($day_market[$day] == 2) {
                $gameList[$key]['market_open'] = false;
                $gameList[$key]['play'] = false;
                $gameList[$key]['open'] = false;
            }

            $gameList[$key]['open_time'] = date('h:i A', strtotime($day_market[$day3 . '_open']));
            $gameList[$key]['close_time'] = date('h:i A', strtotime($day_market[$day3 . '_close']));

            $whr_res['conditions']['decleared_at>'] = $start_date;
            $whr_res['conditions']['decleared_at<'] = $end_date;
            $whr_res['conditions']['game_id'] = $game['id'];
            $whr_res['fields'] = ['open_digit', 'close_digit', 'open_panna', 'close_panna'];

            $game_result = $this->ResultsModel->first($whr_res);
            if ($game_result) {
                $gameList[$key]['result'] = $game_result['open_panna'] . '-' . $game_result['open_digit'] . $game_result['close_digit'] . '-' . $game_result['close_panna'];
            } else {
                $gameList[$key]['result'] = '***-**-***';
            }
        }

        if ($gameList) {
            $code = '100';
            $this->response($gameList, "successfully fetched", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("No Game Available", $code);
        }
    }

    //place bid
    public function place_bid()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }
        if (!isset($_REQUEST['game_bids']) || empty($_REQUEST['game_bids'])) {
            return $this->withoutdata_res('Please select game bids', 400);
        }

        $token = $getHeaders['token'];
        $game_bids = $_REQUEST['game_bids'];

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $user = $this->UsersModel->first($whr_arr);

        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $game_bids_array = json_decode($game_bids);
        if (!isset($game_bids_array->bids) || empty($game_bids_array->bids)) {
            return $this->withoutdata_res('Invailid data', 400);
        }
        $bids_array = $game_bids_array->bids;
        $total_bid_points = 0;

        $currentTimeStamp = time();
        $date = date('Y-m-d', $currentTimeStamp);
        $time = date('H:i:s', $currentTimeStamp);
        $day = strtolower(date('l', $currentTimeStamp));
        $day3 = substr($day, 0, 3);

        $whr_acc  = [
            'conditions' => ['id' => 1],
            'fields' => ['minimum_bid_amount', 'maximum_bid_amount', 'market_open_time']
        ];
        $acc = $this->AccountModel->first($whr_acc);

        $marketTime = strtotime($acc['market_open_time']);
        $currentTime = strtotime($time);

        if ($currentTime < $marketTime) {
            $date = date('Y-m-d', strtotime($date . ' -1 day'));
            $day = strtolower(date('l', strtotime($date)));
            $day3 = substr($day, 0, 3);
        }

        foreach ($bids_array as $key => $bids) {
            if (!isset($bids->game_id) || empty($bids->game_id) || !isset($bids->game_type) || empty($bids->game_type) || !isset($bids->session) || empty($bids->session) || !isset($bids->bid_points) || empty($bids->bid_points))
                return $this->withoutdata_res('Invailid data', 400);
            if ((!isset($bids->open_digit) && !isset($bids->close_digit) && !isset($bids->open_panna) && !isset($bids->close_panna)) || ($bids->open_digit == "" && $bids->close_digit == "" && $bids->open_panna == "" && $bids->close_panna == ""))
                return $this->withoutdata_res('Invailid data', 400);
            if ($bids->bid_points < $acc['minimum_bid_amount'] || $bids->bid_points > $acc['maximum_bid_amount']) return $this->withoutdata_res('Minimum bid points  ' . $acc['minimum_bid_amount'] . ' & Maximum bid points ' . $acc['maximum_bid_amount'], 400);
            $total_bid_points += $bids->bid_points;
            $whr_game  = [
                'conditions' => ['id' => $bids->game_id, 'status' => '1']
            ];
            $data_game = $this->GamesModel->first($whr_game);
            if (!$data_game) return $this->withoutdata_res('Game does not exist', 400);
            $whr_ses = [
                'conditions' => ['game_id' => $bids->game_id, $day => '1']
            ];
            $data_game_day = $this->GameMarketDayWise->first($whr_ses);
            if (!$data_game_day) return $this->withoutdata_res('Market closed', 400);
            if (!isset($data_game_day[$day3 . '_' . strtolower($bids->session)]) || time() > strtotime($date . ' ' . $data_game_day[$day3 . '_' . strtolower($bids->session)])) return $this->withoutdata_res('Session closed', 400);
        }
        if ($user['available_points'] < $total_bid_points) return $this->withoutdata_res('Insufficient points', 400);

        foreach ($bids_array as $key => $bids) {
            $bid_arr = ['user_id' => $user['id'], 'game_id' => $bids->game_id, 'game_type' => $bids->game_type, 'session' => $bids->session, 'open_panna' => $bids->open_panna, 'open_digit' => $bids->open_digit, 'close_panna' => $bids->close_panna, 'close_digit' => $bids->close_digit, 'bid_points' => $bids->bid_points, 'bidded_at' => Date('Y-m-d H:i:s')];
            $bid_place = $this->BidModel->save($bid_arr);
            $whr_arr_user  = [
                'conditions' => ['token' => $token]
            ];
            $userData = $this->UsersModel->first($whr_arr_user);
            if ($bid_place) {
                $current_points = $userData['available_points'] - $bids->bid_points;
                $trans_arr = ['user_id' => $user['id'], 'points' => $bids->bid_points, 'trans_type' => '9', 'trans_det' => $bid_place, 'trans_status' => 'SUCCESSFUL', 'admin_status' => 'APPROVED', 'created_at' => Date('Y-m-d H:i:s')];
                $update_arr_point = [
                    'available_points' => $current_points
                ];
                $whrr_user = ['token' => $token];
                $this->UsersModel->updateTable($update_arr_point, $whrr_user);
                $this->UserTransModel->save($trans_arr);
            }
        }



        if ($user) {
            $code = '100';
            $this->withoutdata_res("Bid successfully placed", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("error", $code);
        }
    }

    public function game_rate_list()
    {

        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }
        $token = $getHeaders['token'];
        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $user = $this->UsersModel->first($whr_arr);

        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $whr_arr  = [

            'fields' => ['id', 'name', 'cost_amount', 'earning_amount']
        ];
        $user = $this->GameRateModel->all($whr_arr);

        if ($user) {
            $code = '100';
            $this->response($user, "successfully fetched", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("Error", $code);
        }
    }

    public function how_to_play()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }
        $token = $getHeaders['token'];
        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $user = $this->UsersModel->first($whr_arr);

        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $whr_arr  = [
            'fields' => ['how_to_play']
        ];
        $user = $this->PagesModel->all($whr_arr);

        if ($user) {
            $code = '100';
            $this->response($user[0]['how_to_play'], "successfully fetched", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("Error", $code);
        }
    }

    public function app_details()
    {
        $whr_arr  = [
            'conditions' => ['option_category' => 'contact_details'],
            'fields' => ['option_key', 'option_value']
        ];
        $con = $this->SettingsModel->all($whr_arr);
        $contact_details = [];
        foreach ($con as $key => $det) {
            $contact_details[$det['option_key']] = $det['option_value'];
        }


        $whr_arr  = [
            'conditions' => ['option_category' => 'banner_image'],
            'fields' => ['option_key', 'option_value']
        ];
        $banner = $this->SettingsModel->all($whr_arr);
        $banner_image = [];
        foreach ($banner as $key => $img) {

            $img_bnr = ($img['option_value']);
            $decoded = $this->decodeBase64Image($img_bnr, 'setting/');
            // $decode  = base64_decode($img['option_value']);

            // _ddd($decoded);
            $full_path_decode = SITE_URL . "uploads/setting/" . $decoded;

            $banner_image[$img['option_key']] = $img_bnr;
        }


        $whr_mar  = [
            'conditions' => ['option_key' => 'banner_marquee'],
            'fields' => ['option_value']
        ];
        $mar = $this->SettingsModel->all($whr_mar);

        $data = ['banner_marquee' => $mar[0]['option_value'], 'contact_details' => $contact_details, 'banner_image' => $banner_image];


        if ($data) {
            $code = '100';
            $this->response($data, "successfully fetched", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("Error", $code);
        }
    }


    //starline game
    public function starline_game()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        $token    = $getHeaders['token'];
        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $user = $this->UsersModel->first($whr_arr);
        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $whr_arr  = [
            'fields' => ['name', 'cost_amount', 'earning_amount']
        ];
        $con = $this->StarlineGameRateModel->all($whr_arr);

        $whracc  = [
            'conditions' => ['id' => 1],
            'fields' => ['market_open_time']
        ];
        $accSetting = $this->AccountModel->first($whracc);

        $whr_list_arr  = [
            'conditions' => ['status' => '1'],
            'fields' => ['name', 'time', 'id'],
            'order' => ['by' => 'time', 'type' => 'ASC']
        ];


        $data_game = $this->StarlineGamesModel->all($whr_list_arr);
        $currentTimeStamp = time();
        $date = date('Y-m-d', $currentTimeStamp);
        $time = date('H:i:s', $currentTimeStamp);
        $day = strtolower(date('l', $currentTimeStamp));
        $day3 = substr($day, 0, 3);

        $marketTime = strtotime($accSetting['market_open_time']);
        $currentTime = strtotime($time);
        if ($currentTime < $marketTime) {
            $date = date('Y-m-d', strtotime($date . ' -1 day'));
            $day = strtolower(date('l', strtotime($date)));
            $day3 = substr($day, 0, 3);
        }

        $start_date = $date . " 00:00:00";
        $end_date = $date . " 23:59:59";

        foreach ($data_game as $key => $game) {

            $whr_list_arr  = [
                'conditions' => ['game_id' => $data_game[$key]['id']],
                'fields' => ['panna', 'digit', 'date']
            ];

            $whr_list_arr['conditions']['date>'] = $start_date;
            $whr_list_arr['conditions']['date<'] = $end_date;

            $star_result = $this->StarlineResultsModel->first($whr_list_arr);
            if ($star_result) {
                $data_game[$key]["result"] = $star_result['panna'] . '-' . $star_result['digit'];
            } else {
                $data_game[$key]["result"] = '***-*';
            }


            if (time() < strtotime($date . ' ' . $data_game[$key]['time'])) {
                $data_game[$key]["play"] = true;
            } else {
                $data_game[$key]["play"] = false;
            }
            unset($data_game[$key]['time']);
        }

        $data = ['starline_chart' => Starline_Chart, 'starline_rates' => $con, 'starline_game' => $data_game];
        if ($data) {
            $code = '100';
            $this->response($data, "successfully fetched", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("No Game Available", $code);
        }
    }

    //starline place bid
    public function starline_place_bid()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }
        if (!isset($_REQUEST['game_bids']) || empty($_REQUEST['game_bids'])) {
            return $this->withoutdata_res('Please select game bids', 400);
        }

        $token = $getHeaders['token'];
        $game_bids = $_REQUEST['game_bids'];

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $user = $this->UsersModel->first($whr_arr);

        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $game_bids_array = json_decode($game_bids);
        if (!isset($game_bids_array->bids) || empty($game_bids_array->bids)) {
            return $this->withoutdata_res('Invailid data', 400);
        }
        $bids_array = $game_bids_array->bids;
        $total_bid_points = 0;

        $currentTimeStamp = time();
        $date = date('Y-m-d', $currentTimeStamp);
        $time = date('H:i:s', $currentTimeStamp);
        $day = strtolower(date('l', $currentTimeStamp));
        $day3 = substr($day, 0, 3);

        $whr_acc  = [
            'conditions' => ['id' => 1],
            'fields' => ['minimum_bid_amount', 'maximum_bid_amount', 'market_open_time']
        ];
        $acc = $this->AccountModel->first($whr_acc);

        $marketTime = strtotime($acc['market_open_time']);
        $currentTime = strtotime($time);

        if ($currentTime < $marketTime) {
            $date = date('Y-m-d', strtotime($date . ' -1 day'));
            $day = strtolower(date('l', strtotime($date)));
            $day3 = substr($day, 0, 3);
        }

        foreach ($bids_array as $key => $bids) {
            if (!isset($bids->game_id) || empty($bids->game_id) || !isset($bids->game_type) || empty($bids->game_type) || !isset($bids->bid_points) || empty($bids->bid_points))
                return $this->withoutdata_res('Invailid data', 400);
            if ((!isset($bids->digit) && !isset($bids->panna)) || ($bids->digit == "" && $bids->panna == "")) {
                return $this->withoutdata_res('Invailid data', 400);
            }
            if ($bids->bid_points < $acc['minimum_bid_amount'] || $bids->bid_points > $acc['maximum_bid_amount']) return $this->withoutdata_res('Minimum bid points  ' . $acc['minimum_bid_amount'] . ' & Maximum bid points ' . $acc['maximum_bid_amount'], 400);
            $total_bid_points += $bids->bid_points;
            $whr_game  = [
                'conditions' => ['id' => $bids->game_id, 'status' => '1']
            ];
            $data_game = $this->StarlineGamesModel->first($whr_game);
            if (!$data_game) return $this->withoutdata_res('Game does not exist', 400);
            // $whr_ses = [
            //     'conditions' => ['game_id'=>$bids->game_id,$day=>'1']
            // ];
            // $data_game = $this->GameMarketDayWise->first($whr_ses);
            // if(!$data_game) return $this->withoutdata_res('Market closed', 400);
            if (time() > strtotime($date . ' ' . $data_game['time'])) return $this->withoutdata_res('Session closed', 400);
        }
        if ($user['available_points'] < $total_bid_points) return $this->withoutdata_res('Insufficient points', 400);

        foreach ($bids_array as $key => $bids) {
            $bid_arr = ['user_id' => $user['id'], 'game_id' => $bids->game_id, 'game_type' => $bids->game_type, 'panna' => $bids->panna, 'digit' => $bids->digit, 'bid_points' => $bids->bid_points, 'bidded_at' => Date('Y-m-d H:i:s')];
            $bid_place = $this->StarlineBidModel->save($bid_arr);
            $whr_arr_user  = [
                'conditions' => ['token' => $token]
            ];
            $userData = $this->UsersModel->first($whr_arr_user);
            if ($bid_place) {
                $current_points = $user['available_points'] - $bids->bid_points;
                $trans_arr = ['user_id' => $user['id'], 'points' => $bids->bid_points, 'trans_type' => '19', 'trans_det' => $bid_place, 'trans_status' => 'SUCCESSFUL', 'admin_status' => 'APPROVED', 'created_at' => Date('Y-m-d H:i:s')];
                $update_arr_point = [
                    'available_points' => $current_points
                ];
                $whrr_user = ['token' => $token];
                $this->UsersModel->updateTable($update_arr_point, $whrr_user);
                $this->UserTransModel->save($trans_arr);
            }
        }
        if ($user) {
            $code = '100';
            $this->withoutdata_res("bid successfully placed", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("error", $code);
        }
    }

    //starline bid history
    public function starline_bid_history()
    {

        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }
        $token = $getHeaders['token'];
        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $user = $this->UsersModel->first($whr_arr);

        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $par['conditions']['user_id'] = $user['id'];
        if (isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date'])) {
            $par['conditions']['bidded_at>='] = $_REQUEST['from_date'];
        }
        if (isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date'])) {
            $par['conditions']['bidded_at<='] = $_REQUEST['to_date'];
        }

        $par['fields'] = ['game_id', 'game_type', 'digit', 'panna', 'bid_points', 'bidded_at'];
        $par['order'] = ['by' => 'id', 'type' => 'DESC'];
        $acc = $this->StarlineBidModel->all($par);
        foreach ($acc as $key => $val) {
            $whrgamearr  = [
                'conditions' => ['id' => $val['game_id']]
            ];
            $game = $this->StarlineGamesModel->first($whrgamearr);

            $acc[$key]['game_name'] = $game['name'];
        }


        if ($acc) {
            $code = '100';
            $this->response($acc, "successfully fetched", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("No Record Found", $code);
        }
    }

    //starline win history
    public function starline_win_history()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }
        $token = $getHeaders['token'];
        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $user = $this->UsersModel->first($whr_arr);

        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $par['conditions']['user_id'] = $user['id'];
        $par['conditions']['won'] = 1;
        if (isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date'])) {
            $par['conditions']['bidded_at>='] = $_REQUEST['from_date'];
        }
        if (isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date'])) {
            $par['conditions']['bidded_at<='] = $_REQUEST['to_date'];
        }

        $par['fields'] = ['game_id', 'game_type', 'digit', 'panna', 'bid_points', 'win_points', 'bidded_at', 'won_at'];
        $par['order'] = ['by' => 'id', 'type' => 'DESC'];
        //print_r($par); die();
        $acc = $this->StarlineBidModel->all($par);
        foreach ($acc as $key => $val) {
            $whrgamearr  = [
                'conditions' => ['id' => $val['game_id']]
            ];
            $game = $this->StarlineGamesModel->first($whrgamearr);

            $acc[$key]['game_name'] = $game['name'];
        }


        if ($acc) {
            $code = '100';
            $this->response($acc, "successfully fetched", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("No Record Found", $code);
        }
    }

    //gali disawar


    //gali disawar game
    public function gali_disawar_game()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        $token    = $getHeaders['token'];
        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $user = $this->UsersModel->first($whr_arr);
        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $whr_arr  = [
            'fields' => ['name', 'cost_amount', 'earning_amount']
        ];
        $con = $this->GalidisawarGameRateModel->all($whr_arr);

        $whracc  = [
            'conditions' => ['id' => 1],
            'fields' => ['market_open_time']
        ];
        $accSetting = $this->AccountModel->first($whracc);

        $whr_list_arr  = [
            'conditions' => ['status' => '1'],
            'fields' => ['name', 'time', 'id'],
            'order' => ['by' => 'time', 'type' => 'ASC']
        ];
        $data_game = $this->GalidisawarGameModel->all($whr_list_arr);
        $currentTimeStamp = time();
        $date = date('Y-m-d', $currentTimeStamp);
        $time = date('H:i:s', $currentTimeStamp);
        $day = strtolower(date('l', $currentTimeStamp));
        $day3 = substr($day, 0, 3);

        $marketTime = strtotime($accSetting['market_open_time']);
        $currentTime = strtotime($time);
        if ($currentTime < $marketTime) {
            $date = date('Y-m-d', strtotime($date . ' -1 day'));
            $day = strtolower(date('l', strtotime($date)));
            $day3 = substr($day, 0, 3);
        }

        $start_date = $date . " 00:00:00";
        $end_date = $date . " 23:59:59";

        foreach ($data_game as $key => $game) {

            $whr_list_arr  = [
                'conditions' => ['game_id' => $data_game[$key]['id']],
                'fields' => ['left_digit', 'right_digit', 'date']
            ];

            $whr_list_arr['conditions']['date>'] = $start_date;
            $whr_list_arr['conditions']['date<'] = $end_date;

            $star_result = $this->GalidisawarResultModel->first($whr_list_arr);
            if ($star_result) {
                $data_game[$key]["result"] = $star_result['left_digit'] . '-' . $star_result['right_digit'];
            } else {
                $data_game[$key]["result"] = '**';
            }


            if (time() < strtotime($date . ' ' . $data_game[$key]['time'])) {
                $data_game[$key]["play"] = true;
            } else {
                $data_game[$key]["play"] = false;
            }
            $data_game[$key]['time'] = date('h:i A', strtotime($game['time']));
        }

        $data = ['gali_disawar_chart' => GaliDesawar_Chart, 'gali_disawar_rates' => $con, 'gali_disawar_game' => $data_game];
        if ($data) {
            $code = '100';
            $this->response($data, "successfully fetched", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("No Game Available", $code);
        }
    }

    //gali disawar place bid
    public function gali_disawar_place_bid()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }
        if (!isset($_REQUEST['game_bids']) || empty($_REQUEST['game_bids'])) {
            return $this->withoutdata_res('Please select game bids', 400);
        }

        $token = $getHeaders['token'];
        $game_bids = $_REQUEST['game_bids'];

        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $user = $this->UsersModel->first($whr_arr);

        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $game_bids_array = json_decode($game_bids);
        if (!isset($game_bids_array->bids) || empty($game_bids_array->bids)) {
            return $this->withoutdata_res('Invailid data', 400);
        }
        $bids_array = $game_bids_array->bids;
        $total_bid_points = 0;

        $currentTimeStamp = time();
        $date = date('Y-m-d', $currentTimeStamp);
        $time = date('H:i:s', $currentTimeStamp);
        $day = strtolower(date('l', $currentTimeStamp));
        $day3 = substr($day, 0, 3);

        $whr_acc  = [
            'conditions' => ['id' => 1],
            'fields' => ['minimum_bid_amount', 'maximum_bid_amount', 'market_open_time']
        ];
        $acc = $this->AccountModel->first($whr_acc);

        $marketTime = strtotime($acc['market_open_time']);
        $currentTime = strtotime($time);

        if ($currentTime < $marketTime) {
            $date = date('Y-m-d', strtotime($date . ' -1 day'));
            $day = strtolower(date('l', strtotime($date)));
            $day3 = substr($day, 0, 3);
        }

        foreach ($bids_array as $key => $bids) {
            if (!isset($bids->game_id) || empty($bids->game_id) || !isset($bids->game_type) || empty($bids->game_type) || !isset($bids->bid_points) || empty($bids->bid_points))
                return $this->withoutdata_res('Invailid data', 400);
            if ((!isset($bids->left_digit) && !isset($bids->right_digit)) || ($bids->left_digit == "" && $bids->right_digit == "")) {
                return $this->withoutdata_res('Invailid data', 400);
            }
            if ($bids->bid_points < $acc['minimum_bid_amount'] || $bids->bid_points > $acc['maximum_bid_amount']) return $this->withoutdata_res('Minimum bid points  ' . $acc['minimum_bid_amount'] . ' & Maximum bid points ' . $acc['maximum_bid_amount'], 400);
            $total_bid_points += $bids->bid_points;
            $whr_game  = [
                'conditions' => ['id' => $bids->game_id, 'status' => '1']
            ];
            $data_game = $this->GalidisawarGameModel->first($whr_game);
            if (!$data_game) return $this->withoutdata_res('Game does not exist', 400);
            // $whr_ses = [
            //     'conditions' => ['game_id'=>$bids->game_id,$day=>'1']
            // ];
            // $data_game = $this->GameMarketDayWise->first($whr_ses);
            // if(!$data_game) return $this->withoutdata_res('Market closed', 400);
            if (time() > strtotime($date . ' ' . $data_game['time'])) return $this->withoutdata_res('Session closed', 400);
        }
        if ($user['available_points'] < $total_bid_points) return $this->withoutdata_res('Insufficient points', 400);

        foreach ($bids_array as $key => $bids) {
            $bid_arr = ['user_id' => $user['id'], 'game_id' => $bids->game_id, 'game_type' => $bids->game_type, 'left_digit' => $bids->left_digit, 'right_digit' => $bids->right_digit, 'bid_points' => $bids->bid_points, 'bidded_at' => Date('Y-m-d H:i:s')];
            $bid_place = $this->GalidisawarBidModel->save($bid_arr);
            $whr_arr_user  = [
                'conditions' => ['token' => $token]
            ];
            $userData = $this->UsersModel->first($whr_arr_user);
            if ($bid_place) {
                $current_points = $user['available_points'] - $bids->bid_points;
                $trans_arr = ['user_id' => $user['id'], 'points' => $bids->bid_points, 'trans_type' => '21', 'trans_det' => $bid_place, 'trans_status' => 'SUCCESSFUL', 'admin_status' => 'APPROVED', 'created_at' => Date('Y-m-d H:i:s')];
                $update_arr_point = [
                    'available_points' => $current_points
                ];
                $whrr_user = ['token' => $token];
                $this->UsersModel->updateTable($update_arr_point, $whrr_user);
                $this->UserTransModel->save($trans_arr);
            }
        }
        if ($user) {
            $code = '100';
            $this->withoutdata_res("bid successfully placed", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("error", $code);
        }
    }

    //gali disawar bid history
    public function gali_disawar_bid_history()
    {

        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }
        $token = $getHeaders['token'];
        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $user = $this->UsersModel->first($whr_arr);

        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $par['conditions']['user_id'] = $user['id'];
        if (isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date'])) {
            $par['conditions']['bidded_at>='] = $_REQUEST['from_date'];
        }
        if (isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date'])) {
            $par['conditions']['bidded_at<='] = $_REQUEST['to_date'];
        }

        $par['fields'] = ['game_id', 'game_type', 'left_digit', 'right_digit', 'bid_points', 'bidded_at'];
        $par['order'] = ['by' => 'id', 'type' => 'DESC'];
        $acc = $this->GalidisawarBidModel->all($par);
        foreach ($acc as $key => $val) {
            $whrgamearr  = [
                'conditions' => ['id' => $val['game_id']]
            ];
            $game = $this->GalidisawarGameModel->first($whrgamearr);

            $acc[$key]['game_name'] = $game['name'];
        }


        if ($acc) {
            $code = '100';
            $this->response($acc, "successfully fetched", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("No Record Found", $code);
        }
    }

    //gali disawar win history
    public function gali_disawar_win_history()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }
        $token = $getHeaders['token'];
        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $user = $this->UsersModel->first($whr_arr);

        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $par['conditions']['user_id'] = $user['id'];
        $par['conditions']['won'] = 1;
        if (isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date'])) {
            $par['conditions']['bidded_at>='] = $_REQUEST['from_date'];
        }
        if (isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date'])) {
            $par['conditions']['bidded_at<='] = $_REQUEST['to_date'];
        }

        $par['fields'] = ['game_id', 'game_type', 'left_digit', 'right_digit', 'bid_points', 'win_points', 'bidded_at', 'won_at'];
        $par['order'] = ['by' => 'id', 'type' => 'DESC'];
        //print_r($par); die();
        $acc = $this->GalidisawarBidModel->all($par);
        foreach ($acc as $key => $val) {
            $whrgamearr  = [
                'conditions' => ['id' => $val['game_id']]
            ];
            $game = $this->GalidisawarGameModel->first($whrgamearr);

            $acc[$key]['game_name'] = $game['name'];
        }


        if ($acc) {
            $code = '100';
            $this->response($acc, "successfully fetched", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("No Record Found", $code);
        }
    }

    // get token
    public function getToken()
    {
        if (!isset($_REQUEST['mobile']) || empty($_REQUEST['mobile'])) {
            return $this->withoutdata_res('Please select mobile', 400);
        }

        $mobile = $_REQUEST['mobile'];

        $whr_arr  = [
            'conditions' => ['mobile' => $mobile]
        ];
        $user = $this->UsersModel->first($whr_arr);
        if ($user) {
            $this->withoutdata_res($user['token'], 100);
        }
    }

    //apk url
    public function apk_url()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }
        $token = $getHeaders['token'];
        $whr_arr  = [
            'conditions' => ['token' => $token]
        ];
        $user = $this->UsersModel->first($whr_arr);

        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }


        $par['conditions'] = ['id' => 1];
        $par['fields'] = ['apk'];
        $acc = $this->AccountModel->first($par);

        if ($acc) {
            $code = '100';
            $this->response($acc['apk'], "successfully fetched", $code);
        } else {
            $code = '400';
            $this->withoutdata_res("No Record Found", $code);
        }
    }

    // top 10 recent winners
    public function top_winners()
    {
        $getHeaders = apache_request_headers();
        if (!isset($getHeaders['token']) || empty($getHeaders['token'])) {
            return $this->withoutdata_res('Please select token', 505);
        }

        $token = $getHeaders['token'];
        $whr_arr  = ['conditions' => ['token' => $token]];
        $user = $this->UsersModel->first($whr_arr);

        if (empty($user) or $user['is_login'] == '0') {
            return $this->withoutdata_res('Please login first', 505);
        }

        $names = [
            'Arjun', 'Rahul', 'Vivek', 'Suresh', 'Amit', 'Deepak', 'Karan', 'Sumit', 'Vijay', 'Rohit', 
            'Ankit', 'Manoj', 'Rishi', 'Aman', 'Sanjay', 'Vikram', 'Aditya', 'Harsh', 'Mohit', 'Pankaj', 
            'Abhishek', 'Ravi', 'Sunil', 'Pradeep', 'Ashok', 'Gaurav', 'Yash', 'Aryan', 'Sahil', 'Varun',
            'Neha', 'Priya', 'Anjali', 'Sneha', 'Rishabh', 'Ishan', 'Kavita', 'Suman', 'Tushar', 'Yogesh',
            'Tarun', 'Anshul', 'Mayank', 'Saurabh', 'Lokesh', 'Piyush', 'Ishani', 'Riya', 'Nikita', 'Mitali'
        ];
        
        $games = [
            'Kalyan', 'Milan Day', 'Milan Night', 'Rajdhani Day', 'Rajdhani Night', 
            'Main Bazaar', 'Time Bazar', 'Madhur Day', 'Madhur Night', 'Sridevi', 
            'Supreme Day', 'Kalyan Night'
        ];

        // Pairing specific prices with game types as requested
        $rates = [
            'Single Digit' => '100',
            'Jodi Digit'   => '1000',
            'Single Panna' => '1600',
            'Double Panna' => '3200',
            'Triple Panna' => '7000',
            'Half Sangam'  => '10000'
        ];
        
        $types = array_keys($rates);
        $result = [];
        
        // Generate between 50 to 100 users
        // $total_users = rand(50, 100);
        
        for ($i = 0; $i < 10; $i++) {
            $rawName = $names[array_rand($names)];
            $visible = substr($rawName, 0, 2);
            if ($visible === false) {
                $visible = '';
            }
            $visible = str_pad($visible, 2, 'X');
            $username = $visible . '*' . rand(0, 9);

            $type = $types[array_rand($types)];
            $baseAmount = (int) $rates[$type];

            $multiplier = rand(2, 5);
            $amountDisplay = (string) ($baseAmount * $multiplier);

            $game = $games[array_rand($games)];

            $result[] = [
                'username' => $username,
                'win_amount' => $amountDisplay,
                'game_name' => $game,
                'game_type' => $type
            ];
        }

        if (!empty($result)) {
            shuffle($result); // Randomize order
            $this->response($result, "Top winners successfully fetched", "100");
        } else {
            $this->withoutdata_res("No Record Found", "400");
        }
    }
}
