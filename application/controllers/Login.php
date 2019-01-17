<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
	}

	public function index()
	{
		$id = $this->input->get('u');
		// var_dump($coba);exit();
		$where = array('id' => $id);
		if ($id!=null) {
			$cek = $this->login_model->cek_login("karyawan",$where)->row_array();
			// var_dump($cek);exit();
			if ($cek) {
				$data_session = array('user_id' => $cek['id'],
								  'nama' => $cek['nama'],
								  'id_divisi' => $cek['id_divisi'],
								  
								  'status' => "Login" );
				
				$this->session->set_userdata($data_session);
				redirect(site_url('dashboard'));
			}
			
			
		}else{
			$this->session->sess_destroy();
			$this->load->view('login/login');	
		}
		

	}

	public function cekLogin(){

		// var_dump($_POST);exit();
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'username' => $username,
			'password' => md5($password)
			);
		$cek = $this->login_model->cek_login("karyawan",$where)->row_array();
		
		if(!empty($cek)){
			$jab = $cek['jabatan'];
			$jabs = substr($jab, 0,6);
			if ($jabs == "Kepala") {
				$jabatan = $jabs;
			}
			
			$data_session = array(
				'user_id' => $cek['id'] ,
				'nama' => $cek['nama'] ,
				'id_divisi' => $cek['id_divisi'] ,
				'status_kh' => $cek['status_kh'],
				'kode_jab' => $cek['kode_jab'],
				'jabatan' => $jabatan,
				'status' => "login"
				);
 
			$this->session->set_userdata($data_session);
 
			redirect(site_url("dashboard"));
 
		}else{
			echo "Username Atau Password Salah";
			echo '<meta http-equiv="refresh" content="2;URL='.site_url('login').'" />';
			//redirect(site_url(login));
			//echo "Username dan password salah !";
		}
	}

	public function logout(){
	$this->session->sess_destroy();
	redirect(site_url('login'));
}
}
