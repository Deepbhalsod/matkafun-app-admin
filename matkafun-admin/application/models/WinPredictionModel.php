<?php defined('BASEPATH') or exit('No direct script access allowed');

class WinPredictionModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->database();
        $this->tableName = 'win_prediction_list';
    }
}

/* End of file CategoriesModel.php */