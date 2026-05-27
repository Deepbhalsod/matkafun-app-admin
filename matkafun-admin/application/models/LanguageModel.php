<?php defined('BASEPATH') or exit('No direct script access allowed');

class LanguageModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->database();
        $this->tableName = 'employee_languages';
    }
}

/* End of file CategoriesModel.php */