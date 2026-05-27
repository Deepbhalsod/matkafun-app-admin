<?php defined('BASEPATH') or exit('No direct script access allowed');
/** Load Setting Pages & Queries */
class Setting extends CI_Controller
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
		$this->load->model([
			'SettingsModel',
			'UsersModel',
			'AccountModel'
		]);
	}


	/** Load Default Index To Show 404 Error
	 *
	 * @return void */
	public function index()
	{
		return show_404();
	}

	public function add_account()
	{
		$ratingsData = [];
		if ($this->input->post('addbankAccount')) {



			$job = $this->AccountModel->updateTable([
				'account_holder_name' => $this->input->post('account_holder_name'),
				'account_no' => $this->input->post('account_no'),
				'ifsc_code' => $this->input->post('ifsc_code'),

			], ['id' => 1]);
		}

		if ($this->input->post('addappstatus')) {



			$job = $this->AccountModel->updateTable([
				'app_live_status' => $this->input->post('app_live_status')

			], ['id' => 1]);
		}

		if ($this->input->post('addapk')) {

			$config['upload_path'] = './uploads/setapk';
			$config['allowed_types'] = 'APk|apk';
			$config['max_size'] = 100000;
			$this->load->library('upload', $config);

			if ($this->upload->do_upload('apkset')) {


				$data = array('upload_data' => $this->upload->data());

				$FileName = $data['upload_data']['file_name'];
				$FullPath = $data['upload_data']['full_path'];
				$path = SITE_URL . "uploads/setapk/" . $data['upload_data']['file_name'];
			}

			$job = $this->AccountModel->updateTable([
				'apk' => $path

			], ['id' => 1]);
		}

		if ($this->input->post('addappAccount')) {



			$job = $this->AccountModel->updateTable([
				'app_link' => $this->input->post('app_link'),
				'share_message' => $this->input->post('share_message'),

			], ['id' => 1]);
		}

		if ($this->input->post('addupiAccount')) {



			$job = $this->AccountModel->updateTable([
				'upi_name' => $this->input->post('upi_name'),
				'upi_payment_id' => $this->input->post('upi_payment_id'),
				'g_pay_upi' => $this->input->post('g_pay_upi'),
				'phonepe_upi' => $this->input->post('phonepe_upi'),
				'paytm_upi' => $this->input->post('paytm_upi'),
				'others_upi' => $this->input->post('others_upi'),

			], ['id' => 1]);
		}


		if ($this->input->post('addotherAccount')) {

			$job = $this->AccountModel->updateTable([
				'market_open_time' => $this->input->post('market_open_time'),
				'alert_message' => $this->input->post('alert_message'),
			], ['id' => 1]);
		}
		if ($this->input->post('addautoresult')) {
			$job = $this->AccountModel->updateTable([
				'auto_result' => $this->input->post('auto_result_status')
			], ['id' => 1]);
		}

		if ($this->input->post('addvisibility')) {
			$job = $this->AccountModel->updateTable([
				'visibilityOfSection' => $this->input->post('visibilityOfSection_result')
			], ['id' => 1]);
		}


		if ($this->input->post('addvalueAccount')) {

			$job = $this->AccountModel->updateTable([
				'maximum_deposit' => $this->input->post('maximum_deposite'),
				'minimum_deposit' => $this->input->post('minimum_deposite'),
				'minimum_withdraw' => $this->input->post('minimum_withdraw'),
				'maximum_withdraw' => $this->input->post('maximum_withdraw'),
				'maximum_transfer' => $this->input->post('maximum_transfer'),
				'minimum_transfer' => $this->input->post('minimum_transfer'),
				'maximum_bid_amount' => $this->input->post('maximum_bid_amount'),
				'minimum_bid_amount' => $this->input->post('minimum_bid_amount'),
				'withdraw_open_time' => $this->input->post('withdraw_open_time'),
				'withdraw_close_time' => $this->input->post('withdraw_close_time')
			], ['id' => 1]);
		}

		if ($this->input->post('addtelegramLink')) {
			$telegram_link = $this->input->post('telegram_link');
			$exists = $this->SettingsModel->first(['conditions' => ['option_key' => 'telegram_channel_link']]);
			if ($exists) {
				$job = $this->SettingsModel->updateTable(['option_value' => $telegram_link], ['option_key' => 'telegram_channel_link']);
			} else {
				$job = $this->SettingsModel->save([
					'option_key' => 'telegram_channel_link',
					'option_value' => $telegram_link,
					'option_category' => 'contact_details'
				]);
			}
		}

		$full_sangam_Data = $this->AccountModel->first([
			'conditions' => [
				'id' => 1
			]
		]);

		$telegram_Data = $this->SettingsModel->first(['conditions' => ['option_key' => 'telegram_channel_link']]);

		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('setting/account_list', compact('full_sangam_Data', 'telegram_Data'));
		$this->load->view('template/footer');
	}

	/** Load Setting List Page */
	public function list_setting(string $type = 'brand')
	{
		flash_message(
			'dashboard/login',
			is_login(),
			'unsuccess',
			'Please Login Then Try Again'
		);

		user_can('setting_list') or show_404();

		is_array(SETTINGS) and array_key_exists($type, SETTINGS) and is_array(SETTINGS[$type])
			or show_404();

		$settingData = object([
			'type' => 'Settings'
		]);
		$setting = $this->SettingsModel->all([
			'order' => [
				'by' => 'option_key',
				'type' => 'ASC'
			]
		]);

		empty($setting) or is($setting, 'array') and $settingData = object([
			'type' => 'Settings',
			'data' => $setting
		]);


		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('setting/list', compact('settingData', 'type'));
		$this->load->view('template/footer');
	}

	/** Edit Setting */
	public function edit_setting($setting_slug = null)
	{
		empty($setting_slug) and show_404();

		user_can('setting_edit') or show_404();


		if ($this->input->post('editSetting')) {

			flash_message(
				'edit/setting/' . $setting_slug,
				$this->input->post('option_value')
				or is($_FILES['option_value']),
				'unsuccess',
				'Something Went Wrong',
				'Look like Form Not Fill Properly, Please Fill & Try Again.'
			);

			if (is($_FILES['option_value'])) {/* Upload Images */
				$form_images = upload(['uploads/setting' => 'option_value']);

				isset($form_images['option_value']) and $setting_image = $form_images['option_value'][0] or $setting_image = $this->input->post('oldoption_value');
			} else {
				$setting_image = $this->input->post('option_value');
			}


			// upload web logo
			if (($setting_slug == "web_logo") || ($setting_slug == "admin_favicon") || ($setting_slug == "web_favicon") || ($setting_slug == "banner_img_1") || ($setting_slug == "banner_img_2") || ($setting_slug == "banner_img_3") || ($setting_slug == "admin_logo") || ($setting_slug == "web_favicon")) {



				$config['upload_path'] = './uploads/setting/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['encrypt_name'] = TRUE;

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('option_value')) {

					$data = array('upload_data' => $this->upload->data());

					$FileName = $data['upload_data']['file_name'];
					$FullPath = $data['upload_data']['full_path'];
					$path = SITE_URL . "uploads/setting/" . $data['upload_data']['file_name'];

					// $img = file_get_contents($path);

					//         // Encode the image string data into base64
					// $data = base64_encode($img);

					$setting = $this->SettingsModel->updateTable([
						'option_value' => $path,
					], ['option_key' => $setting_slug]);
				}


			} else {
				$setting = $this->SettingsModel->updateTable([
					'option_value' => $setting_image
				], ['option_key' => $setting_slug]);
			}



			flash_message(
				'edit/setting/' . $setting_slug,
				$setting,
				'unsuccess',
				"Something Went Wrong"
			);

			flash_message(
				'settings/brand',
				$setting,
				'success',
				"Setting Updated Successfully"
			);
		}


		$settingData = '';
		$setting = $this->SettingsModel->first(['conditions' => ['option_key' => $setting_slug]]);
		$settingData = json_decode(json_encode($setting));
		//_dd($settingData);
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('setting/edit', compact('settingData'));
		$this->load->view('template/footer');
	}

	/** Delete Setting */
	public function delete_setting($setting_slug = null)
	{
		empty($setting_slug) and show_404();

		flash_message(
			'dashboard/login',
			is_login(),
			'unsuccess',
			'Please Login Then Try Again'
		);

		user_can('setting_delete') or show_404();

		$setting = $this->SettingsModel->updateTable([
			'status' => '3',
		], ['slug' => $setting_slug]);
		flash_message(
			'settings/brand',
			$setting,
			'unsuccess',
			"Something Went Wrong"
		);

		flash_message(
			'settings/brand',
			$setting,
			'success',
			"Setting Deleted Successfully"
		);
	}
}

/* End of file Setting.php */
