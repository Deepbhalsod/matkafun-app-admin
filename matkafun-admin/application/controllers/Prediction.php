<?php defined('BASEPATH') or exit('No direct script access allowed');

/** Load & Execute User Modules */
class Prediction extends CI_Controller
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
        $this->load->model(['UsersModel', 'User_GroupsModel',  'UserAddressesModel','WinPredictionModel', 'GamesModel','BidModel','GameRateModel']);
    }


    /** Load Default Index To Show 404 Error
     *
     * @return void */
    public function index()
    {
        return show_404();
    }


    /** Add Users
     * @return void */


    // lIST USER
    public function list_prediction()
    {
        $chk=[];
        if (isset($_POST['pre_filter'])) {
            $open_panna = $_POST['open_panna'];
            $close_panna = $_POST['close_panna'];
            $open_digit = "";
            $close_digit = "";
            $orgDate =  $_POST['from_date'];
            $newDate = date("Y-m-d", strtotime($orgDate));
            $start_date = ("$newDate 00:00:00");
            $end_date = ("$newDate 23:59:59");
            $session = $_POST['session'];
            $game_id = $_POST['game_id'];
            
            if(isset($open_panna) && $open_panna!=""){
                $test = str_split($_POST['open_panna']);
                $rrr = [];
                foreach ($test as $key => $val) {
                    $rrr[] = $val;
                }
                $sum = array_sum($rrr);
                $open_digit = (fmod($sum, 10));
            }
            if(isset($close_panna) && $close_panna!=""){
                $test = str_split($_POST['close_panna']);
                $rrr = [];
                foreach ($test as $key => $val) {
                    $rrr[] = $val;
                }
                $sum = array_sum($rrr);
                $close_digit = (fmod($sum, 10));
            }
            
            $jobs_wc = ['conditions' => " `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = '$session' AND (`open_panna` = '$open_panna' OR `open_digit` = '$open_digit' OR `close_panna` = '$close_panna' OR `close_digit` = '$close_digit') "];
            $chk = $this->BidModel->all($jobs_wc);
        }
        
        
        
        
        $games = $this->GamesModel->all([ 'conditions' =>['status' => '1']]);
        $number = PANNA;

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('prediction/list', compact('chk', 'games', 'number'));
        $this->load->view('template/footer');
    }
    
    public function data_by_filter()
    {
        $chk=array();
         
        if ( ($_POST['pre_open_pana'] != '') || ($_POST['pre_session']== 'Open')) {
                
            $orgDate =  $_POST['pre_from_date'];
            $newDate = date("Y-m-d", strtotime($orgDate));
            $start_date = ("$newDate 00:00:00");
            $end_date = ("$newDate 23:59:59");
            
            $open_panna = $_POST['pre_open_pana'];
            
            $session = $_POST['pre_session'];
            $game_id = $_POST['pre_game_id'];
           
            $test = str_split($_POST['pre_open_pana']);
            $rrr = [];
            foreach ($test as $key => $val) {
                $rrr[] = $val;
            }
            $sum = array_sum($rrr);
            $open_digit = (fmod($sum, 10));
            
            
            $jobs_wc = ['conditions' => " `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = '$session' AND (`open_panna` = '$open_panna' OR `open_digit` = '$open_digit') "];  
            
          
          
        }
        if (($_POST['pre_close_pana'] != '') || ($_POST['pre_session']== 'Close')) {
          
            
            $close = str_split($_POST['pre_close_pana']);
            $rrclose= [];
            foreach ($close as $key_close => $val_close) {
                $rrclose[] = $val_close;
            }
            $sum_close = array_sum($rrclose);
            $close_digit = (fmod($sum_close, 10));
            
            $orgDate =  $_POST['pre_from_date'];
            $newDate = date("Y-m-d", strtotime($orgDate));
            $start_date = ("$newDate 00:00:00");
            $end_date = ("$newDate 23:59:59");
            
            $close_panna = $_POST['pre_close_pana'];
            
            $session = $_POST['pre_session'];
            $game_id = $_POST['pre_game_id'];
            
           $jobs_wc = ['conditions' => " `bidded_at` >= '$start_date' AND `bidded_at` <= '$end_date' AND `game_id` = '$game_id' AND `session` = '$session' AND (`close_panna` = '$close_panna' OR `close_digit` = '$close_digit') "];
       
       
        }
        
        $chk = $this->BidModel->all($jobs_wc);
        foreach($chk as $bidKey => $bidData){
            $data_bid_user = $this->UsersModel->first([ 'conditions' => ['id'   => $bidData['user_id']] ]);
            $data_game = $this->GamesModel->first([ 'conditions' => ['id'   => $bidData['game_id']] ]);
            $game_type_bid = $this->GameRateModel->first(['conditions' => ['name' => $bidData['game_type']]]);
            
            $chk[$bidKey]['mobile'] = $data_bid_user['mobile'];
            $chk[$bidKey]['username'] = $data_bid_user['username'];
            $chk[$bidKey]['game_name'] = $data_game['name'];
            $chk[$bidKey]['bidded_at'] = ($bidData['bidded_at']) ? date("d-m-Y", strtotime($bidData['bidded_at'])): date("d-m-Y");
            $chk[$bidKey]['game_type'] = ucwords(str_replace('_',' ',$bidData['game_type']));
            $chk[$bidKey]['open_panna'] = ($bidData['open_panna']) ? $bidData['open_panna']: 'N/A';
            $chk[$bidKey]['open_digit'] = ($bidData['open_digit']) ? $bidData['open_digit']: 'N/A';
            $chk[$bidKey]['close_panna'] = ($bidData['close_panna']) ? $bidData['close_panna']: 'N/A';
            $chk[$bidKey]['close_digit'] = ($bidData['close_digit']) ? $bidData['close_digit']: 'N/A';
            $chk[$bidKey]['win_points'] = ($bidData['bid_points'] * $game_type_bid['per_point_earning_amount']);
        }
       
         echo json_encode($chk);
    }


}

    /* End of file  User.php */
