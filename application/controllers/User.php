<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		if (!empty($_SESSION['user_id'])) {
			// echo $this->session->nama;
			$user_id = $this->session->user_id;
		} else{
			redirect(site_url('login'));
			return;
		}
	}

	public function index()
	{
		$data['karyawan'] = $this->user_model->getData('karyawan');
		$data['gol'] = $this->user_model->getData('gol');
		$this->load->view('user/user',$data);
	}

	public function edit(){
		$id = $this->uri->segment('3');
		$where = array('id'=>$id);
		$data['karyawan'] = $this->user_model->getDataWhere('karyawan',$where);
		$data['gol'] = $this->user_model->getData('gol');
		$this->load->view('user/user_edit',$data);
	}

	public function hapus(){
		$id = $this->uri->segment('3');
		$where = array('id'=>$id);
		$hapus = $this->user_model->hapusWhere('karyawan',$where);
		if ($hapus) {
			redirect(site_url('user'));
		}else{
			echo "Gagal Hapus";
			echo '<meta http-equiv="refresh" content="2;URL='.site_url('user').'" />';
		}
	}

	public function akses()
	{
		$data['akses'] = $this->user_model->getDataQuerys('select * from akses join karyawan on akses.user_id=karyawan.id');
		$data['allKaryawan'] = $this->user_model->getData('karyawan');
		$this->load->view('user/akses',$data);
	}

	public function tambahPegawai(){
		// var_dump($_POST);exit;
		$nip = $this->input->post('nip');
		$nama = $this->input->post('nama');
		$pangkat = $this->input->post('pangkat');
		$jabatan = $this->input->post('jabatan');
		$hp = $this->input->post('hp');
		$email = $this->input->post('email');
		$wa = $this->input->post('wa');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$ul_password = $this->input->post('ul_password');
		$bid = $this->input->post('bid');
		$bag = $this->input->post('bag');

		if ($password!=$ul_password) {
			echo "Password tidak sama";
			echo '<meta http-equiv="refresh" content="1;URL='.site_url('user').'" />';
			return;
		}
		$data = array(
						'nip' => $nip,
						'nama' => $nama,
						'golongan' => $pangkat,
						'jabatan' => $jabatan,
						'hp' => $hp,
						'email' => $email,
						'wa' => $wa,
						'status_kh' => $bid,
						'kode_jab' => $bag,
						'username' => $username,
						'password' => md5($password)

					);
		$input = $this->user_model->addData('karyawan',$data);
		if ($input) {
			redirect(site_url('user'));
		}else {
			echo "Gagal Tambah Pegawai";
		}
	}

	public function editAkses(){
		$id = $this->input->post('id');
		$app = $this->input->post('aplikasi');
		$akses = $this->input->post('akses');
		$ids = $app."_".$id;

		$data = array('id' => $app."_".$id,
					  'aplikasi' => $app,
					  'user_id' => $id,
					  'hak_akses' => $akses );

		$cek = $this->user_model->getDataWhere('akses', array('id' =>  $app."_".$id));
		if(!empty($cek)){
			if($this->user_model->updateData('akses',$data,array('id' =>  $app."_".$id))){
				redirect(site_url('user/akses'));
			}else{
				echo "Gagal Update Hak Akses";
			}
		}else{
			if($this->user_model->addData('akses',$data)){
				redirect(site_url('user/akses'));
			}else{
				echo "Gagal Tambah Hak Akses";
			}
		}
	}
}
