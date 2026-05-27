<?php defined('BASEPATH') or exit('No direct script access allowed');
/** Load Category Pages & Queries */
class Starline extends CI_Controller
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

        $this->load->model(['NotificationModel','UsersModel','StarlineBidModel', 'StarlineGameRateModel', 'StarlineGamesModel', 'StarlineResultsModel', 'BidModel', 'GamesModel','StarlineWinPredictionModel','UserTransModel', 'NotificationsSentModel']);
        $this->load->helper('send'); // loads sendResultNotificationOneSignal()
    }


    /** Load Default Index To Show 404 Error
     *
     * @return void */
    public function index()
    {
        return show_404();
    }
    
    public function revert_bid_by_click()
	{
	    
	    $orgDate =  $_POST['starline_bid_revert_date'];
        $newDate = date("Y-m-d", strtotime($orgDate));
        $start_date = ("$newDate 00:00:00");
        $end_date = ("$newDate 23:59:59");
        
        $jobs_wc['conditions']['bid.bidded_at >'] = $start_date;
        $jobs_wc['conditions']['bid.bidded_at >'] = $end_date;
        $cond = ['conditions'=>"(`bidded_at` > '$start_date')  AND (`bidded_at` < '$end_date')"];
        
        $query =[];
        
        $query = $this->StarlineBidModel->all($cond);
        
        foreach($query as $key=>$val)
        {
             $bid_points = $val['bid_points'];
             $id = $val['id'];
             $u_id = $val['user_id'];
            
            $trans_con = [ 'conditions'=>"(`trans_type`='19')  AND `user_id`='$u_id'  AND `trans_det`='$id'"];
            $transdata = $this->UserTransModel->first($trans_con);
            
           
             $transdata_destroy  = $this->UserTransModel->destroy(['id' => $transdata['id']]);
            $user = $this->UsersModel->first(['id' => $u_id]);
            $total_points = $user['available_points'];
            $upd_point = $total_points + $bid_points;
            $user_point_update = $this->UsersModel->updateTable([ 'available_points' => $upd_point,], ['id' => $u_id]); 
                
        }
        
        
	}

   public function edit_bid_history_starline($id)
    {


        if ($this->input->post('editbidhisstarline')) {
            
            $panna = $_POST['panna'];
            $digit = $_POST['digit'];
            $bid_points = $_POST['bid_points'];
            $old_bid =   $this->StarlineBidModel->first([ 'conditions' => ['id'     => $id]]); 
            $old_bid_point = $old_bid['bid_points'];
            $user =   $this->UsersModel->first(['conditions' => [ 'id'     => $old_bid['user_id'] ]]); 
            if($bid_points==$old_bid_point){
                $rate = $this->StarlineBidModel->updateTable([
                    'digit'                      => $digit,
                    'panna'                      => $panna
                ], ['id' => $id]);
                    
            }
            else{
                    
                $rate = $this->StarlineBidModel->updateTable([
                    'digit'                      => $digit,
                    'panna'                      => $panna,
                    'bid_points'                    =>$bid_points
                ], ['id' => $id]);
                $u_id = $user['id'];
                $trans_con = [ 'conditions'=>"(`trans_type`='9')  AND `user_id`='$u_id'  AND `trans_det`='$id'"];
                $transdata = $this->UserTransModel->first($trans_con);
                $transdata_point_update = $this->UserTransModel->updateTable([
                'points'                      =>$bid_points,
                ], ['id' => $transdata['id']]);
                
                $main_diff_points = $old_bid_point - $bid_points;
                $total_points = $user['available_points'];
                
                $upd_point = $total_points + $main_diff_points;
                
                $user_point_update = $this->UsersModel->updateTable([
                'available_points'                      =>$upd_point,
                ], ['id' => $user['id']]);
            }
            

           
            // _ddd($vehicles);

            flash_message(
                'edit_bid/starline/' . $id,
                $rate,
                'unsuccess',
                "Something Went Wrong"
            );

            flash_message(
                'starlineBid_history_list/starline',
                $rate,
                'success',
                "Bid Updated Successfully"
            );
        }


        $ratingssssData = '';
        $ratingssssData = $this->StarlineBidModel->first([ 'conditions' => [ 'id'     => $id ]]);
        $ratingssssData['game_type'] = ucwords(str_replace('_',' ',$ratingssssData['game_type']));
        if($ratingssssData)
        {
            $user =   $this->UsersModel->first([ 'conditions' => [ 'id'     => $ratingssssData['user_id'], ] ]); 
            $ratingssssData['username']= $user['username'];
            
            $gameData =   $this->StarlineGamesModel->first([ 'conditions' => [ 'id'     => $ratingssssData['game_id'], ] ]); 
            $ratingssssData['game_name'] = $gameData['name'];
        }else{
            $ratingssssData['username'] ="";
            $ratingssssData['game_name'] ="";
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('starline/edit_bid', compact('ratingssssData'));
        $this->load->view('template/footer');
    }

    public function edit_bid_starline($id)
    {


        if ($this->input->post('editbidstarline')) {
            
          
            $panna = $_POST['panna'];
            $digit = $_POST['digit'];
            $bid_points = $_POST['bid_points'];
            $old_bid =   $this->StarlineBidModel->first([ 'conditions' => ['id'     => $id]]); 
            $old_bid_point = $old_bid['bid_points'];
            $user =   $this->UsersModel->first(['conditions' => [ 'id'     => $old_bid['user_id'] ]]); 
            if($bid_points==$old_bid_point){
                $rate = $this->StarlineBidModel->updateTable([
                    'digit'                      => $digit,
                    'panna'                      => $panna
                ], ['id' => $id]);
                    
            }
            else{
                    
                $rate = $this->StarlineBidModel->updateTable([
                    'digit'                      => $digit,
                    'panna'                      => $panna,
                    'bid_points'                    =>$bid_points
                ], ['id' => $id]);
                $u_id = $user['id'];
                $trans_con = [ 'conditions'=>"(`trans_type`='9')  AND `user_id`='$u_id'  AND `trans_det`='$id'"];
                $transdata = $this->UserTransModel->first($trans_con);
                $transdata_point_update = $this->UserTransModel->updateTable([
                'points'                      =>$bid_points,
                ], ['id' => $transdata['id']]);
                
                $main_diff_points = $old_bid_point - $bid_points;
                $total_points = $user['available_points'];
                
                $upd_point = $total_points + $main_diff_points;
                
                $user_point_update = $this->UsersModel->updateTable([
                'available_points'                      =>$upd_point,
                ], ['id' => $user['id']]);
                }
            

           
            // _ddd($vehicles);

            flash_message(
                'edit/starline/' . $id,
                $rate,
                'unsuccess',
                "Something Went Wrong"
            );

            flash_message(
                'result_list/starline',
                $rate,
                'success',
                "Bid Updated Successfully"
            );
        }


        $ratingssssData = '';
        $ratingssssData = $this->StarlineBidModel->first([ 'conditions' => [ 'id'     => $id ]]);
        $ratingssssData['game_type'] = ucwords(str_replace('_',' ',$ratingssssData['game_type']));
        if($ratingssssData)
        {
            $user =   $this->UsersModel->first([ 'conditions' => [ 'id'     => $ratingssssData['user_id'], ] ]); 
            $ratingssssData['username']= $user['username'];
            
            $gameData =   $this->StarlineGamesModel->first([ 'conditions' => [ 'id'     => $ratingssssData['game_id'], ] ]); 
            $ratingssssData['game_name'] = $gameData['name'];
        }else{
            $ratingssssData['username'] ="";
            $ratingssssData['game_name'] ="";
        }
        _ddd($ratingssssData);
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('starline/edit', compact('ratingssssData'));
        $this->load->view('template/footer');
    }

    /** Load List Page */
    public function list_game_starline()
    {

        $ratingsData = [];
        $ratingsData = $this->StarlineGamesModel->all([
            'conditions' => [
                'status!='     => '3',
            ],
            'order' => [
                'by'   => 'id',
                'type' => 'DESC'
            ]
        ]);
        
        foreach($ratingsData as $gameKey => $gameData){
            $ratingsData[$gameKey]['name'] = ucwords($gameData['name']);
            $ratingsData[$gameKey]['time'] = date('h:i A',strtotime($gameData['time']));
            $ratingsData[$gameKey]['market_status'] = (date("H:i:s")<$gameData['time']) ? true : false;
        }


        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('starline/list', compact('ratingsData'));
        $this->load->view('template/footer');
    }

   public function sell_report_list()
    {
        $newDate = date("Y-m-d");
        $start_date = ("$newDate 00:00:00");
        $end_date = ("$newDate 23:59:59");
        $jobs_wc = [
            'order'      => [
                'by'   => 'id',
                'type' => 'DESC'
            ]
        ];

        if (isset($_POST['from_date']) && $_POST['from_date'] != '') {

            $orgDate =  $_POST['from_date'];
            $newDate = date("Y-m-d", strtotime($orgDate));
            $start_date = ("$newDate 00:00:00");
            $end_date = ("$newDate 23:59:59");
            
            $jobs_wc['conditions']['starline_bid.bidded_at>'] = $start_date;
            $jobs_wc['conditions']['starline_bid.bidded_at<'] = $end_date;
        }
        if (isset($_POST['game_id']) && ($_POST['game_id'] != '') && ($_POST['game_id']
            !== 'All')) {
            $jobs_wc['conditions']['starline_bid.game_id'] = $_POST['game_id'];
        }
        
        $sellList = $this->StarlineBidModel->all($jobs_wc);
        
        $single_digit_array = range(0,9);    
	    $single_panna_array=SINGLE_PANNA;
	    $double_panna_array = Double_PANNA;
	    $triple_panna_array = Triple_PANNA;
	    
	    $singleDigitReport = array();
	    $singlePannaReport = array();
	    $doublePannaReport = array();
	    $triplePannaReport = array();
	    
	    foreach($single_digit_array as $sdKey => $sdData){
	        $singleDigitReport[$sdKey]['number'] = $sdData;
	        $singleDigitReport[$sdKey]['count'] = 0;
	    }
	    
	    foreach($single_panna_array as $spKey => $spData){
	        $singlePannaReport[$spKey]['number'] = $spData;
	        $singlePannaReport[$spKey]['count'] = 0;
	    }
	    
	    foreach($double_panna_array as $dpKey => $dpData){
	        $doublePannaReport[$dpKey]['number'] = $dpData;
	        $doublePannaReport[$dpKey]['count'] = 0;
	    }
	    
	    foreach($triple_panna_array as $tpKey => $tpData){
	        $triplePannaReport[$tpKey]['number'] = $tpData;
	        $triplePannaReport[$tpKey]['count'] = 0;
	    }
	    
	    

        foreach($sellList as $sellKey => $sellData){
	        $open_digit = $sellData['digit'];
	        $open_panna = $sellData['panna'];
            
            if($sellData['game_type']=='single_digit'){
                if($open_digit!=""){
                    $dataP = array_search($open_digit,$single_digit_array);
                    $singleDigitReport[$dataP]['count'] +=  $sellData['bid_points'];
                }
            }
            if($sellData['game_type']=='single_panna'){
                if($open_panna!=""){
                    $dataP = array_search($open_panna,$single_panna_array);
                    $singlePannaReport[$dataP]['count'] +=  $sellData['bid_points'];
                }
            }
            if($sellData['game_type']=='double_panna'){
                if($open_panna!=""){
                    $dataP = array_search($open_panna,$double_panna_array);
                    $doublePannaReport[$dataP]['count'] +=  $sellData['bid_points'];
                }
            }
            if($sellData['game_type']=='triple_panna'){
                if($open_panna!=""){
                    $dataP = array_search($open_panna,$triple_panna_array);
                    $triplePannaReport[$dataP]['count'] +=  $sellData['bid_points'];
                }
            }
            
        }
        $games = $this->StarlineGamesModel->all([ 'conditions' =>['status' => '1']]);
        
       
	    
   
	   
           
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('starline/sell_report_list', compact('singleDigitReport','singlePannaReport','doublePannaReport','triplePannaReport', 'games'));
        $this->load->view('template/footer');
    }

   
    /** Load List Page */
    public function prediction_list()
    {

       
        
         $chk=[];
        if (isset($_POST['pre_filter'])) {

         
            if (isset($_POST['open_panna']) || ($_POST['open_panna'] != '') || ($_POST['open_panna']
                !== 'All')) {
                    
                $orgDate =  $_POST['from_date'];
                $newDate = date("Y-m-d", strtotime($orgDate));
                $start_date = ("$newDate 00:00:00");
                $end_date = ("$newDate 23:59:59");
                
                $open_panna = $_POST['open_panna'];
                
                $game_id = $_POST['game_id'];
               
                $test = str_split($_POST['open_panna']);
                $rrr = [];
                foreach ($test as $key => $val) {
                    $rrr[] = $val;
                }
                $sum = array_sum($rrr);
                $digit = (fmod($sum, 10));
                
                
                $jobs_wc = ['conditions' => " `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND (`panna` = '$open_panna' OR `digit` = '$digit') "];  
                
              
              
            }
            
            $chk = $this->StarlineBidModel->all($jobs_wc);
           
        }

        
       
        $games = $this->StarlineGamesModel->all(['status' => '1']);
        $number = PANNA;



        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('starline/starline_prediction_list', compact('chk', 'games', 'number'));
        $this->load->view('template/footer');
    }

    /** Load List Page */
    public function starline_bid_history_list()
    {
        $jobs_wc = [
            'order'      => [
                'by'   => 'id',
                'type' => 'DESC'
            ],

        ];

        if (isset($_POST['filter'])) {


            if (isset($_POST['from_date']) && $_POST['from_date'] != '') {

               $orgDate =  $_POST['from_date'];
                $newDate = date("Y-m-d", strtotime($orgDate));
                   $start_date = ("$newDate 00:00:00");
                  $end_date = ("$newDate 23:59:00");
                
                $jobs_wc['conditions']['starline_bid.bidded_at>'] = $start_date;
                $jobs_wc['conditions']['starline_bid.bidded_at<'] = $end_date;
            }
            if (isset($_POST['game_id']) && ($_POST['game_id'] != '') && ($_POST['game_id']
                !== 'All')) {
                $jobs_wc['conditions']['starline_bid.game_id'] = $_POST['game_id'];
            }
            if (isset($_POST['game_type']) && ($_POST['game_type'] != '') && ($_POST['game_type']
                !== 'All')) {
                $jobs_wc['conditions']['starline_bid.game_type'] = $_POST['game_type'];
            }
        }



        $userData = [];
        $userData = $this->StarlineBidModel->all($jobs_wc);
        
        foreach($userData as $dataKey => $data){
            $data_bid_user = $this->UsersModel->first([ 'conditions' => ['id'   => $data['user_id']] ]);
            $data_game = $this->StarlineGamesModel->first([ 'conditions' => ['id'   => $data['game_id']] ]);
            
            $userData[$dataKey]['bidded_at'] = ($data['bidded_at']) ? date("d-m-Y", strtotime($data['bidded_at'])): date("d-m-Y");
            $userData[$dataKey]['username'] = ($data_bid_user['username']) ? $data_bid_user['username'] : "N/A";
            $userData[$dataKey]['game_name'] = ($data_game['name'])? $data_game['name'] :"N/A";
            $userData[$dataKey]['game_type'] = ucwords(str_replace('_',' ',$data['game_type']));
            
            
        }

        $games = $this->StarlineGamesModel->all([ 'conditions'=>['status' => '1']]);

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('starline/starlineBid_history_list', compact('userData', 'games'));
        $this->load->view('template/footer');
    }


    /** Add add_game_starline */
    public function add_game_starline()
    {
        if ($this->input->post('addGames')) {

            $rateingsss = $this->StarlineGamesModel->save([
                'name'                             => $this->input->post('name'),
                'time'                      => $this->input->post('time'),
                'status'                           => '2',
            ]);

            flash_message(
                'add/starline',
                $rateingsss,
                'unsuccess',
                "Something Went Wrong"
            );

            flash_message(
                'list/starline',
                $rateingsss,
                'success',
                "Starline Game Added Successfully"
            );
        }


        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('starline/add');
        $this->load->view('template/footer');
    }
    
    public function edit_game_starline($id)
    {


        if ($this->input->post('editgamestarline')) {

            $rate = $this->StarlineGamesModel->updateTable([
                   'name'                      => $this->input->post('name'),
                   'time'                      => $this->input->post('time')
            ], ['id' => $id]);

            flash_message(
                'edit/starline/' . $id,
                $rate,
                'unsuccess',
                "Something Went Wrong"
            );

            flash_message(
                'list/starline',
                $rate,
                'success',
                "Starline Games Updated Successfully"
            );
        }


        $ratingssssData = '';
        $ratingssssData = $this->StarlineGamesModel->first([
            'conditions' => [
                'id'     => $id,
            ]
        ]);
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('starline/edit', compact('ratingssssData'));
        $this->load->view('template/footer');
    }
    
    public function change_delete($id)
	{

		$job = $this->StarlineGamesModel->updateTable([
			'status'=>'3'
		], ['id' => $id]);

		flash_message(
			'list/starline',
			$job,
			'success',
			"Deleted Successfully"
		);
	}


    /** Change Status */

    public function change_status_gamestarline($id, $stat)
    {

        if ($stat == 'inactive') {

            $job = $this->StarlineGamesModel->updateTable([
                'status'            => '2',
                'market_status'      => '2'
            ], ['id' => $id]);

            flash_message(
                'list/starline',
                $job,
                'success',
                "Status Inactive Successfully"
            );
        }

        if ($stat == 'active') {

            $game = $this->StarlineGamesModel->first([

                'conditions' => ['id' => $id]
            ]);

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

            $job = $this->StarlineGamesModel->updateTable([
                'status'            => '1',
                'market_status'      => $m_stts
            ], ['id' => $id]);
            flash_message(
                'list/starline',
                $job,
                'success',
                "Status Active Successfully"
            );
        }
    }

    public function add_game__rate_starline()
    {
        $ratingsData = [];
        if ($this->input->post('addGamerate')) {


            if ((!empty($_POST['single_digit_value_1'])) or (!empty($_POST['single_digit_value_2']))) {

                $job = $this->StarlineGameRateModel->updateTable([
                    'cost_amount'            => $this->input->post('single_digit_value_1'),
                    'earning_amount'      => $this->input->post('single_digit_value_2'),
                    'per_point_earning_amount' => $this->input->post('single_digit_value_2')/$this->input->post('single_digit_value_1')
                ], ['id' => 1]);
            }


            if ((!empty($_POST['single_pana_value_1'])) or (!empty($_POST['single_pana_value_2']))) {

                $job = $this->StarlineGameRateModel->updateTable([
                    'cost_amount'            => $this->input->post('single_pana_value_1'),
                    'earning_amount'      => $this->input->post('single_pana_value_2'),
                    'per_point_earning_amount' => $this->input->post('single_pana_value_2')/$this->input->post('single_pana_value_1')
                ], ['id' => 2]);
            }

            if ((!empty($_POST['double_pana_value_1'])) or (!empty($_POST['double_pana_value_2']))) {

                $job = $this->StarlineGameRateModel->updateTable([
                    'cost_amount'            => $this->input->post('double_pana_value_1'),
                    'earning_amount'      => $this->input->post('double_pana_value_2'),
                    'per_point_earning_amount' => $this->input->post('double_pana_value_2')/$this->input->post('double_pana_value_1')
                ], ['id' => 3]);
            }

            if ((!empty($_POST['triple_pana_value_1'])) or (!empty($_POST['triple_pana_value_2']))) {

                $job = $this->StarlineGameRateModel->updateTable([
                    'cost_amount'            => $this->input->post('triple_pana_value_1'),
                    'earning_amount'      => $this->input->post('triple_pana_value_2'),
                    'per_point_earning_amount' => $this->input->post('triple_pana_value_2')/$this->input->post('triple_pana_value_1')
                ], ['id' => 4]);
            }
        }
        $single_d_Data = $this->StarlineGameRateModel->first(['conditions' => [
            'id' => 1
        ]]);
        $single_pana_Data = $this->StarlineGameRateModel->first(['conditions' => [
            'id' => 2
        ]]);
        $double_pana_Data = $this->StarlineGameRateModel->first(['conditions' => [
            'id' => 3
        ]]);
        $triple_pana_Data = $this->StarlineGameRateModel->first(['conditions' => [
            'id' => 4
        ]]);

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('starline/game_rate_add', compact('triple_pana_Data', 'double_pana_Data', 'single_pana_Data', 'single_d_Data'));
        $this->load->view('template/footer');
    }
    
    public function starline_winning_report_list()
    {
        $jobs_wc = [
            'conditions'=>['won'=>1],
            'order'      => [
                'by'   => 'id',
                'type' => 'DESC'
            ],

        ];

        if (isset($_POST['from_date']) && $_POST['from_date'] != '') {

            $orgDate =  $_POST['from_date'];
            $newDate = date("Y-m-d", strtotime($orgDate));
               $start_date = ("$newDate 00:00:00");
              $end_date = ("$newDate 23:59:00");
            
            $jobs_wc['conditions']['starline_bid.won_at>'] = $start_date;
            $jobs_wc['conditions']['starline_bid.won_at<'] = $end_date;
        }
        if (isset($_POST['game_id']) && ($_POST['game_id'] != '') && ($_POST['game_id']
            !== 'All')) {
            $jobs_wc['conditions']['starline_bid.game_id'] = $_POST['game_id'];
        }


        $userData = [];
        $userData = $this->StarlineBidModel->all($jobs_wc);
        $games = $this->StarlineGamesModel->all([ 'conditions'=>['status' => '1']]);

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('starline/starline_win_report_list', compact('userData', 'games'));
        $this->load->view('template/footer');
    }
    
    public function check_result(){
        $chk = array();
        $date = $_POST['from_date'];
        $game_id = $_POST['game_id'];
        $start_date = ("$date 00:00:00");
        $end_date = ("$date 23:59:59");
        
        
        
        $result = $this->StarlineResultsModel->first([
            'conditions' => ['date>=' => $start_date,'date<=' => $end_date,'game_id'=>$game_id],
        ]);
        if($result){
            $chk['panna'] = $result['panna'];
            $chk['digit'] = $result['digit'];
        }
        echo json_encode($chk);
    }
    
    public function fetch_result(){
        $chk = array();
        $date = $_POST['from_date_declare'];
        $start_date = ("$date 00:00:00");
        $end_date = ("$date 23:59:59");
        
        $result = $this->StarlineResultsModel->all([
            'conditions' => ['date>=' => $start_date,'date<=' => $end_date],
            'order' => ['by' => 'id', 'type' => 'DESC']
        ]);
        foreach($result as $resultKey => $resultData){
            $data_game = $this->StarlineGamesModel->first([ 'conditions' => ['id'   => $resultData['game_id']] ]);
            $result[$resultKey]['game_name'] = $data_game['name'];
            $result[$resultKey]['time'] = date('h:i A', strtotime($data_game['time']));
        }
        echo json_encode($result);
    }
    
    public function show_win_ajax()
    {
        $chk =array();
        $date = $_POST['win_from_date'];
        $panna = $_POST['win_pana'];
        $digit = $_POST['win_result_new'];
        $game_id = $_POST['win_game_id'];
        
        $start_date = ("$date 00:00:00");
        $end_date = ("$date 23:59:59");
            
        $jobs_wc = ['conditions' => "  (`game_type` = 'single_digit' OR `game_type` = 'single_panna' OR `game_type` = 'double_panna' OR `game_type` = 'triple_panna') AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND (`panna` = '$panna' OR `digit` = '$digit') "];
        $chk = $this->StarlineBidModel->all($jobs_wc);
        
        foreach($chk as $key=>$val)
        {
            
            $data_bid_user = $this->UsersModel->first([ 'conditions' => ['id'   => $val['user_id']] ]);
            $data_game = $this->StarlineGamesModel->first([ 'conditions' => ['id'   => $val['game_id']] ]);
            $game_type_bid = $this->StarlineGameRateModel->first(['conditions' => ['name' => $val['game_type']]]);
            
            $chk[$key]['mobile'] = $data_bid_user['mobile'];
            $chk[$key]['username'] = $data_bid_user['username'];
            $chk[$key]['game_name'] = $data_game['name'];
            $chk[$key]['bidded_at'] = ($val['bidded_at']) ? date("d-m-Y", strtotime($val['bidded_at'])): date("d-m-Y");
            $chk[$key]['game_type'] = ucwords(str_replace('_',' ',$val['game_type']));
            $chk[$key]['panna'] = ($val['panna']) ? $val['panna']: 'N/A';
            $chk[$key]['digit'] = ($val['digit']) ? $val['digit']: 'N/A';
            $chk[$key]['win_points'] = ($val['bid_points'] * $game_type_bid['per_point_earning_amount']);

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
        $result_date = $date." ".date('H:i:s');
        $start_date = ("$date 00:00:00");
        $end_date = ("$date 23:59:59");
        
        $rate = $this->StarlineResultsModel->save([
            'panna'                 => $panna,
            'digit'                => $digit,
            'game_id'               =>$game_id,
            'date'              => $result_date
        ]);
            
        if($rate){
            $game = $this->StarlineGamesModel->first(['conditions' => ['id' =>$game_id]]);
            // ✅ FIX: OneSignal broadcast replaces deprecated FCM loop
            $title = ($game['name']);
            $mes = $panna . "-" . $digit;
            sendResultNotificationOneSignal($title, $mes, 'MANUAL_RESULT');
            $Notification = $this->NotificationModel->save([
                'message'      => $mes,
                'heading'      => "[MANUAL] " . $title,
                'user_id'      => "all",
                'status'       => true,
                'created_date' => date('Y-m-d H:i:s')
            ]);

            $rate_win= ['conditions' => "  (`game_type` = 'single_digit' OR `game_type` = 'single_panna' OR `game_type` = 'double_panna' OR `game_type` = 'triple_panna') AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND (`panna` = '$panna' OR `digit` = '$digit') "];
            $chk = $this->StarlineBidModel->all($rate_win);
            foreach($chk as $key_con=>$val_con)
            {
                $game_type_bid = $this->StarlineGameRateModel->first(['conditions' => ['name' => $val_con['game_type']]]);
                $win_point = ($val_con['bid_points'] * $game_type_bid['per_point_earning_amount']);
                $user_id = $val_con['user_id'];
                $arr = [
                    'user_id' => $user_id,
                    'points' => $win_point,
                    'trans_type' => 20,
                    'trans_status' => "SUCCESSFULL",
                    'admin_status' => 'APPROVED',
                    'trans_det' => $rate."S",
                    'created_at' => date("Y-m-d H:i:s")
                ];
                $trans_save  = $this->UserTransModel->save($arr);
                if($trans_save)
                { 
                    $whr_arr  = ['conditions' => ['id' => $user_id]];
                    $user = $this->UsersModel->first($whr_arr);
                    $data_game = $this->StarlineGamesModel ->first(['conditions' => ['id' => $game_id]]);
                    $updated_points = $win_point + $user['available_points'];
                    $update_arr = [ 'available_points' => $updated_points ];
                    $whr_user = ['id' => $user_id];
                    $updt_point_user = $this->UsersModel->updateTable($update_arr, $whr_user);
                    $update_bid_arr = [ 'win_points' => $win_point,'won' => '1', 'result_id' => $arr['trans_det'], 'won_at'=>date("Y-m-d H:i:s")];
                    $con_bid = ['id' => $val_con['id']];
                    $update_bid = $this->StarlineBidModel->updateTable($update_bid_arr, $con_bid);
                    $chk[$key_con]['win_amount'] = $win_point;
                    $chk[$key_con]['user_name'] = $user['username'];
                    $chk[$key_con]['user_mobile'] = $user['mobile'];
                    $chk[$key_con]['game_name'] = $data_game['name'];
                }
            }
        }
        echo json_encode($chk);
           
    }

    /** Load List Page */
    public function list_result_starline()
    {
        $date = date("Y-m-d");
        $games = array();

        $games = $this->StarlineGamesModel->all([
            'conditions' => ['status' => '1'],
        ]);

        $number = PANNA;
        $start_date = ("$date 00:00:00");
        $end_date = ("$date 23:59:59");
        

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('starline/result_list', compact('games', 'number'));
        $this->load->view('template/footer');
    }
    
    public function change_res($id)
    {

            $job = $this->StarlineResultsModel->destroy(['id' => $id]);
            
            if($job)
            {
                $r_id = $id."S";
                $update_bid_array = [ 'win_points' => '0','won'=>'0','result_id'=>'','won_at'=>'0000-00-00 00:00:00' ];
                $con_bid  = ['result_id' => $r_id];
                $updt_bid = $this->StarlineBidModel->updateTable($update_bid_array, $con_bid);
                $trans_all = $this->UserTransModel->all(['conditions' => ['trans_det' => $r_id]]);
                foreach($trans_all as $key_tra =>$val_trans)
                {
                    $whr_arr  = ['conditions' => ['id' => $val_trans['user_id']]];
                    $user = $this->UsersModel->first($whr_arr);
                    $updated_points = $user['available_points'] -  $val_trans['points'];
                    $update_arr = [ 'available_points' => $updated_points ];
                    $whr_user = ['id' => $val_trans['user_id']];
                    $updt_point_user = $this->UsersModel->updateTable($update_arr, $whr_user);
                    $whr_dearr = [ 'id' => $val_trans['id'] ];
                    $delete_tra = $this->UserTransModel->destroy($whr_dearr);
                }
                
            }


        flash_message(
            'result_list/starline',
            $job,
            'success',
            "Deleted Successfully"
        );
    }


    /** Add Category */
    public function result_history_starline()
    {
        $resultDataList = $this->StarlineResultsModel->all(['order' => ['by'=>'id','type'=>'DESC']]);
        
       
        
        foreach($resultDataList as $resultKey => $dataResult){
            $data_game = $this->StarlineGamesModel ->first(['conditions' => ['id' => $dataResult['game_id']]]);
            
            $resultDataList[$resultKey]['game_name'] = $data_game['name'];
            
            $resultDataList[$resultKey]['panna'] = ($dataResult['panna'])?$dataResult['panna']:'***';
            $resultDataList[$resultKey]['digit'] = ($dataResult['digit'])?$dataResult['digit']:'*';
            $resultDataList[$resultKey]['result'] = $resultDataList[$resultKey]['panna'].'-'.$resultDataList[$resultKey]['digit'];
            $resultDataList[$resultKey]['date'] = date('d-m-Y', strtotime($dataResult['date']));
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('starline/result_history', compact('resultDataList'));
        $this->load->view('template/footer');
    }

    public function delete_starline_game($id = null)
    {


        $ratings = $this->StarlineGamesModel->destroy(['id' => $id]);
        flash_message(
            'list/starline',
            $ratings,
            'unsuccess',
            "Something Went Wrong"
        );

        flash_message(
            'list/starline',
            $ratings,
            'success',
            "Starline Game Deleted Successfully"
        );
    }
}

    /* End of file  Rating.php */
