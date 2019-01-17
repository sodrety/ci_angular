<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perencanaan_kh extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('perencanaan_kh_model');
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
		$n=0;
		// $data1 = array();
		$tgl = date('Y');
		$where = array('status_kh' => 1 );
		$tanggalPeriksa = date('Y-m-d', strtotime(' +1 day'));
		$whereTanggal = array('tgl_periksa' => $tanggalPeriksa);
		$data['pegawai'] = $this->perencanaan_kh_model->getDataQuerys("select * from karyawan join realisasi on karyawan.id=realisasi.id_pegawai join jadwal on karyawan.id=jadwal.id_petugas where karyawan.status_kh=1 and jadwal.tgl='".$tanggalPeriksa."' order by realisasi.jumlah");
		// $data['antrian'] = $this->perencanaan_kh_model->getDataWhereMove('kh_impor',$whereTanggal);
		$data['dokumen'] = $this->perencanaan_kh_model->getDataWhere('perencanaan_tk',$whereTanggal);
		$data['petugas_kh'] = $this->perencanaan_kh_model->getDataWhere('karyawan',array('status_kh' => 1));
		$data['dokumen'] = $this->perencanaan_kh_model->getDataWhere('perencanaan_tk',array('tgl_periksa' => $tanggalPeriksa));
		$data['distribusi'] = $this->perencanaan_kh_model->getDataQuerys('select * from distribusi join karyawan on karyawan.id=distribusi.id_petugas join perencanaan_tk on perencanaan_tk.no_permohonan=distribusi.no_permohonan where distribusi.tgl_periksa="'.$tanggalPeriksa.'"');
		// var_dump($data1['peg']);exit();
		
		// var_dump($a);
		$this->load->view('kh/perencanaan/index',$data);
	}

	public function penempatan(){
		if ($this->input->get('bulan')=="") {
			$bulan=date('m');
		}else{
			$bulan = $this->input->get('bulan');
		}
		if ($this->input->get('tahun')=="") {
			$tahun=date('Y');
		}else{
			$tahun = $this->input->get('tahun');
		}
		$lokasi = $this->input->get('lokasi');
		$data['tahun'] = $tahun;
		$data['bulan'] = $bulan;
		$data['petugas'] = $this->perencanaan_kh_model->getDataWhere('karyawan', array('status_kh' => 1));
		$data['lokasi'] = $this->perencanaan_kh_model->getData('lokasi');
		$data['lokasi_2'] = $this->perencanaan_kh_model->getDataQuerys("select * from lokasi where id_lokasi='".$lokasi."'");
		if($lokasi){
			$data['penempatan'] = $this->perencanaan_kh_model->getDataQuerys("select * from penempatan join karyawan on penempatan.id_pegawai=karyawan.id 
																					   join lokasi on penempatan.id_lokasi=lokasi.id_lokasi
																					   where tahun='".$tahun."' and bulan='".$bulan."' and penempatan.id_lokasi='".$lokasi."'");
		}else{
			$data['penempatan'] = $this->perencanaan_kh_model->getDataquerys('select * from penempatan join karyawan on penempatan.id_pegawai=karyawan.id 
																						   join lokasi on penempatan.id_lokasi=lokasi.id_lokasi');
		}
		// var_dump($data1);exit();
		$this->load->view('kh/perencanaan/penempatan_kh',$data);
	}
	
	public function jadwalAdmin(){
		error_reporting(0);
		if ($this->input->get('bulan')=="") {
			$bulan=date('m');
		}else{
			$bulan = $this->input->get('bulan');
		}
		if ($this->input->get('tahun')=="") {
			$tahun=date('Y');
		}else{
			$tahun = $this->input->get('tahun');
		}
		$lokasi = $this->input->get('lokasi');
		$date= $tahun."-".$bulan."-01";
		$last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
		$j=date("d",$last_date_find);
		$a=0;
		while($a<$j){
			$a++;
			$t=substr("0".$a,-2);
			$th."-".$bl."-".$t."_".$id;
			$data['head'].="<th>".$t."</th>";
			if ($jd>0) {$ch="checked"; } else {$ch=""; }
			//$data['body'].="<td align=center ><input type=checkbox onclick=\"requestContent('ajx/jdwl.php?id=".$id_jd."','jdwl')\"></td>";
			$data['no'] = $a;
		}
		$id_petugas = $this->session->userdata('user_id');
		$lokasi_s = $this->perencanaan_kh_model->getDataWhere('penempatan', array('id_pegawai' => $id_petugas, 'tahun' => $tahun, 'bulan' => $bulan));
		if(!empty($lokasi_s)){
			foreach($lokasi_s as $l){
				$id_lokasi = $l->id_lokasi;
				$status = $l->status;
			}
		}else{
			$id_lokasi = "";
		}
		$data['status'] = $status;
		$data['controller'] = $this;
		$data['tahun'] = $tahun;
		$data['bulan'] = $bulan;
		$data['lokasi'] = $this->perencanaan_kh_model->getData('lokasi');
		$data['jadwal'] = $this->perencanaan_kh_model->getDataQuerys('select * from penempatan join karyawan on penempatan.id_pegawai=karyawan.id');
		$data['lokasi'] = $this->perencanaan_kh_model->getData('lokasi');
		$data['lokasi_2'] = $this->perencanaan_kh_model->getDataQuerys("select * from lokasi where id_lokasi='".$lokasi."'");
		if($lokasi){
			$data['penempatan'] = $this->perencanaan_kh_model->getDataQuerys("select * from penempatan join karyawan on penempatan.id_pegawai=karyawan.id 
																					   join lokasi on penempatan.id_lokasi=lokasi.id_lokasi
																					   where tahun='".$tahun."' and bulan='".$bulan."' and penempatan.id_lokasi='".$lokasi."' order by status desc");
		}else{
			$data['penempatan'] = $this->perencanaan_kh_model->getDataquerys("select * from penempatan join karyawan on penempatan.id_pegawai=karyawan.id 
																					   join lokasi on penempatan.id_lokasi=lokasi.id_lokasi
																					   where tahun='".$tahun."' and bulan='".$bulan."' order by status desc");
		}
		$this->load->view('kh/perencanaan/jadwal_kh',$data);
	}
	
	public function jadwal(){
		error_reporting(0);
		if ($this->input->get('bulan')=="") {
			$bulan=date('m');
		}else{
			$bulan = $this->input->get('bulan');
		}
		if ($this->input->get('tahun')=="") {
			$tahun=date('Y');
		}else{
			$tahun = $this->input->get('tahun');
		}
		$bulan_get = $this->input->get('bulan');
		$tahun_get = $this->input->get('tahun');
		$date= $tahun."-".$bulan."-01";
		$last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
		$j=date("d",$last_date_find);
		$a=0;
		while($a<$j){
			$a++;
			$t=substr("0".$a,-2);
			$th."-".$bl."-".$t."_".$id;
			$data['head'].="<th>".$t."</th>";
			if ($jd>0) {$ch="checked"; } else {$ch=""; }
			//$data['body'].="<td align=center ><input type=checkbox onclick=\"requestContent('ajx/jdwl.php?id=".$id_jd."','jdwl')\"></td>";
			$data['no'] = $a;
		}
		$id_petugas = $this->session->userdata('user_id');
		$lokasi = $this->perencanaan_kh_model->getDataWhere('penempatan', array('id_pegawai' => $id_petugas, 'tahun' => $tahun, 'bulan' => $bulan));
		if(!empty($lokasi)){
			foreach($lokasi as $l){
				$id_lokasi = $l->id_lokasi;
				$status = $l->status;
			}
		}else{
			$id_lokasi = "";
		}
		$data['controller'] = $this;
		$data['status'] = $status;
		$data['tahun'] = $tahun;
		$data['bulan'] = $bulan;
		$data['lokasi'] = $this->perencanaan_kh_model->getData('lokasi');
		$data['lokasi_2'] = $this->perencanaan_kh_model->getDataQuerys("select * from lokasi where id_lokasi='".$lokasi."'");
		if($status==1){
			$data['penempatan'] = $this->perencanaan_kh_model->getDataQuerys("select * from penempatan join karyawan on penempatan.id_pegawai=karyawan.id join lokasi on penempatan.id_lokasi=lokasi.id_lokasi																					   where tahun='".$tahun."' and bulan='".$bulan."' and lokasi.id_lokasi=".$id_lokasi." order by status desc");
		}else{
			$data['penempatan'] = $this->perencanaan_kh_model->getDataquerys("select * from penempatan join karyawan on penempatan.id_pegawai=karyawan.id join lokasi on penempatan.id_lokasi=lokasi.id_lokasi																					   where tahun='".$tahun."' and bulan='".$bulan."' and lokasi.id_lokasi=".$id_lokasi." and id_pegawai='".$id_petugas."' order by status desc");
		}
		$this->load->view('kh/perencanaan/jadwal_kh',$data);
	}
	
	public function checkJadwal($id,$th,$bl){
		$date= $this->input->post('tahun')."-".$this->input->post('bulan')."-01";
		$date= $tahun."-".$bulan."-01";
		$last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
		$j=date("d",$last_date_find);
		$a=0;
		
		//var_dump($link);exit();
		while($a<$j){
			$a++;
			$t=substr("0".$a,-2);
			$id_jd="".$th."-".$bl."-".$t."_".$id."";
			$tgly=$th."-".$bl."-".$t;
			$style="style=background-color:blue;";
			$jd = $this->perencanaan_kh_model->getDataWhere('jadwal', array('id_jadwal' => $id_jd));
			if ($this->nama_hari($tgly)=="Sun") {$bg="bgcolor='999999'"; } elseif ($this->nama_hari($tgly)=="Sat") {$bg="bgcolor='aaaaaa'"; } else  {$bg="";}
			if (!empty($jd)) {$ch="class='btn btn-success btn-sm'"; $tes="1"; $icon="<i class='fa fa-plus'></i>";} else {$ch="class='btn btn-danger btn-sm'"; $tes="0"; $icon="<i class='fa fa-min'></i>";}
			$link = site_url("perencanaan_kh/updateJadwal?id=".$id_jd."");
			$body.="<td align=center ".$bg."><input type=button id=btn ".$ch." onclick=updateJadwal(this,'".$id_jd."','".$tes."')></td>
			";
		}
		return $body;
	}
	
	public function nama_hari($tgl){
		$datetime = DateTime::createFromFormat('Y-m-d', $tgl);
		$hari = $datetime->format('D');
		return $hari;
	}
	
	public function updateJadwal(){
		$tgl = $this->input->post('tanggal');
		$id = $this->input->post('id');
		$ex=explode("_",$tgl);
		$where = array('id_jadwal' => $tgl);
		$data = array('id_jadwal' => $tgl,
					  'id_petugas' => $ex[1],
					  'tgl' => $ex[0]);
		$cek = $this->perencanaan_kh_model->getDataWhere('jadwal',$where);
		if(!empty($cek)){
			$delete = $this->perencanaan_kh_model->deleteData('jadwal',$where);
			if($delete){
				$x= "dihapus";
			}else{
				$x = "gagal hapus";
			}
		}else{
			$update = $this->perencanaan_kh_model->replaceData('jadwal',$data);
			if($update){
				$x = "diupdate";
			}else{
				$x = "gagal input";
			}
		}
		echo $tgl." ".$x;
	}
	
	public function jadwalData(){
		$data = $this->perencanaan_kh_model->getData('karyawan');
		echo json_encode($data);
	}
	

	public function tambahPenempatan(){
		
		$lokasi = $this->input->post('lokasi');
		$id_pegawai = $this->input->post('petugas');
		$status = $this->input->post('status');
		$tahun = $this->input->get('tahun');
		$bulan = $this->input->get('bulan');
		//var_dump($id_pegawai);exit();
		$data = array('id_pegawai' => $id_pegawai,
					  'status' => $status,
					  'id_lokasi' => $lokasi,
					  'tahun' => $tahun,
					  'bulan' => $bulan);
			
		$where = array('id_pegawai' => $id_pegawai,
						   'tahun' => $tahun,
						   'bulan' => $bulan);
						   
		$cek = $this->perencanaan_kh_model->getDataQuerys("select * from penempatan where id_pegawai='".$id_pegawai."' and tahun='".$tahun."' and bulan='".$bulan."'");
		//var_dump($cek);exit();
		if($cek!=null){
			$update = $this->perencanaan_kh_model->updateData('penempatan',$data,$where);
			if($update){
				//echo "Update";
				redirect('perencanaan_kh/penempatan?tahun='.$tahun.'&bulan='.$bulan.'&lokasi='.$lokasi);
			}
		}else{
			$insert = $this->perencanaan_kh_model->insertInto('penempatan',$data);
			if($insert){
				redirect('perencanaan_kh/penempatan?tahun='.$tahun.'&bulan='.$bulan.'&lokasi='.$lokasi);
			}else{
				echo "Gagal Tambah Petugas";
				echo '<meta http-equiv="refresh" content="2;URL='.site_url('perencanaan_kh/penempatan').'" />';
			}
		}
	}



	public function updateRealisasi(){
		$tgl = date('Y');
		$data['peg'] = $this->perencanaan_kh_model->getData('petugas_kh');
		foreach ($data['peg'] as $p) {
			$a = $this->perencanaan_kh_model->jumlah_spt($p->id,$tgl);
			// var_dump($a);
			$this->perencanaan_kh_model->getDataQueryst("replace into realisasi values(".$p->id.",'".$a."')");
			redirect(site_url('perencanaan_kh'));
		}
	}


	public function tambahDokumen(){
		$no_reg = $_POST['no_reg'];
		$jumlahPetugas = $_POST['jumlah'];
		$field = 'id,tanggal,nama_pemilik';
		$tanggalPeriksa = date('Y-m-d', strtotime(' +1 day'));
		$where = array('id' => $no_reg );
		$data['coba'] = $this->perencanaan_kh_model->getDataQueryMix("select no_aju,no_reg from barcode where no_reg='".$no_reg."'","dbAn");
		if(!empty($data['coba'])){
			foreach ($data['coba'] as $a) {
				$no_aju = $a->no_aju;
				$no_reg = $a->no_reg;
				$no_aju = substr($no_aju, 5,7);
				$nama_perusahaan = $this->perencanaan_kh_model->getDataQueryMix("select * from akun_pj where akun like '%".$no_aju."%'","dbAn");
				if(!empty($nama_perusahaan)){
					foreach($nama_perusahaan as $p){
						$nama_per = $p->perusahaan;
					}
				}
			}
		}
		//var_dump($nama_perusahaan);exit();
		$data = array('perusahaan' => $nama_per,
					  'no_permohonan' => $no_reg,
					  'tgl_periksa' => $tanggalPeriksa,
					  'jumlah' => $jumlahPetugas );
		// var_dump($data);exit();
		$insert = $this->perencanaan_kh_model->insertInto('perencanaan_tk',$data);
		if ($insert) {
			redirect(site_url('Perencanaan_kh'));
		}else{
			echo "gagal";
		}
	}


	
	public function acakPetugas(){
		$tanggalPeriksa = date('Y-m-d', strtotime(' +1 day'));
		//if ($_GET['tgl_periksa']=="") {$tgl_periksa=$tanggalPeriksa;} else {$tgl_periksa=$_GET['tgl_periksa'];}
		$where = array('tgl_periksa' => $tanggalPeriksa);
		$data['dokumen'] = $this->perencanaan_kh_model->getDataWhere('perencanaan_tk',$where);
		$data['field'] = $this->perencanaan_kh_model->getDataFieldWhere('123');
		$a=0;$t=0;$md=0;$pmd=0;$al_t=0;$al_a=0;$si_a=0;$si_t=0;$keb=0;$n=0;$na=0;$nt=0;$da="";$dt="";
		foreach($data['dokumen'] as $d){
			$n++;
			$no_permohonan = $d->no_permohonan;
			$jml = $this->perencanaan_kh_model->getDataFieldWhere($d->no_permohonan);
			$keb+=$jml;
			if ($jml==1) {$pm=0;$pp=1;}
			if ($jml==2) {$pm=1;$pp=1;}
			if ($jml==3) {$pm=1;$pp=2;}
			if ($jml==4) {$pm=2;$pp=2;}
			
			$dtanya="|||".$d->no_permohonan." :: ".$d->perusahaan;
			$whereMedik = array('no_permohonan' => $d->no_permohonan, 'tgl_periksa' => $d->tgl_periksa, 'jenjang' => "MEDIK");
			$whereParamedik = array('no_permohonan' => $d->no_permohonan, 'tgl_periksa' => $d->tgl_periksa, 'jenjang' => "PARAMEDIK");
			$jmlMedik = count($this->perencanaan_kh_model->getDataWhere('distribusi',$whereMedik));
			$jmlParamedik = count($this->perencanaan_kh_model->getDataWhere('distribusi',$whereParamedik));
			
			$ppm=($pm-$jmlMedik);$ppp=($pp-$jmlParamedik);
			
			if ($ppm==1) {
				$a+=1;$da.=$dtanya;
				}
			if ($ppp==1) {
				$t+=1;$dt.=$dtanya;
				}
			if ($ppm==2) {
				$a+=2;$da.=$dtanya;$da.=$dtanya;
				}
			if ($ppp==2) {
				$t+=2;$dt.=$dtanya;$dt.=$dtanya;
				}
		}

		$dt = explode("|||", $dt);
		$dt = "STR".implode("|||", $dt);
		$dt = str_replace("STR|||", "", $dt);
		$dt = explode("|||", $dt);
		shuffle ($dt);
		$dt = implode("|||", $dt);

		$da = explode("|||", $da);	
		$da = "STR".implode("|||", $da);
		$da = str_replace("STR|||", "", $da);
		$da = explode("|||", $da);
		shuffle ($da);
		$da = implode("|||", $da); 
		

		$dt=str_replace ("||||||","|||",$dt);
   		$da=str_replace ("||||||","|||",$da);
   		// $da = explode("|||", $da);
   		// $dt = explode("|||", $dt);
		// var_dump($da);exit();
		
		$nn=0;
		$bulan = date('M');
		$tahun = date('Y');
		// $data['petugas'] = $this->perencanaan_kh_model->getDataQuerySpt('select spt.id,spt.tgl,spt_petugas.id_spt,spt_petugas.id_user from spt join spt_petugas on spt.id=spt_petugas.id_spt where month(tgl) = 1 and year(tgl)= '.$tahun.'');
		$data['petugas'] = $this->perencanaan_kh_model->getDataQuerys("select * from karyawan join realisasi on karyawan.id=realisasi.id_pegawai join jadwal on karyawan.id=jadwal.id_petugas where jadwal.tgl='".$tanggalPeriksa."' order by realisasi.jumlah");
		// var_dump($data['petugas']);exit();
		foreach($data['petugas'] as $p){
			$nn+=1;
			$dtnya=$p->nama." :: ".$p->id." :: ".$p->jenjang."|||";
			if ($p->jenjang=="MEDIK"){
				$md+=1;
			}
			if ($p->jenjang=="MEDIK") {
				if ($md>$a) {
						$si_a.=$dtnya;
					} else {
						$al_a.=$dtnya;
				}
			}
			
			if ($p->jenjang=="PARAMEDIK"){
				$pmd+=1;
			}
			if ($p->jenjang=="PARAMEDIK") {
				if ($pmd>$t) {
					$si_t.=$dtnya;
				} else {
					$al_t.=$dtnya;
				}
			}
			
			
			//$data['petugas_tk'] = $this->perencanaan_kh_model->getDataQuery(30);
			
			
		}

			$dta=str_replace ("|||","|||",$al_a.$si_t."");
			$dtt=str_replace ("|||","|||",$al_t.$si_a."");
			//implode("|||", $al_a.$si_t);
			//var_dump($da);exit();
			$c=0;
			
			$perusahaanPara = explode("|||", $dt);
			$perusahaanMedik = explode("|||", $da);
			$petugasPara = explode("|||", $dtt);
			$petugasMedik = explode("|||", $dta);
			// var_dump($petugasMedik);exit();
			$npara=0;
			foreach ($perusahaanPara  as $perPara ) {
				// echo $perPara.' '.$petugasPara[$npara];
				$this->running($tanggalPeriksa,$petugasPara[$npara],$perPara);
				$npara+=1;
			}
			echo "<br>".$da;
			$nmedik=0;
			foreach ($perusahaanMedik  as $perMedik ) {
				echo $perMedik.' '.$petugasMedik[$nmedik];

				$this->running($tanggalPeriksa,$petugasMedik[$nmedik],$perMedik);
				$nmedik+=1;
			}
			// while ($c<$n) {
				
			// 	// $nt+=1;	
			// 	// $na+=2;	
			// 	// var_dump($petugasPara[4]);exit();
			// 	// $petugasPara[$c]!="" and $perusahaanPara[$c]!=""
			// 	if (isset($petugasPara[$c]) and isset($perusahaanPara[$c])) {
			// 		// var_dump($perusahaanPara);exit();
			// 		// $petugasMediks = implode(" :: ", $petugasMedik);
			// 		// $petugasParas = implode(" :: ", $petugasPara);
			// 		// $perusahaanMediks = implode(" :: ", $perusahaanMedik);
			// 		// $perusahaanParas = implode(" :: ", $perusahaanPara);

			// 		// $petugasMediks = explode(" :: ",$petugasMedik[$c]);	
			// 		$petugasParas = explode(" :: ",$petugasPara[$c]);
			// 		// $perusahaanMediks = explode(" :: ",$perusahaanMedik[$c]);
			// 		$perusahaanParas = explode(" :: ",$perusahaanPara[$c]);
					
			// 		$data = array('id'=>$petugasParas[1].'_'.$tanggalPeriksa,
			// 		  'no_permohonan'=>$perusahaanParas[0],
			// 		  'tgl_periksa'=>$tanggalPeriksa,
			// 		  'id_petugas'=>$petugasParas[1],
			// 		  'perusahaan'=>$perusahaanParas[1],
			// 		  'jenjang'=>$petugasParas[2]);
			// 		$where = array('id'=> $petugasParas[1].'_'.$tanggalPeriksa);
			// 	 	//$this->running($tanggalPeriksa,$dtt[$c],$dt[$c]);
			// 	 	 // var_dump($data);exit();
			// 		$cek = count($this->perencanaan_kh_model->getDataWhere('distribusi',$where));
			// 		// var_dump($petugass);exit();
			// 		if($cek<=0 and $cek!=""){
			// 			$insert = $this->perencanaan_kh_model->insertInto('distribusi',$data);
			// 			if ($insert) {
			// 				echo "Berhasil Simpan Paramedik";
			// 				// echo '<meta http-equiv="refresh" content="2;URL='.site_url('perencanaan_kh').'" />';
			// 			}else{
			// 				// echo "Gagal Input Paramedik";
			// 			}
			// 		}else{
			// 			$update = $this->perencanaan_kh_model->updateData('distribusi',$data,$where);
			// 			if ($update) {
			// 				echo "Berhasil Update Paramedik";
			// 				// echo '<meta http-equiv="refresh" content="2;URL='.site_url('perencanaan_kh').'" />';
			// 			 }else{
			// 			 	// echo "Gagal Update Paramedik";
			// 			 } 
			// 		}
			// 	}
			// 	// $petugasMedik[$c]!="" and $perusahaanMedik[$c]!="" and 
			// 	if (isset($petugasMedik[$c]) and isset($perusahaanMedik[$c])) {
			// 		// $petugasMediks = implode(" :: ", $petugasMedik);
			// 		// $petugasParas = implode(" :: ", $petugasPara);
			// 		// $perusahaanMediks = implode(" :: ", $perusahaanMedik);
			// 		// $perusahaanParas = implode(" :: ", $perusahaanPara);
			// 		$petugasMediks = explode(" :: ",$petugasMedik[$c]);	
			// 		// $petugasParas = explode(" :: ",$petugasPara[$c]);
			// 		$perusahaanMediks = explode(" :: ",$perusahaanMedik[$c]);
			// 		// $perusahaanParas = explode(" :: ",$perusahaanPara[$c]);
			// 		$data = array('id'=>$petugasMediks[1].'_'.$tanggalPeriksa,
			// 		  'no_permohonan'=>$perusahaanMediks[0],
			// 		  'tgl_periksa'=>$tanggalPeriksa,
			// 		  'id_petugas'=>$petugasMediks[1],
			// 		  'perusahaan'=>$perusahaanMediks[1],
			// 		  'jenjang'=>$petugasMediks[2]);
			// 		$where = array('id'=> $petugasMediks[1].'_'.$tanggalPeriksa);
			// 		//$this->running($tanggalPeriksa,$dta[$c],$da[$c]);
			// 		$cek = count($this->perencanaan_kh_model->getDataWhere('distribusi',$where));
			// 		// var_dump($data);exit();
			// 		if($cek<=0 and $cek!=""){
			// 			$insert = $this->perencanaan_kh_model->insertInto('distribusi',$data);
			// 			if ($insert) {
			// 				echo "Berhasil Simpan Medik";
			// 				// echo '<meta http-equiv="refresh" content="2;URL='.site_url('perencanaan_kh').'" />';
			// 			}else{
			// 				// echo "Gagal Input Medik";
			// 			}
			// 		}else{
			// 			$update = $this->perencanaan_kh_model->updateData('distribusi',$data,$where);
			// 			if ($update) {
			// 				echo "Berhasil Update Medik";
			// 				// echo '<meta http-equiv="refresh" content="2;URL='.site_url('perencanaan_kh').'" />';
			// 			 }else{
			// 			 	// echo "Gagal Update Medik";
			// 			 } 
			// 		}
			// 	}
				
			// 	$c+=1;
			// 	echo '<meta http-equiv="refresh" content="2;URL='.site_url('perencanaan_kh').'" />';
			// 	// echo $c;
			// }
			// exit();
			
			//$ket= explode(" :: ",$dta[$c]);
		// var_dump($dt[0]);exit();
		
	}

	public function running($tgl,$petugas,$perusahaan){
		$petugass = explode(" :: ",$petugas);
		$perusahaans = explode(" :: ",$perusahaan);
		$where = array('id_distribusi'=> $petugass[1].'_'.$tgl);
		$data = array('id_distribusi'=>$petugass[1].'_'.$tgl,
					  'no_permohonan'=>$perusahaans[0],
					  'tgl_periksa'=>$tgl,
					  'id_petugas'=>$petugass[1],
					  'perusahaan'=>$perusahaans[1],
					  'jenjang'=>$petugass[2],
					  'status'=>1);
		$cek = count($this->perencanaan_kh_model->getDataWhere('distribusi',$where));
		// var_dump($petugass);exit();
		if($cek<=0){
			$insert = $this->perencanaan_kh_model->insertInto('distribusi',$data);
			if ($insert) {
				echo '<meta http-equiv="refresh" content="2;URL='.site_url('perencanaan_kh/acakPetugas').'" />';
				return true;
			}else{
				echo "Gagal Input";
			}
			
		}else{
			$update = $this->perencanaan_kh_model->updateData('distribusi',$data,$where);
			if ($update) {
				echo '<meta http-equiv="refresh" content="2;URL='.site_url('perencanaan_kh').'" />';
				return true;
			 }else{
			 	echo "Gagal Update";
			 } 
		}

		//var_dump($data);
		
	}
	
	public function tambahPetugas(){
		$petugas = $this->input->post('petugas');
		$no_reg = $this->input->post('no_reg');
		$tanggalPeriksa = date('Y-m-d', strtotime(' +1 day'));
		$id = $petugas.'_'.$no_reg;
		$data = array('id_distribusi' => $petugas.'_'.$no_reg,
					  'id_petugas' => $petugas,
					  'no_permohonan' => $no_reg,
					  'tgl_periksa' => $tanggalPeriksa,
					  'status' => 1);
					
		$cek = $this->perencanaan_kh_model->getDataWhere('distribusi', array('id_distribusi' => $id));
		if(!empty($cek)){
			echo "Petugas sudah ada";
			echo '<meta http-equiv="refresh" content="2;URL='.site_url('perencanaan_kh').'" />';
		}else{
			if($this->perencanaan_kh_model->insertInto('distribusi', $data)){
				redirect(site_url('perencanaan_kh'));
			}else{
				echo "Gagal Tambah Petugas";
				echo '<meta http-equiv="refresh" content="2;URL='.site_url('perencanaan_kh').'" />';
			}
		}
	}

	public function hapusDokumen(){
		$id = $this->uri->segment(4);
		$field = 'id';
		$hapus = $this->perencanaan_kh_model->deleteData('perencanaan_tk',$field,$id);
		if ($hapus) {
			redirect(site_url('perencanaan_kh'));
		}else{
			echo "Gagal Hapus";
		}
		// var_dump($id);exit();
	}
	public function hapusDistribusi(){
		$id = $this->uri->segment(4);
		//var_dump($id);exit();
		$field = 'id_distribusi';
		$hapus = $this->perencanaan_kh_model->deleteData('distribusi',array('id_distribusi' => $id));
		if ($hapus) {
			redirect(site_url('perencanaan_kh'));
		}else{
			echo "Gagal Hapus";
		}
		// 
	}
	
	

}
?>


 