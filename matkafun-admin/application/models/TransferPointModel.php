<?php defined('BASEPATH') or exit('No direct script access allowed');

class TransferPointModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->database();
        $this->tableName = 'transfer_point';
    }
}

/* End of file CategoriesModel.php */