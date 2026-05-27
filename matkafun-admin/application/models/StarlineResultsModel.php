<?php defined('BASEPATH') or exit('No direct script access allowed');

class StarlineResultsModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->database();
        $this->tableName = 'starline_result';
    }
}

/* End of file CategoriesModel.php */
