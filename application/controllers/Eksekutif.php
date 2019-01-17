<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eksekutif extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('eksekutif_model');
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
		$kom = $this->input->post('kom');
		$rentang = $this->input->post('rentang');
		$jenis = $this->input->post('jenis');
		$bid = $this->input->post('bid');
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
		//var_dump($bid);exit();
		if($bid=="kt"){
			if($jenis=="impor"){
				$tb = "%I%";
				$tbl = "kt9";
			}elseif ($jenis=="domestikKeluar") {
				$tb = "%.K.%";
				$tbl = "kt12";
			}elseif ($jenis=="domestikMasuk") {
				$tb = "%.M.%";
				$tbl = "kt9";
			}else{
				$tb = "%E%";
				$tbl = "kt10";
			}
			if($this->input->post('rentang')==null){
				$data['eksekutif'] = $this->eksekutif_model->getDataQuery("SELECT peruntukan, nama_penerima, master_satuan.nama as nama_satuan, volume_netto, komoditas_tumbuhan.nama as nama_tum,master_negara.nama,alamat_pengirim,nama_pengirim,no_aju,tanggal,nomor,ppk_komoditas_tumbuhan.ppk_id,ppk_komoditas_tumbuhan_id,komoditas_tumbuhan.nama_en FROM 
				komoditas_tumbuhan 
				JOIN ppk_komoditas_tumbuhan_detail ON komoditas_tumbuhan.id=ppk_komoditas_tumbuhan_detail.komoditas_tumbuhan_id
				JOIN ppk_komoditas_tumbuhan ON ppk_komoditas_tumbuhan_detail.ppk_komoditas_tumbuhan_id=ppk_komoditas_tumbuhan.id
				JOIN ".$tbl." ON ppk_komoditas_tumbuhan.ppk_id=".$tbl.".ppk_id
				JOIN ppk ON ppk_komoditas_tumbuhan.ppk_id=ppk.id
				JOIN master_negara ON master_negara.id=ppk.negara_tujuan
				JOIN master_satuan ON master_satuan.id=ppk_komoditas_tumbuhan_detail.satuan_netto
				WHERE (komoditas_tumbuhan.nama_en LIKE '%".$kom."%' or komoditas_tumbuhan.nama LIKE '%".$kom."%') and nomor LIKE '".$tb."' order by tanggal desc");
				
			}else{
				$data['eksekutif'] = $this->eksekutif_model->getDataQuery("SELECT peruntukan, nama_penerima, master_satuan.nama as nama_satuan, volume_netto, ".$tbl.".tanggal,komoditas_tumbuhan.nama as nama_tum,master_negara.nama,alamat_pengirim,nama_pengirim,no_aju,tanggal,nomor,ppk_komoditas_tumbuhan.ppk_id,ppk_komoditas_tumbuhan_id,komoditas_tumbuhan.nama_en FROM 
				komoditas_tumbuhan 
				JOIN ppk_komoditas_tumbuhan_detail ON komoditas_tumbuhan.id=ppk_komoditas_tumbuhan_detail.komoditas_tumbuhan_id
				JOIN ppk_komoditas_tumbuhan ON ppk_komoditas_tumbuhan_detail.ppk_komoditas_tumbuhan_id=ppk_komoditas_tumbuhan.id
				JOIN ".$tbl." ON ppk_komoditas_tumbuhan.ppk_id=".$tbl.".ppk_id
				JOIN ppk ON ppk_komoditas_tumbuhan.ppk_id=ppk.id
				JOIN master_negara ON master_negara.id=ppk.negara_asal
				JOIN master_satuan ON master_satuan.id=ppk_komoditas_tumbuhan_detail.satuan_netto
				WHERE (komoditas_tumbuhan.nama_en LIKE '%".$kom."%' or komoditas_tumbuhan.nama LIKE '%".$kom."%') and nomor LIKE '".$tb."' and ".$tbl.".tanggal>='".$tglmulaifinal."' and ".$tbl.".tanggal<='".$tglakhirfinal."' order by nama_penerima desc");
				// $data['eksekutif'] = $this->eksekutif_model->getDataQuery("SELECT master_pelabuhan.nama as nama_pelabuhan, peruntukan, nama_penerima, master_satuan.nama as nama_satuan, volume_netto, ".$tbl.".tanggal,komoditas_tumbuhan.nama as nama_tum,master_negara.nama,alamat_pengirim,nama_pengirim,no_aju,tanggal,nomor,ppk_komoditas_tumbuhan.ppk_id,ppk_komoditas_tumbuhan_id,komoditas_tumbuhan.nama_en FROM 
				// komoditas_tumbuhan 
				// JOIN ppk_komoditas_tumbuhan_detail ON komoditas_tumbuhan.id=ppk_komoditas_tumbuhan_detail.komoditas_tumbuhan_id
				// JOIN ppk_komoditas_tumbuhan ON ppk_komoditas_tumbuhan_detail.ppk_komoditas_tumbuhan_id=ppk_komoditas_tumbuhan.id
				// JOIN ".$tbl." ON ppk_komoditas_tumbuhan.ppk_id=".$tbl.".ppk_id
				// JOIN ppk ON ppk_komoditas_tumbuhan.ppk_id=ppk.id
				// JOIN master_negara ON master_negara.id=ppk.negara_tujuan
				// JOIN master_satuan ON master_satuan.id=ppk_komoditas_tumbuhan_detail.satuan_netto
				// JOIN master_pelabuhan ON master_pelabuhan.id=ppk.pelabuhan_asal
				// WHERE (komoditas_tumbuhan.nama_en LIKE '%".$kom."%' or komoditas_tumbuhan.nama LIKE '%".$kom."%') and (master_pelabuhan.nama like '%bali%' and master_pelabuhan.nama_kota!=null) and nomor LIKE '".$tb."' and ".$tbl.".tanggal>='".$tglmulaifinal."' and ".$tbl.".tanggal<='".$tglakhirfinal."' order by tanggal desc");
			}
		}else{
			$tb = "%K%";
			$tbl = "kh11";
			$data['eksekutif'] = $this->eksekutif_model->getDataQuery("SELECT komoditas_hewan_kelas6.nama as nama_tum, komoditas_hewan_kelas6.nama_en, master_negara.nama as nama_negara, nama_penerima, master_satuan.nama as nama_sat, ppk_komoditas_hewan_detail.netto FROM 
			komoditas_hewan_kelas1 
			JOIN komoditas_hewan_kelas2 ON komoditas_hewan_kelas1.id=komoditas_hewan_kelas2.komoditas_hewan_kelas1_id
			JOIN komoditas_hewan_kelas3 ON komoditas_hewan_kelas2.id=komoditas_hewan_kelas3.komoditas_hewan_kelas2_id
			JOIN komoditas_hewan_kelas4 ON komoditas_hewan_kelas3.id=komoditas_hewan_kelas4.komoditas_hewan_kelas3_id
			JOIN komoditas_hewan_kelas5 ON komoditas_hewan_kelas4.id=komoditas_hewan_kelas5.komoditas_hewan_kelas4_id
			JOIN komoditas_hewan_kelas6 ON komoditas_hewan_kelas5.id=komoditas_hewan_kelas6.komoditas_hewan_kelas5_id
			JOIN ppk_komoditas_hewan_detail ON komoditas_hewan_kelas6.id=ppk_komoditas_hewan_detail.komoditas_hewan_kelas6_id
			JOIN ppk_komoditas_hewan ON ppk_komoditas_hewan_detail.ppk_komoditas_hewan_id=ppk_komoditas_hewan.id
			JOIN kh1 ON kh1.ppk_id=ppk_komoditas_hewan.ppk_id
			JOIN ppk ON ppk.id=ppk_komoditas_hewan.ppk_id
			JOIN master_satuan ON master_satuan.id=ppk_komoditas_hewan_detail.satuan_netto
			JOIN master_negara ON master_negara.id=ppk_komoditas_hewan_detail.negara_asal
			WHERE (komoditas_hewan_kelas6.nama_en LIKE '%".$kom."%' or komoditas_hewan_kelas6.nama LIKE '%".$kom."%') and kh1.tanggal>='".$tglmulaifinal."' and kh1.tanggal<='".$tglakhirfinal."' order by kh1.tanggal desc");
		}
		
		
		
		
		
		//var_dump($data);exit();
		$this->load->view('eksekutif/eksekutif',$data);
	}
	
	public function pilihanEksekutif(){
		$this->load->view('eksekutif/pilihan_eksekutif');
	}

	public function pilihanEksekutifTerlambat(){
		$data['eksekutif'] = $this->eksekutif_model->getDataQuery("SELECT pelabuhan_gudang, kt2.tanggal as tglkt2, nama_pemohon, sp1.tanggal as tglsp1, dp5.tanggal as tgldp5, kt9.tanggal as tglkt9 FROM 
		data_terlambat
		JOIN kt2 ON data_terlambat.no_sp2mp=kt2.nomor 
		JOIN sp1 ON kt2.ppk_id=sp1.ppk_id
		JOIN ppk ON kt2.ppk_id=ppk.id
		JOIN dp5 ON kt2.ppk_id=dp5.ppk_id
		JOIN kt9 ON dp5.ppk_id=kt9.ppk_id 
		WHERE nama_pemohon like '%basf%' and sp1.tanggal>='2018-02-01 08:32:16' and sp1.tanggal<='2018-11-26 08:27:33' limit 0,1000");
		$data['controller'] = $this;
		$this->load->view('eksekutif/eksekutif_terlambat',$data);
	}
	
	public function export($pos){
		var_dump($pos);exit();
	}

	public function durasi($t0,$t1){
		if ($t0=="" or $t1=="" or $t0=="0000-00-00 00:00:00" or $t1=="0000-00-00 00:00:00") {return "";} else {
		if ($t0<=$t1) { $min="+";
			$diff = strtotime($t1) - strtotime($t0);
		} else { $min="-";
			$diff = strtotime($t0) - strtotime($t1);
		}
			$d=(gmdate("d", $diff)-1);
			$h=gmdate("H", $diff);
			$i=gmdate("i", $diff);
		if ($d<=0) {$dd=""; } else {$dd="<b>".(gmdate("d", $diff)-1)."</b>h";}
		//return "<b>$min</b> $dd <b>".$h."</b>:<b>".$i."</b>";
		$menit=($d*24*60)+($h*60)+$i;
		$hari=($menit/1440)*1;
		return number_format($hari,2,",","");
		//return "<b>".gmdate("H", $diff)."</b>:<b>".gmdate("i", $diff)."</b>:<b>".gmdate("s", $diff)."</b>";
		}
	
	}
}
