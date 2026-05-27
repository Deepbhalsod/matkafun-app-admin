<?php defined('BASEPATH') or exit('No direct script access allowed');

class RedeemRequest extends CI_Controller
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

		$this->load->model(['RedeemModel']);
	}

	/** Load Default Index To Show 404 Error
	 *
	 * @return void */
	public function index()
	{
		return show_404();
	}


	// public function add_redeem()
	// {
	// 	//die('hii');
	// 	flash_message(
	// 		'dashboard/login',
	// 		is_login(),
	// 		'unsuccess',
	// 		'Please Login Then Try Again'
	// 	);


	// 	if ($this->input->post('addRedeem')) {
	// 		$request_amount              = $_REQUEST['request_amount'];

	// 		$redeems = $this->RedeemModel->save([

	// 			'request_amount'    => $request_amount,
	// 			'user_id'     =>  $this->input->post('user_id'),

	// 		]);

	// 		flash_message(
	// 			'add/redeem',
	// 			$redeems,
	// 			'unsuccess',
	// 			"Something Went Wrong"
	// 		);

	// 		flash_message(
	// 			'list/redeem',
	// 			$redeems,
	// 			'success',
	// 			"User Created Successfully"
	// 		);
	// 	}
	// 	$users = json_decode(json_encode($this->UsersModel->all([
	// 		'conditions' => ['status!=' => '3'],
	// 		'fields' => ['id', 'username']
	// 	])));

	// 	$redeems = json_decode(json_encode($this->RedeemModel->all()));

	// 	$this->load->view('template/header');
	// 	$this->load->view('template/sidebar');
	// 	$this->load->view('redeem/add', compact('redeems', 'users'));
	// 	$this->load->view('template/footer');
	// }


	public function list_redeem()
	{
		flash_message(
			'dashboard/login',
			is_login(),
			'unsuccess',
			'Please Login Then Try Again'
		);


		$redeemData = $this->RedeemModel->all([
			'order' => [
				'by' => 'id',
				'type' => 'DESC'
			],
			'datatype' => 'json'
		]);


		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('redeem/list', compact('redeemData'));
		$this->load->view('template/footer');
	}



	// public function pay($type, $user_id, $redeem_id)
	// {

	// 	if ($this->input->post('addPay')) {
	// 		$comment              = $_REQUEST['comment'];
	// 		//$reason                =>'REDEEM';
	// 		/* Upload Images */
	// 		$form_images = upload(['uploads/redeem' => 'redeemImg']);

	// 		isset($form_images['redeemImg']) and $redeem_image = $form_images['redeemImg'][0] or $redeem_image = "";

	// 		$redeems = $this->RedeemModel->updateTable([

	// 			'comment'           => $comment,
	// 			'image'             => $redeem_image,
	// 			'payment_status'   => $this->input->post('payment_status'),
	// 		], ['id' => $redeem_id]);


	// 		$transiction = $this->UserPaymentHistoryModel->save([

	// 			'user_id'                => $user_id,
	// 			'reason'                 => $this->input->post('reason'),
	// 			'credit_debit'          => $this->input->post('credit_debit'),
	// 			'amount'                => $this->input->post('request_amount'),

	// 		]);


	// 		$request_amount = $this->input->post('request_amount');
	// 		$wallet_amount = $this->input->post('wallet_amount');

	// 		$data = round($wallet_amount - $request_amount);

	// 		$update_wallet = $this->UsersModel->updateTable([

	// 			'wallet_amount'           => $data,

	// 		], ['id' => $user_id]);


	// 		flash_message(
	// 			'pay/redeem' . $redeem_id,
	// 			$redeems,
	// 			'unsuccess',
	// 			"Something Went Wrong"
	// 		);

	// 		flash_message(
	// 			'list/redeem',
	// 			$redeems,
	// 			'success',
	// 			"User Created Successfully"
	// 		);
	// 	}



	// 	$redeemData = $this->RedeemModel->first([
	// 		'fields' => ['redeem.*', 'users.wallet_amount as wallet_amount'],
	// 		'join' => [['users', 'redeem.user_id = users.id']],
	// 		'conditions' => [
	// 			'redeem.id' => $redeem_id,
	// 		],

	// 		'datatype' => 'json'
	// 	]);

	// 	$this->load->view('template/header');
	// 	$this->load->view('template/sidebar');
	// 	$this->load->view('redeem/pay', compact('redeemData'));
	// 	$this->load->view('template/footer');
	// }


	// public function decline($redeem_id)
	// {

	// 	if ($this->input->post('decline')) {
	// 		$comment              = $_REQUEST['comment'];
	// 		/* Upload Images */
	// 		$form_images = upload(['uploads/redeem' => 'declineImg']);

	// 		isset($form_images['declineImg']) and $decline_image = $form_images['declineImg'][0] or $decline_image = "";

	// 		$redeem = $this->RedeemModel->updateTable([

	// 			'comment'           => $comment,
	// 			'payment_status'   => $this->input->post('payment_status'),
	// 			'image'             => $decline_image
	// 		], ['id' => $redeem_id]);

	// 		flash_message(
	// 			'decline/redeem',
	// 			$redeem,
	// 			'unsuccess',
	// 			"Something Went Wrong"
	// 		);

	// 		flash_message(
	// 			'list/redeem',
	// 			$redeem,
	// 			'success',
	// 			"Decline Successfully"
	// 		);
	// 	}

	// 	$redeem = json_decode(json_encode($this->RedeemModel->all()));


	// 	$this->load->view('template/header');
	// 	$this->load->view('template/sidebar');
	// 	$this->load->view('redeem/decline', compact('redeem'));
	// 	$this->load->view('template/footer');
	// }


	// public function delete_lead($lead_slug = null)
	// {
	// 	empty($lead_slug) and show_404();

	// 	flash_message(
	// 		'dashboard/login',
	// 		is_login(),
	// 		'unsuccess',
	// 		'Please Login Then Try Again'
	// 	);

	// 	user_can('lead_delete') or show_404();
	// 	$user = $this->UsersModel->updateTable([
	// 		'status' => '3',
	// 	], ['slug' => $lead_slug]);

	// 	flash_message(
	// 		'list/leads',
	// 		$user,
	// 		'unsuccess',
	// 		"Something Went Wrong"
	// 	);

	// 	flash_message(
	// 		'list/leads',
	// 		$user,
	// 		'success',
	// 		"Lead Deleted Successfully"
	// 	);
	// }
}

/* End of file  Lead.php */
