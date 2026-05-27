<?php defined('BASEPATH') or exit('No direct script access allowed');
/** Load Category Pages & Queries */
class AutoResult extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
         flash_message(
             'dashboard/login',
             is_login(),
             'unsuccess',
             'Please Login Then Try Again'
         );

        $this->load->model(['AccountModel','ResultsModel', 'GamesModel','BidModel','GameRateModel','UserTransModel','UsersModel','NotificationModel','GameMarketDayWise', 'NotificationsSentModel']);
        $this->load->helper('send'); // loads sendResultNotificationOneSignal()
    }


    /** Load Default Index To Show 404 Error
     *
     * @return void */
    public function index()
    {
        return show_404();
    }
    
    public function check_result(){
        $chk = array();
        $date = $_POST['from_date'];
        $session = $_POST['session'];
        $game_id = $_POST['game_id'];
        $start_date = ("$date 00:00:00");
        $end_date = ("$date 23:59:59");
        
        $result = $this->ResultsModel->first([
            'conditions' => ['decleared_at>=' => $start_date,'decleared_at<=' => $end_date,'game_id'=>$game_id],
        ]);
        if($result){
            if ($session == "Open"){
                $chk['panna'] = $result['open_panna'];
                $chk['digit'] = $result['open_digit'];
            }
            if ($session == "Close" && $result['close_panna']!='***'){
                $chk['panna'] = $result['close_panna'];
                $chk['digit'] = $result['close_digit'];
            }
        }
        echo json_encode($chk);
    }
    
    public function fetch_result(){
        $chk = array();
        $date = $_POST['from_date_declare'];
        $start_date = ("$date 00:00:00");
        $end_date = ("$date 23:59:59");
        $day = strtolower(date('l'));
        $day3 = substr($day,0,3);
        
        $result = $this->ResultsModel->all([
            'conditions' => ['decleared_at>=' => $start_date,'decleared_at<=' => $end_date],
            'order' => ['by' => 'id', 'type' => 'DESC']
        ]);
        foreach($result as $resultKey => $resultData){
            $data_game = $this->GamesModel->first([ 'conditions' => ['id'   => $resultData['game_id']] ]);
            $whr_day  = [
                'conditions' => ['game_id' => $resultData['game_id']],
                'fields' => [$day, $day3.'_open', $day3.'_close'],
            ];
            $day_market = $this->GameMarketDayWise->first($whr_day);
            $result[$resultKey]['game_name'] = $data_game['name'];
            $result[$resultKey]['open_time'] = date('h:i A', strtotime($day_market[$day3.'_open']));
            $result[$resultKey]['close_time'] = date('h:i A', strtotime($day_market[$day3.'_close']));
        }
        echo json_encode($result);
    }


    public function show_win_ajax()
    {
        $chk =array();
        $date = $_POST['win_from_date'];
        $panna = $_POST['win_pana'];
        $digit = $_POST['win_result_new'];
        $session = $_POST['win_session']; 
        $game_id = $_POST['win_game_id'];
        
        $start_date = ("$date 00:00:00");
        $end_date = ("$date 23:59:59");
            if($session=="Open"){
                $jobs_wc = ['conditions' => "  (`game_type` = 'single_digit' OR `game_type` = 'single_panna' OR `game_type` = 'double_panna' OR `game_type` = 'triple_panna') AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = '$session' AND (`open_panna` = '$panna' OR `open_digit` = '$digit') "];
                $chk = $this->BidModel->all($jobs_wc);
                
                foreach($chk as $key=>$val)
                {
                    
                    $data_bid_user = $this->UsersModel->first([ 'conditions' => ['id'   => $val['user_id']] ]);
                    $data_game = $this->GamesModel->first([ 'conditions' => ['id'   => $val['game_id']] ]);
                    $game_type_bid = $this->GameRateModel->first(['conditions' => ['name' => $val['game_type']]]);
                    
                    $chk[$key]['mobile'] = $data_bid_user['mobile'];
                    $chk[$key]['username'] = $data_bid_user['username'];
                    $chk[$key]['game_name'] = $data_game['name'];
                    $chk[$key]['bidded_at'] = ($val['bidded_at']) ? date("d-m-Y", strtotime($val['bidded_at'])): date("d-m-Y");
                    $chk[$key]['game_type'] = ucwords(str_replace('_',' ',$val['game_type']));
                    $chk[$key]['open_panna'] = ($val['open_panna']) ? $val['open_panna']: 'N/A';
                    $chk[$key]['open_digit'] = ($val['open_digit']) ? $val['open_digit']: 'N/A';
                    $chk[$key]['close_panna'] = ($val['close_panna']) ? $val['close_panna']: 'N/A';
                    $chk[$key]['close_digit'] = ($val['close_digit']) ? $val['close_digit']: 'N/A';
                    $chk[$key]['win_points'] = ($val['bid_points'] * $game_type_bid['per_point_earning_amount']);
        
                }
            }
            else{
                $fet_result = $this->ResultsModel->first(['conditions' => ['game_id' => $game_id, 'decleared_at>=' => $start_date,'decleared_at<=' => $end_date]]);
                $fet_open_panna =$fet_result['open_panna']; 
                $fet_open_digit = $fet_result['open_digit']; 
                $chk = array();
                
                $job_close = ['conditions' => "  (`game_type` = 'single_digit' OR `game_type` = 'single_panna' OR `game_type` = 'double_panna' OR `game_type` = 'triple_panna') AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = '$session' AND (`close_panna` = '$panna' OR `close_digit` = '$digit') "];
                $data_close_bid = $this->BidModel->all($job_close);
                $chk = $data_close_bid;
                
                $job_jodi = ['conditions' => "`game_type` = 'jodi_digit' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `open_digit` = '$fet_open_digit' AND `close_digit` = '$digit' "];
                $data_close_jodi = $this->BidModel->all($job_jodi);
                $chk = array_merge($chk,$data_close_jodi);
                
                $job_full_sangam = ['conditions' => "`game_type` = 'full_sangam' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `open_panna` = '$fet_open_panna' AND `close_panna` = '$panna' "];
                $data_close_fs = $this->BidModel->all($job_full_sangam);
                $chk = array_merge($chk,$data_close_fs);
                
                $job_open_hs = ['conditions' => "`game_type` = 'half_sangam' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = 'Open' AND`open_digit` = '$fet_open_digit' AND `close_panna` = '$panna' "];
                $data_open_hs = $this->BidModel->all($job_open_hs);
                $chk = array_merge($chk,$data_open_hs);
                
                $job_close_hs = ['conditions' => "`game_type` = 'half_sangam' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = 'Close' AND`open_panna` = '$fet_open_panna' AND `close_digit` = '$digit' "];
                $data_close_hs = $this->BidModel->all($job_close_hs);
                $chk = array_merge($chk,$data_close_hs);
                
                foreach($chk as $key=>$val)
                    {
                        $game_type = $this->GameRateModel->first(['conditions' => ['name' => $val['game_type']]]);
                        $data_user = $this->UsersModel->first(['conditions' => ['id' => $val['user_id']]]);
                        $data_game = $this->GamesModel ->first(['conditions' => ['id' => $game_id]]);
                        $chk[$key]['win_amount'] = ($val['bid_points'] * $game_type['per_point_earning_amount']);
                        $chk[$key]['username'] = $data_user['username'];
                        $chk[$key]['mobile'] = $data_user['mobile'];
                        $chk[$key]['game_name'] = $data_game['name'];
                        $chk[$key]['game_type'] = ucwords(str_replace('_',' ',$val['game_type']));
                        $chk[$key]['open_panna'] = ($val['open_panna']) ? $val['open_panna']: 'N/A';
                        $chk[$key]['open_digit'] = ($val['open_digit']) ? $val['open_digit']: 'N/A';
                        $chk[$key]['close_panna'] = ($val['close_panna']) ? $val['close_panna']: 'N/A';
                        $chk[$key]['close_digit'] = ($val['close_digit']) ? $val['close_digit']: 'N/A';
                        $chk[$key]['bidded_at'] = ($val['bidded_at']) ? date("d-m-Y", strtotime($val['bidded_at'])): date("d-m-Y");
                    }
            }
               
            
        echo json_encode($chk);
        
    }
    
    public function declare_ajax()
    {
        $chk =array();
        $date = $_POST['from_date_declare'];
        $game_id = $_POST['game_id_declare'];
        $panna = $_POST['pana_declare'];
        $digit = $_POST['result_new_declare'];
        $session = $_POST['session_declare']; 
        $result_date = $date." ".date('H:i:s');
            
            $start_date = ("$date 00:00:00");
            $end_date = ("$date 23:59:59");
            $result = $this->ResultsModel->first([
                'conditions' => ['decleared_at>=' => $start_date,'decleared_at<=' => $end_date,'game_id'=>$game_id],
            ]);
            if (!empty($result)) {
                if ($session == "Open") {
                    if ($result['open_panna'] == "***" || $result['open_panna'] == "") {
                        $rate = $this->ResultsModel->updateTable([
                            'open_panna'                 => $panna,
                            'open_digit'                => $digit
                        ], ['id' => $result['id']]);
                        
                        if($rate)
                        {
                            $game = $this->GamesModel->first(['conditions' => ['id' =>$game_id]]);
                            // ✅ FIX: OneSignal broadcast replaces deprecated FCM loop
                            $title = ($game['name']);
                            $mes = ucfirst($session) . $panna . "-" . $digit;
                            // Check if already sent
                            $is_sent = $this->NotificationsSentModel->first(['result_id' => $result['id'], 'sent_type' => 'OPEN']);
                            if (!$is_sent) {
                                sendResultNotificationOneSignal($title, $mes, 'MANUAL_RESULT');
                                $this->NotificationsSentModel->save(['result_id' => $result['id'], 'sent_type' => 'OPEN']);
                            }
                             $Notification = $this->NotificationModel->save([
                                 'message'      => $mes,
                                 'heading'      => "[MANUAL] " . $title,
                                 'user_id'      => "all",
                                 'status'       => true,
                                 'created_date' => date('Y-m-d H:i:s')
                             ]);

                            $rate_win= ['conditions' => "  (`game_type` = 'single_digit' OR `game_type` = 'single_panna' OR `game_type` = 'double_panna' OR `game_type` = 'triple_panna') AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = '$session' AND (`open_panna` = '$panna' OR `open_digit` = '$digit') "];
                            $chk = $this->BidModel->all($rate_win);
                            foreach($chk as $key_con=>$val_con)
                            {
                                $game_type_bid = $this->GameRateModel->first(['conditions' => ['name' => $val_con['game_type']]]);
                                $win_point = ($val_con['bid_points'] * $game_type_bid['per_point_earning_amount']);
                                $user_id = $val_con['user_id'];
                                $arr = [
                                    'user_id' => $user_id,
                                    'points' => $win_point,
                                    'trans_type' => 5,
                                    'trans_status' => "SUCCESSFULL",
                                    'admin_status' => 'APPROVED',
                                    'trans_det' => $result['id']."M",
                                    'created_at' => date("Y-m-d H:i:s")
                                ];
                                $trans_save  = $this->UserTransModel->save($arr);
                                if($trans_save)
                                { 
                                    $whr_arr  = ['conditions' => ['id' => $user_id]];
                                    $user = $this->UsersModel->first($whr_arr);
                                    $data_game = $this->GamesModel ->first(['conditions' => ['id' => $game_id]]);
                                    $updated_points = $win_point + $user['available_points'];
                                    $update_arr = [ 'available_points' => $updated_points ];
                                    $whr_user = ['id' => $user_id];
                                    $updt_point_user = $this->UsersModel->updateTable($update_arr, $whr_user);
                                    $update_bid_arr = [ 'win_points' => $win_point,'won' => '1', 'result_id' => $arr['trans_det'], 'won_at'=>date("Y-m-d H:i:s")];
                                    $con_bid = ['id' => $val_con['id']];
                                    $update_bid = $this->BidModel->updateTable($update_bid_arr, $con_bid);
                                    $chk[$key_con]['win_amount'] = $win_point;
                                    $chk[$key_con]['user_name'] = $user['username'];
                                    $chk[$key_con]['user_mobile'] = $user['mobile'];
                                    $chk[$key_con]['game_name'] = $data_game['name'];
                                }
                            }
                        }
                        
                    } 
                } else {
                  if(($result['close_panna'] == "") OR ($result['close_panna'] == "***")) {
                        $result_id = $result['id'];
                        $rate = $this->ResultsModel->updateTable([
                            'close_panna'                 => $panna,
                            'close_digit'                => $digit
                        ], ['id' => $result['id']]);
                        if($rate)
                        {
                            $game = $this->GamesModel->first(['conditions' => ['id' =>$game_id]]);
                            // ✅ FIX: OneSignal broadcast replaces deprecated FCM loop
                            $title = ($game['name']);
                            $mes = ucfirst($session) . $panna . "-" . $digit;
                            // Check if already sent BOTH (since close is declared, we use BOTH)
                            $is_sent = $this->NotificationsSentModel->first(['result_id' => $result['id'], 'sent_type' => 'BOTH']);
                            if (!$is_sent) {
                                sendResultNotificationOneSignal($title, $mes, 'MANUAL_RESULT');
                                $this->NotificationsSentModel->save(['result_id' => $result['id'], 'sent_type' => 'BOTH']);
                            }
                             $Notification = $this->NotificationModel->save([
                                 'message'      => $mes,
                                 'heading'      => "[MANUAL] " . $title,
                                 'user_id'      => "all",
                                 'status'       => true,
                                 'created_date' => date('Y-m-d H:i:s')
                             ]);
                            
                            $fet_result = $this->ResultsModel->first(['conditions' => ['game_id' => $game_id, 'decleared_at>=' => $start_date,'decleared_at<=' => $end_date]]);
                            $fet_open_panna =$fet_result['open_panna']; 
                            $fet_open_digit = $fet_result['open_digit']; 
                            
                            $job_close = ['conditions' => "  (`game_type` = 'single_digit' OR `game_type` = 'single_panna' OR `game_type` = 'double_panna' OR `game_type` = 'triple_panna') AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = '$session' AND (`close_panna` = '$panna' OR `close_digit` = '$digit') "];
                            $data_close_bid = $this->BidModel->all($job_close);
                            $chk = $data_close_bid;
                            
                            $job_jodi = ['conditions' => "`game_type` = 'jodi_digit' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `open_digit` = '$fet_open_digit' AND `close_digit` = '$digit' "];
                            $data_close_jodi = $this->BidModel->all($job_jodi);
                            $chk = array_merge($chk,$data_close_jodi);
                            
                            $job_full_sangam = ['conditions' => "`game_type` = 'full_sangam' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `open_panna` = '$fet_open_panna' AND `close_panna` = '$panna' "];
                            $data_close_fs = $this->BidModel->all($job_full_sangam);
                            $chk = array_merge($chk,$data_close_fs);
                            
                            $job_open_hs = ['conditions' => "`game_type` = 'half_sangam' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = 'Open' AND `open_digit` = '$fet_open_digit' AND `close_panna` = '$panna' "];
                            $data_open_hs = $this->BidModel->all($job_open_hs);
                            $chk = array_merge($chk,$data_open_hs);
                            
                            $job_close_hs = ['conditions' => "`game_type` = 'half_sangam' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = 'Close' AND `open_panna` = '$fet_open_panna' AND `close_digit` = '$digit' "];
                            $data_close_hs = $this->BidModel->all($job_close_hs);
                            $chk = array_merge($chk,$data_close_hs);
                            
                            
                            foreach($chk as $key_con=>$val_con)
                            {
                                $game_type_bid = $this->GameRateModel->first(['conditions' => ['name' => $val_con['game_type']]]);
                                $win_point = ($val_con['bid_points'] * $game_type_bid['per_point_earning_amount']);
                                $user_id = $val_con['user_id'];
                                $arr = [
                                    'user_id' => $user_id,
                                    'points' => $win_point,
                                    'trans_type' => 5,
                                    'trans_status' => "SUCCESSFULL",
                                    'admin_status' => 'APPROVED',
                                    'trans_det' =>$result_id."M",
                                    'created_at' => date("Y-m-d H:i:s")
                                ];
                                $trans_save  = $this->UserTransModel->save($arr);
                                if($trans_save)
                                { 
                                    $whr_arr  = ['conditions' => ['id' => $user_id]];
                                    $user = $this->UsersModel->first($whr_arr);
                                    $data_game = $this->GamesModel ->first(['conditions' => ['id' => $game_id]]);
                                    $updated_points = $win_point + $user['available_points'];
                                    $update_arr =
                                        [
                                            'available_points' => $updated_points
                                        ];
                        
                                    $whr_user = ['id' => $user_id];
                                    $updt_point_user = $this->UsersModel->updateTable($update_arr, $whr_user);
                                    
                                    $update_bid_arr = [ 'win_points' => $win_point,'won' => '1', 'result_id' => $arr['trans_det'], 'won_at'=>date("Y-m-d H:i:s")];
                                    $con_bid = ['id' => $val_con['id']];
                                    $update_bid = $this->BidModel->updateTable($update_bid_arr, $con_bid);
                                    
                                    $chk[$key_con]['win_amount'] = $win_point;
                                    $chk[$key_con]['user_name'] = $user['username'];
                                    $chk[$key_con]['user_mobile'] = $user['mobile'];
                                    $chk[$key_con]['game_name'] = $data_game['name'];
                                }
                            }
                        }
                    }
                    
                }
            } else {
                if ($session == "Open") {
                    $rate = $this->ResultsModel->save([
                        'game_id'                    => $game_id,
                        'open_panna'                 => $panna,
                        'open_digit'                => $digit,
                        'close_panna'                 => "***",
                        'close_digit'                => "*",
                        'decleared_at'              => $result_date
                    ]);
                    if($rate)
                    {
                        $game = $this->GamesModel->first(['conditions' => ['id' =>$game_id]]);
                        // ✅ FIX: OneSignal broadcast replaces deprecated FCM loop
                        $title = ($game['name']);
                        $mes = ucfirst($session) . $panna . "-" . $digit;
                        sendResultNotificationOneSignal($title, $mes, 'MANUAL_RESULT');
                        $Notification = $this->NotificationModel->save([
                            'message'  => $mes,
                            'heading'  => "[MANUAL] " . $title,
                            'user_id'  => "all",
                            'status'   => true
                        ]);
               
              
                        $rate_win= ['conditions' => "  (`game_type` = 'single_digit' OR `game_type` = 'single_panna' OR `game_type` = 'double_panna' OR `game_type` = 'triple_panna') AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = '$session' AND (`open_panna` = '$panna' OR `open_digit` = '$digit') "];
                        $chk = $this->BidModel->all($rate_win);
                        foreach($chk as $key_con=>$val_con)
                        {
                            $game_type_bid = $this->GameRateModel->first(['conditions' => ['name' => $val_con['game_type']]]);
                            $win_point = ($val_con['bid_points'] * $game_type_bid['per_point_earning_amount']);
                            $user_id = $val_con['user_id'];
                            $arr = [
                                'user_id' => $user_id,
                                'points' => $win_point,
                                'trans_type' => 5,
                                'trans_status' => "SUCCESSFULL",
                                'admin_status' => 'APPROVED',
                                'trans_det' => $rate."M",
                                'created_at' => date("Y-m-d H:i:s")
                            ];
                            $trans_save  = $this->UserTransModel->save($arr);
                                
                            if($trans_save)
                            { 
                                $whr_arr  = ['conditions' => ['id' => $user_id]];
                                $user = $this->UsersModel->first($whr_arr);
                                $data_game = $this->GamesModel ->first(['conditions' => ['id' => $game_id]]);
                                $updated_points = $win_point + $user['available_points'];
                                $update_arr = [ 'available_points' => $updated_points ];
                                $whr_user = ['id' => $user_id];
                                $updt_point_user = $this->UsersModel->updateTable($update_arr, $whr_user);
                                $update_bid_arr = [ 'win_points' => $win_point,'won' => '1', 'result_id' => $arr['trans_det'], 'won_at'=>date("Y-m-d H:i:s")];
                                $con_bid = ['id' => $val_con['id']];
                                $update_bid = $this->BidModel->updateTable($update_bid_arr, $con_bid);
                                $chk[$key_con]['win_amount'] = $win_point;
                                $chk[$key_con]['user_name'] = $user['username'];
                                $chk[$key_con]['user_mobile'] = $user['mobile'];
                                $chk[$key_con]['game_name'] = $data_game['name'];
                            }
                         }
                    }
                    
                   
                } 
            }
        echo json_encode($chk);
           
    }
    
    /** Load List Page */
    public function list_result()
    {
        $chk = array();

        $games = [];
        $games = $this->GamesModel->all([
            'conditions' => ['status' => '1'],
        ]);

        $number = PANNA;
        $ratingsData = [];
        $ratingsData = $this->ResultsModel->all([
            'conditions' => ['decleared_at>' => Date('Y-m-d 00:00:00'),'decleared_at<' => Date('Y-m-d 23:59:59')],
        ]);

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('result/list', compact('ratingsData','games', 'number','chk'));
        $this->load->view('template/footer');
    }
  
    
    public function change_res($id)
    {
        
        $del_array = ['id' => $id];
        $delete_result = $this->ResultsModel->destroy($del_array);
        if($delete_result){
            $r_id = $id."M";
            $con_bid  = ['result_id' => $r_id]; 
            
            $update_bid_array = [ 'win_points' => '0','won'=>'0','result_id'=>'','won_at'=>'0000-00-00 00:00:00' ];
            $updt_bid = $this->BidModel->updateTable($update_bid_array, $con_bid);
            $trans_all = $this->UserTransModel->all(['conditions' => ['trans_det' => $r_id]]);
            $delete_sent = $this->NotificationsSentModel->destroy(['result_id' => $id]);
            foreach($trans_all as $key_tra =>$val_trans)
            {
                $whr_arr  = ['conditions' => ['id' => $val_trans['user_id']]];
                $user = $this->UsersModel->first($whr_arr);
                $updated_points = $user['available_points'] -  $val_trans['points'];
                $update_arr = [ 'available_points' => $updated_points];
                $whr_user = ['id' => $val_trans['user_id']];
                $updt_point_user = $this->UsersModel->updateTable($update_arr, $whr_user);
                $whr_dearr = [ 'id' => $val_trans['id'] ];
                $delete_tra = $this->UserTransModel->destroy($whr_dearr);
            }
        }
        flash_message(
            'list/result',
            $delete_result,
            'success',
            "Deleted Successfully"
        );
    }
    
    public function edit_bid_history($id)
    {
        if ($this->input->post('editbidHISresult')) {
            
            $open_panna = $_POST['open_panna'];
            $open_digit = $_POST['open_digit'];
            $close_panna = $_POST['close_panna'];
            $close_digit = $_POST['close_digit'];
            $game_type = $_POST['game_type'];
            $game_id = $_POST['game_id'];
            $bid_points = $_POST['bid_points'];
            
            $old_bid =   $this->BidModel->first([ 'conditions' => ['id'     => $id]]); 
            $old_bid_point = $old_bid['bid_points'];
            $user =   $this->UsersModel->first([ 'conditions' => [ 'id'     => $old_bid['user_id'] ]]);
            
            $game = $this->GamesModel->first(['conditions' => ['id' => $game_id]]);
            $open_time = $game['open_time'];
            $close_time = $game['close_time'];
            date_default_timezone_set("Asia/Kolkata");
            $current_time = date("H:i");
            $open_time_24 = date("H:i", strtotime($open_time));
            $close_time_24 = date("H:i", strtotime($close_time));

            if (($close_time_24 >= $current_time) and ($current_time >= $open_time_24)) {
                $m_stts = '1';
            } else {
                $m_stts = '2';
            }
            if($bid_points==$old_bid_point){
                    $rate = $this->BidModel->updateTable([
                        'open_digit'                      => $open_digit,
                        'open_panna'                      => $open_panna,
                        'close_panna'                      => $close_panna,
                        'close_digit'                      => $close_digit
                    ], ['id' => $id]);
                    
            }else{
                
                $rate = $this->BidModel->updateTable([
                    'open_digit'                      => $open_digit,
                    'open_panna'                      => $open_panna,
                    'close_panna'                      => $close_panna,
                    'close_digit'                      => $close_digit,
                    'bid_points'                    =>$bid_points
                ], ['id' => $id]);
                
                $u_id = $user['id'];
                $trans_con = [ 'conditions'=>"(`trans_type`='9')  AND `user_id`='$u_id'  AND `trans_det`='$id'"];
                $transdata = $this->UserTransModel->first($trans_con);
                $transdata_point_update = $this->UserTransModel->updateTable(['points'  => $bid_points], ['id' => $transdata['id']]);
                $main_diff_points = $old_bid_point - $bid_points;
                $total_points = $user['available_points'];
                $upd_point = $total_points + $main_diff_points;
                $user_point_update = $this->UsersModel->updateTable([ 'available_points' => $upd_point,], ['id' => $user['id']]);
                
            }

           
            // _ddd($vehicles);

            flash_message(
                'edit/result/' . $id,
                $rate,
                'unsuccess',
                "Something Went Wrong"
            );

            flash_message(
                'list/result',
                $rate,
                'success',
                "Bid Updated Successfully"
            );
        }


        $ratingssssData = '';
        $bidData = array();
        $ratingssssData = $this->BidModel->first([ 'conditions' => [ 'id'     => $id ] ]);
        
        
        
        
        
        $ratingssssData['game_type'] = ucwords(str_replace('_',' ',$ratingssssData['game_type']));
        
        if($ratingssssData)
        {
            $user =   $this->UsersModel->first([ 'conditions' => [ 'id'     => $ratingssssData['user_id'], ] ]); 
            $ratingssssData['username']= $user['username'];
            
            $gameData =   $this->GamesModel->first([ 'conditions' => [ 'id'     => $ratingssssData['game_id'], ] ]); 
            $ratingssssData['game_name'] = $gameData['name'];
            
            
            
        }else{
             $ratingssssData['username'] ="";
             $ratingssssData['game_name'] ="";
             
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('result/edit', compact('ratingssssData'));
        $this->load->view('template/footer');
    }
    
    public function fetchAutoResult($market){
        $market = str_replace("_"," ",$market);
        $whracc  = [
            'conditions' => ['id' => 1],
            'fields' => ['auto_result']
        ];
        $accSetting = $this->AccountModel->first($whracc);
        
        if($accSetting['auto_result']=='Yes'){
            $url = "https://matkaapi.com/api/market_api.php";
            $data = array(
                'domain' => 'matkagold.com',
                'api_key' => '6257d2457b39c',
                'domain_key' => '8bf039972dea8ecf4161abe2f41b6b5a',
                'market' => $market);
            
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, true, $context);
            $manage = json_decode($result);
            if($manage->status==1){
                $objData = $manage->data;
                if($objData!=null){
                    $data = $objData[0];
                    $gameName = $data->name;
                    $gameResult = $data->result;
                    $gameDate = $data->date;
                    if($gameResult=='Loading...'){
                        echo $gameName." ".$gameResult." ".$gameDate." result not declared";
                    }else{
                        $this->parseGame($gameName,$gameResult,$gameDate);
                    }
                }else{
                    echo "$market no record available";
                }
            }
            else{
                echo $manage->message;
            }
        }else{
            echo "Auto Result Disabled";
        }
        
        
    }
    function parseGame($gameName,$gameResult,$gameDate){
        $result = explode("-",$gameResult);
        if(sizeof($result)>0){
            $games = $this->GamesModel->first([
                'conditions' => ['status!=' => '3', 'name' => $gameName],
                'order' => ['by'   => 'id','type' => 'DESC']
            ]);
            if($games){
                $this->parseResult($gameName,$games['id'],$gameResult);
            }else{
                echo $gameName." game not added";
            }
        }else{
            echo $gameName." ".$gameResult." ".$gameDate." invalid result";
        }
    }
    
    function parseResult($gameName,$id,$gameResult){
        $result = explode("-",$gameResult);
        $startDate = date('Y-m-d 00:00:00');
        $endDate = date('Y-m-d 23:59:59');
        $fetchResult = $this->ResultsModel->first([
            'conditions' => ['decleared_at>=' => $startDate,'decleared_at<=' => $endDate,'game_id'=>$id],
        ]);
        if($fetchResult){
            if($fetchResult['close_panna']=='***'&&sizeof($result)==3){
                $this->delcareResult($gameName,'Close',$id,$result[2],$result[1]%10,$fetchResult['id']);
            }
            else{
                echo "result already declared";
            }
        }else{
            if(sizeof($result)==3){
                $fetchResult = $this->ResultsModel->first([
                    'conditions' => ['open_panna' => $result[0],'close_panna' => $result[2],'game_id'=>$id],
                ]);
                if($fetchResult){
                    echo "$gameResult yesterday's result.";
                }
                else{
                    $this->declareOcResult($gameName,$id,$result);
                }
            }
            else{
                $this->delcareResult($gameName,'Open',$id,$result[0],$result[1]);
            }
        }
    }
    
    function declareOcResult($gameName,$game_id,$result){
        $date = date('Y-m-d');
        $result_date = $date." ".date('H:i:s');
        $start_date = ("$date 00:00:00");
        $end_date = ("$date 23:59:59");
        $open_panna = $result[0];
        $close_panna = $result[2];
        $open_digit = floor($result[1]/10);
        $close_digit = $result[1]%10;
        $rate = $this->ResultsModel->save([
            'game_id'                    => $game_id,
            'open_panna'                 => $open_panna,
            'open_digit'                => $open_digit,
            'close_panna'                 => $close_panna,
            'close_digit'                => $close_digit,
            'decleared_at'              => $result_date
        ]);
        if($rate)
            {
                $game = $this->GamesModel->first(['conditions' => ['id' =>$game_id]]);
                // Add notifications for both sessions
                $title = $game['name'];
                $msg_open = "Open " . $open_panna . "-" . $open_digit;
                $msg_close = "Close " . $close_panna . "-" . $close_digit;
                
                // Check if open already sent
                $is_open_sent = $this->NotificationsSentModel->first(['result_id' => $rate, 'sent_type' => 'OPEN']);
                if (!$is_open_sent) {
                    sendResultNotificationOneSignal($title, $msg_open, 'CRON_AUTO_RESULT');
                    $this->NotificationsSentModel->save(['result_id' => $rate, 'sent_type' => 'OPEN']);
                }
                 $this->NotificationModel->save([
                     'message'      => $msg_open, 
                     'heading'      => "[AUTO-CRON] " . $title, 
                     'user_id'      => 'all', 
                     'status'       => true,
                     'created_date' => date('Y-m-d H:i:s')
                 ]);
                 
                 // Check if both already sent
                 $is_both_sent = $this->NotificationsSentModel->first(['result_id' => $rate, 'sent_type' => 'BOTH']);
                 if (!$is_both_sent) {
                     sendResultNotificationOneSignal($title, $msg_close, 'CRON_AUTO_RESULT');
                     $this->NotificationsSentModel->save(['result_id' => $rate, 'sent_type' => 'BOTH']);
                 }
                 $this->NotificationModel->save([
                     'message'      => $msg_close, 
                     'heading'      => "[AUTO-CRON] " . $title, 
                     'user_id'      => 'all', 
                     'status'       => true,
                     'created_date' => date('Y-m-d H:i:s')
                 ]);

                $rate_win= ['conditions' => "  (`game_type` = 'single_digit' OR `game_type` = 'single_panna' OR `game_type` = 'double_panna' OR `game_type` = 'triple_panna') AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = 'Open' AND (`open_panna` = '$open_panna' OR `open_digit` = '$open_digit') "];
                $chk = $this->BidModel->all($rate_win);
                
                $job_close = ['conditions' => "  (`game_type` = 'single_digit' OR `game_type` = 'single_panna' OR `game_type` = 'double_panna' OR `game_type` = 'triple_panna') AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = 'Close' AND (`close_panna` = '$close_panna' OR `close_digit` = '$close_digit') "];
                $data_close_bid = $this->BidModel->all($job_close);
                $chk = array_merge($chk,$data_close_bid);
                
                $job_jodi = ['conditions' => "`game_type` = 'jodi_digit' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `open_digit` = '$open_digit' AND `close_digit` = '$close_digit' "];
                $data_close_jodi = $this->BidModel->all($job_jodi);
                $chk = array_merge($chk,$data_close_jodi);
                
                $job_full_sangam = ['conditions' => "`game_type` = 'full_sangam' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `open_panna` = '$open_panna' AND `close_panna` = '$close_panna' "];
                $data_close_fs = $this->BidModel->all($job_full_sangam);
                $chk = array_merge($chk,$data_close_fs);
                
                $job_open_hs = ['conditions' => "`game_type` = 'half_sangam' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = 'Open' AND `open_digit` = '$open_digit' AND `close_panna` = '$open_panna' "];
                $data_open_hs = $this->BidModel->all($job_open_hs);
                $chk = array_merge($chk,$data_open_hs);
                
                $job_close_hs = ['conditions' => "`game_type` = 'half_sangam' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = 'Close' AND `open_panna` = '$open_panna' AND `close_digit` = '$close_digit' "];
                $data_close_hs = $this->BidModel->all($job_close_hs);
                $chk = array_merge($chk,$data_close_hs);
                
                foreach($chk as $key_con=>$val_con)
                {
                    $game_type_bid = $this->GameRateModel->first(['conditions' => ['name' => $val_con['game_type']]]);
                    $win_point = ($val_con['bid_points'] * $game_type_bid['per_point_earning_amount']);
                    $user_id = $val_con['user_id'];
                    $arr = [
                        'user_id' => $user_id,
                        'points' => $win_point,
                        'trans_type' => 5,
                        'trans_status' => "SUCCESSFULL",
                        'admin_status' => 'APPROVED',
                        'trans_det' => $rate."M",
                        'created_at' => date("Y-m-d H:i:s")
                    ];
                    $trans_save  = $this->UserTransModel->save($arr);
                    if($trans_save)
                    { 
                        $whr_arr  = ['conditions' => ['id' => $user_id]];
                        $user = $this->UsersModel->first($whr_arr);
                        $data_game = $this->GamesModel ->first(['conditions' => ['id' => $game_id]]);
                        $updated_points = $win_point + $user['available_points'];
                        $update_arr = [ 'available_points' => $updated_points ];
                        $whr_user = ['id' => $user_id];
                        $updt_point_user = $this->UsersModel->updateTable($update_arr, $whr_user);
                        $update_bid_arr = [ 'win_points' => $win_point,'won' => '1', 'result_id' => $arr['trans_det'], 'won_at'=>date("Y-m-d H:i:s")];
                        $con_bid = ['id' => $val_con['id']];
                        $update_bid = $this->BidModel->updateTable($update_bid_arr, $con_bid);
                    }
                }
                echo "$gameName result delcared";
            }
    }
    function delcareResult($gameName,$session,$game_id,$panna,$digit,$result_id=null){
        $date = date('Y-m-d');
        $result_date = $date." ".date('H:i:s');
        $start_date = ("$date 00:00:00");
        $end_date = ("$date 23:59:59");
        if ($session == "Open") {
            $rate = $this->ResultsModel->save([
                'game_id'                    => $game_id,
                'open_panna'                 => $panna,
                'open_digit'                => $digit,
                'close_panna'                 => "***",
                'close_digit'                => "*",
                'decleared_at'              => $result_date
            ]);
            if($rate)
            {
                $game = $this->GamesModel->first(['conditions' => ['id' =>$game_id]]);
                $title = $game['name'];
                $mes = ucfirst($session) . " " . $panna . "-" . $digit;
                // Check if already sent
                $is_sent = $this->NotificationsSentModel->first(['result_id' => $rate, 'sent_type' => 'OPEN']);
                if (!$is_sent) {
                    sendResultNotificationOneSignal($title, $mes, 'CRON_AUTO_RESULT');
                    $this->NotificationsSentModel->save(['result_id' => $rate, 'sent_type' => 'OPEN']);
                }
                $this->NotificationModel->save(['message' => $mes, 'heading' => "[AUTO] " . $title, 'user_id' => 'all', 'status' => true]);

                $rate_win= ['conditions' => "  (`game_type` = 'single_digit' OR `game_type` = 'single_panna' OR `game_type` = 'double_panna' OR `game_type` = 'triple_panna') AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = '$session' AND (`open_panna` = '$panna' OR `open_digit` = '$digit') "];
                $chk = $this->BidModel->all($rate_win);
                foreach($chk as $key_con=>$val_con)
                {
                    $game_type_bid = $this->GameRateModel->first(['conditions' => ['name' => $val_con['game_type']]]);
                    $win_point = ($val_con['bid_points'] * $game_type_bid['per_point_earning_amount']);
                    $user_id = $val_con['user_id'];
                    $arr = [
                        'user_id' => $user_id,
                        'points' => $win_point,
                        'trans_type' => 5,
                        'trans_status' => "SUCCESSFULL",
                        'admin_status' => 'APPROVED',
                        'trans_det' => $rate."M",
                        'created_at' => date("Y-m-d H:i:s")
                    ];
                    $trans_save  = $this->UserTransModel->save($arr);
                    if($trans_save)
                    { 
                        $whr_arr  = ['conditions' => ['id' => $user_id]];
                        $user = $this->UsersModel->first($whr_arr);
                        $data_game = $this->GamesModel ->first(['conditions' => ['id' => $game_id]]);
                        $updated_points = $win_point + $user['available_points'];
                        $update_arr = [ 'available_points' => $updated_points ];
                        $whr_user = ['id' => $user_id];
                        $updt_point_user = $this->UsersModel->updateTable($update_arr, $whr_user);
                        $update_bid_arr = [ 'win_points' => $win_point,'won' => '1', 'result_id' => $arr['trans_det'], 'won_at'=>date("Y-m-d H:i:s")];
                        $con_bid = ['id' => $val_con['id']];
                        $update_bid = $this->BidModel->updateTable($update_bid_arr, $con_bid);
                    }
                }
                echo "$gameName $session result delcared";
            }
        }
        else {
            $rate = $this->ResultsModel->updateTable([
                'close_panna'                 => $panna,
                'close_digit'                => $digit
            ], ['id' => $result_id]);
            if($rate)
            {
                $game = $this->GamesModel->first(['conditions' => ['id' =>$game_id]]);
                $title = $game['name'];
                $mes = ucfirst($session) . " " . $panna . "-" . $digit;
                // Check if already sent BOTH
                $is_sent = $this->NotificationsSentModel->first(['result_id' => $result_id, 'sent_type' => 'BOTH']);
                if (!$is_sent) {
                    sendResultNotificationOneSignal($title, $mes, 'CRON_AUTO_RESULT');
                    $this->NotificationsSentModel->save(['result_id' => $result_id, 'sent_type' => 'BOTH']);
                }
                $this->NotificationModel->save(['message' => $mes, 'heading' => "[AUTO] " . $title, 'user_id' => 'all', 'status' => true]);
                
                $fet_result = $this->ResultsModel->first(['conditions' => ['game_id' => $game_id, 'id' => $result_id]]);
                $fet_open_panna =$fet_result['open_panna']; 
                $fet_open_digit = $fet_result['open_digit']; 
                
                $job_close = ['conditions' => "  (`game_type` = 'single_digit' OR `game_type` = 'single_panna' OR `game_type` = 'double_panna' OR `game_type` = 'triple_panna') AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = '$session' AND (`close_panna` = '$panna' OR `close_digit` = '$digit') "];
                $data_close_bid = $this->BidModel->all($job_close);
                $chk = $data_close_bid;
                
                $job_jodi = ['conditions' => "`game_type` = 'jodi_digit' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `open_digit` = '$fet_open_digit' AND `close_digit` = '$digit' "];
                $data_close_jodi = $this->BidModel->all($job_jodi);
                $chk = array_merge($chk,$data_close_jodi);
                
                $job_full_sangam = ['conditions' => "`game_type` = 'full_sangam' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `open_panna` = '$fet_open_panna' AND `close_panna` = '$panna' "];
                $data_close_fs = $this->BidModel->all($job_full_sangam);
                $chk = array_merge($chk,$data_close_fs);
                
                $job_open_hs = ['conditions' => "`game_type` = 'half_sangam' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = 'Open' AND `open_digit` = '$fet_open_digit' AND `close_panna` = '$panna' "];
                $data_open_hs = $this->BidModel->all($job_open_hs);
                $chk = array_merge($chk,$data_open_hs);
                
                $job_close_hs = ['conditions' => "`game_type` = 'half_sangam' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = 'Close' AND `open_panna` = '$fet_open_panna' AND `close_digit` = '$digit' "];
                $data_close_hs = $this->BidModel->all($job_close_hs);
                $chk = array_merge($chk,$data_close_hs);
                
                
                foreach($chk as $key_con=>$val_con)
                {
                    $game_type_bid = $this->GameRateModel->first(['conditions' => ['name' => $val_con['game_type']]]);
                    $win_point = ($val_con['bid_points'] * $game_type_bid['per_point_earning_amount']);
                    $user_id = $val_con['user_id'];
                    $arr = [
                        'user_id' => $user_id,
                        'points' => $win_point,
                        'trans_type' => 5,
                        'trans_status' => "SUCCESSFULL",
                        'admin_status' => 'APPROVED',
                        'trans_det' =>$result_id."M",
                        'created_at' => date("Y-m-d H:i:s")
                    ];
                    $trans_save  = $this->UserTransModel->save($arr);
                    if($trans_save)
                    { 
                        $whr_arr  = ['conditions' => ['id' => $user_id]];
                        $user = $this->UsersModel->first($whr_arr);
                        $data_game = $this->GamesModel ->first(['conditions' => ['id' => $game_id]]);
                        $updated_points = $win_point + $user['available_points'];
                        $update_arr =
                            [
                                'available_points' => $updated_points
                            ];
            
                        $whr_user = ['id' => $user_id];
                        $updt_point_user = $this->UsersModel->updateTable($update_arr, $whr_user);
                        
                        $update_bid_arr = [ 'win_points' => $win_point,'won' => '1', 'result_id' => $arr['trans_det'], 'won_at'=>date("Y-m-d H:i:s")];
                        $con_bid = ['id' => $val_con['id']];
                        $update_bid = $this->BidModel->updateTable($update_bid_arr, $con_bid);
                    }
                }
               echo "$gameName $session result delcared"; 
            }
            
        }
    }

    
}

    /* End of file  Rating.php */
