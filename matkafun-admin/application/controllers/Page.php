<?php defined('BASEPATH') or exit('No direct script access allowed');

/** Load & Execute User Modules */
class Page extends CI_Controller
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
		$this->load->model(['PagesModel']);
	}


	/** Load Default Index To Show 404 Error
	 *
	 * @return void */
	public function index()
	{
		return show_404();
	}

	public function list_pages()
	{
		if ($this->input->post('editDriverPages')) {


			$page = $this->PagesModel->updateTable([
				'how_to_play' => $this->input->post('how_to_play'),
				'video_link' => $this->input->post('video_link'),
	
			], ['id' => '1']);
			
		        

			flash_message(
				'list/page',
				$page,
				'unsuccess',
				"Something Went Wrong"
			);

			flash_message(
				'list/page',
				$page,
				'success',
				"Pages Updated Successfully"
			);
			
			
		}
		
		$settingData = json_decode(json_encode($this->PagesModel->first([
			'conditions' => [
				// 'status!=' => '3'
			],
		])));


		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('page/list', compact('settingData'));
		$this->load->view('template/footer');
	}

	public function edit_pages()
	{

		if ($this->input->post('editPages')) {


			$page = $this->PagesModel->updateTable([
				'about' => $this->input->post('about'),
			], ['id' => '1']);


			flash_message(
				'edit/page',
				$page,
				'unsuccess',
				"Something Went Wrong"
			);

			flash_message(
				'edit/page',
				$page,
				'success',
				"page Updated Successfully"
			);
		}
		
		$settingData = json_decode(json_encode($this->PagesModel->first([
			'conditions' => [
				// 'status!=' => '3'
			],
		])));


		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('page/edit', compact('settingData'));
		$this->load->view('template/footer');
	}
}

    /* End of file  User.php */
