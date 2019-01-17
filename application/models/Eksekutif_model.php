<?php
	class Eksekutif_model extends CI_model{

		public function __construct(){
			parent::__construct();
			$this->db = $this->load->database('eksekutif',true);
		}

		public function getDataQuery($query){
			$querys = $this->db->query($query);
			return $querys->result();
		}
	}
?>
