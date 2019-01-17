<?php
	class Cuti_model extends CI_model{

		public function __construct(){
			parent::__construct();
			$this->db = $this->load->database('default',true);
			$this->tpk = $this->load->database('tpk',true);
		}

		public function ambilData($user_id){
			$select = "SELECT DISTINCT
					   data_cuti_jenis.*,
					   data_cuti_satuan.*,
					   data_cuti.*,
					   karyawan.status_kh,
					   Atasan.nama AS nama_atasan,
					   karyawan.nama AS nama_karyawan

					FROM karyawan AS Atasan,
						 karyawan AS karyawan,
					     -- data_cuti_satuan,
					     data_cuti

					LEFT JOIN data_cuti_satuan ON data_cuti.id_cutisatuan=data_cuti_satuan.id_cutisatuan
					LEFT JOIN data_cuti_jenis ON data_cuti.id_jeniscuti=data_cuti_jenis.id_jeniscuti

					WHERE data_cuti.id_jeniscuti = data_cuti_jenis.id_jeniscuti
					  AND karyawan.id = data_cuti.id_pegawai
					   AND  Atasan.id = data_cuti.id_atasan
					   AND data_cuti.id_pegawai = {$user_id}
					   AND data_cuti.is_active = 1
					   -- AND data_cuti.id_rekom = {$user_id} ";
			$query = $this->db->query($select);
			return $query->result();
			// $select = "SELECT * FROM printCuti WHERE id_pegawai= {$user_id} AND id_rekom = {$user_id} AND status = 1 OR status = 2";
			// $query = $this->db->query($select);
			// return $query->result();

		}
		
		public function ambilDataProses($user_id){
			$query = $this->db->query('SELECT DISTINCT
					   data_cuti_jenis.*,
					   data_cuti.*,
					   data_cuti_satuan.*,
					   Atasan.nama AS nama_atasan,
					   karyawan.nama AS nama_karyawan

					FROM karyawan AS Atasan,
						 karyawan AS karyawan,
					     data_cuti_jenis,
					     data_cuti

					LEFT JOIN data_cuti_satuan ON data_cuti.id_cutisatuan=data_cuti_satuan.id_cutisatuan

					WHERE data_cuti.id_jeniscuti = data_cuti_jenis.id_jeniscuti
					  AND karyawan.id = data_cuti.id_pegawai
					   AND  Atasan.id = data_cuti.id_atasan
					   AND (data_cuti.status = 1 OR data_cuti.status = 7)
					   AND data_cuti.is_active = 1
					   ');
			return $query->result();

		}

		public function ambilDataApproval($field,$user_id,$status){

			$select = "SELECT DISTINCT
					   data_cuti_jenis.*,
					   data_cuti_satuan.*,
					   data_cuti.*,
					   karyawan.status_kh,
					   Atasan.nama AS nama_atasan,
					   karyawan.nama AS nama_karyawan

					FROM karyawan AS Atasan,
						 karyawan AS karyawan,
					     -- data_cuti_satuan,
					     data_cuti

					LEFT JOIN data_cuti_satuan ON data_cuti.id_cutisatuan=data_cuti_satuan.id_cutisatuan
					LEFT JOIN data_cuti_jenis ON data_cuti.id_jeniscuti=data_cuti_jenis.id_jeniscuti

					WHERE data_cuti.id_jeniscuti = data_cuti_jenis.id_jeniscuti
					  AND karyawan.id = data_cuti.id_pegawai
					   AND  Atasan.id = data_cuti.id_atasan
					   AND data_cuti.{$field} = {$user_id}
					   AND data_cuti.status = {$status}
					   -- AND data_cuti.id_rekom = {$user_id} ";
			$query = $this->db->query($select);
			return $query->result();
			// $select = "SELECT * FROM printCuti WHERE id_atasan= {$user_id} OR id_pejabat = {$user_id} AND 'status' = 2";
			// $query = $this->db->query($select);
			// $this->db->select('*');
			// $this->db->from('printCuti');
			// $this->db->where($where);
			// return $this->db->get()->result();

		}

		public function ambilDataApprovalAll(){
			$query = $this->db->query('SELECT DISTINCT
					   data_cuti_jenis.*,
					   data_cuti.*,
					   data_cuti_satuan.*,
					   Atasan.nama AS nama_atasan,
					   karyawan.nama AS nama_karyawan

					FROM karyawan AS Atasan,
						 karyawan AS karyawan,
					     data_cuti_jenis,
					     data_cuti

					LEFT JOIN data_cuti_satuan ON data_cuti.id_cutisatuan=data_cuti_satuan.id_cutisatuan

					WHERE data_cuti.id_jeniscuti = data_cuti_jenis.id_jeniscuti
					  AND karyawan.id = data_cuti.id_pegawai
					   AND Atasan.id = data_cuti.id_atasan
					   AND data_cuti.status = 2');
			return $query->result();

		}

		public function ambilDataKaryawan(){
			// $this->db->protect_identifiers('karyawan');
			// $this->db->select('karyawan');
			$query = $this->db->query('SELECT karyawan.id, karyawan.nama, data_cuti.id_pegawai, data_cuti.id_atasan FROM karyawan INNER JOIN data_cuti ON karyawan.id = data_cuti.id_pegawai');
			return $query->result();

		}

		public function getDataQuery($query){
			$querys = $this->db->query($query);
			return $querys->result();
		}

		public function ambilPejabat(){
			$this->db->from('karyawan_pejabat');
			$this->db->join('karyawan','karyawan.id=karyawan_pejabat.id_pegawai','left');
			return $this->db->get()->result();
		}


		public function ambilDataWhere($where){
			// $this->db->protect_identifiers('karyawan');
			$this->db->from('data_cuti');
			$this->db->join('karyawan','karyawan.id = data_cuti.id_pegawai','left');
			$this->db->join('data_cuti_jenis','data_cuti_jenis.id_jeniscuti = data_cuti.id_jeniscuti','left');
			$this->db->join('data_cuti_satuan','data_cuti_satuan.id_cutisatuan = data_cuti.id_cutisatuan','left');
			$this->db->where($where);
			// $query = $this->db->query('SELECT * FROM karyawan');
			// $this->db->join('divisi','divisi.id_divisi = data_jabatan.id_divisi','left');
			return $this->db->get()->result();

		}

		public function ambilPrintout($where){
			$this->db->from('printcuti');
			$this->db->where($where);
			return $this->db->get()->result();
		}

		public function ambilCutiAll(){
			$this->db->from('printcuti');
			$this->db->order_by('id_cuti','asc');
			return $this->db->get()->result();
		}

		public function ambilJenisCuti(){
			$query = $this->db->from('data_cuti_jenis');
			return $query->get()->result();
		}
		public function ambilSatuanCuti(){
			$query = $this->db->from('data_cuti_satuan');
			return $query->get()->result();
		}

		public function ambilKaryawanSession($table,$where){
			return $this->db->get_where($table,$where)->result();
		}

		public function ambilAllKaryawan(){
			$this->db->from('karyawan');
			return $this->db->get()->result();
		}

		public function ambilKaryawanLike($like){
			$this->db->from('karyawan');
			$this->db->like('jabatan',$like);
			return $this->db->get()->result();
		}

		public function tambah_data($data){
			$this->db->insert('data_cuti',$data);
			return true;
		}

		public function updateData($data,$where){
			$this->db->where($where);
			$this->db->update('data_cuti',$data);
			return true;
		}

		public function updateDataWhere($table,$data,$where){
			$this->db->where($where);
			$this->db->update($table,$data);
			return true;
		}

		public function hapus_data($id){
			$this->db->where('id_cuti', $id);
			$this->db->delete('data_cuti');
			return true;
		}

		public function hapusWhere($table,$id,$field){
			$this->db->where($field, $id);
			$this->db->delete($table);
			return true;
		}

		public function approveCuti($id,$data){
			$this->db->where('id_cuti', $id);
			$this->db->update('data_cuti',$data);
			return true;
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

		public function getGol(){
			$this->db->from('gol');
			return $this->db->get()->result();
		}

		public function updateProfil($data,$where){
			$this->db->where($where);
			$this->db->update('karyawan',$data);
			return true;
		}

		public function simpanData($table,$data){
			$this->db->insert($table,$data);
			return true;
		}

		public function getTotal(){
			$this->db->from('data_cuti_total');
			$this->db->join('karyawan','karyawan.id=data_cuti_total.user_id','left');
			$this->db->group_by('data_cuti_total.id');
			$this->db->order_by('karyawan.id','asc');
			return $this->db->get()->result();
		}

		public function rekap($table,$where,$group){
			$this->db->from($table);
			$this->db->where($where);
			$this->db->order_by($group);
			return $this->db->get()->result();

		}

		public function getDataTpk($query){
			$querys = $this->tpk->query($query);
			return $querys->result();
		}

		public function getDataTpkInsert($query){
			$querys = $this->tpk->query($query);
			return true;
		}
	}
?>
