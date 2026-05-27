<?php defined('BASEPATH') or exit('No direct script access allowed');
/** Load Category Pages & Queries */
class Result extends CI_Controller
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

        $this->load->model(['ResultsModel', 'GamesModel','BidModel','GameRateModel','UserTransModel','UsersModel','NotificationModel','GameMarketDayWise', 'NotificationsSentModel']);
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
        $is_edit = $this->input->post('is_edit');
        $result_date = $date." ".date('H:i:s');
            
            $start_date = ("$date 00:00:00");
            $end_date = ("$date 23:59:59");

            if ($is_edit == 'true') {
                $exist_res = $this->ResultsModel->first([
                    'conditions' => ['decleared_at>=' => $start_date,'decleared_at<=' => $end_date,'game_id'=>$game_id],
                ]);
            
                    
                if ($exist_res) {
                    $res_id = $exist_res['id'];
                    $r_id = $res_id . "M";
                    
                    $this->ResultsModel->updateTable([
    'manual_lock' => 1
], ['id' => $res_id]);
                    
                    // Revert old wins and transactions for this result
                    $trans_all = $this->UserTransModel->all(['conditions' => ['trans_det' => $r_id]]);
                    foreach($trans_all as $val_trans) {
                        $user = $this->UsersModel->first(['conditions' => ['id' => $val_trans['user_id']]]);
                        if ($user) {
                            $updated_points = $user['available_points'] - $val_trans['points'];
                            $this->UsersModel->updateTable(['available_points' => $updated_points], ['id' => $val_trans['user_id']]);
                        }
                        $this->UserTransModel->destroy(['id' => $val_trans['id']]);
                    }
                    $this->BidModel->updateTable(['win_points' => '0', 'won' => '0', 'result_id' => '', 'won_at' => '0000-00-00 00:00:00'], ['result_id' => $r_id]);
                    $this->NotificationsSentModel->destroy(['result_id' => $res_id]);
                    
                    // Clear the current session in the result record so it can be updated
                    if ($session == "Open") {
                        $this->ResultsModel->updateTable(['open_panna' => '', 'open_digit' => ''], ['id' => $res_id]);
                    } else {
                        $this->ResultsModel->updateTable(['close_panna' => '***', 'close_digit' => '*'], ['id' => $res_id]);
                    }
                }
            }
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
                            // ✅ FIX: Use OneSignal broadcast instead of deprecated per-user FCM loop
                            $title = ($game['name']);
                            $mes = ucfirst($session) . $panna . "-" . $digit;
                            sendResultNotificationOneSignal($title, $mes);
                            $Notification = $this->NotificationModel->save([
                                'message'  => $mes,
                                'heading'  => $title,
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

                            // If this was an edit and the close session was already declared, re-run close-session win logic
                            // because Jodi, Half Sangam, Full Sangam depend on both open/close results.
                            if ($is_edit == 'true' && !empty($result['close_panna']) && $result['close_panna'] != '***') {
                                $this->process_close_session_wins($game_id, $start_date, $end_date, $result['id'], $result['close_panna'], $result['close_digit']);
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
                            // ✅ FIX: Use OneSignal broadcast instead of deprecated per-user FCM loop
                            $title = ($game['name']);
                            $mes = ucfirst($session) . $panna . "-" . $digit;
                            sendResultNotificationOneSignal($title, $mes);
                            $Notification = $this->NotificationModel->save([
                                'message'  => $mes,
                                'heading'  => $title,
                                'user_id'  => "all",
                                'status'   => true
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

                            // If this was an edit, we already reverted everything above. 
                            // If we just updated Close, we still need to make sure Open session wins are re-declared 
                            // because we reverted ALL wins for this result ID.
                            if ($is_edit == 'true' && !empty($result['open_panna']) && $result['open_panna'] != '***') {
                                $this->process_open_session_wins($game_id, $start_date, $end_date, $result['id'], $result['open_panna'], $result['open_digit']);
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
                        // ✅ FIX: Use OneSignal broadcast instead of deprecated per-user FCM loop
                        $title = ($game['name']);
                        $mes = ucfirst($session) . $panna . "-" . $digit;
                        sendResultNotificationOneSignal($title, $mes);
                        $Notification = $this->NotificationModel->save([
                            'message'  => $mes,
                            'heading'  => $title,
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
    
    /** Helper to process open session wins (used during edit re-calculations) */
    private function process_open_session_wins($game_id, $start_date, $end_date, $result_id, $panna, $digit)
    {
        $session = "Open";
        $rate_win= ['conditions' => "  (`game_type` = 'single_digit' OR `game_type` = 'single_panna' OR `game_type` = 'double_panna' OR `game_type` = 'triple_panna') AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = '$session' AND (`open_panna` = '$panna' OR `open_digit` = '$digit') "];
        $chk = $this->BidModel->all($rate_win);
        foreach($chk as $val_con)
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
                'trans_det' => $result_id."M",
                'created_at' => date("Y-m-d H:i:s")
            ];
            $trans_save  = $this->UserTransModel->save($arr);
            if($trans_save)
            { 
                $user = $this->UsersModel->first(['conditions' => ['id' => $user_id]]);
                $updated_points = $win_point + $user['available_points'];
                $this->UsersModel->updateTable(['available_points' => $updated_points], ['id' => $user_id]);
                $this->BidModel->updateTable(['win_points' => $win_point,'won' => '1', 'result_id' => $arr['trans_det'], 'won_at'=>date("Y-m-d H:i:s")], ['id' => $val_con['id']]);
            }
        }
    }

    /** Helper to process close session wins (used during edit re-calculations) */
    private function process_close_session_wins($game_id, $start_date, $end_date, $result_id, $panna, $digit)
    {
        $session = "Close";
        $fet_result = $this->ResultsModel->first(['conditions' => ['id' => $result_id]]);
        $fet_open_panna = $fet_result['open_panna']; 
        $fet_open_digit = $fet_result['open_digit']; 
        
        $job_close = ['conditions' => "  (`game_type` = 'single_digit' OR `game_type` = 'single_panna' OR `game_type` = 'double_panna' OR `game_type` = 'triple_panna') AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = '$session' AND (`close_panna` = '$panna' OR `close_digit` = '$digit') "];
        $chk = $this->BidModel->all($job_close);
        
        $job_jodi = ['conditions' => "`game_type` = 'jodi_digit' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `open_digit` = '$fet_open_digit' AND `close_digit` = '$digit' "];
        $chk = array_merge($chk, $this->BidModel->all($job_jodi));
        
        $job_full_sangam = ['conditions' => "`game_type` = 'full_sangam' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `open_panna` = '$fet_open_panna' AND `close_panna` = '$panna' "];
        $chk = array_merge($chk, $this->BidModel->all($job_full_sangam));
        
        $job_open_hs = ['conditions' => "`game_type` = 'half_sangam' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = 'Open' AND `open_digit` = '$fet_open_digit' AND `close_panna` = '$panna' "];
        $chk = array_merge($chk, $this->BidModel->all($job_open_hs));
        
        $job_close_hs = ['conditions' => "`game_type` = 'half_sangam' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = 'Close' AND `open_panna` = '$fet_open_panna' AND `close_digit` = '$digit' "];
        $chk = array_merge($chk, $this->BidModel->all($job_close_hs));
        
        foreach($chk as $val_con)
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
                'trans_det' => $result_id."M",
                'created_at' => date("Y-m-d H:i:s")
            ];
            $trans_save  = $this->UserTransModel->save($arr);
            if($trans_save)
            { 
                $user = $this->UsersModel->first(['conditions' => ['id' => $user_id]]);
                $updated_points = $win_point + $user['available_points'];
                $this->UsersModel->updateTable(['available_points' => $updated_points], ['id' => $user_id]);
                $this->BidModel->updateTable(['win_points' => $win_point,'won' => '1', 'result_id' => $arr['trans_det'], 'won_at'=>date("Y-m-d H:i:s")], ['id' => $val_con['id']]);
            }
        }
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
            // Also delete the notification text from notifications table if needed
            // But usually we just care about notifications_sent
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

    
}

    /* End of file  Rating.php */
