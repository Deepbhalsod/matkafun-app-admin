<?php defined('BASEPATH') or exit('No direct script access allowed');

class FirstaidModel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->database();
		$this->tableName = 'app_image';
	}
}

/* End of file FiltersModel.php */
