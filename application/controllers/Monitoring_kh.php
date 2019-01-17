<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_kh extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('monitoring_kh_model');
		$this->load->library('session');
		$this->load->library('upload');
	}

	public function index()
	{
		if (!empty($_SESSION['user_id'])) {
		 	// echo $this->session->nama;
		 	$user_id = $this->session->user_id;
		 } else{
		 	redirect(site_url('login'));
		 	return;
		 }
		$user_id = $this->session->userdata('user_id');
		$where = array('id_petugas' => $user_id);
		$data['monitoring'] = $this->monitoring_kh_model->getDataQuerys('select * from distribusi join karyawan on distribusi.id_petugas=karyawan.id where id_petugas="'.$user_id.'"');
		$this->load->view('kh/monitoring/monitoring_kh',$data);
	}
	
	public function userKH(){
		if (!empty($_SESSION['user_id'])) {
		 	// echo $this->session->nama;
		 	$user_id = $this->session->user_id;
		 } else{
		 	redirect(site_url('login'));
		 	return;
		 }
		$data['allKaryawan']= $this->monitoring_kh_model->getDataMix('dbDef','karyawan');
		$data['karyawan']= $this->monitoring_kh_model->getData('petugas_kh');
		$this->load->view('kh/monitoring/user_kh',$data);
	}
	
	public function proses(){
		$id_dis = $this->uri->segment(3);
		$where = array('id_distribusi' => $id_dis);
		$data['detail'] = $this->monitoring_kh_model->getDataWhere('distribusi',$where);
		$data['files'] = $this->monitoring_kh_model->getDataQuerys('select * from distribusi_detail join distribusi on distribusi_detail.id_distribusi=distribusi.id_distribusi where distribusi_detail.id_distribusi="'.$id_dis.'"');
		$this->load->view('kh/monitoring/monitoring_detail',$data);
	}
	
	public function tambahKh(){
		if (!empty($_SESSION['user_id'])) {
		 	// echo $this->session->nama;
		 	$user_id = $this->session->user_id;
		 } else{
		 	redirect(site_url('login'));
		 	return;
		 }
		$id = $this->input->post('id');
		$jenjang = $this->input->post('jenjang');
		$where = array('id' =>$id);
		$nama = $this->monitoring_kh_model->getDataMixWhere('dbDef','karyawan',$where);
		foreach ($nama as $a){
			$nama = $a->nama;
		}
		
		$data = array('id' => $id,
					  'nama' => $nama,
					  'jenjang' => $jenjang,
					  'status_kh' =>1);
		
		$cek = $this->monitoring_kh_model->getDataWhere('karyawan',$where);
		if($cek!=null){
			$this->monitoring_kh_model->updateData('karyawan',$data,$where);
			redirect(site_url('monitoring_kh/userKH'));
		}else{
			$this->monitoring_kh_model->insertInto('karyawan',$data);
			redirect(site_url('monitoring_kh/userKH'));
		}
	}
	
	public function tambahGambar(){
		if (!empty($_SESSION['user_id'])) {
		 	// echo $this->session->nama;
		 	$user_id = $this->session->user_id;
		} else{
		 	redirect(site_url('login'));
		 	return;
		}
		//var_dump($_FILES['gambar']['name']);exit();
		$isi = $this->input->post('isi');
		$id_dis = $this->input->post('id_dis');
		$id_petugas = $this->session->userdata('user_id');
		$uploadPath = 'uploads/'.$id_petugas;
		$uploadDate = date('Y-m-d H:m:s');
		$uploadData = array();
		//var_dump($_FILES['gambar']);exit();
		
		// File upload configuration
		if($_FILES['gambar']['name']!=""){
			$config['upload_path'] = './uploads/'.$id_petugas;
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['max_size']      =  1000;
			//$config['file_name'] = $new_name;
			
			// Load and initialize upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if (!is_dir('uploads/'.$id_petugas)) {
				mkdir('uploads/'.$id_petugas,0777, TRUE);
				echo "Bikin Folder";
			}

			if($this->upload->do_upload('gambar')){
				$uploadData = $this->upload->data();
				if($uploadData){
					//var_dump($uploadData);exit();
				}
			}else{
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
			}
			
			$data = array('path' => $uploadPath.'/'.$uploadData['file_name'],
						  'created_date' => $uploadDate,
						  'id_distribusi' => $id_dis);
			
			if($uploadData['file_name']!=null){
				$insert = $this->monitoring_kh_model->insertInto('distribusi_detail',$data);
				if($insert){
					redirect(site_url('monitoring_kh'));
				}
			}
		}else{
			echo "Ga Nyimpen ";
		}
		
		$dataIsi = array('isi' =>$isi);
		$whereIsi = array('id_distribusi' => $id_dis);
		if($isi!=null){
			$update = $this->monitoring_kh_model->updateData('distribusi',$dataIsi,$whereIsi);
			if($update){
				redirect(site_url('monitoring_kh'));
			}else{
				echo "Gagal";
			}
		}
	}
	
	public function admin(){
		$data['monitoring'] = $this->monitoring_kh_model->getDataQuerys('select * from distribusi join karyawan on distribusi.id_petugas=karyawan.id order by tgl_periksa desc');
		$this->load->view('kh/monitoring/monitoring_admin',$data);
	}
	
	public function hapus(){
		$id = $this->uri->segment('3');
		$where = array('id'=>$id);
		$hapus = $this->monitoring_kh_model->hapusWhere('karyawan',$where);
		if ($hapus) {
			redirect(site_url('monitoring_kh/userKH'));
		}else{
			echo "Gagal Hapus";
			echo '<meta http-equiv="refresh" content="2;URL='.site_url('monitoring_kh/userKH').'" />';
		}
	}
	
	public function hapusGambar($param){
		//$get = $this->input->get('uploads');
		$where = array('id' => $param);
		$delete = $this->monitoring_kh_model->hapusWhere('distribusi_detail',$where);
		if($delete){
			redirect(site_url('monitoring_kh'));
		}else{
			echo "Gagal Delete Gambar";
		}
		
		
	}

	public function updateTotal(){
		$data = $this->monitoring_kh_model->getDataQuerys('select distinct(user_id) from data_cuti_total');
		// var_dump($data);exit();
		$n=0;
		foreach($data as $d ){
			$n++;
			$user_id = $d->user_id;
			$tahun7 = $this->monitoring_kh_model->getDataQuerys("select total from data_cuti_total where tahun ='2017' and user_id='".$user_id."'");
			foreach($tahun7 as $t){
				$tahun1 = $t->total;
			}
			$tahun8 = $this->monitoring_kh_model->getDataQuerys("select total from data_cuti_total where tahun ='2018' and user_id='".$user_id."'");
			foreach($tahun8 as $t){
				$tahun = $t->total;
			}
			$this->monitoring_kh_model->insertInto('data_cuti_tes',array('user_id' => $user_id, 'n' => $tahun, 'n1' => $tahun1));
		}
	}

	Public function totalTahunan(){
		$data = $this->monitoring_kh_model->getData('data_cuti_tes');
		$n=0;$kuota=12;
		foreach ($data as $d ) {
			$n++;
			$id=$d->id;
			$n = $d->n;
			$hasil = $kuota - $n;
			if($hasil<=6){
				$nfinal = 6-$hasil;
			}else{
				$nfinal = 0;
			}
			//if($hasil<0){
				//$nfinal = 6;
			//}elseif($hasil==6){
				//$nfinal = 0;
			//}else{
				//$nfinal = $hasil;
			//}
			$this->totalTahunanUpdate($id,$nfinal);
			
		}
		var_dump($n);
	}

	public function totalTahunanUpdate($id,$n){
		$update = $this->monitoring_kh_model->updateData('data_cuti_tes',array('n1' => $n),array('id' => $id)); 
		if($update){
			if($this->monitoring_kh_model->updateData('data_cuti_tes',array('n' => 0), array('id' => $id))){
				echo "update total tahunan berhasil";
			}

		}else{
			echo "update gagal";
		}
	}
}
