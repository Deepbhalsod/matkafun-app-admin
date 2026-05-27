<?php defined('BASEPATH') or exit('No direct script access allowed');
class NotificationsSentModel extends CI_Model
{
    public $tableName;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tableName = 'notifications_sent';
    }

    public function save($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function first($where)
    {
        return $this->db->get_where($this->table, $where)->row_array();
    }
}
