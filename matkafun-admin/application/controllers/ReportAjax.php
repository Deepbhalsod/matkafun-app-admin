<?php defined('BASEPATH') or exit('No direct script access allowed');
/** Load Category Pages & Queries */
class ReportAjax extends CI_Controller
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
    public function report_user_bid_his()
    {
        
        
        $userData = [];
         
        $jobs_wc = [
            'order'      => [
                'by'   => 'id',
                'type' => 'DESC'
            ],

        ];

        
            if (isset($_POST['report_bid_from_date']) && $_POST['report_bid_from_date'] != '') {
                $orgDate =  $_POST['report_bid_from_date'];
                $newDate = date("Y-m-d", strtotime($orgDate));
                $start_date = ("$newDate 00:00:00");
                $end_date = ("$newDate 23:59:59");
                
                $jobs_wc['conditions']['bid.bidded_at>'] = $start_date;
                $jobs_wc['conditions']['bid.bidded_at<'] = $end_date;
            }
            if (($_POST['report_bid_game_id'] != '') || ($_POST['report_bid_game_id']!== 'All')) {
                $jobs_wc['conditions']['bid.game_id'] = $_POST['report_bid_game_id'];
            }
            if (isset($_POST['report_bid_game_type']) && ($_POST['report_bid_game_type'] != '') && ($_POST['report_bid_game_type']
                !== 'All')) {
                $jobs_wc['conditions']['bid.game_type'] = $_POST['report_bid_game_type'];
            }
        

        
        $userData = $this->BidModel->all($jobs_wc);
        _ddd($userData);
        foreach($userData as $dataKey => $data){
            $data_bid_user = $this->UsersModel->first([ 'conditions' => ['id'   => $data['user_id']] ]);
            $data_game = $this->GamesModel->first([ 'conditions' => ['id'   => $data['game_id']] ]);
            
            $userData[$dataKey]['bidded_at'] = ($data['bidded_at']) ? date("d-m-Y", strtotime($data['bidded_at'])): date("d-m-Y");
            $userData[$dataKey]['user_name'] = ($data_bid_user['username']) ? $data_bid_user['username'] : "N/A";
            $userData[$dataKey]['game_name'] = ($data_game['name'])? $data_game['name'] :"N/A";
            $userData[$dataKey]['game_type'] = ucwords(str_replace('_',' ',$data['game_type']));
            
            
        }
       
         echo json_encode($userData);

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
            
            $userData[$dataKey]['won_at'] = ($data['won_at']) ? date("d-m-Y", strtotime($data['won_at'])): date("d-m-Y");
            $userData[$dataKey]['user_mobile'] = ($data_bid_user['mobile']) ? $data_bid_user['mobile'] : "N/A";
            $userData[$dataKey]['user_name'] = ($data_bid_user['username']) ? $data_bid_user['username'] : "N/A";
            $userData[$dataKey]['game_name'] = ($data_game['name'])? $data_game['name'] :"N/A";
            $userData[$dataKey]['game_type'] = ucwords(str_replace('_',' ',$data['game_type']));
        }
        $games = $this->GamesModel->all(['status' => '1']);

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
        
        $games = $this->GamesModel->all(['status' => '1']);
        foreach($userData as $dataKey => $data){
            $data_bid_user = $this->UsersModel->first([ 'conditions' => ['id'   => $data['user_id']] ]);
            $data_game = $this->GamesModel->first([ 'conditions' => ['id'   => $data['game_id']] ]);
            
            $userData[$dataKey]['bidded_at'] = ($data['bidded_at']) ? date("d-m-Y", strtotime($data['bidded_at'])): date("d-m-Y");
            $userData[$dataKey]['username'] = ($data_bid_user['username']) ? $data_bid_user['username'] : "N/A";
            $userData[$dataKey]['game_name'] = ($data_game['name'])? $data_game['name'] :"N/A";
            $userData[$dataKey]['game_type'] = ucwords(str_replace('_',' ',$data['game_type']));
            $bidReport['total_bid_points'] += (int)$data['bid_points'];
        }
        foreach($dataWin as $winKey => $win){
            $data_bid_user = $this->UsersModel->first([ 'conditions' => ['id'   => $win['user_id']] ]);
            $data_game = $this->GamesModel->first([ 'conditions' => ['id'   => $win['game_id']] ]);
            
            $dataWin[$winKey]['won_at'] = ($win['won_at']) ? date("d-m-Y", strtotime($win['won_at'])): date("d-m-Y");
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
       
        $jobs_wc = ['conditions' => "`trans_type` = 6 OR `trans_type` = 7 ",
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
            
                // $jobs_wc['conditions']['user_trans.created_at>'] = $start_date;
                // $jobs_wc['conditions']['user_trans.created_at<'] = $end_date;
                
                $jobs_wc = ['conditions' => " `created_at` >= '$start_date' AND `created_at` <= '$end_date'  "];
            
            }
        }else{
               $orgDate =  date("Y-m-d");
                $newDate = date("Y-m-d", strtotime($orgDate));
                $start_date = ("$newDate 00:00:00");
                $end_date = ("$newDate 23:59:59");
            
                // $jobs_wc['conditions']['user_trans.created_at>'] = $start_date;
                // $jobs_wc['conditions']['user_trans.created_at<'] = $end_date;
             $jobs_wc = ['conditions' => " `created_at` >= '$start_date' AND `created_at` <= '$end_date'  "];
           
        }


        $userData = [];
        $userData = $this->UserTransModel->all($jobs_wc);
        foreach($userData as $dataKey => $data){
            $data_user = $this->UsersModel->first([ 'conditions' => ['id'   => $data['user_id']] ]);
            
            $userData[$dataKey]['created_at'] = ($data['created_at']) ? date("d-m-Y", strtotime($data['created_at'])): date("d-m-Y");
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
        $DataTrans = $this->TransactionTypeModel->all();
        foreach($userData as $dataKey => $data){
            $data_user = $this->UsersModel->first([ 'conditions' => ['id'   => $data['user_id']] ]);
            
            $userData[$dataKey]['created_at'] = ($data['created_at']) ? date("d-m-Y", strtotime($data['created_at'])): date("d-m-Y");
            $userData[$dataKey]['username'] = ($data_user['username']) ? $data_user['username'] : "N/A";
            $userData[$dataKey]['mobile'] = ($data_user['mobile']) ? $data_user['mobile'] : "N/A";
            $userData[$dataKey]['details'] = $DataTrans[$data['trans_type']]['trans_msg'];
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
            
            $userData[$dataKey]['created_at'] = ($data['created_at']) ? date("d-m-Y", strtotime($data['created_at'])): date("d-m-Y");
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
