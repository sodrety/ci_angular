<?php
	class Perencanaan_kh_model  extends CI_model{

		public function __construct(){
			parent::__construct();
			$this->db = $this->load->database('kh',true);
			$this->dbAn = $this->load->database('antrian',true);
			$this->dbSpt = $this->load->database('spt',true);
		}

		public function getData($table){
			$this->db->from($table);
			return $this->db->get()->result();
		}
		
		public function getDataQuery($limit){
			$select = "select * from petugas_kh limit 0,{$limit}";
			$query = $this->db->query($select);
			return $query->result();
		}

		public function getDataQuerys($query){
			$querys = $this->db->query($query);
			return $querys->result();
		}

		public function getDataQueryst($query){
			$querys = $this->db->query($query);
			return true;
		}

		public function getDataQuerySpt($query){
			$querys = $this->dbSpt->query($query);
			return $querys->result();
		}

		public function getDataWhere($table,$where){
			$this->db->from($table);
			$this->db->where($where);
			return $this->db->get()->result();
		}
		
		public function getDataWhereFalse($table,$where){
			$this->db->from($table);
			$this->db->where($where);
			return 'btn btn-danger';
		}

		public function getDataMove($table){
			$this->dbAn->from($table);
			return $this->dbAn->get()->result();
		}
		
		public function getDataFieldWhere($no){
			$query = "select * from perencanaan_tk where no_permohonan={$no}";
			$select = $this->db->query($query);
			$data = $select->result_array();
			
			foreach($data as $s){
				$no++;
				$jml=$s['jumlah'];
			}
			//var_dump($jml);exit();
			return $jml;
		}

		public function getDataWhereMove($table,$where){
			$this->dbAn->from($table);
			$this->dbAn->where($where);
			return $this->dbAn->get()->result();
		}

		public function getDataFieldWhereMove($table,$field,$where){
			$this->dbAn->select($field);
			$this->dbAn->from($table);
			$this->dbAn->where($where);
			return $this->dbAn->get()->result();
		}
		
		public function getDataQueryMix($query,$mt){
			$querys = $this->$mt->query($query);
			return $querys->result();
		}

		public function insertInto($table,$data){
			$this->db->insert($table,$data);
			return true;
		}
		
		public function replaceData($table,$data){
			$this->db->replace($table, $data);
			return true;
		}

		public function updateData($table,$data,$where){
			$this->db->where($where);
			$this->db->update($table,$data);
			return true;
		}

		public function deleteData($table,$where){
			$this->db->where($where);
			$this->db->delete($table);
			return true;
		}

		public function jumlah_spt($id,$tgl){
			$n=0;
			$data = $this->perencanaan_kh_model->getDataQuerySpt('select * from spt join spt_petugas on spt.id=spt_petugas.id_spt where id_user="'.$id.'" and kat="TKH" and spd="SPD.KH" and waktu_selesai like "'.$tgl.'%"');
			// var_dump($data['spt']);
			foreach ($data as $s) {
				$n++;
				// $id = $s->id;
				
			}
			return $n;
		}
		
	}
?>
