<?php
	class User_model extends CI_model{

		public function __construct(){
			parent::__construct();
			// $this->db = $this->load->database();
		}

		public function getData($table){
			$this->db->from($table);
			return $this->db->get()->result();
		}

		public function getDataWhere($table,$where){
			$this->db->from($table);
			$this->db->where($where);
			return $this->db->get()->result();
		}

		public function getDataQuerys($query){
			$querys = $this->db->query($query);
			return $querys->result();
		}

		public function hapusWhere($table,$where){
			$this->db->where($where);
			$this->db->delete($table);
			return true;
		}

		public function updateData($table,$data,$where){
			$this->db->where($where);
			$this->db->update($table,$data);
			return true;
		}

		public function addData($table,$data){
			$this->db->insert($table,$data);
			return true;
		}
	}
?>
