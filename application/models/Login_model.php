<?php
	class Login_model extends CI_model{

		public function __construct(){
			parent::__construct();
			// $this->db = $this->load->database();
		}

		public function cek_login($table, $where){
			return $this->db->get_where($table,$where);
		}
	}
?>
