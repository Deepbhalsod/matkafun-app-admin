<?php defined('BASEPATH') or exit('No direct script access allowed');

/** Load & Execute User Modules */
class Fund extends CI_Controller
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
		$this->load->model(['UsersModel', 'BidModel',  'GamesModel', 'WithdrawReqModel', 'FundModel','UserTransModel','ResultsModel']);
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
	public function list_fund_req()
	{
	    $userData = $this->UserTransModel->all([
			'conditions' => [
				
				'trans_type' => 1,
				'admin_status' => 'PENDING',
				
			],

			'datatype' => 'json'
		]);

		//_dd($userData);

		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('fund/fund_req_list', compact('userData'));
		$this->load->view('template/footer');
	}
	
	public function change_action_status_withdraw($id, $stat)
	{
	    $trans_status = "Successful";

		if($stat=="REJECTED"){
		    $transData = $this->UserTransModel->first([ 'conditions' => [ 'id' => $id] ]);
		    $data_bid_user = $this->UsersModel->first([ 'conditions' => ['id'   => $transData['user_id']] ]);
		    $current_points = $data_bid_user['available_points'] + $transData['points'];
		    $update_arr_point = [ 'available_points' => $current_points ];
            $whrr_user = ['id' => $transData['user_id']];
            $this->UsersModel->updateTable($update_arr_point, $whrr_user);
		    $trans_status = "Rejected";
		}
		
		$job = $this->UserTransModel->updateTable([
			'admin_status'            => $stat,
			'modified_date'      =>date('Y-m-d h:i:s a', time()),
			'trans_status'=> $trans_status
		], ['id' => $id]);
		
	

		flash_message(
			'withdraw_req_list/fund',
			$job,
			'success',
			"Status Change Successfully"
		);
	}

	// lIST USER
	public function list_withdraw_req()
	{

		$userData = $this->UserTransModel->all([
		    
		    'conditions'=>['trans_type'=>6],

			'order' => [
				'by' => 'id',
				'type' => 'DESC'
			],
			'datatype' => 'json'
		]);

		//_dd($userData);

		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('fund/withdraw_req_list', compact('userData'));
		$this->load->view('template/footer');
	}
	
	public function show_details()
	{
	    
	    $id = $_POST['show_url'];
		$userData = $this->UserTransModel->first([
		    
		    'conditions'=>['trans_type'=>6 ,'id'=>$id],

		]);
		if(!empty($userData))
		{
		    
		       $user = $this->UsersModel->first([
		    
        		    'conditions'=>['id'=>$userData['user_id']],
        
        		]);
        		
    		    if($userData['trans_det']=="gpay_mobile_no")
    		    {
    		       $userData['payment_method'] ="Googlepay";
    		       $userData['payment_method_no'] = $user['gpay_mobile_no'];
    		        
    		    }elseif($userData['trans_det']=="bank_name")
    		    {
    		       $userData['payment_method'] ="Bank";
    		       $userData['payment_method_no'] = $user['bank_account_no'];
    		        
    		    }elseif($userData['trans_det']=="paytm_mobile_no")
    		    {  
    		       $userData['payment_method'] ="Paytm";
    		       $userData['payment_method_no'] = $user['paytm_mobile_no'];
    		        
    		    }elseif($userData['trans_det']=="phonepe_mobile_no")
    		    {
    		        $userData['payment_method'] = "Phonepe";
    		        $userData['payment_method_no'] = $user['phonepe_mobile_no'];
    		        
    		    }
    		    
        		$userData['username'] = $user['username'];
		}
		
		echo json_encode($userData);
	}


	/** Add Category */
	public function add_fund()
	{
		if ($this->input->post('Addfund')) {
		    
		    $trans_id=uniqid();
		    $user_id = $this->input->post('user_id');

			$rateingsss = $this->UserTransModel->save([
			   
				'user_id'              => $this->input->post('user_id'),
				'points'               => $this->input->post('amount'),
				'trans_type'            => 3,
                'trans_status'          =>'successful',
                'admin_status'          => 'APPROVED',
                'trans_det'             => 'add_fund_by_admin',
                'created_at'            => Date('Y-m-d H:i:s'),
			]);
			
			if($rateingsss)
            {
                  $userData = $this->UsersModel->first([
            			'conditions' => [
            				'id' => $user_id
            			],
            
            		]);
            		
            		$this_points = $this->input->post('amount');
            		$av_points =$userData['available_points'];
            	    
            	    $point =($av_points + $this_points);	
                   
                	$job = $this->UsersModel->updateTable([
            			'available_points'            => $point,
            		
            		], ['id' => $user_id]);
            	
            }

			flash_message(
				'add/fund',
				$rateingsss,
				'unsuccess',
				"Something Went Wrong"
			);

			flash_message(
				'add/fund',
				$rateingsss,
				'success',
				"Fund Added Successfully"
			);
		}

		$users = $this->UsersModel->all();

		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('fund/add', compact('users'));
		$this->load->view('template/footer');
	}

	// VIEW payment_list
	public function bid_revert_list()
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
                
                $jobs_wc['conditions']['bid.bidded_at >'] = $start_date;
                $jobs_wc['conditions']['bid.bidded_at >'] = $end_date;
            }
            if (isset($_POST['game_id']) && ($_POST['game_id'] != '') && ($_POST['game_id']
                !== 'All')) {
                $jobs_wc['conditions']['bid.game_id'] = $_POST['game_id'];
            }
            
            
        }else{
           
                $orgDate = date('Y-m-d');
                $newDate = date("Y-m-d", strtotime($orgDate));
                $start_date = ("$newDate 00:00:00");
                $end_date = ("$newDate 23:59:59");
                
                $jobs_wc['conditions']['bid.bidded_at >'] = $start_date;
                $jobs_wc['conditions']['bid.bidded_at <'] = $end_date;
                
        }



        $userData = [];
        $query =[];
        $bid_id_array =[];
        $query = $this->BidModel->all($jobs_wc);
       
        
        foreach($query as $aKey => $data_a){
            
            $bid_id_array[]=$data_a['id'];
            
            $result = $this->ResultsModel->all([
                'conditions' => ['decleared_at>=' => $start_date,'decleared_at<=' => $end_date,'game_id'=>$data_a['game_id']],
            ]);
            
            $in_array=[];
            if(!empty($result))
            {
                foreach($result as $key=>$val)
                {
                    $in_array[]=$data_a['id'];
                }
            }
            
            
        }
       
        if(!empty($in_array))
        {
            
            
            $result = array_diff($bid_id_array,$in_array);
            $sub_in_array = implode(',', $result);
             
            $bid_WHR = [
                'conditions' => "id IN ($sub_in_array)"
            ];

            $userData  = $this->BidModel->all($bid_WHR);
            
            foreach($userData as $dataKey => $data){
                
                $bid_id_array[]=$data['id'];
                
                $result = $this->ResultsModel->all([
                    'conditions' => ['decleared_at>=' => $start_date,'decleared_at<=' => $end_date,'game_id'=>$data['game_id']],
                ]);
                
                $in_array=[];
                if(!empty($result))
                {
                    foreach($result as $key=>$val)
                    {
                        $in_array[]=$data['id'];
                    }
                }
                
                
                $data_bid_user = $this->UsersModel->first([ 'conditions' => ['id'   => $data['user_id']] ]);
                $data_game = $this->GamesModel->first([ 'conditions' => ['id'   => $data['game_id']] ]);
                
                $userData[$dataKey]['bidded_at'] = ($data['bidded_at']) ? date("d-m-Y", strtotime($data['bidded_at'])): date("d-m-Y");
                $userData[$dataKey]['user_name'] = ($data_bid_user['username']) ? $data_bid_user['username'] : "N/A";
                $userData[$dataKey]['game_name'] = ($data_game['name'])? $data_game['name'] :"N/A";
                $userData[$dataKey]['game_type'] = ucwords(str_replace('_',' ',$data['game_type']));
            
            
            }
        }else{
            
             $userData  = $this->BidModel->all($jobs_wc);
            
            foreach($userData as $dataKey => $data){
                
                $bid_id_array[]=$data['id'];
                
                $result = $this->ResultsModel->all([
                    'conditions' => ['decleared_at>=' => $start_date,'decleared_at<=' => $end_date,'game_id'=>$data['game_id']],
                ]);
                
                $in_array=[];
                if(!empty($result))
                {
                    foreach($result as $key=>$val)
                    {
                        $in_array[]=$data['id'];
                    }
                }
                
                
                $data_bid_user = $this->UsersModel->first([ 'conditions' => ['id'   => $data['user_id']] ]);
                $data_game = $this->GamesModel->first([ 'conditions' => ['id'   => $data['game_id']] ]);
                
                $userData[$dataKey]['bidded_at'] = ($data['bidded_at']) ? date("d-m-Y", strtotime($data['bidded_at'])): date("d-m-Y");
                $userData[$dataKey]['user_name'] = ($data_bid_user['username']) ? $data_bid_user['username'] : "N/A";
                $userData[$dataKey]['game_name'] = ($data_game['name'])? $data_game['name'] :"N/A";
                $userData[$dataKey]['game_type'] = ucwords(str_replace('_',' ',$data['game_type']));
            
            
            }
            
        }
        
        $games = $this->GamesModel->all([ 'conditions' => ['status'   => '1'] ]);

		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('fund/bid_revert_list', compact('userData','games'));
		$this->load->view('template/footer');
	}
	
	
	public function revert_bid_by_click()
	{
	    
	     $orgDate =  $_POST['date'];
        $newDate = date("Y-m-d", strtotime($orgDate));
        $start_date = ("$newDate 00:00:00");
        $end_date = ("$newDate 23:59:59");
        
        $jobs_wc['conditions']['bid.bidded_at >'] = $start_date;
        $jobs_wc['conditions']['bid.bidded_at >'] = $end_date;
        $cond = ['conditions'=>"(`bidded_at` > '$start_date')  AND (`bidded_at` < '$end_date')"];
        
        $query =[];
        
        $query = $this->BidModel->all($cond);
        
        foreach($query as $key=>$val)
        {
            echo $bid_points = $val['bid_points'];
            echo $id = $val['id'];
            echo $u_id = $val['user_id'];
            
            $trans_con = [ 'conditions'=>"(`trans_type`='9')  AND `user_id`='$u_id'  AND `trans_det`='$id'"];
            $transdata = $this->UserTransModel->first($trans_con);
            
           
             $transdata_destroy  = $this->UserTransModel->destroy(['id' => $transdata['id']]);
            $user = $this->UsersModel->first(['id' => $u_id]);
            $total_points = $user['available_points'];
            $upd_point = $total_points + $bid_points;
            $user_point_update = $this->UsersModel->updateTable([ 'available_points' => $upd_point,], ['id' => $u_id]); 
                
        }
        
        
	}

	/** Delete USER */
	public function delete_user($id = null)
	{
		empty($id) and show_404();

		user_can('user_delete') or show_404();

		flash_message(
			'list/user',
			$id,
			'unsuccess',
			"Please Select Id"
		);

		$role = $this->UsersModel->destroy(['id' => $id]);
		flash_message(
			'list/user',
			$role,
			'unsuccess',
			"Something Went Wrong"
		);

		flash_message(
			'list/user',
			$role,
			'success',
			"User Deleted Successfully"
		);
	}
}

    /* End of file  User.php */
