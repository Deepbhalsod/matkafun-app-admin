<?php defined('BASEPATH') or exit('No direct script access allowed');

/** Load & Execute User Modules */
class User extends CI_Controller
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
		$this->load->library('encryption');
		$this->load->model(['UsersModel', 'User_GroupsModel',  'UserAddressesModel', 'UserTransModel','TransactionTypeModel','BidModel', 'GalidisawarBidModel', 'StarlineBidModel']);
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


    public function change_delete($id)
	{



		$job = $this->UsersModel->updateTable([
			'is_delete'  => '1',
			'is_login' => '0',
			'mobile_verified' => '0',
			'status'=>'3'
		], ['id' => $id]);

		flash_message(
			'list/user',
			$job,
			'success',
			"Deleted Successfully"
		);
	}

	// lIST USER
	public function list_user()
	{

		$userData = $this->UsersModel->all([
		    'conditions' => [ 'is_delete' => '2'],
			'order' => [ 'by' => 'id','type' => 'DESC'],
			'datatype' => 'json'
		]);

		//_dd($userData);

		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('user/list', compact('userData'));
		$this->load->view('template/footer');
	}
	
		// lIST USER
	public function list_unapprove_user()
	{

		$userData = $this->UsersModel->all([
			'conditions' => ['status' => '2' , 'is_delete' => '2'],
			'order' => ['by' => 'id','type' => 'DESC'],
			'datatype' => 'json'
		]);

		//_dd($userData);

		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('user/unapprove_user_list', compact('userData'));
		$this->load->view('template/footer');
	}
	

	/** Change Status */

	public function change_status_user($id, $stat)
	{

		if ($stat == 'inactive') {

			$job = $this->UsersModel->updateTable([
				'status'            => '2'
			], ['id' => $id]);

			flash_message(
				'list/user',
				$job,
				'success',
				"Status Inactive Successfully"
			);
		}

		if ($stat == 'active') {

			$job = $this->UsersModel->updateTable([
				'status'            => '1'
			], ['id' => $id]);
			flash_message(
				'list/user',
				$job,
				'success',
				"Status Active Successfully"
			);
		}
	}
    
    
    public function trans_status_user($id)
	{
         
		$user = $this->UsersModel->first([
			'conditions' => ['id' => $id ]	]);
		
		$transfer = $user['transfer'];
		if($transfer==1)
		{
		    $sts = 0;
		}else{
		    $sts = 1;
		}

			$job = $this->UsersModel->updateTable([
				'transfer'            => $sts
			], ['id' => $id]);

			flash_message(
				'list/user',
				$job,
				'success',
				"Transfer Status Updated Successfully"
			);
		

		
	}
	
	


	// VIEW ADDRESS LIST
	public function user_detail_list($user_id)
	{
		$userperData = " ";
		$userperData = $this->UsersModel->first([
			'conditions' => [
				'id' => $user_id
			],

			'datatype' => 'json'
		]);
		
	
        $userData =new stdclass;
		$userData = $this->UserAddressesModel->first([
			'conditions' => [
				'user_id' => $user_id
			],

		]);
		
		

        $credt_whr = ['conditions' 
            => "`user_id` = $user_id AND (`trans_type` =1 OR `trans_type` =2 OR `trans_type` =3 OR `trans_type` =4 OR `trans_type` =5 OR `trans_type` =20)",
            'datatype' => 'json'];
            
		$funds = $this->UserTransModel->all($credt_whr);
		foreach($funds as $key_fund =>$val_fund)
		{
		    $typ = $val_fund->trans_type;
		    	$typData = $this->TransactionTypeModel->first([
            			'conditions' => [
            				'id' => $typ
            			],
            
            		]);
            		
            $funds[$key_fund]->rem=$typData['trans_msg'];
		
		    
		}

        $debit_whr = ['conditions' 
            => "`user_id` = $user_id AND (`trans_type` =6 OR `trans_type` =19 OR `trans_type` =7 OR `trans_type` =8 OR `trans_type` =9 OR `trans_type` =21)",
            'datatype' => 'json'];
		$debit = $this->UserTransModel->all($debit_whr);
		
		foreach($debit as $key_debit =>$val_debit)
		{
		    $typ = $val_debit->trans_type;
		    	$typData = $this->TransactionTypeModel->first([
            			'conditions' => [
            				'id' => $typ
            			],
            
            		]);
            		
            $debit[$key_debit]->rem=$typData['trans_msg'];
		
		    
		}
		

		$req = $this->UserTransModel->all([
			'conditions' => [
				'user_id' => $user_id,
				'trans_type' => 1 ],

			'datatype' => 'json'
		]);
		
			$Bid_con = [
		    'conditions' => [
				'user_id' => $user_id
			],
            'order'      => [
                'by'   => 'id',
                'type' => 'DESC'
            ],

        ];
		
        $BidData = $this->BidModel->all($Bid_con);
        
        $win_con = [
		    'conditions' => [
				'user_id' => $user_id,
				'won'=>1
			],
            'order'      => [
                'by'   => 'id',
                'type' => 'DESC'
            ],

        ];
		
        $winData = $this->BidModel->all($win_con);

        // Gali Disawar Bids
        $GD_Bid_con = [
            'conditions' => [
                'user_id' => $user_id
            ],
            'order'      => [
                'by'   => 'id',
                'type' => 'DESC'
            ],
        ];
        $GD_BidData = $this->GalidisawarBidModel->all($GD_Bid_con);

        // Gali Disawar Wins
        $GD_win_con = [
            'conditions' => [
                'user_id' => $user_id,
                'won' => 1
            ],
            'order'      => [
                'by'   => 'id',
                'type' => 'DESC'
            ],
        ];
        $GD_winData = $this->GalidisawarBidModel->all($GD_win_con);

        // Starline Bids
        $SL_Bid_con = [
            'conditions' => [
                'user_id' => $user_id
            ],
            'order'      => [
                'by'   => 'id',
                'type' => 'DESC'
            ],
        ];
        $SL_BidData = $this->StarlineBidModel->all($SL_Bid_con);

        // Starline Wins
        $SL_win_con = [
            'conditions' => [
                'user_id' => $user_id,
                'won' => 1
            ],
            'order'      => [
                'by'   => 'id',
                'type' => 'DESC'
            ],
        ];
        $SL_winData = $this->StarlineBidModel->all($SL_win_con);
        
        $with_whr = [
		    'conditions' => [
				'user_id' => $user_id,
				'trans_type'=>6
			],
            'order'      => [
                'by'   => 'id',
                'type' => 'DESC'
            ],

        ];
            
		$withdraw_data = $this->UserTransModel->all($with_whr);


		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('user/user_detail_list', compact('BidData','winData','GD_BidData','GD_winData','SL_BidData','SL_winData','withdraw_data','userData', 'userperData','funds', 'debit', 'req'));
		$this->load->view('template/footer');
	}
	
	public function add_fund_adm($user_id)
	{
	       $update = $this->UserTransModel->save([
                    'trans_type'                 => 3,
                    'user_id'                    => $user_id,
                    'points'                     => $this->input->post('points'),
                    'trans_det'                  => "add_fund_by_admin",
                    'trans_status'               => "SUCCESSFUL",
                    'admin_status'               => "APPROVED"
            ]);
            
            if($update)
            {
                  $userData = $this->UsersModel->first([
            			'conditions' => [
            				'id' => $user_id
            			],
            
            		]);
            		
            		$this_points = $this->input->post('points');
            		$av_points =$userData['available_points'];
            	    
            	    $point =($av_points + $this_points);	
                   
                	$job = $this->UsersModel->updateTable([
            			'available_points'            => $point,
            		
            		], ['id' => $user_id]);
            }
                
            flash_message(
    			'user_detail_list/user/'.$user_id,
    			 $update,
    			'success',
    			"Add Fund Successfully"
    		);
	}
   
    public function add_withdraw_adm($user_id)
	{
	       $update = $this->UserTransModel->save([
                    'trans_type'                 => 7,
                    'user_id'                    => $user_id,
                    'points'                     => $this->input->post('points'),
                    'trans_det'                  => "withdraw_by_admin",
                    'trans_status'               => "SUCCESSFUL",
                    'admin_status'               => "APPROVED"
            ]);
            if($update)
            {
                	$userData = $this->UsersModel->first([
            			'conditions' => [
            				'id' => $user_id
            			],
            
            		]);
            		
            		$this_points = $this->input->post('points');
            		$av_points =$userData['available_points'];
            	    
            	    $point =($av_points-$this_points);	
                   
                	$job = $this->UsersModel->updateTable([
            			'available_points'            => $point,
            		
            		], ['id' => $user_id]);
            }
                
        flash_message(
			'user_detail_list/user/'.$user_id,
			 $update,
			'success',
			"Add Withdraw Successfully"
		);
	}
	
	   
  

	// VIEW payment_list
	public function payment_list($user_id)
	{
		$userData = "";
		$userData = $this->UsersModel->first([
			'conditions' => [
				'id' => $user_id
			],

		]);

		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('user/payment_list', compact('userData'));
		$this->load->view('template/footer');
	}
	
	public function user_list_ajax()
{
    $request = $_REQUEST;

    $columns = [
        0 => 'id',
        1 => 'username',
        2 => 'mobile',
        3 => 'registred_date',
        4 => 'available_points'
    ];

    $limit = $request['length'];
    $start = $request['start'];
    $search = $request['search']['value'];

    // Total count
    $totalData = $this->UsersModel->count(['is_delete' => '2']);

    // Search condition
    $where = "is_delete = '2'";
    if (!empty($search)) {
        $where .= " AND (username LIKE '%$search%' OR mobile LIKE '%$search%')";
    }

    // Fetch data with limit
    $query = $this->db->query("
        SELECT * FROM users
        WHERE $where
        ORDER BY id DESC
        LIMIT $start, $limit
    ");

    $data = [];
    $i = $start + 1;

    foreach ($query->result() as $row) {

        $nestedData = [];
        $nestedData[] = $i++ . ".";
        $nestedData[] = $row->username;
        $nestedData[] = $row->mobile;
        $nestedData[] = date('M d, Y h:i A', strtotime($row->registred_date));
        $nestedData[] = $row->available_points;

        $nestedData[] = $row->transfer == 1
            ? '<span class="badge badge-success">Yes</span>'
            : '<span class="badge badge-danger">No</span>';

        $nestedData[] = $row->status == 1
            ? '<span class="badge badge-success">Active</span>'
            : '<span class="badge badge-danger">Inactive</span>';

        $nestedData[] = '<a href="'.SITE_URL.'user_detail_list/user/'.$row->id.'">View</a>';

        $data[] = $nestedData;
    }

    $totalFiltered = $this->db->query("SELECT COUNT(*) as total FROM users WHERE $where")->row()->total;

    $json_data = [
        "draw" => intval($request['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    ];

    echo json_encode($json_data);
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
