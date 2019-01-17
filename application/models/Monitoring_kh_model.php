<?php
	class Monitoring_kh_model extends CI_model{

		public function __construct(){
			parent::__construct();
			$this->db = $this->load->database('kh',true);
			$this->dbDef = $this->load->database('default',true);
			// $this->db = $this->load->database();
		}

		public function getData($table){
			$this->db->from($table);
			return $this->db->get()->result();
		}

		public function getDataQuerys($query){
			$querys = $this->db->query($query);
			return $querys->result();
		}

		public function getDataWhere($table,$where){
			$this->db->from($table);
			$this->db->where($where);
			return $this->db->get()->result();
		}
		
		public function getDataMix($op,$table){
			$this->$op->from($table);
			return $this->$op->get()->result();
		}
		
		public function getDataMixWhere($op,$table,$where){
			$this->$op->from($table);
			$this->$op->where($where);
			return $this->$op->get()->result();
		}
		
		public function insertInto($table,$data){
			$this->db->insert($table,$data);
			return true;
		}

		public function updateData($table,$data,$where){
			$this->db->where($where);
			$this->db->update($table,$data);
			return true;
		}
		
		public function hapusWhere($table,$where){
			$this->db->where($where);
			$this->db->delete($table);
			return true;
		}
		
		public function getRows($id = ''){
			$this->db->select('id,nama_file,upload_date');
			$this->db->from('distribusi_detail');
			if($id){
				$this->db->where('id',$id);
				$query = $this->db->get();
				$result = $query->row_array();
			}else{
				$this->db->order_by('upload_date','desc');
				$query = $this->db->get();
				$result = $query->result_array();
			}
			return !empty($result)?$result:false;
		}
		
		public function insert($data = array()){
			$insert = $this->db->insert_batch('distribusi_detail',$data);
			return $insert?true:false;
		}
		
	}
?>
