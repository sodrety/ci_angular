<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_cuti extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('cuti_model');
		$this->load->library('session');
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
		$tanggal = date('Y-m-d');
		$data['current_date'] = $tanggal;
		

 		$a = $_SERVER['SERVER_ADDR'];
 		$server = explode('/',$a);
 		$a[0];
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$data['controller'] = $this;
		$statusAtasan = 2;
 		$statusPejabat = 3;
 		$statusRekom = 6;
 		$statusRekom2 = 9;
 		$statusTolak = 5;
 		$fieldAtasan = "id_atasan";
 		$fieldPejabat = "id_pejabat";
 		$fieldRekom = "id_rekom";
 		$fieldRekom2 = "id_rekom2";
 		$fieldPegawai = "id_pegawai";
 		$user_id = $this->session->userdata('user_id');
 		$where = array('user_id' => $user_id);
 		$whereProfile = array('id' => $user_id);
 		$whereAntrian = array('tgl' => $curr_date);
 		$whereTolak = array('status' => 5);
 		$whereSelesai = array('status' => 4);
 		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
 		$data['approveAtasan'] = $this->cuti_model->ambilDataApproval($fieldAtasan,$user_id,$statusAtasan);
 		$data['approvePejabat'] = $this->cuti_model->ambilDataApproval($fieldPejabat,$user_id,$statusPejabat);
 		$data['approveRekom'] = $this->cuti_model->ambilDataApproval($fieldRekom,$user_id,$statusRekom);
 		$data['approveRekom2'] = $this->cuti_model->ambilDataApproval($fieldRekom2,$user_id,$statusRekom2);
		$currentYear = date('Y');
		$currentYear1 = date('Y')-1;

		$whereSisa = array('user_id'=>$user_id);
		$whereSisa1 = array('user_id'=>$user_id,'tahun'=>$currentYear1);
		$where = array('id'=>$user_id);
		$whereProfile = array('id' => $user_id);
		$like = "Kepala";
		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
		$data['data_cuti'] = $this->cuti_model->ambilData($user_id);
		// $data['data_cuti_approve'] = $this->cuti_model->ambilDataApproval($user_id);
		$data['jenis_cuti'] = $this->cuti_model->ambilJenisCuti();
		$data['satuan_cuti'] = $this->cuti_model->ambilSatuanCuti();
		$data['allKaryawan'] = $this->cuti_model->ambilAllKaryawan();
		$data['KaryawanLike'] = $this->cuti_model->ambilKaryawanLike($like);
		$data['karyawan'] = $this->cuti_model->ambilKaryawanSession('karyawan',$where);
		$data['pejabat'] = $this->cuti_model->ambilPejabat();
		$data['profil'] = $this->cuti_model->ambilKaryawanSession('karyawan',$whereProfile);
		$data['gol'] = $this->cuti_model->getGol();
		$data['sisa'] = $this->cuti_model->getDataWhere('data_cuti_tes',$whereSisa);
		$data['kuota'] = $this->cuti_model->getData('data_cuti_kuota');
		foreach($data['kuota'] as $k){
			$kuota = $k->n;
			$kuota1 = $k->n1;
		}
		if ($data['sisa']!=null){
			foreach($data['sisa'] as $s){
				$id_sisa = $s->user_id;
				$sisa1 = $s->n1;
				$sisa = $s->n;
			}	
		}else{
			$id_sisa = null;
		}
		if($sisa==null){
			$sisas = 0;
			$sisa = strval($sisas);
		}
		if($sisa1==null){
			$sisas = 0;
			$sisa1 = strval($sisas);
		}
		//var_dump($sisa1);exit();
		$sisa_n = $kuota - $sisa;
		if($sisa_n<=0){
			$sisa_n = 0;
		}
		$sisa_n1 = $kuota1 - $sisa1;
		if($sisa_n1<=0){
			$sisa_n1=0;
		}
		if($id_sisa==null){
			$data['total'] = "Hubungi Kepegawaian untuk mengetahui sisa cuti";
		}else{
			$data['total'] = $sisa_n + $sisa_n1;
		}
		
		$data['sisaId'] = $id_sisa;
		
		
		// $data['atasan'] = $this->cuti_model->ambilAtasan();


		// var_dump($data1);exit();
		foreach ($data['data_cuti'] as $a) {
			$cd = $a->created_date;
			$cdr = str_replace('-','',$cd);
			$id = $a->id_cuti;
			$data['bar'] = "$id$cdr";
		}
		foreach ($data['allKaryawan'] as $all ) {
			$data['atasan'] = $all->id;
		}
		foreach ($data['karyawan'] as $k ) {
			$data['nama'] = $k->id;
		}
		if ($data['nama']==$user_id) {
			$data['notifProses'] = count($data['data_cuti_proses']);
		}
		$data['notifApproveAtasan'] = count($data['approveAtasan']);
		$data['notifApprovePejabat'] = count($data['approvePejabat']);
		$data['notifApproveRekom'] = count($data['approveRekom']);
		$data['notifApproveRekom2'] = count($data['approveRekom2']);

		$data['notifProses'] = count($data['data_cuti_proses']);
		// $data1->modify('+1 day');
		// var_dump($data1);exit();

		// $data['notifApprove'] = count($data['data_cuti_approve']);

		// echo $this->session->userdata('nama');exit();
		// $whereAtasan = array('id' => $id );
		// var_dump($data1);exit();


		// echo '<pre>'; print_r($this->session->all_userdata());exit;
		//var_dump($bar);
		$this->load->view('cuti/data_cuti',$data);

	}
	
	public function alasanTolak($id_tolak){
			$nama_tolak = $this->cuti_model->getDataWhere('karyawan', array('id' => $id_tolak));
			if(!empty($nama_tolak)){
				foreach($nama_tolak as $t){
					$alasan = 'Ditolak Oleh'.' '.$t->nama;
				}
			}else{
				$alasan = "";
			}
		return $alasan;
	}

	public function ajukanCuti(){
		$user_id = $this->session->user_id;
		$where = array('id'=>$user_id);
		$like = "Kepala";
		$limit = date('m-d-Y', strtotime(' -5 day'));
		$data['limits'] = (string)$limit;
		$data['karyawan'] = $this->cuti_model->ambilKaryawanSession('karyawan',$where);
		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
		$data['data_cuti'] = $this->cuti_model->ambilData($user_id);
		// $data['data_cuti_approve'] = $this->cuti_model->ambilDataApproval($user_id);
		$data['jenis_cuti'] = $this->cuti_model->ambilJenisCuti();
		$data['satuan_cuti'] = $this->cuti_model->ambilSatuanCuti();
		$data['allKaryawan'] = $this->cuti_model->ambilAllKaryawan();
		$data['KaryawanLike'] = $this->cuti_model->ambilKaryawanLike($like);
		$data['karyawan'] = $this->cuti_model->ambilKaryawanSession('karyawan',$where);
		$data['pejabat'] = $this->cuti_model->ambilPejabat();
		$this->load->view('cuti/data_cuti_ajuan',$data);
	}

	public function printCuti(){
		$user_id = $this->uri->segment(3);
		$where = array('id_cuti'=>$user_id);
		$data['detail_print'] = $this->cuti_model->ambilPrintout($where);
		$data['detail'] = $this->cuti_model->ambilDataWhere($where);
		foreach ($data['detail_print'] as $a) {
			$cd = $a->created_date;
			$cdr = str_replace('-','',$cd);
			$id = $a->id_cuti;
			$data['bar'] = "$cdr$id";
		}
		$this->load->view('cuti/printCuti',$data);
	}


	public function detail(){
		$user_id = $this->uri->segment(3);
		$date = new DateTime("now");
  		$curr_date = $date->format('Y-m-d');
		$user_login = $this->session->user_id;
		$whereProfile = array('id' => $user_id);
		$where = array('id_cuti'=>$user_id);
		$statusAtasan = 2;
		$statusPejabat = 3;
		$statusRekom = 6;
		$statusRekom2 = 9;
		$statusTolak = 5;
		$fieldAtasan = "id_atasan";
		$fieldPejabat = "id_pejabat";
		$fieldRekom = "id_rekom";
		$fieldRekom2 = "id_rekom2";
		$fieldPegawai = "id_pegawai";
		$user_id = $this->session->userdata('user_id');
		// $where = array('user_id' => $user_id);
		$whereProfile = array('id' => $user_id);
		$whereAntrian = array('tgl' => $curr_date);
		$whereTolak = array('status' => 5);
		$whereSelesai = array('status' => 4);
		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
		$data['approveAtasan'] = $this->cuti_model->ambilDataApproval($fieldAtasan,$user_id,$statusAtasan);
		$data['approvePejabat'] = $this->cuti_model->ambilDataApproval($fieldPejabat,$user_id,$statusPejabat);
		$data['approveRekom'] = $this->cuti_model->ambilDataApproval($fieldRekom,$user_id,$statusRekom);
		$data['approveRekom2'] = $this->cuti_model->ambilDataApproval($fieldRekom2,$user_id,$statusRekom2);
		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
	    $data['detail'] = $this->cuti_model->ambilDataWhere($where);
	    $data['detail_print'] = $this->cuti_model->ambilPrintout($where);
	    $data['satuan_cuti'] = $this->cuti_model->ambilSatuanCuti();
		$data['jenis_cuti'] = $this->cuti_model->ambilJenisCuti();
		$data['allKaryawan'] = $this->cuti_model->ambilAllKaryawan();
		$data['profil'] = $this->cuti_model->ambilKaryawanSession('karyawan',$whereProfile);
		$data['gol'] = $this->cuti_model->getGol();
		//$data['sisa'] = $this->cuti_model->getDataWhere('data_cuti_total',$whereSisa);
		$data['notifApproveAtasan'] = count($data['approveAtasan']);
		$data['notifApprovePejabat'] = count($data['approvePejabat']);
		$data['notifApproveRekom'] = count($data['approveRekom']);
		$data['notifApproveRekom2'] = count($data['approveRekom2']);

		$data['notifProses'] = count($data['data_cuti_proses']);
		// var_dump($data1);exit();
		$data['notifProses'] = count($data['data_cuti_proses']);
	    // var_dump($data);
	    // exit();
		// $data['gaji'] = $this->pegawai_model->ambilgaji($where);
		$this->load->view('cuti/data_cuti_detail',$data);

	}

	public function edit(){
		$user_id = $this->uri->segment(3);
		error_reporting(0);
		$currentYear = date('Y');
		$currentYear1 = date('Y')-1;
		$whereProfile = array('id' => $user_id);
		$where = array('id_cuti'=>$user_id);
		$whereSisa = array('user_id'=>$id,'tahun'=>$currentYear);
		$whereSisa1 = array('user_id'=>$id,'tahun'=>$currentYear1);
		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
	    $data['detail'] = $this->cuti_model->ambilDataWhere($where);
	    $data['satuan_cuti'] = $this->cuti_model->ambilSatuanCuti();
		$data['jenis_cuti'] = $this->cuti_model->ambilJenisCuti();
		$data['allKaryawan'] = $this->cuti_model->ambilAllKaryawan();
		$data['profil'] = $this->cuti_model->ambilKaryawanSession('karyawan',$whereProfile);
		$data['gol'] = $this->cuti_model->getGol();
		$data['sisa'] = $this->cuti_model->getDataWhere('data_cuti_total',$whereSisa);
		$data['sisa1'] = $this->cuti_model->getDataWhere('data_cuti_total',$whereSisa1);
		$data['kuota'] = $this->cuti_model->getData('data_cuti_kuota');
		foreach($data['kuota'] as $k){
			$kuota = $k->n;
			$kuota1 = $k->n1;
		}
		foreach($data['sisa'] as $s){
			$sisa = $s->total;
		}
		foreach($data['sisa1'] as $s){
			$sisa1 = $s->total;
		}
		if($data['sisa']==null){
			$sisas = 0;
			$sisa = strval($sisas);
		}
		$data['sisa_n'] = $kuota - $sisa;
		if ($data['sisa_n']<0) {
			$data['sisa_n'] = 0;
		}else{
			$data['sisa_n'] = $data['sisa_n'];
		}
		$data['sisa_n1'] = $kuota1 - $sisa1;
		if ($data['sisa_n1']<0) {
			$data['sisa_n1'] = 0;
		}else{
			$data['sisa_n1'] = $data['sisa_n1'];
		}
		
		foreach($data['detail'] as $d){
			$data['tgl_buat'] = date($d->created_date, strtotime(' -5 day'));
		}
		$data['notifProses'] = count($data['data_cuti_proses']);
	    //var_dump($data['tgl_buat']);
	    //exit();
		// $data['gaji'] = $this->pegawai_model->ambilgaji($where);
		$this->load->view('cuti/data_cuti_edit',$data);

	}

	public function proses(){
		if (!empty($_SESSION['user_id'])) {
		 	// echo $this->session->nama;
		 	$user_id = $this->session->user_id;
		} else{
		 	redirect(site_url('login'));
		 	return;
		}
		$date = new DateTime("now");
  		$curr_date = $date->format('Y-m-d');
		$statusAtasan = 2;
 		$statusPejabat = 3;
 		$statusRekom = 6;
 		$statusRekom2 = 9;
 		$statusTolak = 5;
 		$fieldAtasan = "id_atasan";
 		$fieldPejabat = "id_pejabat";
 		$fieldRekom = "id_rekom";
 		$fieldRekom2 = "id_rekom2";
 		$fieldPegawai = "id_pegawai";
 		$user_id = $this->session->userdata('user_id');
 		$where = array('user_id' => $user_id);
 		$whereProfile = array('id' => $user_id);
 		$whereAntrian = array('tgl' => $curr_date);
 		$whereTolak = array('status' => 5);
 		$whereSelesai = array('status' => 4);
 		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
 		$data['approveAtasan'] = $this->cuti_model->ambilDataApproval($fieldAtasan,$user_id,$statusAtasan);
 		$data['approvePejabat'] = $this->cuti_model->ambilDataApproval($fieldPejabat,$user_id,$statusPejabat);
 		$data['approveRekom'] = $this->cuti_model->ambilDataApproval($fieldRekom,$user_id,$statusRekom);
 		$data['approveRekom2'] = $this->cuti_model->ambilDataApproval($fieldRekom2,$user_id,$statusRekom2);
		$whereProfile = array('id' => $user_id);
		$where = array('id'=>$user_id);
		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
		$data['jenis_cuti'] = $this->cuti_model->ambilJenisCuti();
		$data['allKaryawan'] = $this->cuti_model->ambilAllKaryawan();
		$data['karyawan'] = $this->cuti_model->ambilKaryawanSession('karyawan',$where);
		$data['profil'] = $this->cuti_model->ambilKaryawanSession('karyawan',$whereProfile);
		$data['gol'] = $this->cuti_model->getGol();
		// $data['atasan'] = $this->cuti_model->ambilAtasan();
		$data['notifApproveAtasan'] = count($data['approveAtasan']);
		$data['notifApprovePejabat'] = count($data['approvePejabat']);
		$data['notifApproveRekom'] = count($data['approveRekom']);
		$data['notifApproveRekom2'] = count($data['approveRekom2']);

		$data['notifProses'] = count($data['data_cuti_proses']);
		//var_dump($data['data_cuti_proses']);exit();
		foreach ($data['allKaryawan'] as $all ) {
			$data['atasan'] = $all->id;
		}
		foreach ($data['karyawan'] as $k ) {
			$data['nama'] = $k->id;
		}
		$this->load->view('cuti/data_cuti_proses',$data);
	}

	public function lengkapi(){
		error_reporting(0);
		$currentYear = date('Y');
		$currentYear1 = date('Y')-1;
		//print_r($currentYear);exit();
		$user_login = $this->session->user_id;
		$user_id = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$whereProfile = array('id' => $user_id);
		$where = array('id_cuti'=>$user_id);
		// $data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
		// foreach($data['data_cuti_proses'] as $p){
		// 	$id = $p->id_pegawai;
		// }
		$whereSisa = array('user_id'=>$id,'tahun'=>$currentYear);
		$whereSisa1 = array('user_id'=>$id,'tahun'=>$currentYear1);

	    $data['detail'] = $this->cuti_model->ambilDataWhere($where);
	    $data['satuan_cuti'] = $this->cuti_model->ambilSatuanCuti();
		$data['jenis_cuti'] = $this->cuti_model->ambilJenisCuti();
		$data['allKaryawan'] = $this->cuti_model->ambilAllKaryawan();
		$data['notifProses'] = count($data['data_cuti_proses']);
		$data['profil'] = $this->cuti_model->ambilKaryawanSession('karyawan',$whereProfile);
		$data['gol'] = $this->cuti_model->getGol();
		$data['sisa'] = $this->cuti_model->getDataWhere('data_cuti_total',$whereSisa);
		$data['sisa1'] = $this->cuti_model->getDataWhere('data_cuti_total',$whereSisa1);
		$data['kuota'] = $this->cuti_model->getData('data_cuti_kuota');
		foreach($data['kuota'] as $k){
			$kuota = $k->n;
			$kuota1 = $k->n1;
		}
		foreach($data['sisa'] as $s){
			$sisa = $s->total;
		}
		foreach($data['sisa1'] as $s){
			$sisa1 = $s->total;
		}
		if($data['sisa']==null){
			$sisas = 0;
			$sisa = strval($sisas);
		}
		$data['sisa_n'] = $kuota - $sisa;
		if ($data['sisa_n']<0) {
			$data['sisa_n'] = 0;
		}else{
			$data['sisa_n'] = $data['sisa_n'];
		}
		$data['sisa_n1'] = $kuota1 - $sisa1;
		if ($data['sisa_n1']<0) {
			$data['sisa_n1'] = 0;
		}else{
			$data['sisa_n1'] = $data['sisa_n1'];
		}

		//print_r($data['sisa_n']);exit();
	    // var_dump($sisa1);exit();
		// $data['gaji'] = $this->pegawai_model->ambilgaji($where);
		$this->load->view('cuti/data_cuti_detail',$data);

	}

	public function approval(){
		if (!empty($_SESSION['user_id'])) {
		 	// echo $this->session->nama;
		 	$user_id = $this->session->user_id;
		} else{
		 	redirect(site_url('login'));
		 	return;
		}
		$date = new DateTime("now");
  	$curr_date = $date->format('Y-m-d');
		$statusAtasan = 2;
 		$statusPejabat = 3;
 		$statusRekom = 6;
 		$statusRekom2 = 9;
 		$statusTolak = 5;
 		$fieldAtasan = "id_atasan";
 		$fieldPejabat = "id_pejabat";
 		$fieldRekom = "id_rekom";
 		$fieldRekom2 = "id_rekom2";
 		$fieldPegawai = "id_pegawai";
 		$user_id = $this->session->userdata('user_id');
 		$where = array('user_id' => $user_id);
 		$whereProfile = array('id' => $user_id);
 		$whereAntrian = array('tgl' => $curr_date);
 		$whereTolak = array('status' => 5);
 		$whereSelesai = array('status' => 4);
 		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
 		$data['approveAtasan'] = $this->cuti_model->ambilDataApproval($fieldAtasan,$user_id,$statusAtasan);
 		$data['approvePejabat'] = $this->cuti_model->ambilDataApproval($fieldPejabat,$user_id,$statusPejabat);
 		$data['approveRekom'] = $this->cuti_model->ambilDataApproval($fieldRekom,$user_id,$statusRekom);
 		$data['approveRekom2'] = $this->cuti_model->ambilDataApproval($fieldRekom2,$user_id,$statusRekom2);
		// var_dump($user_id);exit();
		$field = "id_atasan";
		$status = 2;
		$where = array('id'=>$user_id);
		$whereProfile = array('id' => $user_id);
		$whereAtasan = array('id_atasan' => $user_id,
							 'status' => 2 );
		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
		$data['data_cuti'] = $this->cuti_model->ambilDataApproval($field,$user_id,$status);
		$data['jenis_cuti'] = $this->cuti_model->ambilJenisCuti();
		$data['allKaryawan'] = $this->cuti_model->ambilAllKaryawan();
		$data['karyawan'] = $this->cuti_model->ambilKaryawanSession('karyawan',$where);
		$data['profil'] = $this->cuti_model->ambilKaryawanSession('karyawan',$whereProfile);
		$data['gol'] = $this->cuti_model->getGol();
		// $data['atasan'] = $this->cuti_model->ambilAtasan();
		$data['notifApproveAtasan'] = count($data['approveAtasan']);
		$data['notifApprovePejabat'] = count($data['approvePejabat']);
		$data['notifApproveRekom'] = count($data['approveRekom']);
		$data['notifApproveRekom2'] = count($data['approveRekom2']);

		$data['notifProses'] = count($data['data_cuti_proses']);
		// var_dump($data1);exit();
		// if ($data['karyawan']['id']==$user_id) {
			$data['notifProses'] = count($data['data_cuti_proses']);
		// }

		$data['notifApprove'] = count($data['data_cuti']);


		// var_dump($data1);exit();
		foreach ($data['allKaryawan'] as $all ) {
			$data['atasan'] = $all->id;
		}
		foreach ($data['karyawan'] as $k ) {
			$data['nama'] = $k->id;
		}
		$this->load->view('cuti/data_cuti',$data);
	}

	public function approvalPejabat(){
		if (!empty($_SESSION['user_id'])) {
		 	// echo $this->session->nama;
		 	$user_id = $this->session->user_id;
			$link = $this->uri->segment(2);
			$url = "data_cuti/$link";

		} else{
		 	redirect(site_url('login'));
		 	return;
		}

		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$statusAtasan = 2;
 		$statusPejabat = 3;
 		$statusRekom = 6;
 		$statusRekom2 = 9;
 		$statusTolak = 5;
 		$fieldAtasan = "id_atasan";
 		$fieldPejabat = "id_pejabat";
 		$fieldRekom = "id_rekom";
 		$fieldRekom2 = "id_rekom2";
 		$fieldPegawai = "id_pegawai";
 		$user_id = $this->session->userdata('user_id');
 		$where = array('user_id' => $user_id);
 		$whereProfile = array('id' => $user_id);
 		$whereAntrian = array('tgl' => $curr_date);
 		$whereTolak = array('status' => 5);
 		$whereSelesai = array('status' => 4);
 		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
 		$data['approveAtasan'] = $this->cuti_model->ambilDataApproval($fieldAtasan,$user_id,$statusAtasan);
 		$data['approvePejabat'] = $this->cuti_model->ambilDataApproval($fieldPejabat,$user_id,$statusPejabat);
 		$data['approveRekom'] = $this->cuti_model->ambilDataApproval($fieldRekom,$user_id,$statusRekom);
 		$data['approveRekom2'] = $this->cuti_model->ambilDataApproval($fieldRekom2,$user_id,$statusRekom2);
		// var_dump($user_id);exit();
		$field= "id_pejabat";
		$status = 3;
		$where = array('id'=>$user_id);
		$wherePejabat = array('id_pejabat' => $user_id, 'status' => 3 );
		$whereProfile = array('id' => $user_id);
		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
		$data['data_cuti'] = $this->cuti_model->ambilDataApproval($field,$user_id,$status);
		$data['jenis_cuti'] = $this->cuti_model->ambilJenisCuti();
		$data['allKaryawan'] = $this->cuti_model->ambilAllKaryawan();
		$data['karyawan'] = $this->cuti_model->ambilKaryawanSession('karyawan',$where);
		$data['profil'] = $this->cuti_model->ambilKaryawanSession('karyawan',$whereProfile);
		$data['gol'] = $this->cuti_model->getGol();
		// $data['atasan'] = $this->cuti_model->ambilAtasan();

		// var_dump($data1);exit();
		// if ($data['karyawan']['id']==$user_id) {
		$data['notifApproveAtasan'] = count($data['approveAtasan']);
		$data['notifApprovePejabat'] = count($data['approvePejabat']);
		$data['notifApproveRekom'] = count($data['approveRekom']);
		$data['notifApproveRekom2'] = count($data['approveRekom2']);

		$data['notifProses'] = count($data['data_cuti_proses']);
		// }

		$data['notifApprove'] = count($data['data_cuti']);
		foreach($data['data_cuti'] as $d){
			$data['jumlah'] = $d->jumlah_cuti;
			$data['id'] = $d->id_cuti;
		}

		//var_dump($data['jumlah']);exit();
		foreach ($data['allKaryawan'] as $all ) {
			$data['atasan'] = $all->id;
		}
		foreach ($data['karyawan'] as $k ) {
			$data['nama'] = $k->id;
		}
		$this->load->view('cuti/data_cuti',$data);
	}

	public function approvalRekom(){
		if (!empty($_SESSION['user_id'])) {
		 	// echo $this->session->nama;
		 	$user_id = $this->session->user_id;
			$status_kh = $this->session->status_kh;
		} else{
		 	redirect(site_url('login'));
		 	return;
		}
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$statusAtasan = 2;
 		$statusPejabat = 3;
 		$statusRekom = 6;
 		$statusRekom2 = 9;
 		$statusTolak = 5;
 		$fieldAtasan = "id_atasan";
 		$fieldPejabat = "id_pejabat";
 		$fieldRekom = "id_rekom";
 		$fieldRekom2 = "id_rekom2";
 		$fieldPegawai = "id_pegawai";
 		$user_id = $this->session->userdata('user_id');
 		$data['status_kh'] = $status_kh;
 		$where = array('user_id' => $user_id);
 		$whereProfile = array('id' => $user_id);
 		$whereAntrian = array('tgl' => $curr_date);
 		$whereTolak = array('status' => 5);
 		$whereSelesai = array('status' => 4);
 		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
 		$data['approveAtasan'] = $this->cuti_model->ambilDataApproval($fieldAtasan,$user_id,$statusAtasan);
 		$data['approvePejabat'] = $this->cuti_model->ambilDataApproval($fieldPejabat,$user_id,$statusPejabat);
 		$data['approveRekom'] = $this->cuti_model->ambilDataApproval($fieldRekom,$user_id,$statusRekom);
 		$data['approveRekom2'] = $this->cuti_model->ambilDataApproval($fieldRekom2,$user_id,$statusRekom2);
		// var_dump($user_id);exit();
		$field = "id_rekom";
		$status = 6;
		$where = array('id'=>$user_id);
		$whereProfile = array('id' => $user_id);
		// $wherePejabat = array('id_rekom' => $user_id, 'status' => 6 );
		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
		$data['data_cuti'] = $this->cuti_model->ambilDataApproval($field,$user_id,$status);
		$data['jenis_cuti'] = $this->cuti_model->ambilJenisCuti();
		$data['allKaryawan'] = $this->cuti_model->ambilAllKaryawan();
		$data['karyawan'] = $this->cuti_model->ambilKaryawanSession('karyawan',$where);
		$data['profil'] = $this->cuti_model->ambilKaryawanSession('karyawan',$whereProfile);
		$data['gol'] = $this->cuti_model->getGol();
		// $data['atasan'] = $this->cuti_model->ambilAtasan();

		// var_dump($data1);exit();
		// if ($data['karyawan']['id']==$user_id) {
		$data['notifApproveAtasan'] = count($data['approveAtasan']);
		$data['notifApprovePejabat'] = count($data['approvePejabat']);
		$data['notifApproveRekom'] = count($data['approveRekom']);
		$data['notifApproveRekom2'] = count($data['approveRekom2']);
		$data['notifProses'] = count($data['data_cuti_proses']);
		// }

		$data['notifApprove'] = count($data['data_cuti']);


		// var_dump($data1);exit();
		foreach ($data['allKaryawan'] as $all ) {
			$data['atasan'] = $all->id;
		}
		foreach ($data['karyawan'] as $k ) {
			$data['nama'] = $k->id;
		}
		$this->load->view('cuti/data_cuti',$data);
	}

	public function approvalRekom2(){
		if (!empty($_SESSION['user_id'])) {
		 	// echo $this->session->nama;
		 	$user_id = $this->session->user_id;
		 	$status_kh = $this->session->status_kh;
			
		} else{
		 	redirect(site_url('login'));
		 	return;
		}
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$statusAtasan = 2;
 		$statusPejabat = 3;
 		$statusRekom = 6;
 		$statusRekom2 = 9;
 		$statusTolak = 5;
 		$fieldAtasan = "id_atasan";
 		$fieldPejabat = "id_pejabat";
 		$fieldRekom = "id_rekom";
 		$fieldRekom2 = "id_rekom2";
 		$fieldPegawai = "id_pegawai";
 		$user_id = $this->session->userdata('user_id');
		// $data['status_kh'] = $status_kh;
 		$where = array('user_id' => $user_id);
 		$whereProfile = array('id' => $user_id);
 		$whereAntrian = array('tgl' => $curr_date);
 		$whereTolak = array('status' => 5);
 		$whereSelesai = array('status' => 4);
 		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
 		$data['approveAtasan'] = $this->cuti_model->ambilDataApproval($fieldAtasan,$user_id,$statusAtasan);
 		$data['approvePejabat'] = $this->cuti_model->ambilDataApproval($fieldPejabat,$user_id,$statusPejabat);
 		$data['approveRekom'] = $this->cuti_model->ambilDataApproval($fieldRekom,$user_id,$statusRekom);
 		$data['approveRekom2'] = $this->cuti_model->ambilDataApproval($fieldRekom2,$user_id,$statusRekom2);
		// var_dump($user_id);exit();
		$field = "id_rekom2";
		$status = 9;
		$where = array('id'=>$user_id);
		$whereProfile = array('id' => $user_id);
		// $wherePejabat = array('id_rekom' => $user_id, 'status' => 6 );
		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
		$data['data_cuti'] = $this->cuti_model->ambilDataApproval($field,$user_id,$status);
		$data['jenis_cuti'] = $this->cuti_model->ambilJenisCuti();
		$data['allKaryawan'] = $this->cuti_model->ambilAllKaryawan();
		$data['karyawan'] = $this->cuti_model->ambilKaryawanSession('karyawan',$where);
		$data['profil'] = $this->cuti_model->ambilKaryawanSession('karyawan',$whereProfile);
		$data['gol'] = $this->cuti_model->getGol();
		// $data['atasan'] = $this->cuti_model->ambilAtasan();

		// var_dump($data1);exit();
		// if ($data['karyawan']['id']==$user_id) {
		$data['notifApproveAtasan'] = count($data['approveAtasan']);
		$data['notifApprovePejabat'] = count($data['approvePejabat']);
		$data['notifApproveRekom'] = count($data['approveRekom']);
		$data['notifApproveRekom2'] = count($data['approveRekom2']);

		$data['notifProses'] = count($data['data_cuti_proses']);
		// }

		$data['notifApprove'] = count($data['data_cuti']);


		// var_dump($data1);exit();
		foreach ($data['allKaryawan'] as $all ) {
			$data['atasan'] = $all->id;
		}
		foreach ($data['karyawan'] as $k ) {
			$data['nama'] = $k->id;
		}
		$this->load->view('cuti/data_cuti',$data);
	}
	
	public function approvalRekom3(){
		if (!empty($_SESSION['user_id'])) {
		 	// echo $this->session->nama;
		 	$user_id = $this->session->user_id;
		 	$status_kh = $this->session->status_kh;
			
		} else{
		 	redirect(site_url('login'));
		 	return;
		}
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$statusAtasan = 2;
 		$statusPejabat = 3;
 		$statusRekom = 6;
 		$statusRekom2 = 9;
 		$statusTolak = 5;
 		$fieldAtasan = "id_atasan";
 		$fieldPejabat = "id_pejabat";
 		$fieldRekom = "id_rekom";
 		$fieldRekom2 = "id_rekom2";
 		$fieldPegawai = "id_pegawai";
 		$user_id = $this->session->userdata('user_id');
		$data['status_kh'] = $status_kh;
		
 		$where = array('user_id' => $user_id);
 		$whereProfile = array('id' => $user_id);
 		$whereAntrian = array('tgl' => $curr_date);
 		$whereTolak = array('status' => 5);
 		$whereSelesai = array('status' => 4);
 		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
 		$data['approveAtasan'] = $this->cuti_model->ambilDataApproval($fieldAtasan,$user_id,$statusAtasan);
 		$data['approvePejabat'] = $this->cuti_model->ambilDataApproval($fieldPejabat,$user_id,$statusPejabat);
 		$data['approveRekom'] = $this->cuti_model->ambilDataApproval($fieldRekom,$user_id,$statusRekom);
 		$data['approveRekom2'] = $this->cuti_model->ambilDataApproval($fieldRekom2,$user_id,$statusRekom2);
		// var_dump($user_id);exit();
		$field = "id_rekom3";
		$status = 10;
		$where = array('id'=>$user_id);
		$whereProfile = array('id' => $user_id);
		// $wherePejabat = array('id_rekom' => $user_id, 'status' => 6 );
		$data['data_cuti_proses'] = $this->cuti_model->ambilDataProses($user_id);
		$data['data_cuti'] = $this->cuti_model->ambilDataApproval($field,$user_id,$status);
		$data['jenis_cuti'] = $this->cuti_model->ambilJenisCuti();
		$data['allKaryawan'] = $this->cuti_model->ambilAllKaryawan();
		$data['karyawan'] = $this->cuti_model->ambilKaryawanSession('karyawan',$where);
		$data['profil'] = $this->cuti_model->ambilKaryawanSession('karyawan',$whereProfile);
		$data['gol'] = $this->cuti_model->getGol();
		// $data['atasan'] = $this->cuti_model->ambilAtasan();

		// var_dump($data1);exit();
		// if ($data['karyawan']['id']==$user_id) {
		$data['notifApproveAtasan'] = count($data['approveAtasan']);
		$data['notifApprovePejabat'] = count($data['approvePejabat']);
		$data['notifApproveRekom'] = count($data['approveRekom']);
		$data['notifApproveRekom2'] = count($data['approveRekom2']);

		$data['notifProses'] = count($data['data_cuti_proses']);
		// }

		$data['notifApprove'] = count($data['data_cuti']);


		// var_dump($data1);exit();
		foreach ($data['allKaryawan'] as $all ) {
			$data['atasan'] = $all->id;
		}
		foreach ($data['karyawan'] as $k ) {
			$data['nama'] = $k->id;
		}
		$this->load->view('cuti/data_cuti',$data);
	}

	public function rekap(){
		if (!empty($_SESSION['user_id'])) {
		 	// echo $this->session->nama;
		 	$user_id = $this->session->user_id;
		} else{
		 	redirect(site_url('login'));
		 	return;
		}
		$whereProfile = array('id' => $user_id);
		$data['data_cuti'] = $this->cuti_model->getDataQuery('select * from data_cuti join data_cuti_jenis on data_cuti_jenis.id_jeniscuti=data_cuti.id_jeniscuti');
		$data['profil'] = $this->cuti_model->ambilKaryawanSession('karyawan',$whereProfile);
		$data['gol'] = $this->cuti_model->getGol();
		$data['allKaryawan'] = $this->cuti_model->getData('karyawan');
		$this->load->view('cuti/data_cuti_rekap',$data);
	}

	public function totalCuti(){
		if (!empty($_SESSION['user_id'])) {
		 	// echo $this->session->nama;
		 	$data['user_id'] = $this->session->user_id;
		} else{
		 	redirect(site_url('login'));
		 	return;
		}
		$data['year'] = date('Y');
		$data['year1'] = date('Y')-1;
		$data['data_cuti'] = $this->cuti_model->getDataQuery('select * from data_cuti_tes join karyawan on data_cuti_tes.user_id=karyawan.id');
		$data['allKaryawan'] = $this->cuti_model->ambilAllKaryawan();
		//var_dump($data['year']);exit();
		$this->load->view('cuti/data_cuti_sisa',$data);
	}
	
	public function detailSisa(){
		$id = $this->uri->segment(3);
		$data['detail'] = $this->cuti_model->getDataQuery("select * from data_cuti join karyawan on data_cuti.id_pegawai=karyawan.id where id='".$id."'");
		//var_dump($d);exit();
		$this->load->view('cuti/data_cuti_sisa_detail',$data);
	}

	public function tambahCuti(){
		// var_dump($_POST);exit;
		$user_id = $this->session->user_id;
		$currentYear = date('Y');
		$currentYear1 = date('Y')-1;

		$whereSisa = array('user_id'=>$user_id,'tahun'=>$currentYear);
		$whereSisa1 = array('user_id'=>$user_id,'tahun'=>$currentYear1);
		//$data['sisa'] = $this->cuti_model->getDataWhere('data_cuti_total',$whereSisa);
		$data['sisa'] = $this->cuti_model->getDataWhere('data_cuti_tes',array('user_id' => $user_id));
		$data['kuota'] = $this->cuti_model->getData('data_cuti_kuota');
		foreach($data['kuota'] as $k){
			$kuota = $k->n;
			$kuota1 = $k->n1;
		}
		if ($data['sisa']!=null){
			foreach($data['sisa'] as $s){
				$id_sisa = $s->user_id;
				$sisa1 = $s->n1;
				$sisa = $s->n;
			}	
		}else{
			$id_sisa = null;
		}
		if($sisa==null){
			$sisas = 0;
			$sisa = strval($sisas);
		}
		if($sisa1==null){
			$sisas = 0;
			$sisa1 = strval($sisas);
		}
		//var_dump($sisa1);exit();
		$sisa_n = $kuota - $sisa;
		if($sisa_n<=0){
			$sisa_n = 0;
		}
		$sisa_n1 = $kuota1 - $sisa1;
		if($sisa_n1<=0){
			$sisa_n1=0;
		}
		$total = $sisa_n + $sisa_n1;
		// var_dump($total);
		// exit();
		$id_pegawai = $this->input->post('id_pegawai');
		$unit = $this->input->post('unit');
		$masa = $this->input->post('masa');
		$alasan = $this->input->post('alasan');
		$jumlah = $this->input->post('jumlah');
		$jenis = $this->input->post('jenis_cuti');
		$satuan = $this->input->post('satuan');
		$rentang = $this->input->post('rentang');
		$alamat_cuti = $this->input->post('alamat_cuti');
		$jabatan = $this->input->post('jabatan');
		$golongan = $this->input->post('golongan');
		$atasan = $this->input->post('atasan');
		$pejabat = $this->input->post('pejabat');
		$rekom = $this->input->post('rekom');
		$rekom2 = $this->input->post('rekom2');
		$rekom3 = $this->input->post('rekom3');
		if ($rekom!=null) {
			$status = 6;
		}else {
			$status = 1;
		}
		if ($rekom2!=null) {
			$status = 9;
		}else {
			$status = 1;
		}
		if ($rekom==null) {
			$rekom=0;
		}
		if ($rekom2==null) {
			$rekom2=0;
		}
		if ($rekom3==null) {
			$rekom3=0;
		}
		$dateNow = date("Y-m-d H:i:s");

		// if ($satuan=="Bulan") {
		// 	$newSatuan = $jumlah * 30;
		// } elseif ($satuan=="Tahun") {
		// 	$newSatuan = $jumlah * 365;
		// } else{
		// 	$newSatuan = $jumlah;
		// }
		// $jumlahHari = strval($newSatuan);

		$tglmulai = substr($rentang, 0,-13);
		$tglmulai = str_replace('/', '-', $tglmulai);
		$tglakhir = substr($rentang, -10);
		$tglakhir = str_replace('/', '-', $tglakhir);
		$year = substr($tglmulai,6,9);
		$month = substr($tglmulai,0,2);
		$day = substr($tglmulai,3,2);
		$year1 = substr($tglakhir,6,9);
		$month1 = substr($tglakhir,0,2);
		$day1 = substr($tglakhir,3,2);
		$tglmulaifinal = "$year-$month-$day";
		$tglakhirfinal = "$year1-$month1-$day1";
		// var_dump($tglakhirfinal);exit();
//
		$data = array(
			'id_pegawai' => $id_pegawai,
			'unit_kerja' => $unit,
			'masa_kerja' => $masa,
			'alasan_cuti' => $alasan,
			'jumlah_cuti' => $jumlah,
			'jabatan_cuti' => $jabatan,
			'golongan_cuti' => $golongan,
			'id_jeniscuti' => $jenis,
			'tanggal_mulai' => $tglmulaifinal,
			'tanggal_berakhir' => $tglakhirfinal,
			'alamat_cuti' => $alamat_cuti,
			'status' => $status,
			'created_date' => $dateNow,
			'id_atasan' => $atasan,
			'id_cutisatuan' => $satuan,
			'id_pejabat' => $pejabat,
			'id_rekom' => $rekom,
			'id_rekom2' => $rekom2,
			'id_rekom3' => $rekom3
			);
		$where = array('id_pegawai'=>$id_pegawai);
		$jumlahKaryawan = count($this->cuti_model->getData('karyawan'));
		$jmlPersen = round($jumlahKaryawan * 5 / 100);
		$whereToday = array('tanggal_mulai' => date("m-d-Y"));
		$cekKaryawan = count($this->cuti_model->getDataWhere('data_cuti',$whereToday));
		$cek = $this->cuti_model->getDataWhere('data_cuti',$where);
		//var_dump($jmlPersen,$cekKaryawan);exit();
		foreach($cek as $c){
			$stat = $c->status;
			$active = $c->is_active;
		}
		//var_dump($cek);exit();
		if ($jenis==1) {
			if ($jumlah>$total) {
			echo "Jumlah Pengajuan Cuti lebih dari sisa kuota";
			echo '<meta http-equiv="refresh" content="2;URL='.site_url('data_cuti').'" />';
			return;
			}	
		}
		
		if ($cekKaryawan >= $jumlahKaryawan) {
			echo "Jumlah Pengajuan Cuti pada hari itu sudah melebihi batas";
			echo '<meta http-equiv="refresh" content="2;URL='.site_url('data_cuti').'" />';
		}else {
			if($cek!=null){
				if($stat!=4 && $active==1){
					//header('Location:site_url('data_cuti')');
					//echo '<script language="javascript">';
					//echo 'alert("Tunggu sampai proses cuti yang sebelumnya selesai")';
					//echo '</script>';
					echo "Tunggu sampai proses cuti yang sebelumnya selesai";
					echo '<meta http-equiv="refresh" content="2;URL='.site_url('data_cuti').'" />';

					//redirect(site_url('data_cuti'));
				}else{
					$simpan = $this->cuti_model->tambah_data($data);
					if($simpan){
						redirect('data_cuti');
					}
					else{
						print_r('Gagal Simpan');
					}
				     }
			}else{
				$simpan = $this->cuti_model->tambah_data($data);
					if($simpan){
						redirect('data_cuti');
					}
					else{
						print_r('Gagal Simpan');
					}
			}
		}

		//redirect(site_url('data_cuti'));

	}

	public function lengkapiCuti(){
		$catatan = $this->input->post('catatan_cuti');
		$sisa_n1 = $this->input->post('sisa_n1');
		$ket_n1 = $this->input->post('ket_n1');
		$sisa_n = $this->input->post('sisa_n');
		$ket_n = $this->input->post('ket_n');
		$id = $this->input->post('id');

		$data = array(
						'catatan_cuti' => $catatan,
						'sisa_cuti_n1' => $sisa_n1,
						'ket_cuti_n1' => $ket_n1,
						'ket_cuti' => $ket_n,
						'sisa_cuti' => $sisa_n,
						'status' => 2

						);
		$where = array('id_cuti' => $id);
		$lengkapi = $this->cuti_model->updateData($data,$where);
		if ($lengkapi) {
			redirect('data_cuti/proses');
		}else{
			echo "Gagal Update";
		}

	}

	public function update(){
		$id = $this->input->post('id');
		$masa = $this->input->post('masa');
		$alasan = $this->input->post('alasan');
		$jumlah = $this->input->post('jumlah');
		$jenis = $this->input->post('jenis_cuti');
		$satuan = $this->input->post('satuan');
		$tglmulai = $this->input->post('tglmulai');
		$tglakhir = $this->input->post('tglakhir');
		$alamat_cuti = $this->input->post('alamat_cuti');
		$rekom = $this->input->post('rekom');
		$rekom2 = $this->input->post('rekom2');
		$rekom3 = $this->input->post('rekom3');
		$atasan = $this->input->post('atasan');
		$pejabat = $this->input->post('pejabat');
		$catatan = $this->input->post('catatan_cuti');
		$sisa_n1 = $this->input->post('sisa_n1');
		$ket_n1 = $this->input->post('ket_n1');
		$sisa_n = $this->input->post('sisa_n');
		$ket_n = $this->input->post('ket_n');
		$id = $this->input->post('id');
		
		$data = array(
						'masa_kerja' => $masa,
						'id_jeniscuti' => $jenis,
						'alasan_cuti' => $alasan,
						'jumlah_cuti' => $jumlah,
						'id_cutisatuan' => $satuan,
						'tanggal_mulai' => $tglmulai,
						'tanggal_berakhir' => $tglakhir,
						'tanggal_berakhir' => $tglakhir,
						'alamat_cuti' => $alamat_cuti,
						'id_rekom' => $rekom,
						'id_rekom2' => $rekom2,
						'id_rekom3' => $rekom3,
						'id_atasan' => $atasan,
						'catatan_cuti' => $catatan,
						'sisa_cuti_n1' => $sisa_n1,
						'ket_cuti_n1' => $ket_n1,
						'ket_cuti' => $ket_n,
						'sisa_cuti' => $sisa_n,
						'id_pejabat' => $pejabat
					);
		$where = array('id_cuti' => $id);
		$this->cuti_model->updateData($data,$where);
		redirect('data_cuti/edit/'.$id);
	}

	public function updateProfil(){
		$id = $this->input->post('id');
		$nama = $this->input->post('nama');
		$pangkat = $this->input->post('pangkat');
		$jabatan = $this->input->post('jabatan');
		$hp = $this->input->post('hp');
		$email = $this->input->post('email');
		$wa = $this->input->post('wa');
		$username = $this->input->post('username');
		$bid = $this->input->post('bid');
		$bag = $this->input->post('bag');
		$password = $this->input->post('password');
		$ul_password = $this->input->post('ul_password');

		$where = array('id' => $id);
		$data = array(
						'password' => md5($password)
		);
		if($password==$ul_password && $password!=''){
			//echo "<script type='text/javascript'>swal("Good job!", "You clicked the button!", "success")</script>"
			$this->cuti_model->updateProfil($data,$where);

		}
		$data = array(
						'nama' => $nama,
						'golongan' => $pangkat,
						'jabatan' => $jabatan,
						'hp' => $hp,
						'email' => $email,
						'wa' => $wa,
						'status_kh' => $bid,
						'kode_jab' => $bag,
						'username' => $username

					);

		$update = $this->cuti_model->updateProfil($data,$where);
		if($update){
			//echo "<script type='text/javascript'>swal("Good job!", "You clicked the button!", "success");</script>";
			redirect(site_url('user'));

		}else{
			echo "Gagal Update Profil";
		}
	}

	public function updateTolak(){
		$jab = $this->session->userdata('kode_jab');
		$stat_kh = $this->session->userdata('status_kh');
		$id = $this->input->post('id');
		$masa = $this->input->post('masa');
		$alasan = $this->input->post('alasan');
		$jumlah = $this->input->post('jumlah');
		$jenis = $this->input->post('jenis_cuti');
		$satuan = $this->input->post('satuan');
		$tglmulai = $this->input->post('tglmulai');
		$tglakhir = $this->input->post('tglakhir');
		$alamat_cuti = $this->input->post('alamat_cuti');
		$atasan = $this->input->post('atasan');
		$pejabat = $this->input->post('pejabat');
		$status = $this->input->post('status');
		$rekom2 = $this->input->post('rekom2');
		$rekom3 = $this->input->post('rekom3');
		$rekom = $this->input->post('rekom');
		if ($status==5 && $jab=="st" ) {
			$newStatus = 1;
		}else{
			$newStatus = 9;
		}
		// var_dump($newStatus);exit();
		$data = array(
						'masa_kerja' => $masa,
						'id_jeniscuti' => $jenis,
						'alasan_cuti' => $alasan,
						'jumlah_cuti' => $jumlah,
						'id_cutisatuan' => $satuan,
						'tanggal_mulai' => $tglmulai,
						'tanggal_berakhir' => $tglakhir,
						'tanggal_berakhir' => $tglakhir,
						'alamat_cuti' => $alamat_cuti,
						'id_atasan' => $atasan,
						'id_pejabat' => $pejabat,
						'alasan_tolak' => '',
						'id_rekom' => $rekom,
						'id_rekom2' => $rekom2,
						'id_rekom3' => $rekom3,
						'id_tolak' => '',
						'status' => $newStatus
					);
		$where = array('id_cuti' => $id);
		$this->cuti_model->updateData($data,$where);
		redirect('data_cuti');
	}

	public function hapus() {
	$user_id = $this->uri->segment(3);
		$a = $this->cuti_model->hapus_data($user_id);
		if($a){
			redirect('data_cuti');
		}else{
			print_r('Gagal Hapus');
		}
	}

	public function approve(){
		$user_id = $this->uri->segment('3');

		$data = array('status' => 3 );
		$a = $this->cuti_model->approveCuti($user_id,$data);
		if ($a) {
			redirect('data_cuti/approval');
		}else{
			print_r('Gagal Approve');
		}
	}

	public function approvePejabat(){
		$user_id = $this->session->user_id;
		$id_pegawai = $this->input->post('id_pegawai');
		$id_jenis = $this->input->post('id_jenis');
		$jumlah = $this->input->post('jumlah');
		$id = $this->input->post('id');
		$currentYear = date('Y');
		$currentYear1 = date('Y')-1;
		$whereSisa = array('user_id'=>$id_pegawai,'tahun'=>$currentYear);
		$whereSisa1 = array('user_id'=>$id_pegawai,'tahun'=>$currentYear1);
		$data['sisa'] = $this->cuti_model->getDataWhere('data_cuti_total',$whereSisa);
		$data['sisa1'] = $this->cuti_model->getDataWhere('data_cuti_total',$whereSisa1);
		$data['kuota'] = $this->cuti_model->getData('data_cuti_kuota');
		//get data sisa
		foreach($data['kuota'] as $k){
			$kuota = $k->n;
			$kuota1 = $k->n1;
		}
		foreach($data['sisa'] as $s){
			$totalPake = $s->total;
		}
		foreach($data['sisa1'] as $s){
			$totalPake1 = $s->total;
		}
		if($data['sisa']==null){
			$sisas = 0;
			$totalPake = strval($sisas);
		}
		if($data['sisa1']==null){
			$sisas = 0;
			$totalPake1 = strval($sisas);
		}
		//var_dump($sisa1);exit();
		$sisa_n = $kuota - $totalPake;
		if($sisa_n<=0){
			$sisa_n = 0;
		}
		$sisa_n1 = $kuota1 - $totalPake1;
		if($sisa_n1<=0){
			$sisa_n1=0;
		}
		//proses pengurangan sisa
		$total = $sisa_n1-$jumlah;
		if($total>=0){
			$final = strval($total);
			$year = $currentYear1;
			$finals = $kuota1 - $final;
		}else{
			$totals = abs($total);
			$final = strval($sisa_n-$totals);
			$year = $currentYear;
			$finals = $kuota-$final;
			$data1 = array('total'=>$kuota1);
			$where1 = array('id'=>$currentYear1.'_'.$id_pegawai);
			$this->cuti_model->updateDataWhere('data_cuti_total',$data1,$where1);
		}
		$data = array('total' => $finals);
		$where = array('id' => $year.'_'.$id_pegawai);
		//var_dump($data);exit();
		$dataCuti = array('status' => 4);
		$a = $this->cuti_model->approveCuti($id,$dataCuti);
		if ($a) {
			$cek = $this->cuti_model->getDataWhere('data_cuti_total',$where);
			//var_dump($data);exit();
			if ($id_jenis==1) {
				if(!empty($cek)){
					$simpan = $this->cuti_model->updateDataWhere('data_cuti_total',$data,$where);
					if($simpan){

						redirect('data_cuti/approvalPejabat');
					}
				}else{
					$dataInput = array('id'=>$year.'_'.$id_pegawai, 'tahun'=>$year, 'user_id'=>$id_pegawai, 'total'=>$finals);
					$this->cuti_model->simpanData('data_cuti_total',$dataInput);
				}
			}
			redirect('data_cuti/approvalPejabat');

		}else{
			print_r('Gagal Approve');
		}
	}

	public function approvePejabatBaru(){
		$user_id = $this->session->user_id;
		$id_pegawai = $this->input->post('id_pegawai');
		$id_jenis = $this->input->post('id_jenis');
		$jumlah = $this->input->post('jumlah');
		$id = $this->input->post('id');
		$currentYear = date('Y');
		$currentYear1 = date('Y')-1;
		$whereSisa = array('user_id'=>$id_pegawai);
		$data['sisa'] = $this->cuti_model->getDataWhere('data_cuti_tes',$whereSisa);
		$data['kuota'] = $this->cuti_model->getData('data_cuti_kuota');
		//get data sisa
		foreach($data['kuota'] as $k){
			$kuota = $k->n;
			$kuota1 = $k->n1;
		}
		foreach($data['sisa'] as $s){
			$totalPake = $s->n;
			$totalPake1 = $s->n1;
		}
		if($totalPake==null){
			$sisas = 0;
			$totalPake = strval($sisas);
		}
		if($totalPake1==null){
			$sisas = 0;
			$totalPake1 = strval($sisas);
		}
		//var_dump($sisa1);exit();
		$sisa_n = $kuota - $totalPake;
		if($sisa_n<=0){
			$sisa_n = 0;
		}
		$sisa_n1 = $kuota1 - $totalPake1;
		if($sisa_n1<=0){
			$sisa_n1=0;
		}
		//proses pengurangan sisa
		$total = $sisa_n1-$jumlah;
		if($total>=0){
			$final = strval($total);
			$year = $currentYear1;
			$finals = $kuota1 - $final;
			$field = "n1";
			
		}else{
			$totals = abs($total);
			$final = strval($sisa_n-$totals);
			$year = $currentYear;
			$field = "n";
			$finals = $kuota-$final;
			$data1 = array('n1'=>$kuota1);
			$where1 = array('user_id'=> $id_pegawai);
			$this->cuti_model->updateDataWhere('data_cuti_tes',$data1,$where1);
		}
		$data = array($field => $finals);
		$where = array('user_id' => $id_pegawai);
		//var_dump($data);exit();
		$dataCuti = array('status' => 4);
		$a = $this->cuti_model->approveCuti($id,$dataCuti);
		if ($a) {
			$cek = $this->cuti_model->getDataWhere('data_cuti_tes',$where);
			//var_dump($data);exit();
			if ($id_jenis==1) {
				if(!empty($cek)){
					$simpan = $this->cuti_model->updateDataWhere('data_cuti_tes',$data,$where);
					if($simpan){

						redirect('data_cuti/approvalPejabat');
					}
				}else{
					$dataInput = array('n'=>0, 'n1' => 0, 'user_id'=>$id_pegawai);
					$this->cuti_model->simpanData('data_cuti_tes',$dataInput);
				}
			}
			redirect('data_cuti/approvalPejabat');

		}else{
			print_r('Gagal Approve');
		}
	}

	public function tolakCuti(){
		$user_id = $this->session->user_id;
		$id = $this->input->post('id');
		$alasan = $this->input->post('alasan');

		$data = array('alasan_tolak' => $alasan,
					  'status' => 5,
					  'id_tolak' => $user_id);
		$where = array('id_cuti' => $id);
		$a = $this->cuti_model->updateData($data,$where);
		if ($a) {
			redirect(site_url('data_cuti'));
		}else{
			echo "Gagal Update";
		}
	}

	public function terimaRekom(){
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$kh = $this->input->post('kh');
		$link = $this->uri->segment(2);
		// $url = "data_cuti/$link";

		if($status==9){
			$stat = 6;
			$url = "data_cuti/approvalRekom2";
			
		}elseif($status==6){
			if($kh!=0){
				$stat = 10;
				$url = "data_cuti/approvalRekom";
			}else{
				$stat = 1;
				$url = "data_cuti/approvalRekom";
			}
		}else{
			$stat = 1;
			$url = "data_cuti/approvalRekom3";
		}
		//var_dump($url);exit();
		$where = array('id_cuti' => $id);
		$data = array('status_rekomendasi' => "Disetujui",
					  'status' => $stat);
		$a = $this->cuti_model->updateData($data,$where);
		if ($a) {
			redirect(site_url($url));
		}else{
			echo "Gagal";
		}
	}

	public function tolakRekom(){
		$user_id = $this->session->user_id;
		$id = $this->uri->segment('3');
		$where = array('id_cuti' => $id);
		$data = array('alasan_tolak' => "Rekomendasi Ditolak",
					  'status' => 5,
					  'id_tolak' => $user_id);
		$a = $this->cuti_model->updateData($data,$where);
		if ($a) {
			redirect(site_url('data_cuti'));
		}else{
			echo "Gagal";
		}
	}

	public function editTotal(){
		$id = $this->input->post('nama');
		$tahun = $this->input->post('tahun');
		$jumlah = $this->input->post('jumlah');
		//var_dump(date('Y'));exit();
		$ids = $tahun.'_'.$id;
		$where = array('user_id'=>$id);
		$cek = $this->cuti_model->getDataWhere('data_cuti_tes',$where);
		if(!empty($cek)){
			$data = array($tahun=>$jumlah);
			$update = $this->cuti_model->updateDataWhere('data_cuti_tes',$data,$where);
			if($update){
				redirect(site_url('data_cuti/totalCuti'));
			}
		}else{
			$data1 = array('user_id'=>$id,$tahun=>$jumlah);
			$this->cuti_model->simpanData('data_cuti_tes',$data1);
			redirect(site_url('data_cuti/totalCuti'));
		}
		// var_dump($cek);exit();
	}

	public function bulan($noBln){
		$bulan = array(
			'01' => 'Januari',
			'02' => 'Februari',
			'03' => 'Maret',
			'04' => 'April',
			'05' => 'Mei',
			'06' => 'Juni',
			'07' => 'Juli',
			'08' => 'Agustus',
			'09' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember',
		);
		return $bulan[$noBln];
	}

	public function pilihRekap(){
		$tanggal = $this->input->post('tanggal');
		$tglmulai = substr($tanggal, 0,-13);
		$tglmulai = str_replace('/', '-', $tglmulai);
		$tglmulaiTahun = substr($tglmulai, -4);
		$tglmulaiBulan = substr($tglmulai, 0,5);
		$tglmulaifinal = "$tglmulaiTahun-$tglmulaiBulan";
		$tglakhir = substr($tanggal, -10);
		$tglakhir = str_replace('/', '-', $tglakhir);
		$tglakhirTahun = substr($tglakhir, -4);
		$tglakhirBulan = substr($tglakhir, 0,5);
		$tglakhirfinal = "$tglakhirTahun-$tglakhirBulan";
		$bulan = substr($tanggal,0,2);
		$tahun = substr($tanggal,3,4);
		$grup = "nama_karyawan";
		// var_dump($tglakhirfinal);exit();
		$where = array('tanggal_mulai >=' => $tglmulaifinal, 'tanggal_mulai <=' => $tglakhirfinal) ;
		$data['data_cuti'] = $this->cuti_model->rekap('printcuti',$where,$grup);
		$data['tglmulai'] = $tglmulaifinal;
		$data['tglakhir'] = $tglakhirfinal;
		$data['bulan'] = $this->bulan($bulan);
		$data['tahun'] = $tahun;
		//var_dump($data1);exit();
		$this->load->view('cuti/data_cuti_rekap_detail',$data);
	}



	public function toexcel(){
		error_reporting(0);
		$tglmulai = $this->uri->segment(3);
		$tglakhir = $this->uri->segment(4);
		$grup = "tanggal_mulai";
		$where = array('tanggal_mulai >=' => $tglmulai, 'tanggal_mulai <=' => $tglakhir);
		$data['data_cuti'] = $this->cuti_model->rekap('printcuti',$where,$grup);
		$data['bulan'] = $this->bulan($bulan);
		$data['tahun'] = $tahun;
		$data['today'] = date('d-m-Y');
		$this->load->view('cuti/excel_rekap',$data);
	}

	public function hapusCuti(){
		$id = $this->uri->segment(3);
		$field = "id_cuti";
		$hapus = $this->cuti_model->updateData(array('is_active' => 0, 'status' => 11), array('id_cuti' => $id));
		if ($hapus) {
			echo "Jangan Lupa Ubah Jumlah Sisa Cuti";
			echo '<meta http-equiv="refresh" content="2;URL='.site_url('data_cuti/rekap').'" />';
			return;
		}else {
			echo "gagal hapus cuti";
		}
	}

	Public function totalTahunan(){
		$data = $this->cuti_model->getData('data_cuti_tes');
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
		$update = $this->cuti_model->updateDataWhere('data_cuti_tes',array('n1' => $n),array('id' => $id)); 
		if($update){
			if($this->cuti_model->updateDataWhere('data_cuti_tes',array('n' => 0), array('id' => $id))){
				echo "update total tahunan berhasil";
			}

		}else{
			echo "update gagal";
		}
	}
	
	Public function updateTotal(){
		$id = $this->input->post('id');
		$field = $this->input->post('field');
		$nilai = $this->input->post('val');
		var_dump($nilai);
		if($this->cuti_model->updateDataWhere('data_cuti_tes', array($field => $nilai) , array('user_id' => $id))){
			echo "Edit Berhasil";
		}else{
			echo "Gagal";
		}
	}
	
	Public function cutiDarurat(){
		
		$userid = $this->input->post('id_pegawai');
		$jumlah = $this->input->post('jumlah');
		$rentang = $this->input->post('tanggal');
		
		$cuti = $this->cuti_model->getDataQuery("select * from karyawan join data_cuti_tes on karyawan.id=data_cuti_tes.user_id where karyawan.id= '".$userid."'");
		foreach($cuti as $c){
			$gol = $c->golongan;
			$jabatan = $c->jabatan;
			$n = $c->n;
			$n1 = $c->n1;
			
		}
		$tglmulai = substr($rentang, 0,-13);
		$tglmulai = str_replace('/', '-', $tglmulai);
		$tglakhir = substr($rentang, -10);
		$tglakhir = str_replace('/', '-', $tglakhir);
		$year = substr($tglmulai,6,9);
		$month = substr($tglmulai,0,2);
		$day = substr($tglmulai,3,2);
		$year1 = substr($tglakhir,6,9);
		$month1 = substr($tglakhir,0,2);
		$day1 = substr($tglakhir,3,2);
		$tglmulaifinal = "$year-$month-$day";
		$tglakhirfinal = "$year1-$month1-$day1";
		//var_dump($tglmulaifinal);exit();
		$data = array('id_pegawai' => $userid,
					  'id_atasan' => 368,
					  'id_pejabat' => 368,
					  'id_rekom' => 368,
					  'id_rekom2' => 368,
					  'id_rekom3' => 368,
					  'id_cutisatuan' => 1,
					  'unit_kerja' => "BBKP Tanjung Priok",
					  'id_jeniscuti' => 1,
					  'alasan_cuti' => "-",
					  'jumlah_cuti' => $jumlah,
					  'jabatan_cuti' => $jabatan,
					  'golongan_cuti' => $gol,
					  'tanggal_mulai' => $tglmulaifinal,
					  'tanggal_berakhir' => $tglakhirfinal,
					  'alamat_cuti' => "-",
					  'catatan_cuti' => "Tidak hadir tanpa keterangan",
					  'sisa_cuti' => $n,
					  'sisa_cuti_n1' => $n1,
					  'status' => 4,
					  'created_by' => $this->session->userdata('user_id'),
					  'created_date' => date('Y-m-d')
					  );
		if($this->cuti_model->simpanData('data_cuti',$data)){
			$this->daruratTotal($userid,$n,$n1,$jumlah);
		}else{
			echo "Gagal";
		}
	}
	
	public function daruratTotal($id,$n,$n1,$jumlah){
		$kuota_n =12;$kuota_n1=6;
		$pake_n1 = $n1 + $jumlah;
		if($pake_n1>6){
			$sisa = abs($kuota_n1 - $pake_n1);
			$total_n1 = 6;
			if($n1>=6){
				$total_n = $n + $jumlah;
			}else{
				$total_n = $n + $sisa;
			}
		}elseif($pake_n1==6){
			$total_n1 = 6;
			$total_n = 0;
		}else{
			$total_n = 0; 
			$total_n1 = $pake_n1; 
		}
		$data = array('n' => $total_n, 'n1' => $total_n1);
		
		$update = $this->cuti_model->updateDataWhere('data_cuti_tes',$data,array('user_id' => $id));
		if($update){
			redirect(site_url('data_cuti/totalCuti'));
		}else{
			echo "Gagal";
		}
	}

	public function tesData(){
		$data['tes'] = $this->cuti_model->getData('data_cuti_tes');
		echo json_encode($data);
	}
}
