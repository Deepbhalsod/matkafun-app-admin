<?php defined('BASEPATH') or exit('No direct script access allowed');

class VideoModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->database();
        $this->tableName = 'video';
    }
}

/* End of file BookingModel.php */
