<?php defined('BASEPATH') or exit('No direct script access allowed');

class GameMarketDayWise extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->database();
        $this->tableName = 'game_market_day_wise';
    }
}

/* End of file CategoriesModel.php */
