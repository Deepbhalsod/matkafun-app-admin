<?php defined('BASEPATH') or exit('No direct script access allowed');

class GalidisawarGameModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        $this->tableName = 'gali_disawar_game';
    }
}
?>