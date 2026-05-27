<?php defined('BASEPATH') or exit('No direct script access allowed');
/** Load Category Pages & Queries */
class Galidisawar extends CI_Controller
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

        $this->load->model(['NotificationModel', 'UsersModel', 'GalidisawarBidModel', 'GalidisawarGameRateModel', 'GalidisawarGameModel', 'GalidisawarResultModel', 'BidModel', 'GamesModel', 'StarlineWinPredictionModel', 'UserTransModel']);
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
	    
	    $orgDate =  $_POST['gali_bid_revert_date'];
        $newDate = date("Y-m-d", strtotime($orgDate));
        $start_date = ("$newDate 00:00:00");
        $end_date = ("$newDate 23:59:59");
        
        $jobs_wc['conditions']['bid.bidded_at >'] = $start_date;
        $jobs_wc['conditions']['bid.bidded_at >'] = $end_date;
        $cond = ['conditions'=>"(`bidded_at` > '$start_date')  AND (`bidded_at` < '$end_date')"];
        
        $query =[];
        
        $query = $this->GalidisawarBidModel->all($cond);
        
        foreach($query as $key=>$val)
        {
             $bid_points = $val['bid_points'];
             $id = $val['id'];
             $u_id = $val['user_id'];
            
            $trans_con = [ 'conditions'=>"(`trans_type`='21')  AND `user_id`='$u_id'  AND `trans_det`='$id'"];
            $transdata = $this->UserTransModel->first($trans_con);
            
           
             $transdata_destroy  = $this->UserTransModel->destroy(['id' => $transdata['id']]);
            $user = $this->UsersModel->first(['id' => $u_id]);
            $total_points = $user['available_points'];
            $upd_point = $total_points + $bid_points;
            $user_point_update = $this->UsersModel->updateTable([ 'available_points' => $upd_point,], ['id' => $u_id]); 
                
        }
        
        
	}

    public function edit_bid_history_gali_disawar($id)
    {

        if ($this->input->post('editbidhisstarline')) {

            $panna = $_POST['panna'];
            $digit = $_POST['digit'];
            $bid_points = $_POST['bid_points'];
            $old_bid =   $this->GalidisawarBidModel->first(['conditions' => ['id'     => $id]]);
            $old_bid_point = $old_bid['bid_points'];
            $user =   $this->UsersModel->first(['conditions' => ['id'     => $old_bid['user_id']]]);
            if ($bid_points == $old_bid_point) {
                $rate = $this->GalidisawarBidModel->updateTable([
                    'left_digit'                      => $digit,
                    'right_digit'                      => $panna
                ], ['id' => $id]);
            } else {

                $rate = $this->GalidisawarBidModel->updateTable([
                    'left_digit'                      => $digit,
                    'right_digit'                      => $panna,
                    'bid_points'                    => $bid_points
                ], ['id' => $id]);
                $u_id = $user['id'];
                $trans_con = ['conditions' => "(`trans_type`='9')  AND `user_id`='$u_id'  AND `trans_det`='$id'"];
                $transdata = $this->UserTransModel->first($trans_con);
                $transdata_point_update = $this->UserTransModel->updateTable([
                    'points'                      => $bid_points,
                ], ['id' => $transdata['id']]);

                $main_diff_points = $old_bid_point - $bid_points;
                $total_points = $user['available_points'];

                $upd_point = $total_points + $main_diff_points;

                $user_point_update = $this->UsersModel->updateTable([
                    'available_points'                      => $upd_point,
                ], ['id' => $user['id']]);
            }



            flash_message(
                'edit_bid/gali_disawar/' . $id,
                $rate,
                'unsuccess',
                "Something Went Wrong"
            );

            flash_message(
                'Bid_history_list/gali_disawar',
                $rate,
                'success',
                "Bid Updated Successfully"
            );
        }

        $ratingssssData = '';
        $ratingssssData = $this->GalidisawarBidModel->first(['conditions' => ['id'     => $id]]);
        $ratingssssData['game_type'] = ucwords(str_replace('_', ' ', $ratingssssData['game_type']));
        if ($ratingssssData) {
            $user =   $this->UsersModel->first(['conditions' => ['id'     => $ratingssssData['user_id'],]]);
            $ratingssssData['username'] = $user['username'];

            $gameData =   $this->GalidisawarGameModel->first(['conditions' => ['id'     => $ratingssssData['game_id'],]]);
            $ratingssssData['game_name'] = $gameData['name'];
        } else {
            $ratingssssData['username'] = "";
            $ratingssssData['game_name'] = "";
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('gali_disawar/edit_bid', compact('ratingssssData'));
        $this->load->view('template/footer');
    }

    public function edit_bid_gali_disawar($id)
    {


        if ($this->input->post('editbidstarline')) {


            $panna = $_POST['panna'];
            $digit = $_POST['digit'];
            $bid_points = $_POST['bid_points'];
            $old_bid =   $this->GalidisawarBidModel->first(['conditions' => ['id'     => $id]]);
            $old_bid_point = $old_bid['bid_points'];
            $user =   $this->UsersModel->first(['conditions' => ['id'     => $old_bid['user_id']]]);
            if ($bid_points == $old_bid_point) {
                $rate = $this->GalidisawarBidModel->updateTable([
                    'left_digit'                      => $digit,
                    'right_digit'                      => $panna
                ], ['id' => $id]);
            } else {

                $rate = $this->GalidisawarBidModel->updateTable([
                    'left_digit'                      => $digit,
                    'right_digit'                      => $panna,
                    'bid_points'                    => $bid_points
                ], ['id' => $id]);
                $u_id = $user['id'];
                $trans_con = ['conditions' => "(`trans_type`='9')  AND `user_id`='$u_id'  AND `trans_det`='$id'"];
                $transdata = $this->UserTransModel->first($trans_con);
                $transdata_point_update = $this->UserTransModel->updateTable([
                    'points'                      => $bid_points,
                ], ['id' => $transdata['id']]);

                $main_diff_points = $old_bid_point - $bid_points;
                $total_points = $user['available_points'];

                $upd_point = $total_points + $main_diff_points;

                $user_point_update = $this->UsersModel->updateTable([
                    'available_points'                      => $upd_point,
                ], ['id' => $user['id']]);
            }



            // _ddd($vehicles);

            flash_message(
                'edit/gali_disawar/' . $id,
                $rate,
                'unsuccess',
                "Something Went Wrong"
            );

            flash_message(
                'result_list/gali_disawar',
                $rate,
                'success',
                "Bid Updated Successfully"
            );
        }


        $ratingssssData = '';
        $ratingssssData = $this->GalidisawarBidModel->first(['conditions' => ['id'     => $id]]);
        $ratingssssData['game_type'] = ucwords(str_replace('_', ' ', $ratingssssData['game_type']));
        if ($ratingssssData) {
            $user =   $this->UsersModel->first(['conditions' => ['id'     => $ratingssssData['user_id'],]]);
            $ratingssssData['username'] = $user['username'];

            $gameData =   $this->GalidisawarGameModel->first(['conditions' => ['id'     => $ratingssssData['game_id'],]]);
            $ratingssssData['game_name'] = $gameData['name'];
        } else {
            $ratingssssData['username'] = "";
            $ratingssssData['game_name'] = "";
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('gali_disawar/edit', compact('ratingssssData'));
        $this->load->view('template/footer');
    }

    /** Load List Page */
    public function list_game_gali_disawar()
    {

        $ratingsData = [];
        $ratingsData = $this->GalidisawarGameModel->all([
            'conditions' => [
                'status!='     => '3',
            ],
            'order' => [
                'by'   => 'id',
                'type' => 'DESC'
            ]
        ]);

        foreach ($ratingsData as $gameKey => $gameData) {
            $ratingsData[$gameKey]['name'] = ucwords($gameData['name']);
            $ratingsData[$gameKey]['time'] = date('h:i A', strtotime($gameData['time']));
            $ratingsData[$gameKey]['market_status'] = (date("H:i:s") < $gameData['time']) ? true : false;
        }


        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('gali_disawar/list', compact('ratingsData'));
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

            $jobs_wc['conditions']['gali_disawar_bid.bidded_at>'] = $start_date;
            $jobs_wc['conditions']['gali_disawar_bid.bidded_at<'] = $end_date;
        }
        if (isset($_POST['game_id']) && ($_POST['game_id'] != '') && ($_POST['game_id']
            !== 'All')) {
            $jobs_wc['conditions']['gali_disawar_bid.game_id'] = $_POST['game_id'];
        }
        if (isset($_POST['game_type']) && ($_POST['game_type'] != '') && ($_POST['game_type']
            !== 'All')) {
            $jobs_wc['conditions']['gali_disawar_bid.game_type'] = $_POST['game_type'];
        }
        

        $sellList = $this->GalidisawarBidModel->all($jobs_wc);
       

        $left_digit_array = DIGIT;
        $right_digit_array = DIGIT;
        $jodi_digit_array = JODI_DIGIT;
        $triple_digit_array = TRIPLE_DIGIT;

        $tripleDigitReport = array();
        $jodiDigitReport = array();
        $leftDigitReport = array();
        $rightDigitReport = array();

         
        
        foreach ($left_digit_array as $sdKey => $sdData) {
            $leftDigitReport[$sdKey]['number'] = $sdData;
            $leftDigitReport[$sdKey]['count'] = 0;
        }
        
        foreach ($right_digit_array as $right_Key => $right_Data) {
            $rightDigitReport[$right_Key]['number'] = $right_Data;
            $rightDigitReport[$right_Key]['count'] = 0;
        }
        
        foreach ($jodi_digit_array as $jdKey => $jdData) {
            
            $jodiDigitReport[$jdKey]['number'] = $jdData;
            $jodiDigitReport[$jdKey]['count'] = 0;
        }
         

        foreach ($sellList as $sellKey => $sellData) {
            $left_digit = $sellData['left_digit'];
            $right_digit = $sellData['right_digit'];

            if ($sellData['game_type'] == 'left_digit') {
                if ($left_digit != "") {
                    $dataP = array_search($left_digit, $left_digit_array);
                    $leftDigitReport[$dataP]['count'] +=  $sellData['bid_points'];
                }
            }
            if ($sellData['game_type'] == 'right_digit') {
                if ($right_digit != "") {
                    $dataP = array_search($right_digit, $right_digit_array);
                    $rightDigitReport[$dataP]['count'] +=  $sellData['bid_points'];
                }
            }
            if ($sellData['game_type'] == 'jodi_digit') {
                if ($right_digit != "") {
                    $dataP = array_search($right_digit, $jodi_digit_array);
                    $jodiDigitReport[$dataP]['count'] +=  $sellData['bid_points'];
                }
            }
        }
        $games = $this->GalidisawarGameModel->all(['conditions' => ['status' => '1']]);
      
        


        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('gali_disawar/sell_report_list', compact('jodiDigitReport','rightDigitReport', 'leftDigitReport','games'));
        $this->load->view('template/footer');
    }


    /** Load List Page */
    public function prediction_list()
    {

        $chk = [];
        if (isset($_POST['pre_filter'])) {


            if (isset($_POST['open_panna']) || ($_POST['open_panna'] != '') || ($_POST['open_panna']
                !== 'All')) {

                $orgDate =  $_POST['from_date'];
                $newDate = date("Y-m-d", strtotime($orgDate));
                $start_date = ("$newDate 00:00:00");
                $end_date = ("$newDate 23:59:59");

                $open_panna = $_POST['open_panna'];

                $game_id = $_POST['game_id'];


                $jobs_wc = ['conditions' => " `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND (`right_digit` = '$open_panna') "];
            }
            
            if (isset($_POST['left_digit']) || ($_POST['left_digit'] != '') || ($_POST['left_digit']
                !== 'All')) {

                $orgDate =  $_POST['from_date'];
                $newDate = date("Y-m-d", strtotime($orgDate));
                $start_date = ("$newDate 00:00:00");
                $end_date = ("$newDate 23:59:59");

                $left_digit = $_POST['left_digit'];

                $game_id = $_POST['game_id'];



                $jobs_wc = ['conditions' => " `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND (`left_digit` = '$left_digit') "];
            }

            $chk = $this->GalidisawarBidModel->all($jobs_wc);
        }


        $games = $this->GalidisawarGameModel->all(['status' => '1']);
        $number = PANNA;


        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('gali_disawar/prediction_list', compact('chk', 'games', 'number'));
        $this->load->view('template/footer');
    }

    /** Load List Page */
    public function gali_disawar_bid_history_list()
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

                $jobs_wc['conditions']['gali_disawar_bid.bidded_at>'] = $start_date;
                $jobs_wc['conditions']['gali_disawar_bid.bidded_at<'] = $end_date;
            }
            if (isset($_POST['game_id']) && ($_POST['game_id'] != '') && ($_POST['game_id']
                !== 'All')) {
                $jobs_wc['conditions']['gali_disawar_bid.game_id'] = $_POST['game_id'];
            }
            if (isset($_POST['game_type']) && ($_POST['game_type'] != '') && ($_POST['game_type']
                !== 'All')) {
                $jobs_wc['conditions']['gali_disawar_bid.game_type'] = $_POST['game_type'];
            }
        }



        $userData = [];
        $userData = $this->GalidisawarBidModel->all($jobs_wc);

        foreach ($userData as $dataKey => $data) {
            $data_bid_user = $this->UsersModel->first(['conditions' => ['id'   => $data['user_id']]]);
            $data_game = $this->GalidisawarGameModel->first(['conditions' => ['id'   => $data['game_id']]]);

            $userData[$dataKey]['bidded_at'] = ($data['bidded_at']) ? date("d-m-Y", strtotime($data['bidded_at'])) : date("d-m-Y");
            $userData[$dataKey]['username'] = ($data_bid_user['username']) ? $data_bid_user['username'] : "N/A";
            $userData[$dataKey]['game_name'] = ($data_game['name']) ? $data_game['name'] : "N/A";
            $userData[$dataKey]['game_type'] = ucwords(str_replace('_', ' ', $data['game_type']));
        }

        $games = $this->GalidisawarGameModel->all(['conditions' => ['status' => '1']]);

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('gali_disawar/Bid_history_list', compact('userData', 'games'));
        $this->load->view('template/footer');
    }


    /** Add add_game_starline */
    public function add_game_gali_disawar()
    {
        if ($this->input->post('addGames')) {

            $rateingsss = $this->GalidisawarGameModel->save([
                'name'                             => $this->input->post('name'),
                'time'                      => $this->input->post('time'),
                'status'                           => '2',
            ]);

            flash_message(
                'add/gali_disawar',
                $rateingsss,
                'unsuccess',
                "Something Went Wrong"
            );

            flash_message(
                'list/gali_disawar',
                $rateingsss,
                'success',
                "Galidisawar Game Added Successfully"
            );
        }


        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('gali_disawar/add');
        $this->load->view('template/footer');
    }

    public function edit_game_gali_disawar($id)
    {


        if ($this->input->post('editgamestarline')) {

            $rate = $this->GalidisawarGameModel->updateTable([
                'name'                      => $this->input->post('name'),
                'time'                      => $this->input->post('time')
            ], ['id' => $id]);

            flash_message(
                'edit/gali_disawar/' . $id,
                $rate,
                'unsuccess',
                "Something Went Wrong"
            );

            flash_message(
                'list/gali_disawar',
                $rate,
                'success',
                "Galidisawar Games Updated Successfully"
            );
        }


        $ratingssssData = '';
        $ratingssssData = $this->GalidisawarGameModel->first([
            'conditions' => [
                'id'     => $id,
            ]
        ]);
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('gali_disawar/edit', compact('ratingssssData'));
        $this->load->view('template/footer');
    }

    public function change_delete($id)
    {

        $job = $this->GalidisawarGameModel->updateTable([
            'status' => '3'
        ], ['id' => $id]);

        flash_message(
            'list/gali_disawar',
            $job,
            'success',
            "Deleted Successfully"
        );
    }


    /** Change Status */
    public function change_status_gamegali_disawar($id, $stat)
    {

        if ($stat == 'inactive') {

            $job = $this->GalidisawarGameModel->updateTable([
                'status'            => '2',
                'market_status'      => '2'
            ], ['id' => $id]);

            flash_message(
                'list/gali_disawar',
                $job,
                'success',
                "Status Inactive Successfully"
            );
        }

        if ($stat == 'active') {

            $game = $this->GalidisawarGameModel->first([

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

            $job = $this->GalidisawarGameModel->updateTable([
                'status'            => '1',
                'market_status'      => $m_stts
            ], ['id' => $id]);
            flash_message(
                'list/gali_disawar',
                $job,
                'success',
                "Status Active Successfully"
            );
        }
    }

    public function add_game__rate_gali_disawar()
    {
        $ratingsData = [];
        if ($this->input->post('addGamerate')) {


            if ((!empty($_POST['left_digit_value_1'])) or (!empty($_POST['left_digit_value_2']))) {

                $job = $this->GalidisawarGameRateModel->updateTable([
                    'cost_amount'            => $this->input->post('left_digit_value_1'),
                    'earning_amount'      => $this->input->post('left_digit_value_2'),
                    'per_point_earning_amount' => $this->input->post('left_digit_value_2') / $this->input->post('left_digit_value_1')
                ], ['id' => 1]);
            }

            if ((!empty($_POST['right_digit_1'])) or (!empty($_POST['right_digit_2']))) {

                $job = $this->GalidisawarGameRateModel->updateTable([
                    'cost_amount'            => $this->input->post('right_digit_1'),
                    'earning_amount'      => $this->input->post('right_digit_2'),
                    'per_point_earning_amount' => $this->input->post('right_digit_2') / $this->input->post('right_digit_1')
                ], ['id' => 2]);
            }

            if ((!empty($_POST['jodi_digit_1'])) or (!empty($_POST['jodi_digit_2']))) {

                $job = $this->GalidisawarGameRateModel->updateTable([
                    'cost_amount'            => $this->input->post('jodi_digit_1'),
                    'earning_amount'      => $this->input->post('jodi_digit_2'),
                    'per_point_earning_amount' => $this->input->post('jodi_digit_2') / $this->input->post('jodi_digit_1')
                ], ['id' => 3]);
            }
        
        
        if ((!empty($_POST['triple_digit_1'])) or (!empty($_POST['triple_digit_2']))) {

                $job = $this->GalidisawarGameRateModel->updateTable([
                    'cost_amount'            => $this->input->post('triple_digit_1'),
                    'earning_amount'      => $this->input->post('triple_digit_2'),
                    'per_point_earning_amount' => $this->input->post('triple_digit_2') / $this->input->post('triple_digit_1')
                ], ['id' => 4]);
            }
        }
        
        $left_digit  = $this->GalidisawarGameRateModel->first(['conditions' => [
            'id' => 1
        ]]);
        $right_digit = $this->GalidisawarGameRateModel->first(['conditions' => [
            'id' => 2
        ]]);
        $jodi_digit  = $this->GalidisawarGameRateModel->first(['conditions' => [
            'id' => 3
        ]]);
         $triple_digit  = $this->GalidisawarGameRateModel->first(['conditions' => [
            'id' => 4
        ]]);

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('gali_disawar/game_rate_add', compact('left_digit', 'right_digit', 'jodi_digit',  'triple_digit',));
        $this->load->view('template/footer');
    }

    public function gali_disawar_winning_report_list()
    {
        $jobs_wc = [
            'conditions' => ['won' => 1],
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

            $jobs_wc['conditions']['gali_disawar_bid.won_at>'] = $start_date;
            $jobs_wc['conditions']['gali_disawar_bid.won_at<'] = $end_date;
        }
        if (isset($_POST['game_id']) && ($_POST['game_id'] != '') && ($_POST['game_id']
            !== 'All')) {
            $jobs_wc['conditions']['gali_disawar_bid.game_id'] = $_POST['game_id'];
        }


        $userData = [];
        $userData = $this->GalidisawarBidModel->all($jobs_wc);
        $games = $this->GalidisawarGameModel->all(['conditions' => ['status' => '1']]);

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('gali_disawar/win_report_list', compact('userData', 'games'));
        $this->load->view('template/footer');
    }

    public function check_result()
    {
        $chk = array();
        $date = $_POST['from_date_new'];
        $game_id = $_POST['game_id_gali'];
        $start_date = ("$date 00:00:00");
        $end_date = ("$date 23:59:59");



        $result = $this->GalidisawarResultModel->first([
            'conditions' => ['date>=' => $start_date, 'date<=' => $end_date, 'game_id' => $game_id],
        ]);
        if ($result) {
            $chk['panna'] = $result['right_digit'];
            $chk['digit'] = $result['left_digit'];
        }
        echo json_encode($chk);
    }

    public function fetch_result()
    {
        $chk = array();
        $date = $_POST['from_date_new'];
        $start_date = ("$date 00:00:00");
        $end_date = ("$date 23:59:59");

        $result = $this->GalidisawarResultModel->all([
            'conditions' => ['date>=' => $start_date, 'date<=' => $end_date],
            'order' => ['by' => 'id', 'type' => 'DESC']
        ]);
        foreach ($result as $resultKey => $resultData) {
            $data_game = $this->GalidisawarGameModel->first(['conditions' => ['id'   => $resultData['game_id']]]);
            $result[$resultKey]['game_name'] = $data_game['name'];
            $result[$resultKey]['time'] = date('h:i A', strtotime($data_game['time']));
        }
        echo json_encode($result);
    }

    public function show_win_ajax()
    {
        $chk = array();
        $date = $_POST['from_date_new'];
         $right_digit = $_POST['right_digit'];
         $left_digit_result = $_POST['left_digit_result'];
         $game_id = $_POST['game_id_gali'];
        

        $start_date = ("$date 00:00:00");
        $end_date = ("$date 23:59:59");

        $jobs_wc = ['conditions' => "  (`game_type` = 'right_digit' OR `game_type` = 'left_digit') AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND (`right_digit` = '$right_digit' OR `left_digit` = '$left_digit_result') "];
        $chk = $this->GalidisawarBidModel->all($jobs_wc);
        
        $job_jodi = ['conditions' => "`game_type` = 'jodi_digit' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `right_digit` = '$right_digit' AND `left_digit` = '$left_digit_result' "];
        $data_jodi = $this->GalidisawarBidModel->all($job_jodi);
        $chk = array_merge($chk,$data_jodi);

        foreach ($chk as $key => $val) {

            $data_bid_user = $this->UsersModel->first(['conditions' => ['id'   => $val['user_id']]]);
            $data_game = $this->GalidisawarGameModel->first(['conditions' => ['id'   => $val['game_id']]]);
            $game_type_bid = $this->GalidisawarGameRateModel->first(['conditions' => ['name' => $val['game_type']]]);

            $chk[$key]['mobile'] = $data_bid_user['mobile'];
            $chk[$key]['username'] = $data_bid_user['username'];
            $chk[$key]['game_name'] = $data_game['name'];
            $chk[$key]['bidded_at'] = ($val['bidded_at']) ? date("d-m-Y", strtotime($val['bidded_at'])) : date("d-m-Y");
            $chk[$key]['game_type'] = ucwords(str_replace('_', ' ', $val['game_type']));
            $chk[$key]['right_digit'] = ($val['right_digit']) ? $val['right_digit'] : 'N/A';
            $chk[$key]['left_digit'] = ($val['left_digit']) ? $val['left_digit'] : 'N/A';
            $chk[$key]['win_points'] = ($val['bid_points'] * $game_type_bid['per_point_earning_amount']);
        }
       
        echo json_encode($chk);
    }

    public function declare_ajax()
    {
        $chk = array();
        $date = $_POST['from_date_new_declare'];
        $game_id = $_POST['game_id_gali'];
        $gali_right_digit = $_POST['gali_right_digit'];
        $left_digit_result = $_POST['left_digit_result'];
        $result_date = $date . " " . date('H:i:s');
        $start_date = ("$date 00:00:00");
        $end_date = ("$date 23:59:59");

        $rate = $this->GalidisawarResultModel->save([
            'right_digit'                 => $gali_right_digit,
            'left_digit'                => $left_digit_result,
            'game_id'               => $game_id,
            'date'              => $result_date
        ]);

        if ($rate) {
            $game = $this->GalidisawarGameModel->first(['conditions' => ['id' => $game_id]]);
            // ✅ FIX: OneSignal broadcast replaces deprecated FCM loop
            $title = ($game['name']);
            $mes = $gali_right_digit . "-" . $left_digit_result;
            sendResultNotificationOneSignal($title, $mes);
            $Notification = $this->NotificationModel->save([
                'message'      => $mes,
                'heading'      => "[GALI] " . $title,
                'user_id'      => "all",
                'status'       => true,
                'created_date' => date('Y-m-d H:i:s')
            ]);

            $rate_win = ['conditions' => "  (`game_type` = 'right_digit' OR `game_type` = 'left_digit') AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND (`right_digit` = '$gali_right_digit' OR `left_digit` = '$left_digit_result') "];
            $chk = $this->GalidisawarBidModel->all($rate_win);
            
            $job_jodi = ['conditions' => "`game_type` = 'jodi_digit' AND `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `right_digit` = '$gali_right_digit' AND `left_digit` = '$left_digit_result' "];
            $data_jodi = $this->GalidisawarBidModel->all($job_jodi);
            $chk = array_merge($chk,$data_jodi);
            
            foreach ($chk as $key_con => $val_con) {
                $game_type_bid = $this->GalidisawarGameRateModel->first(['conditions' => ['name' => $val_con['game_type']]]);
                $win_point = ($val_con['bid_points'] * $game_type_bid['per_point_earning_amount']);
                $user_id = $val_con['user_id'];
                $arr = [
                    'user_id' => $user_id,
                    'points' => $win_point,
                    'trans_type' => 20,
                    'trans_status' => "SUCCESSFULL",
                    'admin_status' => 'APPROVED',
                    'trans_det' => $rate . "G",
                    'created_at' => date("Y-m-d H:i:s")
                ];
                $trans_save  = $this->UserTransModel->save($arr);
                if ($trans_save) {
                    $whr_arr  = ['conditions' => ['id' => $user_id]];
                    $user = $this->UsersModel->first($whr_arr);
                    $data_game = $this->GalidisawarGameModel->first(['conditions' => ['id' => $game_id]]);
                    $updated_points = $win_point + $user['available_points'];
                    $update_arr = ['available_points' => $updated_points];
                    $whr_user = ['id' => $user_id];
                    $updt_point_user = $this->UsersModel->updateTable($update_arr, $whr_user);
                    $update_bid_arr = ['win_points' => $win_point, 'won' => '1', 'result_id' => $arr['trans_det'], 'won_at' => date("Y-m-d H:i:s")];
                    $con_bid = ['id' => $val_con['id']];
                    $update_bid = $this->GalidisawarBidModel->updateTable($update_bid_arr, $con_bid);
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
    public function list_result_gali_disawar()
    {
        $date = date("Y-m-d");
        $games = array();

        $games = $this->GalidisawarGameModel->all([
            'conditions' => ['status' => '1'],
        ]);

        $number = PANNA;
        $start_date = ("$date 00:00:00");
        $end_date = ("$date 23:59:59");


        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('gali_disawar/result_list', compact('games', 'number'));
        $this->load->view('template/footer');
    }

    public function change_res($id)
    {

        $job = $this->GalidisawarResultModel->destroy(['id' => $id]);

        if ($job) {
            $r_id = $id . "S";
            $update_bid_array = ['win_points' => '0', 'won' => '0', 'result_id' => '', 'won_at' => '0000-00-00 00:00:00'];
            $con_bid  = ['result_id' => $r_id];
            $updt_bid = $this->GalidisawarBidModel->updateTable($update_bid_array, $con_bid);
            $trans_all = $this->UserTransModel->all(['conditions' => ['trans_det' => $r_id]]);
            foreach ($trans_all as $key_tra => $val_trans) {
                $whr_arr  = ['conditions' => ['id' => $val_trans['user_id']]];
                $user = $this->UsersModel->first($whr_arr);
                $updated_points = $user['available_points'] -  $val_trans['points'];
                $update_arr = ['available_points' => $updated_points];
                $whr_user = ['id' => $val_trans['user_id']];
                $updt_point_user = $this->UsersModel->updateTable($update_arr, $whr_user);
                $whr_dearr = ['id' => $val_trans['id']];
                $delete_tra = $this->UserTransModel->destroy($whr_dearr);
            }
        }


        flash_message(
            'result_list/gali_disawar',
            $job,
            'success',
            "Deleted Successfully"
        );
    }


    /** Add Category */
    public function result_history_gali_disawar()
    {
        $resultDataList = $this->GalidisawarResultModel->all(['order' => ['by' => 'id', 'type' => 'DESC']]);

        foreach ($resultDataList as $resultKey => $dataResult) {
            $data_game = $this->GalidisawarGameModel->first(['conditions' => ['id' => $dataResult['game_id']]]);

            $resultDataList[$resultKey]['game_name'] = $data_game['name'];

            $resultDataList[$resultKey]['right_digit'] = ($dataResult['right_digit']) ? $dataResult['right_digit'] : '***';
            $resultDataList[$resultKey]['left_digit'] = ($dataResult['left_digit']) ? $dataResult['left_digit'] : '*';
            $resultDataList[$resultKey]['result'] = $resultDataList[$resultKey]['right_digit'] . '-' . $resultDataList[$resultKey]['left_digit'];
            $resultDataList[$resultKey]['date'] = date('d-m-Y', strtotime($dataResult['date']));
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('gali_disawar/result_history', compact('resultDataList'));
        $this->load->view('template/footer');
    }

    public function delete_gali_disawar_game($id = null)
    {


        $ratings = $this->GalidisawarGameModel->destroy(['id' => $id]);
        flash_message(
            'list/gali_disawar',
            $ratings,
            'unsuccess',
            "Something Went Wrong"
        );

        flash_message(
            'list/gali_disawar',
            $ratings,
            'success',
            "Galidisawar Game Deleted Successfully"
        );
    }
}

    /* End of file  Rating.php */
