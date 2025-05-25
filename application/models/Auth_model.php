<?php
class Auth_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); 
    }
    
    public function insert_user($data) {
       // var_dump($data);exit;
        return $this->db->insert('users', $data);
    }

    public function get_user($email) {
        return $this->db->get_where('users', ['email' => $email])->row();
    }
}
