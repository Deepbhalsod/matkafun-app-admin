<?php defined('BASEPATH') or exit('No direct script access allowed');
/** Load Category Pages & Queries */
class Report extends CI_Controller
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

        $this->load->model(['BidModel', 'GamesModel', 'TransferPointModel','WinModel', 'WithdrawReqModel','UserTransModel','UsersModel','TransactionTypeModel']);
    }


    /** Load Default Index To Show 404 Error
     *
     * @return void */
    public function index()
    {
        return show_404();
    }


    /** Load List Page */
    public function report_user_bid_history_list()
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
                $end_date = ("$newDate 23:59:59");
                
                $jobs_wc['conditions']['bid.bidded_at>'] = $start_date;
                $jobs_wc['conditions']['bid.bidded_at<'] = $end_date;
            }
            if (isset($_POST['game_id']) && ($_POST['game_id'] != '') && ($_POST['game_id']
                !== 'All')) {
                $jobs_wc['conditions']['bid.game_id'] = $_POST['game_id'];
            }
            if (isset($_POST['game_type']) && ($_POST['game_type'] != '') && ($_POST['game_type']
                !== 'All')) {
                $jobs_wc['conditions']['bid.game_type'] = $_POST['game_type'];
            }
        }else{
                $orgDate = date('Y-m-d');
                $newDate = date("Y-m-d", strtotime($orgDate));
                $start_date = ("$newDate 00:00:00");
                $end_date = ("$newDate 23:59:59");
                
                $jobs_wc['conditions']['bid.bidded_at>'] = $start_date;
                $jobs_wc['conditions']['bid.bidded_at<'] = $end_date;
                
        }



        $userData = [];
        $userData = $this->BidModel->all($jobs_wc);
        foreach($userData as $dataKey => $data){
            $data_bid_user = $this->UsersModel->first([ 'conditions' => ['id'   => $data['user_id']] ]);
            $data_game = $this->GamesModel->first([ 'conditions' => ['id'   => $data['game_id']] ]);
            
            $userData[$dataKey]['bidded_at'] = ($data['bidded_at']) ? date("Y-m-d H:i:s", strtotime($data['bidded_at'])): date("Y-m-d H:i:s");
            $userData[$dataKey]['user_name'] = ($data_bid_user['username']) ? $data_bid_user['username'] : "N/A";
            $userData[$dataKey]['game_name'] = ($data_game['name'])? $data_game['name'] :"N/A";
            $userData[$dataKey]['game_type'] = ucwords(str_replace('_',' ',$data['game_type']));
            
            
        }

        $games = $this->GamesModel->all([ 'conditions' =>['status' => '1']]);

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('report/report_user_bid_history_list', compact('userData', 'games'));
        $this->load->view('template/footer');
    }
    
    public function edit_user_bid_history($id)
    {


        if ($this->input->post('editbidHIS')) {
            
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
                'edit/report/' . $id,
                $rate,
                'unsuccess',
                "Something Went Wrong"
            );

            flash_message(
                'report_user_bid_history_list/report',
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
        $this->load->view('report/edit_user_bid', compact('ratingssssData'));
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
            
            $jobs_wc['conditions']['bid.bidded_at>'] = $start_date;
            $jobs_wc['conditions']['bid.bidded_at<'] = $end_date;
        }
        if (isset($_POST['game_id']) && ($_POST['game_id'] != '') && ($_POST['game_id']
            !== 'All')) {
            $jobs_wc['conditions']['bid.game_id'] = $_POST['game_id'];
        }
        
        $sellList = $this->BidModel->all($jobs_wc);
        
        
       
    // print_r($sellData);
    // die();
    
        $single_digit_array = range(0,9);    
        $jodi_digit_array= JODI_DIGIT;
	    $single_panna_array=SINGLE_PANNA;
	    $double_panna_array = Double_PANNA;
	    $triple_panna_array = Triple_PANNA;
	    
	    $singleDigitReport = array();
	    $jodiDigitReport = array();
	    $singlePannaReport = array();
	    $doublePannaReport = array();
	    $triplePannaReport = array();
	    
	   
	    
	    foreach($single_digit_array as $sdKey => $sdData){
	        $singleDigitReport[$sdKey]['number'] = $sdData;
	        $singleDigitReport[$sdKey]['count'] = 0;
	    }
	    
	    foreach($jodi_digit_array as $jdKey => $jdData){
	        $jodiDigitReport[$jdKey]['number'] = $jdData;
	        $jodiDigitReport[$jdKey]['count'] = 0;
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
	        $open_digit = $sellData['open_digit'];
	        $close_digit = $sellData['close_digit'];
	        $open_panna = $sellData['open_panna'];
	        $close_panna = $sellData['close_panna'];
            
            if($sellData['game_type']=='single_digit'){
                if($open_digit!=""){
                    $dataP = array_search($open_digit,$single_digit_array);
                    $singleDigitReport[$dataP]['count'] +=  $sellData['bid_points'];
                }
                if($close_digit!=""){
                    $dataP = array_search($open_digit,$single_digit_array);
                    $singleDigitReport[$dataP]['count'] +=  $sellData['bid_points'];
                }
            }
            
            if($sellData['game_type']=='jodi_digit'){
                if($open_digit!="" && $close_digit!=""){
                    $digit = $open_digit.$close_digit;
                    $dataP = array_search($digit,$jodi_digit_array);
                    $jodiDigitReport[$dataP]['count'] +=  $sellData['bid_points'];
                }
            }
            if($sellData['game_type']=='single_panna'){
                if($open_panna!=""){
                    $dataP = array_search($open_panna,$single_panna_array);
                    $singlePannaReport[$dataP]['count'] +=  $sellData['bid_points'];
                }
                if($close_panna!=""){
                    $dataP = array_search($close_panna,$single_panna_array);
                    $singlePannaReport[$dataP]['count'] +=  $sellData['bid_points'];
                }
            }
            if($sellData['game_type']=='double_panna'){
                if($open_panna!=""){
                    $dataP = array_search($open_panna,$double_panna_array);
                    $doublePannaReport[$dataP]['count'] +=  $sellData['bid_points'];
                }
                if($close_panna!=""){
                    $dataP = array_search($close_panna,$double_panna_array);
                    $doublePannaReport[$dataP]['count'] +=  $sellData['bid_points'];
                }
            }
            if($sellData['game_type']=='triple_panna'){
                if($open_panna!=""){
                    $dataP = array_search($open_panna,$triple_panna_array);
                    $triplePannaReport[$dataP]['count'] +=  $sellData['bid_points'];
                }
                if($close_panna!=""){
                    $dataP = array_search($close_panna,$triple_panna_array);
                    $triplePannaReport[$dataP]['count'] +=  $sellData['bid_points'];
                }
            }
            
        }
	    
	   
        $games = $this->GamesModel->all([ 'conditions' =>['status' => '1']]);
          
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('report/sell_report_list', compact('singleDigitReport','jodiDigitReport','singlePannaReport','doublePannaReport','triplePannaReport', 'games'));
        $this->load->view('template/footer');
    }

        /** Load List Page */
    public function winning_report_list()
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
              $end_date = ("$newDate 23:59:59");
            
            $jobs_wc['conditions']['bid.won_at>'] = $start_date;
            $jobs_wc['conditions']['bid.won_at<'] = $end_date;
        }else{
                $orgDate = date('Y-m-d');
                $newDate = date("Y-m-d", strtotime($orgDate));
                $start_date = ("$newDate 00:00:00");
                $end_date = ("$newDate 23:59:59");
                
                $jobs_wc['conditions']['bid.bidded_at>'] = $start_date;
                $jobs_wc['conditions']['bid.bidded_at<'] = $end_date;
                
        }

        if (isset($_POST['game_id']) && ($_POST['game_id'] != '') && ($_POST['game_id']
            !== 'All')) {
            $jobs_wc['conditions']['bid.game_id'] = $_POST['game_id'];
        }
        


        $userData = [];
        $userData = $this->BidModel->all($jobs_wc);
        foreach($userData as $dataKey => $data){
            $data_bid_user = $this->UsersModel->first([ 'conditions' => ['id'   => $data['user_id']] ]);
            $data_game = $this->GamesModel->first([ 'conditions' => ['id'   => $data['game_id']] ]);
            
            $userData[$dataKey]['won_at'] = ($data['won_at']) ? date("Y-m-d H:i:s", strtotime($data['won_at'])): date("Y-m-d H:i:s");
            $userData[$dataKey]['user_mobile'] = ($data_bid_user['mobile']) ? $data_bid_user['mobile'] : "N/A";
            $userData[$dataKey]['user_name'] = ($data_bid_user['username']) ? $data_bid_user['username'] : "N/A";
            $userData[$dataKey]['game_name'] = ($data_game['name'])? $data_game['name'] :"N/A";
            $userData[$dataKey]['game_type'] = ucwords(str_replace('_',' ',$data['game_type']));
        }
        $games = $this->GamesModel->all([ 'conditions' =>['status' => '1']]);

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('report/winning_report_list', compact('userData', 'games'));
        $this->load->view('template/footer');
    }

    /** Load List Page */
    public function bid_winning_report_list()
    {
        $jobs_wc = [
            'order'      => [
                'by'   => 'id',
                'type' => 'DESC'
            ],

        ];

        if (isset($_POST['from_date']) && $_POST['from_date'] != '') {

            $orgDate =  $_POST['from_date'];
            $newDate = date("Y-m-d", strtotime($orgDate));
            $start_date = ("$newDate 00:00:00");
            $end_date = ("$newDate 23:59:59");
            
            $jobs_wc['conditions']['bid.bidded_at>'] = $start_date;
            $jobs_wc['conditions']['bid.bidded_at<'] = $end_date;
        }else{
               $orgDate = date('Y-m-d');
                $newDate = date("Y-m-d", strtotime($orgDate));
                $start_date = ("$newDate 00:00:00");
                $end_date = ("$newDate 23:59:59");
                
                $jobs_wc['conditions']['bid.bidded_at>'] = $start_date;
                $jobs_wc['conditions']['bid.bidded_at<'] = $end_date;
        }
        if (isset($_POST['game_id']) && ($_POST['game_id'] != '') && ($_POST['game_id']
            !== 'All')) {
            $jobs_wc['conditions']['bid.game_id'] = $_POST['game_id'];
        }

        $userData = [];
        $userData = $this->BidModel->all($jobs_wc);
        
        $jobs_wc['conditions']['won'] = '1';
        $dataWin = $this->BidModel->all($jobs_wc);
        $bidReport['total_bid_points'] = 0;
        $bidReport['total_win_points'] = 0;
        $bidReport['total_profit_points'] = 0;
        
        $games = $this->GamesModel->all([ 'conditions' =>['status' => '1']]);
        foreach($userData as $dataKey => $data){
            $data_bid_user = $this->UsersModel->first([ 'conditions' => ['id'   => $data['user_id']] ]);
            $data_game = $this->GamesModel->first([ 'conditions' => ['id'   => $data['game_id']] ]);
            
            $userData[$dataKey]['bidded_at'] = ($data['bidded_at']) ? date("Y-m-d H:i:s", strtotime($data['bidded_at'])): date("Y-m-d H:i:s");
            $userData[$dataKey]['username'] = ($data_bid_user['username']) ? $data_bid_user['username'] : "N/A";
            $userData[$dataKey]['game_name'] = ($data_game['name'])? $data_game['name'] :"N/A";
            $userData[$dataKey]['game_type'] = ucwords(str_replace('_',' ',$data['game_type']));
            $bidReport['total_bid_points'] += (int)$data['bid_points'];
        }
        foreach($dataWin as $winKey => $win){
            $data_bid_user = $this->UsersModel->first([ 'conditions' => ['id'   => $win['user_id']] ]);
            $data_game = $this->GamesModel->first([ 'conditions' => ['id'   => $win['game_id']] ]);
            
            $dataWin[$winKey]['won_at'] = ($win['won_at']) ? date("Y-m-d H:i:s", strtotime($win['won_at'])): date("Y-m-d H:i:s");
            $dataWin[$winKey]['mobile'] = ($data_bid_user['mobile']) ? $data_bid_user['mobile'] : "N/A";
            $dataWin[$winKey]['username'] = ($data_bid_user['username']) ? $data_bid_user['username'] : "N/A";
            $dataWin[$winKey]['game_name'] = ($data_game['name'])? $data_game['name'] :"N/A";
            $dataWin[$winKey]['game_type'] = ucwords(str_replace('_',' ',$win['game_type']));
            $bidReport['total_win_points'] += (int)$win['win_points'];
        }
        
        $bidReport['total_profit_points'] = $bidReport['total_bid_points']-$bidReport['total_win_points'];
        
        
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('report/bid_winning_report_list', compact('userData','games','dataWin','bidReport'));
        $this->load->view('template/footer');
    }

    public function withdraw_report_list()
    {
       
        $jobs_wc = [
                      'order'      => [
                                    'by'   => 'id',
                                    'type' => 'DESC'
                                ],
                    ];
        $jobs_wc['conditions']['trans_type = 6 OR `trans_type`='] = '7';
         //$jobs_wc['conditions']['OR trans_type'] = '7';

        
        if (isset($_POST['filter'])) {


            if (isset($_POST['from_date']) && $_POST['from_date'] != '') {

                
                $orgDate =  $_POST['from_date'];
                $newDate = date("Y-m-d", strtotime($orgDate));
                $start_date = ("$newDate 00:00:00");
                $end_date = ("$newDate 23:59:59");
            
                $jobs_wc['conditions']['user_trans.created_at>'] = $start_date;
                $jobs_wc['conditions']['user_trans.created_at<'] = $end_date;
                
                //$jobs_wc = ['conditions' => " `created_at` >= '$start_date' AND `created_at` <= '$end_date'  "];
            
            }
        }else{
               $orgDate =  date("Y-m-d");
                $newDate = date("Y-m-d", strtotime($orgDate));
                $start_date = ("$newDate 00:00:00");
                $end_date = ("$newDate 23:59:59");
            
                $jobs_wc['conditions']['user_trans.created_at>'] = $start_date;
                $jobs_wc['conditions']['user_trans.created_at<'] = $end_date;
             //$jobs_wc = ['conditions' => " `created_at` >= '$start_date' AND `created_at` <= '$end_date'  "];
           
        }


        $userData = [];
        $userData = $this->UserTransModel->all($jobs_wc);
        foreach($userData as $dataKey => $data){
            $data_user = $this->UsersModel->first([ 'conditions' => ['id'   => $data['user_id']] ]);
            
            $userData[$dataKey]['created_at'] = ($data['created_at']) ? date("Y-m-d H:i:s", strtotime($data['created_at'])): date("Y-m-d H:i:s");
            $userData[$dataKey]['username'] = ($data_user['username']) ? $data_user['username'] : "N/A";
            $userData[$dataKey]['mobile'] = ($data_user['mobile']) ? $data_user['mobile'] : "N/A";
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('report/withdraw_report_list', compact('userData'));
        $this->load->view('template/footer');
    }
    
    public function add_fund_report_list()
    {
        $jobs_wc = [
            'conditions'=>"(`trans_type`='2' or `trans_type`='3' or `trans_type`='4' or `trans_type`='5' or `trans_type`='20')",
            'order'      => ['by'   => 'id','type' => 'DESC']
            ];

        $userData = [];
        $userData = $this->UserTransModel->all($jobs_wc);
        
        
        foreach($userData as $dataKey => $data){
            $data_user = $this->UsersModel->first([ 'conditions' => ['id'   => $data['user_id']] ]);
            
            $DataTrans = $this->TransactionTypeModel->first([ 'conditions' => ['id' => $data['trans_type'] ] ]);
            
            $userData[$dataKey]['created_at'] = ($data['created_at']) ? date("Y-m-d H:i:s", strtotime($data['created_at'])): date("Y-m-d H:i:s");
            $userData[$dataKey]['username'] = ($data_user['username']) ? $data_user['username'] : "N/A";
            $userData[$dataKey]['mobile'] = ($data_user['mobile']) ? $data_user['mobile'] : "N/A";
            $userData[$dataKey]['details'] = $DataTrans['trans_msg'];
        }
        
        
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('report/add_fund_report_list', compact('userData'));
        $this->load->view('template/footer');
    }
    
    public function auto_deposite_history_list()
    {
        $jobs_wc = [
            'conditions'=>['trans_type'=>1],
            'order'      => [
                'by'   => 'id',
                'type' => 'DESC'
            ],

        ];

        $userData = [];
        $userData = $this->UserTransModel->all($jobs_wc);
        foreach($userData as $dataKey => $data){
            $data_user = $this->UsersModel->first([ 'conditions' => ['id'   => $data['user_id']] ]);
            
            $userData[$dataKey]['created_at'] = ($data['created_at']) ? date("Y-m-d H:i:s", strtotime($data['created_at'])): date("Y-m-d H:i:s");
            $userData[$dataKey]['username'] = ($data_user['username']) ? $data_user['username'] : "N/A";
            $userData[$dataKey]['mobile'] = ($data_user['mobile']) ? $data_user['mobile'] : "N/A";
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('report/auto_deposite_history_list', compact('userData'));
        $this->load->view('template/footer');
    }
    
    /** Load List Page */
    public function report_transfer_point_report_list()
    {
        $jobs_wc = [
            'fields' => ['SUM(points) as total_amount', 'id', 'user_id', 'trans_det', 'points', 'created_at'],
            'conditions'=>['trans_type'=>8],
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
                $end_date = ("$newDate 23:59:59");
            
                $jobs_wc['conditions']['user_trans.created_at>'] = $start_date;
                $jobs_wc['conditions']['user_trans.created_at<'] = $end_date;
            
            }
            
        }else{
            
                $orgDate =  date("Y-m-d");
                $newDate = date("Y-m-d", strtotime($orgDate));
                $start_date = ("$newDate 00:00:00");
                $end_date = ("$newDate 23:59:59");
            
                $jobs_wc['conditions']['user_trans.created_at>'] = $start_date;
                $jobs_wc['conditions']['user_trans.created_at<'] = $end_date;
            
        }



        $userData = [];
        $userData = $this->UserTransModel->all($jobs_wc);
       
        if(!empty($userData[0]['created_at']))
        {        
            
            foreach($userData as $dataKey => $data){
                $data_send_user = $this->UsersModel->first([ 'conditions' => ['id'   => $data['user_id']] ]);
                $data_rec_user = $this->UsersModel->first([ 'conditions' => ['id'   => $data['trans_det']] ]);
                
                // $userData[$dataKey]['created_at'] = ($data['created_at']) ? date("d-m-Y", strtotime($data['created_at'])): date("d-m-Y");
                $userData[$dataKey]['user_sender'] = ($data_send_user['username']) ? $data_send_user['username'] : "N/A";
                $userData[$dataKey]['user_receiver'] = ($data_rec_user['username']) ? $data_rec_user['username'] : "N/A";
                $userData[$dataKey]['sender_id'] = $data['user_id'];
                $userData[$dataKey]['receiver_id'] = $data['trans_det'];
            }
            
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('report/report_transfer_point_report_list', compact('userData'));
        $this->load->view('template/footer');
    }

    public function delete_game($id = null)
    {


        $ratings = $this->GamesModel->destroy(['id' => $id]);
        flash_message(
            'list/game',
            $ratings,
            'unsuccess',
            "Something Went Wrong"
        );

        flash_message(
            'list/game',
            $ratings,
            'success',
            "Game Deleted Successfully"
        );
    }
}

    /* End of file  Rating.php */
