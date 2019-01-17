<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('cuti_model');
		$this->load->library('pdf');
	}

	public function index()
	{
		// $tanggal = new DateTime("now");
		// $curr_date = $tanggal->format('Y-m-d');
		// var_dump($curr_date);
		// exit();
		if (!empty($_SESSION['user_id'])) {
		 	// echo $this->session->nama;
		 	$user_id = $this->session->user_id;
		} else{
		 	redirect(site_url('login'));
		 	return;
		}
		$date = new DateTime("now");
		$a = $_SERVER['SERVER_ADDR'];
		$server = explode('/',$a);
		$a[0];

 		$curr_date = $date->format('Y-m-d');
		//var_dump($a);exit();
		$statusAtasan = 2;
		$statusPejabat = 3;
		$statusRekom = 6;
		$statusRekom2 = 9;
		$statusRekom3 = 10;
		$statusTolak = 5;
		$fieldAtasan = "id_atasan";
		$fieldPejabat = "id_pejabat";
		$fieldRekom = "id_rekom";
		$fieldRekom2 = "id_rekom2";
		$fieldRekom3 = "id_rekom3";
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
		$data['approveRekom3'] = $this->cuti_model->ambilDataApproval($fieldRekom3,$user_id,$statusRekom3);
		$data['data_approve'] = $this->cuti_model->ambilDataApprovalAll();
		$data['surat_masuk'] = $this->cuti_model->ambilKaryawanSession('app_surat_masuk',$where);
		$data['surat_tugas'] = $this->cuti_model->ambilKaryawanSession('app_penugasan',$where);
		$data['antrian'] = $this->cuti_model->getDataWhere('app_antrian',$whereAntrian);
		$data['anggarans'] = $this->cuti_model->getDataQuery('select * from app_anggaran order by tgl desc limit 0,1');
		$data['serapan'] = $this->cuti_model->getDataQuery('select * from app_serapan order by tgl desc limit 0,1');
		$data['profil'] = $this->cuti_model->ambilKaryawanSession('karyawan',$whereProfile);
		$data['gol'] = $this->cuti_model->getGol();
		$data['tolak'] = $this->cuti_model->ambilDataApproval($fieldPegawai,$user_id,$statusTolak);
		$data['selesai'] = $this->cuti_model->getDataWhere('printcuti',$whereSelesai);


		//var_dump($data1);exit();
		if ($data['surat_masuk']==null) {
			$data['jumlahSurat'] = 0;
		}else{
			foreach ($data['surat_masuk'] as $surat) {
				$data['jumlahSurat'] = $surat->value;
			}
		}
		$datas = $data['surat_tugas'];
		error_reporting(0);
		//var_dump($data['surat_tugas']);exit();
		if ($data[$datas[1]]==null) {
			$data['jumlahTugas'] = 0;

		}else{
			foreach ($data['surat_tugas'] as $tugas) {
				$data['jumlahTugas'] = $tugas->value;
			}
		}

		if ($data['serapan']==null) {
			$data['jumlahSerapan'] = 0;
		}else{
			foreach ($data['serapan'] as $tugas) {
				$data['jumlahSerapan'] = $tugas->value;
			}
		}

		$data['notifTolak'] = count($data['tolak']);
		$data['notifApproveAtasan'] = count($data['approveAtasan']);
		$data['notifApprovePejabat'] = count($data['approvePejabat']);
		$data['notifApproveRekom'] = count($data['approveRekom']);
		$data['notifApproveRekom2'] = count($data['approveRekom2']);
		$data['notifApproveRekom3'] = count($data['approveRekom3']);
		$data['notifApproveAll'] = count($data['data_approve']);
		$data['notifProses'] = count($data['data_cuti_proses']);
		$data['notifSelesai'] = count($data['selesai']);
		$this->load->view('dashboard',$data);
	}

	public function rekapTpk(){
		$data['controller'] = $this;
		$data['data'] = $this->cuti_model->getDataTpk('select distinct perusahaan from data');
		//var_dump($data['data']);exit();
		$this->load->view('tpk',$data);
	}

	public function rekapMax($field){
		//error_reporting(0);
		$querys = $this->cuti_model->getDataTpk("select max(terlambat) as terlambat,perusahaan,no_sp2mp from data where perusahaan='$field'");
		$date = date('y-m-d');
		//var_dump($querys);exit();
		foreach ($querys as $k) {
			$max = $k->terlambat;
			$perusahaan = $k->perusahaan;
			$sp2mp = $k->no_sp2mp;
			$this->cuti_model->getDataTpkInsert("replace into data_rekap values('".$date.""._."".$perusahaan."','".$perusahaan."','".$sp2mp."',".$max.")");
		}
		return $max;
		// return;
	}

	public function rekapMaxFinal($field){
		//error_reporting(0);
		$querys = $this->cuti_model->getDataTpk("select max(terlambat) as terlambat,perusahaan from data where perusahaan='$field'");
		$date = date('y-m-d');
		// var_dump($querys);exit();
		foreach ($querys as $k) {
			$max = $k->terlambat;
			$perusahaan = $k->perusahaan;
		}
		return $max;
		// return;
	}

	public function rekapFrek($field){
		$querys = $this->cuti_model->getDataTpk("select * from data where perusahaan='$field'");
		
		// var_dump($querys);exit();
		$no=0;
		foreach ($querys as $k) {
			$no+=1;
			$coba = $k->terlambat;
		}
		return $no;
		// return;
	}

	public function rekap($field){
		$querys = $this->cuti_model->getDataTpk("select * from data where perusahaan='$field'");
		
		// var_dump($querys);exit();
		$nos="";
		foreach ($querys as $k) {
			$nos.=$k->terlambat.', ';
		}
		return $nos;
		// return;
	}

	public function tampilRekap(){
		$data['controller'] = $this;
		$data['data'] = $this->cuti_model->getDataTpk("select distinct perusahaan from data where no_sp2mp like '%K02%'");
		$data['rekap'] = $this->cuti_model->getDataTpk("select * from data_rekap  order by jumlah_max desc");
		//var_dump($data['rekap']);exit();
		$this->load->view('tpk',$data);
	}
	
	public function tampilRekapExcel(){
		$data['controller'] = $this;
		$data['data'] = $this->cuti_model->getDataTpk('select distinct perusahaan from data');
		$data['rekap'] = $this->cuti_model->getDataTpk('select * from data_rekap order by jumlah_max desc');
		//var_dump($data['rekap']);exit();
		$this->load->view('tpk_excel',$data);
	}

	function fpdf(){
		$tgl = date('Y-m-d');
        $pdf = new FPDF('P','mm','A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','',10);
        // mencetak string 
        $pdf->Cell('',7,'Jakarta, '.$tgl.'',0,1,'R');
        $pdf->Cell('',7,'Kepada',0,1,'R');
        $pdf->Cell('',7,'Yth. Kepala Balai Karantina Pertanian Tanjung Priok',0,1,'R');
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(10,5,'',0,1);
        $pdf->Cell('',7,'FORMULIR PERMINTAAN DAN PEMBERIAN CUTI',0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell('',7,'I. Data Pegawai',1,1);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(30,8,'Nama',1,0);
        $pdf->Cell(65,8,'',1,0);
        $pdf->Cell(30,8,'NIP',1,0);
        $pdf->Cell(65,8,'',1,1);
        $pdf->Cell(30,8,'Jabatan',1,0);
        $pdf->Cell(65,8,'',1,0);
        $pdf->Cell(30,8,'Golongan',1,0);
        $pdf->Cell(65,8,'',1,1);
        $pdf->Cell(30,8,'Unit Kerja',1,0);
        $pdf->Cell(65,8,'',1,0);
        $pdf->Cell(30,8,'Masa Kerja',1,0);
        $pdf->Cell(65,8,'',1,1);
		$pdf->Cell(10,5,'',0,1);
        $pdf->SetFont('Arial','B',11);
		$pdf->Cell('',7,'II. JENIS CUTI YANG DIAMBIL **',1,1);
        $pdf->SetFont('Arial','B',11);
        $pdf->SetFont('Arial','',10);
		$pdf->Cell('',7,'',1,1);
		$pdf->Cell(10,5,'',0,1);
        $pdf->SetFont('Arial','B',11);
		$pdf->Cell('',7,'III. ALASAN CUTI',1,1);
        $pdf->SetFont('Arial','',10);
		$pdf->Cell('',15,'',1,1);
		$pdf->Cell(10,5,'',0,1);
        $pdf->SetFont('Arial','B',11);
		$pdf->Cell('',7,'IV. CATATAN CUTI',1,1);
		$pdf->Cell('',10,'',1,1);
        $pdf->SetFont('Arial','',10);
		$pdf->Cell('',7,'CUTI TAHUNAN',1,1);
		$pdf->Cell('60',7,'Tahun',1,0);
		$pdf->Cell('60',7,'Sisa',1,0);
		$pdf->Cell('70',7,'Keterangan',1,1);
		$pdf->Cell('60',7,'',1,0);
		$pdf->Cell('60',7,'',1,0);
		$pdf->Cell('70',7,'',1,1);
		$pdf->Cell('60',7,'',1,0);
		$pdf->Cell('60',7,'',1,0);
		$pdf->Cell('70',7,'',1,1);
		$pdf->Cell('','5','',0,1);
        $pdf->SetFont('Arial','B',11);
		$pdf->Cell('',7,'V. Alamat Selama Menjalankan Cuti',1,1);
		
		
        $pdf->Output();
    }
}