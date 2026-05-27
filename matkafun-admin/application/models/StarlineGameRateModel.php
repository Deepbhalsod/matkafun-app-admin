<?php defined('BASEPATH') or exit('No direct script access allowed');

class StarlineGameRateModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->database();
        $this->tableName = 'starline_game_rate';
    }
}

/* End of file CategoriesModel.php */
