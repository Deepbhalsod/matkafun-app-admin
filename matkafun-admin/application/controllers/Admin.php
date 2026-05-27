<?php defined('BASEPATH') or exit('No direct script access allowed');
/** Load Admin Dashboard Pages */
class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//Do your magic here

		$this->load->model(['UsersModel', 'User_Group_PowersModel', 'User_GroupsModel', 'AdminModel','GamesModel','BidModel','UserTransModel','SettingsModel']);
		$this->load->library('encryption');
	}


	/** Load Default Index To Show 404 Error
	 *
	 * @return void */
	public function index()
	{
		return show_404();
	}

	public function forgot_password()
	{

		if (isset($_POST['recover'])) {
			// _ddd('jj');
			// $inp = $_POST['recover'];

			$chk = $this->AdminModel->first(['email' => $this->input->post('email')]);

			if (empty($chk)) {
				flash_message(
					'dashboard/forgot_pass',
					$chk,
					'unsuccess',
					'Incorrect Details',
					'Seems Like Your Email Not Found, Please Try With Correct Email Address.'
				);
			} else {
				$token = substr(md5(time()), 0, 6);
				$token_update = $this->AdminModel->updateTable([
					'password' => base64_encode($token),
				], ['email' => $this->input->post('email')]);

				$email = $this->input->post('email');

				$mailTo = $email;
				$subject = "Email For Forgot Password";
				$msg = 'Thankyou for loggin in Strong Arm admin panel. Your forgot password is ' . $token;

				$mail = sendMail($mailTo, $subject, $msg);
				// $mail = mail($to, $subject, $msg, $headers);

				flash_message(
					'dashboard/login',
					$token_update,
					'success',
					'Email Sent Successfully',
					'New Password has been sent on your email. Thank you!'
				);
			}
		}

		$this->load->view('template/header');
		$this->load->view('dashboard/forgot_pass');
		$this->load->view('template/footer');
	}

	/** Load Admin Panel Login */
	public function login()
	{
		is_login() and redirect(SITE_URL . 'dashboard');

		if ($this->input->post('LoginAdmin')) {

			flash_message(
				'dashboard/login',
				$this->input->post('username')
					and $this->input->post('password'),
				'unsuccess',
				'Something Went Wrong',
				'Look like Form Not Fill Properly, Please Fill & Try Again.'
			);

			$username = str_clean($this->input->post('username'), ['@', '.', '-', '_']);
			 $pass = $this->input->post('password');
		     
		  //   $password = base64_encode($pass); 
// 			$password = hash_hmac('sha1', $this->input->post('password'), '');
            $password = $this->input->post('password');
			$user_exists = $this->AdminModel->first([
				'conditions' => "`email` = '$username' OR `mobile` = '$username' OR `username` = '$username'"
			]);

			flash_message(
				'dashboard/login',
				is($user_exists, 'array')
					and (base64_encode($password) === $user_exists['password'] || base64_encode(base64_encode($password)) === $user_exists['password'])
					and $user_exists['role_id'] !== '0'
					and $user_exists['status'] === '1',
				'unsuccess',
				'Incorrect Login Details',
				'Seems Like Your Account Not Found, Please Try With Correct Login Details.'
			);

			is($user_exists, 'array')
				and $powers = $this->User_Group_PowersModel->all([
					'conditions' => [
						'group_id' => $user_exists['role_id'],
						'status!=' => '3'
					],
					'fields' => ['action_key']
				]) and $user_role = $this->User_GroupsModel->first($user_exists['role_id']);

			$power = [];
			if (is($powers, 'array')) {
				foreach ($powers as $VALUE) {
					foreach ($VALUE as $val) {
						$power[] = $val;
					}
				}
				$this->session->set_userdata([
					'LOGIN'          => bin2hex($this->encryption->create_key(16)),
					'USER_ID'        => $user_exists['id'],
					'USER_USERNAME'  => $user_exists['username'],
					'USER_NAME'      => ucwords($user_exists['username']),
					'USER_FULLNAME'  => ucwords($user_exists['username']),
					'USER_EMAIL'     => $user_exists['email'],
					'USER_MOBILE'    => $user_exists['mobile'],
					//'USER_PIC'       => is_null($user_exists['profile_pic']) ? '' : $user_exists['profile_pic'],
					//'USER_TYPE'      => $user_exists['user_type'],
					'USER_ROLE'      => $user_exists['role_id'],
					'USER_ROLE_NAME' => $user_role['group_title'],
					'USER_POWER'     => $power
				]);
			} else {
				flash_message(
					'dashboard/login',
					false,
					'unsuccess',
					'Something Went Wrong',
					'Your Role Not Define Properly Yet, Please Login After Some Time.'
				);
			}

			flash_message(
				'dashboard',
				is($user_exists, 'array'),
				'success',
				'Welcome Back, ' . $_SESSION['USER_NAME'],
				'Nice To See You, Have A Nice Day.'
			);
		}
		
		$whr_logo  = [
            'conditions' => ['option_key' => 'admin_logo'],
            'fields' => ['option_value']
        ];
        $logo = $this->SettingsModel->all($whr_logo);

		$this->load->view('template/header');
		$this->load->view('dashboard/login', compact('logo'));
		$this->load->view('template/footer');
	}

	public function logout()
	{
		flash_message(
			'dashboard/login',
			is_login(),
			'unsuccess',
			'Please Login Then Try Again'
		);
		unset($_SESSION['LOGIN'], $_SESSION['USER_ID'], $_SESSION['USER_USERNAME'], $_SESSION['USER_NAME'], $_SESSION['USER_EMAIL'], $_SESSION['USER_MOBILE'], $_SESSION['USER_PIC'], $_SESSION['USER_TYPE'], $_SESSION['USER_ROLE'], $_SESSION['USER_POWER']);
		flash_message(
			'dashboard/login',
			true,
			'success',
			'Your Account Logout Successfully',
			'See You Later.'
		); 
	} 


	/** Load Dashboard HomePage
	 *
	 * @return void */
	public function home()
	{
		// die("eff");
		flash_message(
			'dashboard/login',
			is_login(),
			'unsuccess',
			'Please Login Then Try Again'
		);



		 $appliee = $this->GamesModel->all(['conditions' => [
				'status' =>'1',
				
			]]);
		 $start_date = date('Y-m-d 00:00:00');
		 $end_date = date('Y-m-d 23:59:59');
		     // ✅ [ADDED] Get Today Registered Users
		     $today_regis = $this->db->query("
		     SELECT COUNT(*) AS total 
		     FROM users 
		     WHERE registred_date BETWEEN '$start_date' AND '$end_date'
		     ")->row()->total;
		     
		     // ✅ [ADDED] Get Today Withdrawal Amount
		     $today_withdrawal = $this->db->query("
		     SELECT COALESCE(SUM(points), 0) AS total 
		     FROM user_trans 
		     WHERE trans_type = 6 
		     AND admin_status = 'APPROVED'
		     AND created_at BETWEEN '$start_date' AND '$end_date'
		     ")->row()->total;
		     
		    // ✅ Get Today Deposit (via UPI / user deposits)
$today_deposit = $this->db->query("
    SELECT COALESCE(SUM(points), 0) AS total 
    FROM user_trans 
    WHERE trans_type = 1
    AND admin_status = 'APPROVED'
    AND created_at BETWEEN '$start_date' AND '$end_date'
")->row()->total;

// ✅ Get Today Deposit by Admin (manual add fund)
$today_depositadmin = $this->db->query("
    SELECT COALESCE(SUM(points), 0) AS total 
    FROM user_trans 
    WHERE trans_type = 3
    AND admin_status = 'APPROVED'
    AND created_at BETWEEN '$start_date' AND '$end_date'
")->row()->total;

		
       
		$querryy = $this->BidModel->all([
			'conditions' => [
				'bidded_at>' => $start_date,
				'bidded_at<' => $end_date,
				
			],
			'fields' => ["SUM(bid_points) AS total_bid_amount"],
			'datatype' => 'json'
		]);
		 $start_new_date = $start_date;
         $end_new_date = $end_date;
         
         if (isset($_POST['filter_from_date']) && $_POST['filter_from_date'] != '') {
             $orgDate = $_POST['filter_from_date'];
             $newDate = date("Y-m-d", strtotime($orgDate));
             $start_new_date = "$newDate 00:00:00";
             $end_new_date = "$newDate 23:59:59";
         }

		if (isset($_POST['filter_from_date'])) {
		  
            $bid_win_wc =[
			'fields' => ["SUM(bid_points) AS filter_total_bid_amount"],
			'datatype' => 'json'
            ];
            
            if (isset($_POST['filter_from_date']) && $_POST['filter_from_date'] != '') {
                
                $orgDate =  $_POST['filter_from_date'];
                $newDate = date("Y-m-d", strtotime($orgDate));
                $start_new_date = ("$newDate 00:00:00");
                  $end_new_date = ("$newDate 23:59:59");
                
                $bid_win_wc['conditions']['bidded_at>'] = $start_new_date;
                $bid_win_wc['conditions']['bidded_at<'] = $end_new_date;
               
                
            }
            if (isset($_POST['filter_game_id']) && ($_POST['filter_game_id'] != '') && ($_POST['filter_game_id']
                !== 'All')) {
                $bid_win_wc['conditions']['game_id'] = $_POST['filter_game_id'];
            }
        
        
            $bid_point = $this->BidModel->all($bid_win_wc);
          
             
        }else{
            
           
            
             $bid_win_wc =[
            'conditions'=>['bidded_at>' => $start_date, 'bidded_at<' => $end_date ],
			'fields' => ["SUM(bid_points) AS filter_total_bid_amount"],
			'datatype' => 'json'
            ];
            
        
        
            $bid_point = $this->BidModel->all($bid_win_wc);
            
        }
        
        
       
       
		
        $win_wc = [
			'conditions' => [
				'bidded_at>' => $start_new_date,
				'bidded_at<' => $end_new_date,
				'won'=>1
			],
			'fields' => ["SUM(win_points) AS win_point"],
			'datatype' => 'json'
		];
        if (isset($_POST['filter_game_id']) && $_POST['filter_game_id'] != '' && $_POST['filter_game_id'] !== 'All') {
            $win_wc['conditions']['game_id'] = $_POST['filter_game_id'];
        }
        $win_point = $this->BidModel->all($win_wc);
		
		$report_withdrawal = $this->db->query("
		    SELECT COALESCE(SUM(points), 0) AS total 
		    FROM user_trans 
		    WHERE trans_type = 6 AND admin_status = 'APPROVED'
		    AND created_at BETWEEN '$start_new_date' AND '$end_new_date'
		")->row()->total;
		
		$report_deposit = $this->db->query("
		    SELECT COALESCE(SUM(points), 0) AS total 
		    FROM user_trans 
		    WHERE trans_type = 1 AND admin_status = 'APPROVED'
		    AND created_at BETWEEN '$start_new_date' AND '$end_new_date'
		")->row()->total;
		
		$report_depositadmin = $this->db->query("
		    SELECT COALESCE(SUM(points), 0) AS total 
		    FROM user_trans 
		    WHERE trans_type = 3 AND admin_status = 'APPROVED'
		    AND created_at BETWEEN '$start_new_date' AND '$end_new_date'
		")->row()->total;

		
	    if (isset($_POST['ank_filter'])) {
	         _ddd($_POST);
		    
                
           $ank_data_wc = [ 'conditions'=>['game_type'=>'single_digit', 'bidded_at>'=>$start_date,'bidded_at<'=>$end_date ]
            ];
            
            
            if (isset($_POST['ank_game_id']) && ($_POST['ank_game_id'] != '') && ($_POST['ank_game_id']
                !== 'All')) {
                $ank_data_wc['conditions']['game_id'] = $_POST['ank_game_id'];
            }
           if (isset($_POST['ank_market']) && ($_POST['ank_market'] != '') && ($_POST['ank_market']
                !== 'All')) {
                    if($_POST['ank_market']=="Close")
                $ank_data_wc['conditions']['close_digit'] = 0;
            }
        
            $zero_ank_data = $this->BidModel->all($ank_data_wc);
            $zero_ankpoints = $this->BidModel->all($ank_data_wc);
	    
    	    $points_zero = [];
    	    foreach($zero_ankpoints as $key_zero=>$zero_val)
    	    {
    	        $points_zero[]=$zero_val['bid_points'];
    	    }
    	    
    	    $sum_zero = array_sum($points_zero);
    	   
            
             
        }
        
        $ank_data_wc = [ 'conditions'=>['game_type'=>'single_digit', 'open_digit'=>0 ,'bidded_at>'=>$start_date,'bidded_at<'=>$end_date ]
            ];

	    $zero_ank_data = $this->BidModel->count($ank_data_wc);
	    

	    $zero_ankpoints = $this->BidModel->all($ank_data_wc);
	    
	    $points_zero = [];
	    foreach($zero_ankpoints as $key_zero=>$zero_val)
	    {
	        $points_zero[]=$zero_val['bid_points'];
	    }
	    
	    $sum_zero = array_sum($points_zero);
	    
	    
	    
	    $onw_ank_data_wc = [
            
            'conditions'=>
            ['game_type'=>'single_digit', 'open_digit'=>1 ,'bidded_at>'=>$start_date,'bidded_at<'=>$end_date ]

        ];
	   
	    $onw_ank_data = $this->BidModel->count($onw_ank_data_wc);
	    
	    $onw_ankpoints = $this->BidModel->all($onw_ank_data_wc);
	    
	    $points_onw = [];
	    foreach($onw_ankpoints as $key_onw=>$onw_val)
	    {
	        $points_onw[]=$onw_val['bid_points'];
	    }
	    
	    $sum_onw = array_sum($points_onw);
	    
	    
	    
	    $two_ank_data_wc = [
            'conditions'=>
            ['game_type'=>'single_digit', 'open_digit'=>2 ,'bidded_at>'=>$start_date,'bidded_at<'=>$end_date ]
        ];

	    $two_ank_data = $this->BidModel->count($two_ank_data_wc);
	    
	    $two_ankpoints = $this->BidModel->all($two_ank_data_wc);
	    
	    $points_two = [];
	    foreach($two_ankpoints as $key_two=>$two_val)
	    {
	        $points_two[]=$two_val['bid_points'];
	    }
	    
	    $sum_two = array_sum($points_two);
	    
	    
	    $thre_ank_data_wc = [
            
            'conditions'=>
            ['game_type'=>'single_digit', 'open_digit'=>3 ,'bidded_at>'=>$start_date,'bidded_at<'=>$end_date ]

        ];

	   
	    $thre_ank_data = $this->BidModel->count($thre_ank_data_wc);
	    
	    $thre_ankpoints = $this->BidModel->all($thre_ank_data_wc);
	    
	    $points_thre= [];
	    foreach($thre_ankpoints as $key_thre=>$thre_val)
	    {
	        $points_thre[]=$thre_val['bid_points'];
	    }
	    
	    $sum_thre = array_sum($points_thre);
	    
	    $four_ank_data_wc = [
            
            'conditions'=>
            ['game_type'=>'single_digit', 'open_digit'=>4 ,'bidded_at>'=>$start_date,'bidded_at<'=>$end_date ]

        ];

	   
	    $four_ank_data = $this->BidModel->count($four_ank_data_wc);
	    
	    $four_ankpoints = $this->BidModel->all($four_ank_data_wc);
	    
	    $points_four= [];
	    foreach($four_ankpoints as $key_four=>$four_val)
	    {
	        $points_four[]=$four_val['bid_points'];
	    }
	    
	    $sum_four = array_sum($points_four);
	    
	    
	    $fiv_ank_data_wc = [
            
            'conditions'=>
            ['game_type'=>'single_digit', 'open_digit'=>5 ,'bidded_at>'=>$start_date,'bidded_at<'=>$end_date ]

        ];

	   
	    $fiv_ank_data = $this->BidModel->count($fiv_ank_data_wc);
	    
	    $fiv_ankpoints = $this->BidModel->all($fiv_ank_data_wc);
	    
	    $points_fiv= [];
	    foreach($fiv_ankpoints as $key_fiv=>$fiv_val)
	    {
	        $points_fiv[]=$fiv_val['bid_points'];
	    }
	    
	    $sum_fiv = array_sum($points_fiv);
	    
	    
	     $six_ank_data_wc = [
            
            'conditions'=>
            ['game_type'=>'single_digit', 'open_digit'=>6 ,'bidded_at>'=>$start_date,'bidded_at<'=>$end_date ]

        ];
      
	   
	    $six_ank_data = $this->BidModel->count($six_ank_data_wc);
	    
	    $six_ankpoints = $this->BidModel->all($six_ank_data_wc);
	    
	    $points_six= [];
	    foreach($six_ankpoints as $key_six=>$six_val)
	    {
	        $points_six[]=$six_val['bid_points'];
	    }
	    
	    $sum_six = array_sum($points_six);
	    
	    
	     $svn_ank_data_wc = [
            
            'conditions'=>
            ['game_type'=>'single_digit', 'open_digit'=>7 ,'bidded_at>'=>$start_date,'bidded_at<'=>$end_date ]

        ];

	   
	    $svn_ank_data = $this->BidModel->count($svn_ank_data_wc);
	    $svn_ankpoints = $this->BidModel->all($svn_ank_data_wc);
	    
	    $points_svn= [];
	    foreach($svn_ankpoints as $key_svn=>$svn_val)
	    {
	        $points_svn[]=$svn_val['bid_points'];
	    }
	    
	    $sum_svn = array_sum($points_svn);
	    
	    $eght_ank_data_wc = [
            
            'conditions'=>
            ['game_type'=>'single_digit', 'open_digit'=>8 ,'bidded_at>'=>$start_date,'bidded_at<'=>$end_date ]

        ];

	   
	    $eght_ank_data = $this->BidModel->count($eght_ank_data_wc);
	    $eght_ankpoints = $this->BidModel->all($eght_ank_data_wc);
	    
	    $points_eght= [];
	    foreach($eght_ankpoints as $key_eght=>$eght_val)
	    {
	        $points_eght[]=$eght_val['bid_points'];
	    }
	    
	    $sum_eght = array_sum($points_eght);
	    
	     $nin_ank_data_wc = [
            
            'conditions'=>
            ['game_type'=>'single_digit', 'open_digit'=>9 ,'bidded_at>'=>$start_date,'bidded_at<'=>$end_date ]

        ];

	   
	    $nin_ank_data = $this->BidModel->count($nin_ank_data_wc);
	    $nin_ankpoints = $this->BidModel->all($nin_ank_data_wc);
	    
	    $points_nin= [];
	    foreach($nin_ankpoints as $key_nin=>$nin_val)
	    {
	        $points_nin[]=$nin_val['bid_points'];
	    }
	    
	    $sum_nin = array_sum($points_nin);
	    

		$data = [
			'activeusers' => $this->UsersModel->count(['conditions' =>
			['status' => '1']]),

			'inactiveusers' => $this->UsersModel->count(['conditions' =>
			['status' => '2']]),
			
			'demoaccount' => $this->UsersModel->count(['conditions' =>
			['status' => '4']]),

			'games' => count($appliee),

		


		];


		$data = (object) $data;
		
		$profit_point=[];
		$profit ="";
		if((!empty($win_point)) AND (!empty($bid_point)))
		{
		     foreach($win_point as $keyll2=> $vaawin_point)
		     {
		        $profit_point['win'] =  $vaawin_point->win_point;
		     }
		     foreach($bid_point as $keyyy=> $vaawin_yy)
		     {
		         $profit_point['bid'] =  $vaawin_yy->filter_total_bid_amount;
		     }
		     
		     $profit = $profit_point['bid']-$profit_point['win'];
		}
		
		$re = [
            'fields' => ['SUM(points) as total_amount', 'id', 'user_id', 'trans_det', 'points', 'created_at'],
            'conditions'=>['trans_type'=>'1'],
            'order'      => [
                'by'   => 'id',
                'type' => 'DESC'
            ],
            'paging'     => ["page" => "1", "limit" => "10"],
             'datatype' => 'json'

        ];
        
        $userDatare = [];
        $userDatare = $this->UserTransModel->all($re);
        
        
        
        


		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('dashboard/home', compact('report_withdrawal','report_deposit','report_depositadmin','bid_point','userDatare','profit','win_point','sum_fiv','sum_six','sum_svn','sum_eght','sum_nin','sum_four','sum_thre','sum_two','sum_onw','sum_zero','zero_ank_data','onw_ank_data','two_ank_data','thre_ank_data','four_ank_data','fiv_ank_data','six_ank_data','svn_ank_data','eght_ank_data','nin_ank_data','data','appliee','querryy','today_regis','today_withdrawal','today_deposit','today_depositadmin'));
		$this->load->view('template/footer');
	}
	
	public function ank_ajax()
	{
	    $result = array();

	    // Use the posted date if provided, otherwise default to today
	    if (!empty($_POST['ank_date'])) {
	        $selectedDate = date('Y-m-d', strtotime($_POST['ank_date']));
	    } else {
	        $selectedDate = date('Y-m-d');
	    }
	    $start_date = $selectedDate . ' 00:00:00';
	    $end_date   = $selectedDate . ' 23:59:59';


	    if(($_POST['ank_market']=="Close") AND ($_POST['ank_game_id']!==""))
	    {
	        		  
            $ank_data_wc = [ 'conditions'=>['game_type'=>'single_digit','close_digit'=>0,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date ,'game_id'=>$_POST['ank_game_id'] ]
            ];
    
    	    $zero_ank_data = $this->BidModel->count($ank_data_wc);
    	    
    
    	    $zero_ankpoints = $this->BidModel->all($ank_data_wc);
    	    
    	    $points_zero = [];
    	    foreach($zero_ankpoints as $key_zero=>$zero_val)
    	    {
    	        $points_zero[]=$zero_val['bid_points'];
    	    }
    	    
    	    $sum_zero = array_sum($points_zero);
    	    $result['zero_ank_count'] =$zero_ank_data;
    	    $result['zero_ank_sum'] =$sum_zero;
    	    
    	    
    	    $onw_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>1 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date,'game_id'=>$_POST['ank_game_id']]
    
            ];
    	   
    	    $onw_ank_data = $this->BidModel->count($onw_ank_data_wc);
    	    
    	    $onw_ankpoints = $this->BidModel->all($onw_ank_data_wc);
    	    
    	    $points_onw = [];
    	    foreach($onw_ankpoints as $key_onw=>$onw_val)
    	    {
    	        $points_onw[]=$onw_val['bid_points'];
    	    }
    	    
    	    $sum_onw = array_sum($points_onw);
    	    $result['one_ank_count'] =$onw_ank_data;
    	    $result['one_ank_sum'] =$sum_onw;
    	    
    	    
    	    
    	    
    	    $two_ank_data_wc = [
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>2 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date ,'game_id'=>$_POST['ank_game_id']]
            ];
    
    	    $two_ank_data = $this->BidModel->count($two_ank_data_wc);
    	    
    	    
    	    $two_ankpoints = $this->BidModel->all($two_ank_data_wc);
    	    
    	    $points_two = [];
    	    foreach($two_ankpoints as $key_two=>$two_val)
    	    {
    	        $points_two[]=$two_val['bid_points'];
    	    }
    	    
    	    $sum_two = array_sum($points_two);
    	    $result['two_ank_count'] =$two_ank_data;
    	    $result['two_ank_sum'] =$sum_two;
    	    
    	    $thre_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>3 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date ,'game_id'=>$_POST['ank_game_id']]
    
            ];
    
    	   
    	    $thre_ank_data = $this->BidModel->count($thre_ank_data_wc);
    	    
    	    $thre_ankpoints = $this->BidModel->all($thre_ank_data_wc);
    	    
    	    $points_thre= [];
    	    foreach($thre_ankpoints as $key_thre=>$thre_val)
    	    {
    	        $points_thre[]=$thre_val['bid_points'];
    	    }
    	    
    	    $sum_thre = array_sum($points_thre);
    	    $result['thr_ank_count'] =$thre_ank_data;
    	    $result['thr_ank_sum'] =$sum_thre;
    	    
    	    $four_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>4 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date,'game_id'=>$_POST['ank_game_id'] ]
    
            ];
    
    	   
    	    $four_ank_data = $this->BidModel->count($four_ank_data_wc);
    	    
    	    $four_ankpoints = $this->BidModel->all($four_ank_data_wc);
    	    
    	    $points_four= [];
    	    foreach($four_ankpoints as $key_four=>$four_val)
    	    {
    	        $points_four[]=$four_val['bid_points'];
    	    }
    	    
    	    $sum_four = array_sum($points_four);
    	    $result['four_ank_count'] =$four_ank_data;
    	    $result['four_ank_sum'] =$sum_four;
    	    
    	    
    	    
    	    $fiv_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>5 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date,'game_id'=>$_POST['ank_game_id'] ]
    
            ];
    
    	   
    	    $fiv_ank_data = $this->BidModel->count($fiv_ank_data_wc);
    	    
    	    $fiv_ankpoints = $this->BidModel->all($fiv_ank_data_wc);
    	    
    	    $points_fiv= [];
    	    foreach($fiv_ankpoints as $key_fiv=>$fiv_val)
    	    {
    	        $points_fiv[]=$fiv_val['bid_points'];
    	    }
    	    
    	    $sum_fiv = array_sum($points_fiv);
    	    $result['fiv_ank_count'] =$fiv_ank_data;
    	    $result['fiv_ank_sum'] =$sum_fiv;
    	    
    	    
    	     $six_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>6 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date,'game_id'=>$_POST['ank_game_id']]
    
            ];
          
    	   
    	    $six_ank_data = $this->BidModel->count($six_ank_data_wc);
    	    
    	    $six_ankpoints = $this->BidModel->all($six_ank_data_wc);
    	    
    	    $points_six= [];
    	    foreach($six_ankpoints as $key_six=>$six_val)
    	    {
    	        $points_six[]=$six_val['bid_points'];
    	    }
    	    
    	    $sum_six = array_sum($points_six);
    	     $result['six_ank_count'] =$six_ank_data;
    	    $result['six_ank_sum'] =$sum_six;
    	    
    	    
    	    
    	     $svn_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>7 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date,'game_id'=>$_POST['ank_game_id']]
    
            ];
    
    	   
    	    $svn_ank_data = $this->BidModel->count($svn_ank_data_wc);
    	    $svn_ankpoints = $this->BidModel->all($svn_ank_data_wc);
    	    
    	    $points_svn= [];
    	    foreach($svn_ankpoints as $key_svn=>$svn_val)
    	    {
    	        $points_svn[]=$svn_val['bid_points'];
    	    }
    	    
    	    $sum_svn = array_sum($points_svn);
    	    $result['sev_ank_count'] =$svn_ank_data;
    	    $result['sev_ank_sum'] =$sum_svn;
    	    
    	    
    	    $eght_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>8 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date ,'game_id'=>$_POST['ank_game_id']]
    
            ];
    
    	   
    	    $eght_ank_data = $this->BidModel->count($eght_ank_data_wc);
    	    $eght_ankpoints = $this->BidModel->all($eght_ank_data_wc);
    	    
    	    $points_eght= [];
    	    foreach($eght_ankpoints as $key_eght=>$eght_val)
    	    {
    	        $points_eght[]=$eght_val['bid_points'];
    	    }
    	    
    	    $sum_eght = array_sum($points_eght);
    	    $result['eght_ank_count'] =$eght_ank_data;
    	    $result['eght_ank_sum'] =$sum_eght;
    	    
    	     $nin_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>9 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date ,'game_id'=>$_POST['ank_game_id']]
    
            ];
    
    	   
    	    $nin_ank_data = $this->BidModel->count($nin_ank_data_wc);
    	    $nin_ankpoints = $this->BidModel->all($nin_ank_data_wc);
    	    
    	    $points_nin= [];
    	    foreach($nin_ankpoints as $key_nin=>$nin_val)
    	    {
    	        $points_nin[]=$nin_val['bid_points'];
    	    }
	    
	        $sum_nin = array_sum($points_nin);
	        $result['nine_ank_count'] =$nin_ank_data;
    	    $result['nine_ank_sum'] =$sum_nin;
	    }elseif(($_POST['ank_market']=="Open")AND ($_POST['ank_game_id']!==""))
	    {
	         		  
            $ank_data_wc = [ 'conditions'=>['game_type'=>'single_digit','open_digit'=>0,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date ,'game_id'=>$_POST['ank_game_id'] ]
            ];
    
    	    $zero_ank_data = $this->BidModel->count($ank_data_wc);
    	    
    
    	    $zero_ankpoints = $this->BidModel->all($ank_data_wc);
    	    
    	    $points_zero = [];
    	    foreach($zero_ankpoints as $key_zero=>$zero_val)
    	    {
    	        $points_zero[]=$zero_val['bid_points'];
    	    }
    	    
    	    $sum_zero = array_sum($points_zero);
    	    $result['zero_ank_count'] =$zero_ank_data;
    	    $result['zero_ank_sum'] =$sum_zero;
    	    
    	    
    	    $onw_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>1 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date,'game_id'=>$_POST['ank_game_id']]
    
            ];
    	   
    	    $onw_ank_data = $this->BidModel->count($onw_ank_data_wc);
    	    
    	    $onw_ankpoints = $this->BidModel->all($onw_ank_data_wc);
    	    
    	    $points_onw = [];
    	    foreach($onw_ankpoints as $key_onw=>$onw_val)
    	    {
    	        $points_onw[]=$onw_val['bid_points'];
    	    }
    	    
    	    $sum_onw = array_sum($points_onw);
    	    $result['one_ank_count'] =$onw_ank_data;
    	    $result['one_ank_sum'] =$sum_onw;
    	    
    	    
    	    
    	    
    	    $two_ank_data_wc = [
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>2 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date ,'game_id'=>$_POST['ank_game_id']]
            ];
    
    	    $two_ank_data = $this->BidModel->count($two_ank_data_wc);
    	    
    	    
    	    $two_ankpoints = $this->BidModel->all($two_ank_data_wc);
    	    
    	    $points_two = [];
    	    foreach($two_ankpoints as $key_two=>$two_val)
    	    {
    	        $points_two[]=$two_val['bid_points'];
    	    }
    	    
    	    $sum_two = array_sum($points_two);
    	    $result['two_ank_count'] =$two_ank_data;
    	    $result['two_ank_sum'] =$sum_two;
    	    
    	    $thre_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>3 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date ,'game_id'=>$_POST['ank_game_id']]
    
            ];
    
    	   
    	    $thre_ank_data = $this->BidModel->count($thre_ank_data_wc);
    	    
    	    $thre_ankpoints = $this->BidModel->all($thre_ank_data_wc);
    	    
    	    $points_thre= [];
    	    foreach($thre_ankpoints as $key_thre=>$thre_val)
    	    {
    	        $points_thre[]=$thre_val['bid_points'];
    	    }
    	    
    	    $sum_thre = array_sum($points_thre);
    	    $result['thr_ank_count'] =$thre_ank_data;
    	    $result['thr_ank_sum'] =$sum_thre;
    	    
    	    $four_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>4 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date,'game_id'=>$_POST['ank_game_id'] ]
    
            ];
    
    	   
    	    $four_ank_data = $this->BidModel->count($four_ank_data_wc);
    	    
    	    $four_ankpoints = $this->BidModel->all($four_ank_data_wc);
    	    
    	    $points_four= [];
    	    foreach($four_ankpoints as $key_four=>$four_val)
    	    {
    	        $points_four[]=$four_val['bid_points'];
    	    }
    	    
    	    $sum_four = array_sum($points_four);
    	    $result['four_ank_count'] =$four_ank_data;
    	    $result['four_ank_sum'] =$sum_four;
    	    
    	    
    	    
    	    $fiv_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>5 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date,'game_id'=>$_POST['ank_game_id'] ]
    
            ];
    
    	   
    	    $fiv_ank_data = $this->BidModel->count($fiv_ank_data_wc);
    	    
    	    $fiv_ankpoints = $this->BidModel->all($fiv_ank_data_wc);
    	    
    	    $points_fiv= [];
    	    foreach($fiv_ankpoints as $key_fiv=>$fiv_val)
    	    {
    	        $points_fiv[]=$fiv_val['bid_points'];
    	    }
    	    
    	    $sum_fiv = array_sum($points_fiv);
    	    $result['fiv_ank_count'] =$fiv_ank_data;
    	    $result['fiv_ank_sum'] =$sum_fiv;
    	    
    	    
    	     $six_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>6 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date,'game_id'=>$_POST['ank_game_id']]
    
            ];
          
    	   
    	    $six_ank_data = $this->BidModel->count($six_ank_data_wc);
    	    
    	    $six_ankpoints = $this->BidModel->all($six_ank_data_wc);
    	    
    	    $points_six= [];
    	    foreach($six_ankpoints as $key_six=>$six_val)
    	    {
    	        $points_six[]=$six_val['bid_points'];
    	    }
    	    
    	    $sum_six = array_sum($points_six);
    	     $result['six_ank_count'] =$six_ank_data;
    	    $result['six_ank_sum'] =$sum_six;
    	    
    	    
    	    
    	     $svn_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>7 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date,'game_id'=>$_POST['ank_game_id']]
    
            ];
    
    	   
    	    $svn_ank_data = $this->BidModel->count($svn_ank_data_wc);
    	    $svn_ankpoints = $this->BidModel->all($svn_ank_data_wc);
    	    
    	    $points_svn= [];
    	    foreach($svn_ankpoints as $key_svn=>$svn_val)
    	    {
    	        $points_svn[]=$svn_val['bid_points'];
    	    }
    	    
    	    $sum_svn = array_sum($points_svn);
    	    $result['sev_ank_count'] =$svn_ank_data;
    	    $result['sev_ank_sum'] =$sum_svn;
    	    
    	    
    	    $eght_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>8 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date ,'game_id'=>$_POST['ank_game_id']]
    
            ];
    
    	   
    	    $eght_ank_data = $this->BidModel->count($eght_ank_data_wc);
    	    $eght_ankpoints = $this->BidModel->all($eght_ank_data_wc);
    	    
    	    $points_eght= [];
    	    foreach($eght_ankpoints as $key_eght=>$eght_val)
    	    {
    	        $points_eght[]=$eght_val['bid_points'];
    	    }
    	    
    	    $sum_eght = array_sum($points_eght);
    	    $result['eght_ank_count'] =$eght_ank_data;
    	    $result['eght_ank_sum'] =$sum_eght;
    	    
    	     $nin_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>9 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date ,'game_id'=>$_POST['ank_game_id']]
    
            ];
    
    	   
    	    $nin_ank_data = $this->BidModel->count($nin_ank_data_wc);
    	    $nin_ankpoints = $this->BidModel->all($nin_ank_data_wc);
    	    
    	    $points_nin= [];
    	    foreach($nin_ankpoints as $key_nin=>$nin_val)
    	    {
    	        $points_nin[]=$nin_val['bid_points'];
    	    }
	    
	        $sum_nin = array_sum($points_nin);
	        $result['nine_ank_count'] =$nin_ank_data;
    	    $result['nine_ank_sum'] =$sum_nin;
	        
	    }elseif(($_POST['ank_market']=="") AND ($_POST['ank_game_id']!==""))
	    {
	        $ank_data_wc = [ 'conditions'=>['game_type'=>'single_digit','open_digit'=>0,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date ,'game_id'=>$_POST['ank_game_id'] ]
            ];
    
    	    $zero_ank_data = $this->BidModel->count($ank_data_wc);
    	    
    
    	    $zero_ankpoints = $this->BidModel->all($ank_data_wc);
    	    
    	    $points_zero = [];
    	    foreach($zero_ankpoints as $key_zero=>$zero_val)
    	    {
    	        $points_zero[]=$zero_val['bid_points'];
    	    }
    	    
    	    $sum_zero = array_sum($points_zero);
    	    $result['zero_ank_count'] =$zero_ank_data;
    	    $result['zero_ank_sum'] =$sum_zero;
    	    
    	    
    	    $onw_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>1 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date,'game_id'=>$_POST['ank_game_id']]
    
            ];
    	   
    	    $onw_ank_data = $this->BidModel->count($onw_ank_data_wc);
    	    
    	    $onw_ankpoints = $this->BidModel->all($onw_ank_data_wc);
    	    
    	    $points_onw = [];
    	    foreach($onw_ankpoints as $key_onw=>$onw_val)
    	    {
    	        $points_onw[]=$onw_val['bid_points'];
    	    }
    	    
    	    $sum_onw = array_sum($points_onw);
    	    $result['one_ank_count'] =$onw_ank_data;
    	    $result['one_ank_sum'] =$sum_onw;
    	    
    	    
    	    
    	    
    	    $two_ank_data_wc = [
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>2 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date ,'game_id'=>$_POST['ank_game_id']]
            ];
    
    	    $two_ank_data = $this->BidModel->count($two_ank_data_wc);
    	    
    	    
    	    $two_ankpoints = $this->BidModel->all($two_ank_data_wc);
    	    
    	    $points_two = [];
    	    foreach($two_ankpoints as $key_two=>$two_val)
    	    {
    	        $points_two[]=$two_val['bid_points'];
    	    }
    	    
    	    $sum_two = array_sum($points_two);
    	    $result['two_ank_count'] =$two_ank_data;
    	    $result['two_ank_sum'] =$sum_two;
    	    
    	    $thre_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>3 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date ,'game_id'=>$_POST['ank_game_id']]
    
            ];
    
    	   
    	    $thre_ank_data = $this->BidModel->count($thre_ank_data_wc);
    	    
    	    $thre_ankpoints = $this->BidModel->all($thre_ank_data_wc);
    	    
    	    $points_thre= [];
    	    foreach($thre_ankpoints as $key_thre=>$thre_val)
    	    {
    	        $points_thre[]=$thre_val['bid_points'];
    	    }
    	    
    	    $sum_thre = array_sum($points_thre);
    	    $result['thr_ank_count'] =$thre_ank_data;
    	    $result['thr_ank_sum'] =$sum_thre;
    	    
    	    $four_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>4 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date,'game_id'=>$_POST['ank_game_id'] ]
    
            ];
    
    	   
    	    $four_ank_data = $this->BidModel->count($four_ank_data_wc);
    	    
    	    $four_ankpoints = $this->BidModel->all($four_ank_data_wc);
    	    
    	    $points_four= [];
    	    foreach($four_ankpoints as $key_four=>$four_val)
    	    {
    	        $points_four[]=$four_val['bid_points'];
    	    }
    	    
    	    $sum_four = array_sum($points_four);
    	    $result['four_ank_count'] =$four_ank_data;
    	    $result['four_ank_sum'] =$sum_four;
    	    
    	    
    	    
    	    $fiv_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>5 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date,'game_id'=>$_POST['ank_game_id'] ]
    
            ];
    
    	   
    	    $fiv_ank_data = $this->BidModel->count($fiv_ank_data_wc);
    	    
    	    $fiv_ankpoints = $this->BidModel->all($fiv_ank_data_wc);
    	    
    	    $points_fiv= [];
    	    foreach($fiv_ankpoints as $key_fiv=>$fiv_val)
    	    {
    	        $points_fiv[]=$fiv_val['bid_points'];
    	    }
    	    
    	    $sum_fiv = array_sum($points_fiv);
    	    $result['fiv_ank_count'] =$fiv_ank_data;
    	    $result['fiv_ank_sum'] =$sum_fiv;
    	    
    	    
    	     $six_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>6 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date,'game_id'=>$_POST['ank_game_id']]
    
            ];
          
    	   
    	    $six_ank_data = $this->BidModel->count($six_ank_data_wc);
    	    
    	    $six_ankpoints = $this->BidModel->all($six_ank_data_wc);
    	    
    	    $points_six= [];
    	    foreach($six_ankpoints as $key_six=>$six_val)
    	    {
    	        $points_six[]=$six_val['bid_points'];
    	    }
    	    
    	    $sum_six = array_sum($points_six);
    	     $result['six_ank_count'] =$six_ank_data;
    	    $result['six_ank_sum'] =$sum_six;
    	    
    	    
    	    
    	     $svn_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>7 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date,'game_id'=>$_POST['ank_game_id']]
    
            ];
    
    	   
    	    $svn_ank_data = $this->BidModel->count($svn_ank_data_wc);
    	    $svn_ankpoints = $this->BidModel->all($svn_ank_data_wc);
    	    
    	    $points_svn= [];
    	    foreach($svn_ankpoints as $key_svn=>$svn_val)
    	    {
    	        $points_svn[]=$svn_val['bid_points'];
    	    }
    	    
    	    $sum_svn = array_sum($points_svn);
    	    $result['sev_ank_count'] =$svn_ank_data;
    	    $result['sev_ank_sum'] =$sum_svn;
    	    
    	    
    	    $eght_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>8 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date ,'game_id'=>$_POST['ank_game_id']]
    
            ];
    
    	   
    	    $eght_ank_data = $this->BidModel->count($eght_ank_data_wc);
    	    $eght_ankpoints = $this->BidModel->all($eght_ank_data_wc);
    	    
    	    $points_eght= [];
    	    foreach($eght_ankpoints as $key_eght=>$eght_val)
    	    {
    	        $points_eght[]=$eght_val['bid_points'];
    	    }
    	    
    	    $sum_eght = array_sum($points_eght);
    	    $result['eght_ank_count'] =$eght_ank_data;
    	    $result['eght_ank_sum'] =$sum_eght;
    	    
    	     $nin_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'open_digit'=>9 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date ,'game_id'=>$_POST['ank_game_id']]
    
            ];
    
    	   
    	    $nin_ank_data = $this->BidModel->count($nin_ank_data_wc);
    	    $nin_ankpoints = $this->BidModel->all($nin_ank_data_wc);
    	    
    	    $points_nin= [];
    	    foreach($nin_ankpoints as $key_nin=>$nin_val)
    	    {
    	        $points_nin[]=$nin_val['bid_points'];
    	    }
	    
	        $sum_nin = array_sum($points_nin);
	        $result['nine_ank_count'] =$nin_ank_data;
    	    $result['nine_ank_sum'] =$sum_nin;
	        
	    }elseif(($_POST['ank_market']=="Close") AND ($_POST['ank_game_id']==""))
	    {
	        		  
            $ank_data_wc = [ 'conditions'=>['game_type'=>'single_digit','close_digit'=>0,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date]
            ];
    
    	    $zero_ank_data = $this->BidModel->count($ank_data_wc);
    	    
    
    	    $zero_ankpoints = $this->BidModel->all($ank_data_wc);
    	    
    	    $points_zero = [];
    	    foreach($zero_ankpoints as $key_zero=>$zero_val)
    	    {
    	        $points_zero[]=$zero_val['bid_points'];
    	    }
    	    
    	    $sum_zero = array_sum($points_zero);
    	    $result['zero_ank_count'] =$zero_ank_data;
    	    $result['zero_ank_sum'] =$sum_zero;
    	    
    	    
    	    $onw_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>1 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date]
    
            ];
    	   
    	    $onw_ank_data = $this->BidModel->count($onw_ank_data_wc);
    	    
    	    $onw_ankpoints = $this->BidModel->all($onw_ank_data_wc);
    	    
    	    $points_onw = [];
    	    foreach($onw_ankpoints as $key_onw=>$onw_val)
    	    {
    	        $points_onw[]=$onw_val['bid_points'];
    	    }
    	    
    	    $sum_onw = array_sum($points_onw);
    	    $result['one_ank_count'] =$onw_ank_data;
    	    $result['one_ank_sum'] =$sum_onw;
    	    
    	    
    	    
    	    
    	    $two_ank_data_wc = [
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>2 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date ]
            ];
    
    	    $two_ank_data = $this->BidModel->count($two_ank_data_wc);
    	    
    	    
    	    $two_ankpoints = $this->BidModel->all($two_ank_data_wc);
    	    
    	    $points_two = [];
    	    foreach($two_ankpoints as $key_two=>$two_val)
    	    {
    	        $points_two[]=$two_val['bid_points'];
    	    }
    	    
    	    $sum_two = array_sum($points_two);
    	    $result['two_ank_count'] =$two_ank_data;
    	    $result['two_ank_sum'] =$sum_two;
    	    
    	    $thre_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>3 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date]
    
            ];
    
    	   
    	    $thre_ank_data = $this->BidModel->count($thre_ank_data_wc);
    	    
    	    $thre_ankpoints = $this->BidModel->all($thre_ank_data_wc);
    	    
    	    $points_thre= [];
    	    foreach($thre_ankpoints as $key_thre=>$thre_val)
    	    {
    	        $points_thre[]=$thre_val['bid_points'];
    	    }
    	    
    	    $sum_thre = array_sum($points_thre);
    	    $result['thr_ank_count'] =$thre_ank_data;
    	    $result['thr_ank_sum'] =$sum_thre;
    	    
    	    $four_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>4 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date]
    
            ];
    
    	   
    	    $four_ank_data = $this->BidModel->count($four_ank_data_wc);
    	    
    	    $four_ankpoints = $this->BidModel->all($four_ank_data_wc);
    	    
    	    $points_four= [];
    	    foreach($four_ankpoints as $key_four=>$four_val)
    	    {
    	        $points_four[]=$four_val['bid_points'];
    	    }
    	    
    	    $sum_four = array_sum($points_four);
    	    $result['four_ank_count'] =$four_ank_data;
    	    $result['four_ank_sum'] =$sum_four;
    	    
    	    
    	    
    	    $fiv_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>5 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date]
    
            ];
    
    	   
    	    $fiv_ank_data = $this->BidModel->count($fiv_ank_data_wc);
    	    
    	    $fiv_ankpoints = $this->BidModel->all($fiv_ank_data_wc);
    	    
    	    $points_fiv= [];
    	    foreach($fiv_ankpoints as $key_fiv=>$fiv_val)
    	    {
    	        $points_fiv[]=$fiv_val['bid_points'];
    	    }
    	    
    	    $sum_fiv = array_sum($points_fiv);
    	    $result['fiv_ank_count'] =$fiv_ank_data;
    	    $result['fiv_ank_sum'] =$sum_fiv;
    	    
    	    
    	     $six_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>6 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date]
    
            ];
          
    	   
    	    $six_ank_data = $this->BidModel->count($six_ank_data_wc);
    	    
    	    $six_ankpoints = $this->BidModel->all($six_ank_data_wc);
    	    
    	    $points_six= [];
    	    foreach($six_ankpoints as $key_six=>$six_val)
    	    {
    	        $points_six[]=$six_val['bid_points'];
    	    }
    	    
    	    $sum_six = array_sum($points_six);
    	     $result['six_ank_count'] =$six_ank_data;
    	    $result['six_ank_sum'] =$sum_six;
    	    
    	    
    	    
    	     $svn_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>7 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date]
    
            ];
    
    	   
    	    $svn_ank_data = $this->BidModel->count($svn_ank_data_wc);
    	    $svn_ankpoints = $this->BidModel->all($svn_ank_data_wc);
    	    
    	    $points_svn= [];
    	    foreach($svn_ankpoints as $key_svn=>$svn_val)
    	    {
    	        $points_svn[]=$svn_val['bid_points'];
    	    }
    	    
    	    $sum_svn = array_sum($points_svn);
    	    $result['sev_ank_count'] =$svn_ank_data;
    	    $result['sev_ank_sum'] =$sum_svn;
    	    
    	    
    	    $eght_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>8 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date]
    
            ];
    
    	   
    	    $eght_ank_data = $this->BidModel->count($eght_ank_data_wc);
    	    $eght_ankpoints = $this->BidModel->all($eght_ank_data_wc);
    	    
    	    $points_eght= [];
    	    foreach($eght_ankpoints as $key_eght=>$eght_val)
    	    {
    	        $points_eght[]=$eght_val['bid_points'];
    	    }
    	    
    	    $sum_eght = array_sum($points_eght);
    	    $result['eght_ank_count'] =$eght_ank_data;
    	    $result['eght_ank_sum'] =$sum_eght;
    	    
    	     $nin_ank_data_wc = [
                
                'conditions'=>
                ['game_type'=>'single_digit', 'close_digit'=>9 ,'bid.bidded_at>'=>$start_date,'bid.bidded_at<'=>$end_date ]
    
            ];
    
    	   
    	    $nin_ank_data = $this->BidModel->count($nin_ank_data_wc);
    	    $nin_ankpoints = $this->BidModel->all($nin_ank_data_wc);
    	    
    	    $points_nin= [];
    	    foreach($nin_ankpoints as $key_nin=>$nin_val)
    	    {
    	        $points_nin[]=$nin_val['bid_points'];
    	    }
	    
	        $sum_nin = array_sum($points_nin);
	        $result['nine_ank_count'] =$nin_ank_data;
    	    $result['nine_ank_sum'] =$sum_nin;
	    }

	    
      
    		
            echo json_encode($result);
      
	    
	}
	
	public function win_his_ajax()
	{
	    
		  
            $bid_win_wc =[
			'fields' => ["SUM(bid_points) AS filter_total_bid_amount"],
			'datatype' => 'json'
            ];
            
            if (isset($_POST['date_name']) && $_POST['date_name'] != '') {
                
                $orgDate =  $_POST['date_name'];
                $newDate = date("Y-m-d", strtotime($orgDate));
                $start_new_date = ("$newDate 00:00:00");
                  $end_new_date = ("$newDate 23:59:59");
                
                $bid_win_wc['conditions']['bidded_at>'] = $start_new_date;
                $bid_win_wc['conditions']['bidded_at<'] = $end_new_date;
               
                
            }
            if (isset($_POST['g_name']) && ($_POST['g_name'] != '') && ($_POST['g_name']
                !== 'All')) {
                $bid_win_wc['conditions']['game_id'] = $_POST['g_name'];
            }
            $result = array();
        
            $bid_point = $this->BidModel->all($bid_win_wc);
            foreach($bid_point as $key_bid=> $vaal_bid){
                 $bdd_amnt = "₹".($vaal_bid->filter_total_bid_amount);
                $result['bdd_amnt'] = $bdd_amnt;

            }
            
             $win_point = $this->BidModel->all([
    			'conditions' => [
    				'bidded_at>' => $start_new_date,
    				'bidded_at<' => $end_new_date,
    				'won'=>1
    				
    			],
    			'fields' => ["SUM(win_points) AS win_point"],
    			'datatype' => 'json'
    		]);
    		
    		if (isset($_POST['g_name']) && ($_POST['g_name'] != '') && ($_POST['g_name'] !== 'All')) {
    		    $win_point = $this->BidModel->all([
        			'conditions' => [
        				'bidded_at>' => $start_new_date,
        				'bidded_at<' => $end_new_date,
        				'game_id' => $_POST['g_name'],
        				'won'=>1
        			],
        			'fields' => ["SUM(win_points) AS win_point"],
        			'datatype' => 'json'
        		]);
    		}
    		
    		foreach($win_point as $key_win=> $vaal_win){
                 $win_amnt = "₹".($vaal_win->win_point);
                $result['win_amnt'] = $win_amnt;
            }
            
            $profit ="";
    		if((!empty($win_point)) AND (!empty($bid_point)))
    		{
    		     foreach($win_point as $keyll2=> $vaawin_point)
    		     {
    		        $profit_point['win'] =  $vaawin_point->win_point;
    		     }
    		     foreach($bid_point as $keyyy=> $vaawin_yy)
    		     {
    		         $profit_point['bid'] =  $vaawin_yy->filter_total_bid_amount;
    		     }
    		     
    		     $profit = $profit_point['bid']-$profit_point['win'];
    		     $result['profit'] ="₹".$profit;
    		}
    		
    		$report_withdrawal = $this->db->query("
    		    SELECT COALESCE(SUM(points), 0) AS total 
    		    FROM user_trans 
    		    WHERE trans_type = 6 AND admin_status = 'APPROVED'
    		    AND created_at BETWEEN '$start_new_date' AND '$end_new_date'
    		")->row()->total;
    		
    		$report_deposit = $this->db->query("
    		    SELECT COALESCE(SUM(points), 0) AS total 
    		    FROM user_trans 
    		    WHERE trans_type = 1 AND admin_status = 'APPROVED'
    		    AND created_at BETWEEN '$start_new_date' AND '$end_new_date'
    		")->row()->total;
    		
    		$report_depositadmin = $this->db->query("
    		    SELECT COALESCE(SUM(points), 0) AS total 
    		    FROM user_trans 
    		    WHERE trans_type = 3 AND admin_status = 'APPROVED'
    		    AND created_at BETWEEN '$start_new_date' AND '$end_new_date'
    		")->row()->total;
    		
    		$result['report_withdrawal'] = "₹".$report_withdrawal;
    		$result['report_deposit'] = "₹".$report_deposit;
    		$result['report_depositadmin'] = "₹".$report_depositadmin;
    		
            echo json_encode($result);
      
	    
	}
	
	

	public function my_profile()
	{
		// die("eff");
		flash_message(
			'dashboard/login',
			is_login(),
			'unsuccess',
			'Please Login Then Try Again'
		);

		if ($this->input->post('addAdminImg')) {

			/* Upload Images */
			$form_images = upload(['uploads/setting' => 'profileImg']);

			// _ddd($_FILES);

			/* Check Document Image Uploaded */
			flash_message(
				'dashboard/my_profile',
				isset($form_images['profileImg']),
				'unsuccess',
				'Something Went Wrong',
				"Please Upload Admin Image & Try Again."
			);

			isset($form_images['profileImg']) and $admin_image = $form_images['profileImg'][0] or $admin_image = "";

			$admin = $this->AdminModel->updateTable([
				'profile'              => $admin_image,
			], ['role_id' => '1']);

			flash_message(
				'dashboard/my_profile',
				$admin,
				'unsuccess',
				"Something Went Wrong!"
			);

			flash_message(
				'dashboard/my_profile',
				$admin,
				'success',
				"Admin Profile Changed Successfully"
			);
		}

		$admin = $this->AdminModel->first(['conditions' => ['role_id' => '1']]);


		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('dashboard/my_profile', compact('admin'));
		$this->load->view('template/footer');
	}



	public function list_admin()
	{


		$userData = $this->AdminModel->all([
			'fields' => ['admin.*', 'user_groups.group_title'],

			'order' => [
				'by' => 'admin.id',
				'type' => 'DESC'
			],
			'join' => [['user_groups', 'user_groups.id = admin.role_id']],
			'datatype' => 'json'
		]);

		//_ddd($userData);

		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('admin/list', compact('userData'));
		$this->load->view('template/footer');
	}

	/** Add Users
	 * @return void */
	public function add_admin()
	{


		user_can('admin_add') or show_404();
		if ($this->input->post('addADMIN')) {
		    
		    $pass = $this->input->post('password');
		     
		     $hash_pass = base64_encode($pass);

				$user = $this->AdminModel->save([
					'username'      => $this->input->post('username'),
					'email'           => $this->input->post('email'),
					'mobile'          => str_clean($this->input->post('mobile')),
					'password'        => $hash_pass,
					'role_id'         => str_clean($this->input->post('userRole')),
					'status'          => true
				]);

				if ($user) {
					$this->session->set_flashdata('msg', 'Admin Created Successfully');
					redirect('list/admin');
				} else {
					$this->session->set_flashdata('msg', 'Not Inserted');
					redirect('add/admin');
				}
			}
		

		$roles = $this->User_GroupsModel->all([
			'conditions' => ['status!=' => '3'],
			'datatype' => 'json'
		]);

		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('admin/add', compact('roles'));
		$this->load->view('template/footer');
	}
	
	public function edit_admin($id)
    {


        if ($this->input->post('editADMIN')) {
            
             $pass = $this->input->post('password');
		     
		      $hash_pass = base64_encode($pass);
		    

               $user = $this->AdminModel->updateTable([
    					'username'      => $this->input->post('username'),
    					'email'           => $this->input->post('email'),
    					'password'        => $hash_pass,
    				], ['id' => $id]);

            flash_message(
                'edit/admin/' . $id,
                $user,
                'unsuccess',
                "Something Went Wrong"
            );

            flash_message(
                'list/admin',
                $user,
                'success',
                "Admin Updated Successfully"
            );
        }


        $ratingssssData = '';
        $ratingssssData = $this->AdminModel->first([
            'conditions' => [
                'id'     => $id,
            ]
        ]);

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('admin/edit', compact('ratingssssData'));
        $this->load->view('template/footer');
    }


	/** Delete Role */
	public function delete_admin($id = null)
	{
		empty($id) and show_404();

		user_can('admin_delete') or show_404();

		flash_message(
			'list/admin',
			$id,
			'unsuccess',
			"Please Select Id"
		);

		$role = $this->AdminModel->destroy(['id' => $id]);
		flash_message(
			'list/admin',
			$role,
			'unsuccess',
			"Something Went Wrong"
		);

		flash_message(
			'list/admin',
			$role,
			'success',
			"Admin Deleted Successfully"
		);
	}
}

/* End of file  Admin.php */
