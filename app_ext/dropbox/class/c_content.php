<?php

class content {
	
function form_periode() {	
return "<form method='post'>Tanggal: <input type=date name=mm value='".$this->mm()."'> sd. <input type=date name=ss value='".$this->ss()."'> No Aju: <input type='text' value='".$_POST['no_aju']."' name='no_aju'> Kode: <input type='text' value='".$_POST['kode']."' name='kode' size=5> NoReg <input type='text' value='".$_POST['no_reg']."' name='no_reg'><input type='submit' value='Show'> <input type='hidden' value='list' name='tab'></form>";
}
	
	
function mm() {
if ($_POST['mm']!="") {$mm=$_POST['mm'];} else {$mm=date("Y-m-d");}	
return $mm;
}	


function ss() {
if ($_POST['ss']!="") {$ss=$_POST['ss'];} else {$ss=date("Y-m-d"); }	
return $ss;	
}	

function status($s) {
$k=app_baca("m_status","status='".$s."'","ket");
if ($s!="") {return $k." (".$s.")";}

}	

function bg_status($s,$h) {
if ($s=="9") {$cls="class='green_all'";} elseif ($s=="3" and $h=="Tunda") {$cls="class='red_all'";} elseif ($s=="3") {$cls="class='yellow_all'";} elseif ($s=="1") {$cls="class='black_all'";} else {$cls="class='white_all'";}
return$cls;
}	

function oleh($id) {
return db_baca("user_login","karyawan","id='".$id."'","nama");
}

function perusahaan() {
$db = new database();
$db->connect(app_db());
$pc=$ac=$_POST['pc'];
if ($_POST['p']!=""){ 
$k=str_replace(" ","",$_POST['k']);
$k=str_replace("    ","",$k);
if ($k!="") {
app_replace("akun_pj", "'".$_POST['k']."','".$_POST['p']."','".now()."','".user_id()."',NULL,NULL,NULL");
$pc=$_POST['p'];
$ac=$_POST['k'];
$rep=date("H:i:s")." Update Berhasil";} 
else {$rep=date("H:i:s")." Update Gagal";}
}
echo "<form method=post>Tambah / Replace <input type=text name=k > Nama: <input type=text name=p> <input type=submit value='Replace'>".$rep."</form>
<form method=post>Cari Perusahaan: <input type=text name=pc autofocus> <input type=submit value='Cari'></form>
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>AKUN</th><th>NAMA PERUSAHAAN</th><th>WAKTU</th><th>BY</th><th>JALUR KHUSUS</th><th>BLOKIR</th></tr></thead><tbody>";
if ($_POST) {
$no=1;
$query = "SELECT * from akun_pj WHERE perusahaan LIKE '%".$pc."%' or akun LIKE '%".$ac."%' order by akun limit 0,100";
$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$e_p_2=app_baca("via_pj","akun='".$data['akun']."' and id_via='2_E_P'","id_via");

echo "<tr valign='top'><td>".$no."</td><td>".$data['akun']."</td><td>".$data['perusahaan']."</td><td>".$data['waktu']."</td><td>".$data['oleh']."</td><td>".$e_p_2."</td><td><a href='?t=BlokirPerusahaan&ak=".$data['akun']."&lnk=Perusahaan'>Blokir</a></td></tr>";

$no+=1; 

}
}
echo "</tbody></table>";
	
}	


function blokirperusahaan() {
$db = new database();
$db->connect(app_db());
$ak=$_GET['ak'];
$e_p_2=app_baca("via_pj","akun='".$ak."' and id_via='2_E_P'","id_via");
echo "<table><tr valign='top'><td>Akun</td><td>:</td><td>".$ak."</td></tr>
<tr><td>Perusahaan</td><td>:</td><td>".app_baca("akun_pj","akun='".$ak."'","perusahaan")."</td></tr>
<tr><td>Jalur Khusus</td><td>:</td><td>".$e_p_2."</td></tr>
</table>Blokir -> Alasan/Keterangan :<br>
<form method=post><input type=text name=alasan style='width:90%'> <input type=submit value='Simpan'></form>";
if ($_POST['alasan']!="") {
app_insert("akun_blokir","NULL,'".$ak."','".$_POST['alasan']."', '".now()."', '".user_id()."', '1', NULL,NULL"); 
}
if ($_POST['stop']=="Buka") {
app_update("akun_blokir","id='".$_POST['id']."'","stop_oleh= '".user_id()."', stop_waktu= '".now()."', aktif= '0'"); 
}

$query = "SELECT * FROM akun_blokir WHERE akun='".$ak."' order by waktu desc";
$results = $db->get_results( $query );
echo "
<table class=table width=100%>
<thead>
<tr><th>STATUS</th><th>WAKTU BLOKIR</th><th>KETERANGAN/ALASAN</th><th>BLOKIR OLEH</th><th>STOP PADA</th><th>STOP OLEH</th><th>EXE</th></tr></thead><tbody>";
foreach( $results as $data )
{
if ($data['aktif']=="1") {$st="BLOKIR AKTIF";$bk="<input type=hidden name=id value='".$data['id']."'><input type=submit name=stop value='Buka'>";$blokir+=1;} else {$st="";$bk="";}

echo "<tr valign='top'><td>".$st."</td><td>".$data['waktu']."</td><td>".$data['alasan']."</td><td>".$data['oleh']."</td><td>".$data['stop_waktu']."</td><td>".$data['stop_oleh']."</td><form method=post><td>".$bk."</td></form></tr>";
}
echo "</tbody></table><a href='?t=".$_GET['lnk']."'>Selesai</a>";
if ($blokir>0) {$b="1";} else {$b="0";}
app_replace("akun_pj_blokir","'".$ak."', '".$b."'"); 
}	


function perusahaanterblokir() {
$db = new database();
$db->connect(app_db());
echo "
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>AKUN</th><th>NAMA PERUSAHAAN</th><th>WAKTU</th><th>ALASAN/KETERANGAN</th><th>OLEH</th><th>BLOKIR</th></tr></thead><tbody>";

$no=1;
$query = "SELECT * from akun_pj join akun_pj_blokir ON akun_pj.akun=akun_pj_blokir.akun WHERE blokir>'0' order by perusahaan";
$results = $db->get_results( $query );

foreach( $results as $data )
{
echo "<tr valign='top'><td>".$no."</td><td>".$data['akun']."</td><td>".$data['perusahaan']."</td><td>".$data['waktu']."</td><td>".app_baca("akun_blokir","akun='".$data['akun']."' and aktif='1' order by waktu desc","alasan")."</td><td>".$this->oleh(app_baca("akun_blokir","akun='".$data['akun']."' and aktif='1' order by waktu desc","oleh"))."</td><td><a href='?t=BlokirPerusahaan&ak=".$data['akun']."&lnk=PerusahaanTerblokir'>Blokir Log</a></td></tr>";

$no+=1; 

}

echo "</tbody></table>";
	
}	

function printbarcode() {
$db = new database();
$db->connect(app_db());

echo "".$this->form_periode()."
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>WAKTU REQUEST</th><th>KODE DROPBOX</th><th>NO AJU</th><th>PERUSAHAAN</th><th>STATUS TERAKHIR</th><th>HASIL</th><th>KET</th><th>WAKTU STATUS</th><th>BY</th></tr></thead><tbody>";
$no=1;
$query = "SELECT update_time,kode,id,no_aju,last_status,last_hasil,last_ket,last_waktu,last_oleh from barcode WHERE update_time<='".$this->ss()." 23:59:59' and update_time>='".$this->mm()." 00:00:00' and no_aju LIKE '%".$_POST['no_aju']."%' order by update_time desc";
$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);
echo "<tr valign='top'><td>".$no."</td><td>".$data['update_time']."</td><td>".$data['kode']."</td><td><a href='dropbox/barcode.php?d=".$data['id']."' target='_blank'>".$data['no_aju']."</a></td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td><td>".$this->status($data['last_status'])."</td><td>".$data['last_hasil']."</td><td>".$data['last_ket']."</td><td>".$data['last_waktu']."</td><td>".$data['last_oleh']."</td></tr>";

$no+=1; 

}
echo "</tbody></table>";
	
}


function antri() {
$db = new database();
$db->connect(app_db());
$k=str_replace(" ","",$_POST['k']);
$k=str_replace("	","",$k);
$vi=explode("_",$_GET['via']);
$b=$vi[0];
$blokir=app_baca("akun_pj_blokir","akun='".substr($k,5,7)."'","blokir");
$w=$_GET['w'];
if ($w=="") {$w="00";}
if ($blokir>0) { 

$rep="<font style='color:red'>GAGAL!, ".app_baca("akun_pj","akun='".substr($k,5,7)."'","perusahaan")." <- MASIH DIBLOKIR -> ".app_baca("akun_blokir","akun='".substr($k,5,7)."' and aktif='1' order by waktu DESC","alasan")." <- by ".db_baca("user_login","karyawan","id='".app_baca("akun_blokir","akun='".substr($k,5,7)."' and aktif='1' order by waktu DESC","oleh")."'","nama")."</fornt>"; } 
elseif ($k!="") {
$idb=app_baca("barcode","(no_aju='".$k."' or no_aju='03".$w."-".$k."' or kode='".$k."') and no_aju LIKE '%-".$b."-%'","id");
$ls=app_baca("barcode","id='".$idb."'","last_status");
$lh=app_baca("barcode","id='".$idb."'","last_hasil");

if ($idb=="" and strstr($k,"-".$b."-") and strlen($k)>21 and substr($k,0,5)=="03".$w."-") {
app_query("INSERT INTO barcode (`no_aju`,`input_time`,`update_time`,`bidang`,`lintas`,`via`,`last_status`,`last_antri`,`last_waktu`,`last_oleh`,`wilker`) VALUES ('".$k."', '".now()."', '".now()."', '".$vi[0]."', '".$vi[1]."', '".$vi[2]."', '1', '".now()."', '".now()."', '".user_id()."', '".$w."')");
$idb=app_baca("barcode","no_aju='".$k."'","id");
app_update("barcode","id='".$idb."'","kode='".kode($idb)."'");
app_insert("antrian", "NULL,'".$idb."','".$vi[1]."','1',NULL,NULL,'".now()."','".user_id()."','0','0'");
$rep=date("H:i:s")." berhasil";
} 
elseif ($idb!="" and ($ls=="0" or $lh=="Tunda")) {
app_insert("antrian", "NULL,'".$idb."','".$vi[1]."','1',NULL,NULL,'".now()."','".user_id()."','0','0'");
app_update("barcode","id='".$idb."'","last_antri='".now()."',bidang='".$vi[0]."',lintas='".$vi[1]."',via='".$vi[2]."',last_status='1',last_hasil=NULL,last_ket=NULL,last_waktu='".now()."',last_oleh='".user_id()."',wilker='".$w."'");
$rep=date("H:i:s")." berhasil"; } else {
if ($idb=="") { $r="No AJu / Kode <b>".$k."</b> tidak ditemukan / tidak Valid";} else { $r="No Aju / Kode <b>".$k."</b> tidak sedang ditunda (masih diproses)";} 
$rep=date("H:i:s")." GAGAL: ".$r;}

}

echo "<form method=post>No Aju / Kode Dropbox: <input type=text name=k autofocus> <input type=submit value='Add'> ".$rep."</form>
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>KODE</th><th>WAKTU DROPPING</th><th>NO AJU</th><th>PERUSAHAAN</th><th>STATUS TERAKHIR</th><th>NO REG</th><th>SPPMP</th><th>HASIL</th><th>KET</th><th>WAKTU</th><th>BY</th></tr></thead><tbody>";
$no=1;
$query = "SELECT no_aju,last_status,last_antri,kode,no_reg,sppmp,last_hasil,last_ket,last_waktu,last_oleh from barcode WHERE lintas='".$vi[1]."' and via='".$vi[2]."' and no_aju LIKE '%-".$vi[0]."-%' and last_antri LIKE '".today()."%' and wilker='".$w."' order by last_antri";

$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);


echo "<tr valign='top' ".$this->bg_status($data['last_status'],$data['last_hasil'])."><td>".$no."</td><td>".$data['kode']."</td><td>".$data['last_antri']."</td><td>".$data['no_aju']."</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td><td>".app_baca("m_status","status='".$data['last_status']."'","ket")."(".$data['last_status'].")</td><td>".$data['no_reg']."</td><td>".$data['sppmp']."</td><td>".$data['last_hasil']."</td><td>".$data['last_ket']."</td><td>".$data['last_waktu']."</td><td>".$data['last_oleh']."</td></tr>";

$no+=1; 

}
echo "</tbody></table>";
	
}	


function verifikasi() {
$db = new database();
$db->connect(app_db());
$k=str_replace(" ","",$_POST['k']);
$vi=explode("_",$_GET['via']);
if ($k!="") {
$idb=app_baca("barcode","(no_aju='".$k."' or no_aju='0300-".$k."' or kode='".$k."') and no_aju LIKE '%-".$vi[0]."-%'","id");
if ($idb!="") {
app_insert("antrian", "NULL,'".$idb."','".$vi[1]."','2',NULL,NULL,'".now()."','".user_id()."','0','0'");
app_update("barcode","id='".$idb."'","last_status='2',last_hasil=NULL,last_ket=NULL,last_waktu='".now()."',last_oleh='".user_id()."'");
$rep=date("H:i:s")." berhasil";
} else {$rep=date("H:i:s")." GAGAL";}
}
echo "<form method=post>No Aju / Kode Dropbox: <input type=text name=k autofocus> <input type=submit value='Exe'> ".$rep."</form>
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>KODE</th><th>WAKTU ANTRI</th><th>NO AJU</th><th>PERUSAHAAN</th><th>STATUS</th><th>WAKTU</th><th>BY</th><th>EXE</th><th>KET</th></tr></thead><tbody>";
$no=1;
$query = "SELECT no_aju,last_status,last_antri,kode,no_aju,last_waktu,last_oleh from barcode WHERE lintas='".$vi[1]."' and no_aju LIKE '%-".$vi[0]."-%' and last_antri<='".today()." 24:00:00' and last_status='1' order by last_status asc,last_antri";

$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);
$inp="<input type=submit value='Start'>";
echo "<tr valign='top'><td>".$no."</td><td>".$data['kode']."</td><td>".$data['last_antri']."</td><td>".$data['no_aju']."</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td><td>".app_baca("m_status","status='".$data['last_status']."'","ket")."(".$data['last_status'].")</td><td>".$data['last_waktu']."</td><td>".$data['last_oleh']."</td><form method=post><td><input type=hidden name='k' value='".$data['kode']."'>".$inp."</td><td class=red>Belum Verifikasi</td></form></tr>";

$no+=1; 

}

echo "</tbody></table>";



}	
	



function rekomendasi() {
$vi=explode("_",$_GET['via']);
$k=str_replace(" ","",$_POST['k']);
if ($k!="") {
$idb=app_baca("barcode","(no_aju='".$k."' or no_aju='0300-".$k."' or kode='".$k."') and no_aju LIKE '%-".$vi[0]."-%'","id");
if ($idb!="") {

$this->rekom_proses($idb);
$rep=date("H:i:s")." Ditemukan";
} else {$rep=date("H:i:s")." Tidak Ditemukan";}
}

if ($_POST['id']!="") {
if ($_POST['hasil']=="Proses") {$ket=$_POST['sppmp'];} else {$ket=$_POST['ket'];}
app_insert("antrian", "NULL,'".$_POST['id']."','".$_GET['l']."','3','".$_POST['hasil']."','".$ket."','".now()."','".user_id()."','0','0'");
app_update("barcode","id='".$_POST['id']."'","last_status='3',last_hasil='".$_POST['hasil']."',last_ket='".$ket."',sppmp='".$_POST['sppmp']."',no_reg='".(($_POST['no_reg'])*1)."',last_waktu='".now()."',last_oleh='".user_id()."'");
if ($_POST['hasil']=="Tunda") { 
$this->kirimsms($id,"TUNDA krn ".$data['last_ket'].". NoAju ".$data['no_aju']."");
 }
}

if ($idb=="") {
echo "<form method=post>No Aju / Kode Dropbox: <input type=text name=k autofocus> <input type=submit value='Exe'> ".$rep."</form>";
$this->rekom_tabel(); }

}	

function rekom_proses($id) {
$db = new database();
$db->connect(app_db());
$query = "SELECT waktu,status,ket,oleh,no_reg,no_aju,kode,update_time,hasil from antrian join barcode ON barcode.id=antrian.id_barcode WHERE id_barcode='".$id."' order by waktu";
$results = $db->get_results( $query );

foreach( $results as $data )
{
$no+=1; 
$akun=substr($data['no_aju'],5,7);
$dt.="<tr valign='top'><td>".$no."</td><td>".$data['waktu']."</td><td>".app_baca("m_status","status='".$data['status']."'","ket")."(".$data['status'].")</td><td>".$data['hasil']."</td><td>".$data['ket']."</td><td>".$data['oleh']."</td></tr>";
}
echo "<table width='100%' class=table><form method=post>
<tr><td width='10%'>Rekomendasi</td><td width='1%'>:</td><td>
<input type='radio' name='hasil' value='Proses' checked> Proses* <input type='radio' name='hasil' value='Tunda'> Tunda**</td></tr>

<tr><td>*)Kategori SPPMP</td><td>:</td><td>
<input type='radio' name='sppmp' value='SPPMP'> SPPMP (NSW KT-9/KH-14) <input type='radio' name='sppmp' value='NonSPPMP'> NonSPPM (NSW KT-2/KH-5/KH-7) <input type='radio' name='sppmp' value='Bc23'> Bc-23 / Benih
</td></tr>
<tr><td>*)No. Dok (KT-2/KH-5)</td><td>:</td><td><input type=number name=no_reg value='".$data['no_reg']."'> (cukup nomor saja)</td></tr>
<tr><td>**)Alasan Tunda</td><td>:</td><td><input type=text name=ket style='width:100%'></td></tr>
<tr><td></td><td></td><td><input type=submit value=Simpan><input type=hidden value='".$id."' name=id></td></tr>

<tr><td>No Aju</td><td>:</td><td>".$data['no_aju']."</td></tr>
<tr><td>Kode Barcode</td><td>:</td><td>".$data['kode']."</td></tr>
<tr><td>Perusahaan</td><td>:</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td></tr>
<tr><td>Waktu Request Barcode</td><td>:</td><td>".$data['input_time']." :: ".$data['update_time']."</td></tr></form>
</table>
<h2>LOG SERVICES</h2>
<table class=table>

<tr><th>NO</th><th>WAKTU</th><th>STATUS</th><th>HASIL</th><th>KET</th><th>BY</th></tr>";
echo $dt."</table>";
}

function rekom_tabel() {
$vi=explode("_",$_GET['via']);
$db = new database();
$db->connect(app_db());
echo "
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>KODE</th><th>WAKTU DROPPING</th><th>NO AJU</th><th>PERUSAHAAN</th><th>STATUS</th><th>WAKTU</th><th>BY</th><th>EXE</th><th>KET</th></tr></thead><tbody>";
$no=1;

$query = "SELECT no_aju,last_status,via,update_time,tgl_periksa,last_antri,kode,no_reg,sppmp,last_hasil,last_ket,last_waktu,last_oleh,kode from barcode WHERE lintas='".$vi[1]."' and no_aju LIKE '%-".$vi[0]."-%' and last_status='2' order by last_status asc,last_antri asc";

$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);
if (strstr($data['via'],"P")) {$tgl=$data['update_time'];$tgl_p=$data['tgl_periksa'];} else {$tgl=$data['last_antri'];$tgl_p="";}
$inp="<input type=submit value='Start'>";
echo "<tr valign='top'><td>".$no."</td><td>".$data['kode']."</td><td>".$tgl."</td><td>".$data['no_aju']."</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td><td>".app_baca("m_status","status='".$data['last_status']."'","ket")."(".$data['last_status'].")</td><td>".$data['last_waktu']."</td><td>".$data['last_oleh']."</td><form method=post><td><input type=hidden name='k' value='".$data['kode']."'>".$inp."</td></form><td class=red>Belum Rekomendasi</td></tr>";

$no+=1; 

}
echo "</tbody></table>";
}






function respon() {
$vi=explode("_",$_GET['via']);
$k=str_replace(" ","",$_POST['k']);
$w=$_GET['w'];
if ($w=="") {$w="00";}
if ($k!="") {
$idb=app_baca("barcode","(no_aju='".$k."' or no_aju='03".$w."-".$k."' or kode='".$k."') and no_aju LIKE '%-".$vi[0]."-%'","id");
if ($idb!="") {

$this->respon_proses($idb);
$rep=date("H:i:s")." Ditemukan";
} else {$rep=date("H:i:s")." Tidak Ditemukan";}
}

if ($_POST['id']!="") {
if ($_POST['hasil']=="Proses") {$ket=$_POST['sppmp'];} else {$ket=$_POST['ket'];}
app_insert("antrian", "NULL,'".$_POST['id']."','".$vi[1]."','3','".$_POST['hasil']."','".$ket."','".now()."','".user_id()."','0','0'");
app_update("barcode","id='".$_POST['id']."'","last_status='9',last_hasil='".$_POST['hasil']."',last_ket='".$ket."',sppmp='".$_POST['sppmp']."',no_reg='".substr($_POST['no_reg'],-26)."',last_waktu='".now()."',last_oleh='".user_id()."'");
}

if ($idb=="") {
echo "<form method=post>No Aju / Kode Dropbox: <input type=text name=k autofocus> <input type=submit value='Exe'> ".$rep."</form>";
$this->respon_tabel(); }

}	

function respon_proses($id) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from  barcode  WHERE id='".$id."'";
$results = $db->get_results( $query );

foreach( $results as $data )
{
$no+=1; 
$akun=substr($data['no_aju'],5,7);
}
if ($data['no_reg']=="") {$noreg="2019.2.03".$data['wilker'].".0.S01.E.";} else {$noreg=$data['no_reg'];}
echo "<table width='100%' class=table><form method=post>
<tr class=yellow_all><td width='10%'>Rekomendasi</td><td width='1%'>:</td><td>
<input type='radio' name='hasil' value='Proses' checked> Proses* <input type='radio' name='hasil' value='Tunda'> Tunda**</td></tr>
<input type=hidden value='Ekspor' name=sppmp>
<tr class=yellow_all><td>*)No. Dok (KT-2/KH-5)</td><td>:</td><td><input type=text name=no_reg value='".$noreg."'></td></tr>
<tr class=yellow_all><td>**)Alasan Tunda</td><td>:</td><td><input type=text name=ket style='width:100%'></td></tr>
<tr><td></td><td></td><td><input type=submit value=Simpan><input type=hidden value='".$id."' name=id></td></tr>

<tr><td>No Aju</td><td>:</td><td>".$data['no_aju']."</td></tr>
<tr><td>Kode Barcode</td><td>:</td><td>".$data['kode']."</td></tr>
<tr><td>Perusahaan</td><td>:</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td></tr>
<tr><td>Waktu Request Barcode</td><td>:</td><td>".$data['input_time']." :: ".$data['update_time']."</td></tr></form>
</table>
";
}

function respon_tabel() {
$vi=explode("_",$_GET['via']);
$db = new database();
$db->connect(app_db());
echo "
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>AKSI</th><th>WAKTU ANTRI</th><th>KODE DROPBOX</th><th>NO AJU</th><th>NO REG</th><th>KAT SPPMP</th><th>PERUSAHAAN</th><th>TGL PERIKSA</th><th>STATUS</th><th>HASIL</th><th>KET</th><th>WAKTU</th><th>BY</th><th>EXE</th></tr></thead><tbody>";
$no=1;

$w=$_GET['w'];
if ($w=="") {$w="00";}
$query = "SELECT * from barcode WHERE via='".$vi[2]."' and lintas='".$vi[1]."' and no_aju LIKE '%-".$vi[0]."-%' and last_status='1' and wilker='".$w."' order by last_status asc,last_antri asc";

$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);
if ($data['last_status']=="3") {$st="<td class=green>Sudah Rekomendasi</td>";$inp=""; } else {$st="<td class=red>Belum Rekomendasi</td>"; $inp="<input type=submit value='Start'>"; }
if (strstr($data['via'],"P")) {$tgl=$data['update_time'];$tgl_p=$data['tgl_periksa'];} else {$tgl=$data['last_antri'];$tgl_p="";}

echo "<tr valign='top'><td>".$no."</td>".$st."<td>".$tgl."</td><td>".$data['kode']."</td><td>".$data['no_aju']."</td><td>".$data['no_reg']."</td><td>".$data['sppmp']."</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td><td>".$tgl_p."</td><td>".app_baca("m_status","status='".$data['last_status']."'","ket")."(".$data['last_status'].")</td><td>".$data['last_hasil']."</td><td>".$data['last_ket']."</td><td>".$data['last_waktu']."</td><td>".$data['last_oleh']."</td><form method=post><td><input type=hidden name='k' value='".$data['kode']."'>".$inp."</td></form></tr>";

$no+=1; 

}
echo "</tbody></table>";
}


function kirimsms($id,$txt) {
$no_aju=app_baca("barcode","id='".$id."'","no_aju");
$no_reg=app_baca("barcode","id='".$id."'","no_reg");
$akun=substr($no_aju,5,7);
$hp=app_baca("akun_pj","akun='".$akun."'","hp");
//$hp="085215025655";
//$hp="081215566699";
//$hp="08128899247";
$txt="".$txt.". No Aju ".substr($no_aju,13,20).", NoReg ".substr($no_reg,-8).". by KarantinaPriok";
$txt=substr($txt,0,160);
if (strlen($hp)>8) {
db_query("smsd","INSERT INTO outbox (DestinationNumber, TextDecoded, CreatorID) VALUES ('".$hp."', '".$txt."', 'Gammu')");
}
}



function notifikasidokumen() {

$k=str_replace(" ","",$_POST['k']);
if ($k!="") {
$idb=app_baca("barcode","(no_aju='".$k."' or no_aju='0300-".$k."' or kode='".$k."') and no_aju LIKE '%-".$_GET['b']."-%'","id");
if ($idb!="") {

$this->notifikasidokumen_proses($idb);
$rep=date("H:i:s")." Ditemukan";
} else {$rep=date("H:i:s")." Tidak Ditemukan";}
}

if ($_POST['id']!="") {
app_insert("antrian", "NULL,'".$_POST['id']."','".$_GET['l']."','4','".$_POST['hasil']."','".$_POST['ket']."','".now()."','".user_id()."','0','0'");
$sppmp=app_baca("barcode","id='".$_POST['id']."'","sppmp");

if ($_FILES["dok_k"]["name"]!="") {
$target_dir = "../../../prioqklik/dok/k/";
$target_file = $target_dir . basename($_FILES["dok_k"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$filenya=str_replace(".".$imageFileType,"",$_FILES["dok_k"]["name"])."_".$_POST['id'].".".$imageFileType;
$namefile=$target_dir . $filenya;
move_uploaded_file($_FILES["dok_k"]["tmp_name"], $namefile);
//app_update("barcode","id='".$_POST['id']."'","dok_k='".$filenya."'");
$dok_k=$filenya;
$aa=1;
}

if ($_FILES["dok_s"]["name"]!="") {
$target_dir = "../../../prioqklik/dok/s/";
$target_file = $target_dir . basename($_FILES["dok_s"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$filenya=str_replace(".".$imageFileType,"",$_FILES["dok_s"]["name"])."_".$_POST['id'].".".$imageFileType;
$namefile=$target_dir . $filenya;
move_uploaded_file($_FILES["dok_s"]["tmp_name"], $namefile);
//app_update("barcode","id='".$_POST['id']."'","dok_s='".$dok_s."'");
$dok_s=$filenya;
$bb=1;
}


if ($sppmp=="SPPMP" and ($aa+$bb)>=2) {
app_update("barcode","id='".$_POST['id']."'","last_status='9',last_hasil='Terbit SPPMP',last_ket='INSW KT-9 / KH-14',no_reg='".$_POST['no_reg']."',last_waktu='".now()."',last_oleh='".user_id()."',dok_k='".$dok_k."',dok_s='".$dok_s."'");
//$this->kirimsms($_POST['id'],"KT-2 & SPPMP telah Terbit");
}
elseif ($sppmp=="Bc23"  and $aa==1) {
app_update("barcode","id='".$_POST['id']."'","last_status='9',last_hasil='".$hasil."',last_ket='".$ket."',no_reg='".$_POST['no_reg']."',last_waktu='".now()."',last_oleh='".user_id()."',dok_k='".$dok_k."',dok_s='".$dok_s."'");
}
elseif ($aa>=1) {
app_update("barcode","id='".$_POST['id']."'","last_status='4',last_hasil='".$hasil."',last_ket='".$ket."',no_reg='".$_POST['no_reg']."',last_waktu='".now()."',last_oleh='".user_id()."',dok_k='".$dok_k."',dok_s='".$dok_s."'");
} else {echo "GAGAL";}


}

if ($idb=="") {
echo "<form method=post>No Aju / Kode Dropbox: <input type=text name=k autofocus> <input type=submit value='Exe'> ".$rep."</form>";
$this->notifikasidokumen_tabel(); }

}	

function notifikasidokumen_proses($id) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from antrian join barcode ON barcode.id=antrian.id_barcode WHERE id_barcode='".$id."' order by waktu";
$results = $db->get_results( $query );

foreach( $results as $data )
{
$no+=1; 
$akun=substr($data['no_aju'],5,7);
$dt.="<tr valign='top'><td>".$no."</td><td>".$data['waktu']."</td><td>".app_baca("m_status","status='".$data['status']."'","ket")."(".$data['status'].")</td><td>".$data['hasil']."</td><td>".$data['ket']."</td><td>".$data['oleh']."</td></tr>";
}

if ($data['sppmp']=="SPPMP") {
$upsppmp="<tr class='yellow_all'><td>Upload SPPMP (.pdf)</td><td>:</td><td><input type=file name=dok_s></td></tr>
<input type=hidden name=hasil value='Terbit KT-2 & SPPMP'>
";
} else {$upsppmp="<input type=hidden name=hasil value='Terbit KT-2'>";}

echo "<table width='100%' class=table><form method=post enctype='multipart/form-data'>
<tr><td width='10%'>Rekomendasi</td><td width='1%'>:</td><td>".app_baca("antrian","status='3' and id_barcode='".$id."' order by waktu desc","hasil")."</td></tr>

<tr><td>*)Kategori SPPMP</td><td>:</td><td>".$data['sppmp']."
</td></tr>
<tr class='yellow_all'><td>*)No. Dok (KT-2/KH-5)</td><td>:</td><td><input type=number name=no_reg value='".$data['no_reg']."'> (cukup nomor saja)</td></tr>
<tr class='yellow_all'><td>Upload KT-2/KH-5 (.pdf)</td><td>:</td><td><input type=file name=dok_k></td></tr>".$upsppmp."
<tr><td></td><td></td><td><input type=submit value=Simpan><input type=hidden value='".$id."' name=id></td></tr>

<tr><td>No Aju</td><td>:</td><td>".$data['no_aju']."</td></tr>
<tr><td>Kode Barcode</td><td>:</td><td>".$data['kode']."</td></tr>
<tr><td>Perusahaan</td><td>:</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td></tr>
<tr><td>Waktu Request Barcode</td><td>:</td><td>".$data['input_time']." :: ".$data['update_time']."</td></tr></form>
</table>
<h2>LOG DATA</h2>
<table class=table>

<tr><th>NO</th><th>WAKTU</th><th>STATUS</th><th>HASIL</th><th>KET</th><th>BY</th></tr>";
echo $dt."</table>";
}



function notifikasidokumen_tabel() {
$db = new database();
$db->connect(app_db());

echo "
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>KODE</th><th>WAKTU DROPPING</th><th>NO AJU</th><th>NO REG</th><th>PERUSAHAAN</th><th>STATUS</th><th>HASIL</th><th>KAT SPPMP</th><th>WAKTU</th><th>BY</th><th>EXE</th><th>KET</th></tr></thead><tbody>";
$no=1;

$query = "SELECT no_aju,kode,last_antri,no_aju,no_reg,last_status,last_hasil,sppmp,last_waktu,last_oleh from barcode WHERE lintas='".$_GET['l']."' and no_aju LIKE '%-".$_GET['b']."-%' and ( (last_status='3' and last_hasil='Proses'))  order by last_status asc,last_antri asc";

$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);

$inp="<input type=submit value='Start'>"; 
echo "<tr valign='top'><td>".$no."</td>".$st."<td>".$data['kode']."</td><td>".$data['last_antri']."</td><td>".$data['no_aju']."</td><td>".$data['no_reg']."</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td><td>".app_baca("m_status","status='".$data['last_status']."'","ket")."(".$data['last_status'].")</td><td>".$data['last_hasil']."</td><td>".$data['sppmp']."</td><td>".$data['last_waktu']."</td><td>".$data['last_oleh']."</td><form method=post><td><input type=hidden name='k' value='".$data['kode']."'>".$inp."</td><td class=red>Belum Notifikasi</td></form></tr>";

$no+=1; 

}
echo "</tbody></table>";



}	





function pengesahan() {
$db = new database();
$db->connect(app_db());
$k=str_replace(" ","",$_POST['k']);
if ($k!="") {
$idb=app_baca("barcode","(no_aju='".$k."' or no_aju='0300-".$k."' or kode='".$k."') and no_aju LIKE '%-".$_GET['b']."-%'","id");
if ($idb!="") {
app_insert("antrian", "NULL,'".$idb."','".$_GET['l']."','10','','','".now()."','".user_id()."','0','0'");
app_update("barcode","id='".$idb."'","sah='1'");
$rep=date("H:i:s")." berhasil";
} else {$rep=date("H:i:s")." GAGAL";}
}
echo "<form method=post>Sudah DiUpload-> No Aju / Kode Dropbox: <input type=text name=k autofocus> <input type=submit value='Exe'> ".$rep."</form>
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>WAKTU ANTRI</th><th>KODE</th><th>NO AJU</th><th>NO REG</th><th>KAT SPPMP</th><th>PERUSAHAAN</th><th>STATUS</th><th>KT2 KH5</th><th>SPPMP</th><th>SAHKAN?</th></tr></thead><tbody>";
$no=1;

$query = "SELECT * from barcode WHERE lintas='".$_GET['l']."' and no_aju LIKE '%-".$_GET['b']."-%' and sah='0' and last_status>='4' and no_reg IS NOT NULL order by last_antri asc limit 0,200";

$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);
echo "<tr valign='top'><td>".$no."</td><td>".$data['last_antri']."</td><td>".$data['kode']."</td><td>".$data['no_aju']."</td><td>".$data['no_reg']."</td><td>".$data['sppmp']."</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td><td>".app_baca("m_status","status='".$data['last_status']."'","ket")."(".$data['last_status'].")</td>
<td><a target='_blank' href='../../../prioqklik/dok/k/".$data['dok_k']."'>".substr($data['dok_k'],0,6)."</a></td>
<td><a target='_blank' href='../../../prioqklik/dok/s/".$data['dok_s']."'>".substr($data['dok_s'],0,6)."</a></td>
<form method=post><td align='center'><input type=hidden name='k' value='".$data['kode']."'><input type=submit value=' Ok '></td></form></tr>";

$no+=1; 

}
echo "</tbody></table>";

}	


function notifikasipnbp() {

$k=str_replace(" ","",$_POST['k']);

if ($k!="") {
$idb=app_baca("barcode","no_aju='".$k."' or no_aju='0300-".$k."' or kode='".$k."'","id");
if ($idb!="") {
if ($_POST['submit']=="Invalid") {
app_insert("antrian", "NULL,'".$idb."','".$_GET['l']."','5','Bukti Bayar Tidak Valid',NULL,'".now()."','".user_id()."','0','0'");
app_update("barcode","id='".$idb."'","last_status='5',last_hasil='Bukti Bayar Tidak Valid',last_waktu='".now()."',last_oleh='".user_id()."'");
$rep=date("H:i:s")." berhasil";
$this->notifikasipnbp_tabel();
} 
elseif ($_POST['submit']=="Valid") {
app_insert("antrian", "NULL,'".$idb."','".$_GET['l']."','7','Valid',NULL,'".now()."','".user_id()."','0','0'");
app_update("barcode","id='".$idb."'","last_status='7',last_hasil='Valid',last_waktu='".now()."',last_oleh='".user_id()."'");
$rep=date("H:i:s")." berhasil";
$this->notifikasipnbp_tabel();
} 

else {
$this->notifikasipnbp_proses($idb); }
$rep=date("H:i:s")." Ditemukan";
} else {$rep=date("H:i:s")." Tidak Ditemukan";}
}

if ($_POST['id']!="" and $_POST['billing']!="" and $_POST['pnbp']!="" ) {
if ($_FILES["dok_t"]["name"]!="") {
$target_dir = "../../../prioqklik/dok/t/";
$target_file = $target_dir . basename($_FILES["dok_t"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$filenya=str_replace(".".$imageFileType,"",$_FILES["dok_t"]["name"])."_".$_POST['id'].".".$imageFileType;
$namefile=$target_dir . $filenya;
move_uploaded_file($_FILES["dok_t"]["tmp_name"], $namefile);
app_update("barcode","id='".$_POST['id']."'","dok_t='".$filenya."'");
//$dok_t=$filenya;
$aa=1;
}

if ($_FILES["dok_w"]["name"]!="") {
$target_dir = "../../../prioqklik/dok/w/";
$target_file = $target_dir . basename($_FILES["dok_w"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$filenya=str_replace(".".$imageFileType,"",$_FILES["dok_w"]["name"])."_".$_POST['id'].".".$imageFileType;
$namefile=$target_dir . $filenya;
move_uploaded_file($_FILES["dok_w"]["tmp_name"], $namefile);
app_update("barcode","id='".$_POST['id']."'","dok_w='".$filenya."'");
//$dok_s=$filenya;
$bb=1;
}


$ket="Kode Billing: ".$_POST['billing']." Nominal: ".rp($_POST['pnbp']);
app_insert("antrian", "NULL,'".$_POST['id']."','".$_GET['l']."','5','".$_POST['hasil']."','".$ket."','".now()."','".user_id()."','0','0'");
$sppmp=app_baca("barcode","id='".$_POST['id']."'","sppmp");

app_update("barcode","id='".$_POST['id']."'","last_status='5',last_hasil='".$hasil."',last_ket='".$ket."',last_waktu='".now()."',last_oleh='".user_id()."',billing='".$_POST['billing']."',pnbp='".$_POST['pnbp']."'");

$this->kirimsms($_POST['id'],"Tagihan PNBP ".$ket."");
$eks=app_jml("request_billing","id_barcode='".$_POST['id']."'","id_barcode");
if ($eks>0) {app_update("request_billing","id_barcode='".$_POST['id']."'","respon='1',respon_pada='".now()."',respon_oleh='".user_id()."'");
echo "<meta http-equiv=\"refresh\" content=\"0; URL=?t=RequestBilling\">";} 

}

if ($idb=="") {
echo "<form method=post>No Aju / Kode Dropbox: <input type=text name=k autofocus> <input type=submit value='Exe'> ".$rep."</form>";
$this->notifikasipnbp_tabel(); }

}	

function notifikasipnbp_proses($id) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from antrian join barcode ON barcode.id=antrian.id_barcode WHERE id_barcode='".$id."' order by waktu";
$results = $db->get_results( $query );

foreach( $results as $data )
{
$no+=1; 
$akun=substr($data['no_aju'],5,7);
$dt.="<tr valign='top'><td>".$no."</td><td>".$data['waktu']."</td><td>".app_baca("m_status","status='".$data['status']."'","ket")."(".$data['status'].")</td><td>".$data['hasil']."</td><td>".$data['ket']."</td><td>".$data['oleh']."</td></tr>";
}

echo "<table width='100%' class=table><form method=post enctype='multipart/form-data'>
<tr><td width='10%'>Rekomendasi</td><td width='1%'>:</td><td>".app_baca("antrian","status='3' and id_barcode='".$id."' order by waktu desc","hasil")."</td></tr>

<tr><td>*)Kategori SPPMP</td><td>:</td><td>".$data['sppmp']."
</td></tr>
<tr><td>*)No. Dok (KT-2/KH-5)</td><td>:</td><td>".$data['no_reg']."</td></tr>
<input type=hidden name=hasil value='Tagihan PNBP'>
<tr class='yellow_all'><td>Kode Billing</td><td>:</td><td><input type=text name=billing></td></tr>
<tr class='yellow_all'><td>Tagihan PNBP</td><td>:</td><td><input type=text name=pnbp></td></tr>
<tr class='yellow_all'><td>Bukti Tagih (.pdf)</td><td>:</td><td><input type=file name=dok_t></td></tr>
<tr class='yellow_all'><td>Kwitansi (.pdf)</td><td>:</td><td><input type=file name=dok_w></td></tr>
<tr><td></td><td></td><td><input type=submit value=Simpan><input type=hidden value='".$id."' name=id></td></tr>

<tr><td>No Aju</td><td>:</td><td>".$data['no_aju']."</td></tr>
<tr><td>Kode Barcode</td><td>:</td><td>".$data['kode']."</td></tr>
<tr><td>Perusahaan</td><td>:</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td></tr>
<tr><td>Waktu Request Barcode</td><td>:</td><td>".$data['input_time']." :: ".$data['update_time']."</td></tr></form>
</table>
<h2>LOG SERVICES</h2>
<table class=table>

<tr><th>NO</th><th>WAKTU</th><th>STATUS</th><th>HASIL</th><th>KET</th><th>BY</th></tr>";
echo $dt."</table>";
}



function notifikasipnbp_tabel() {
$db = new database();
$db->connect(app_db());

echo "
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>KET</th><th>WAKTU ANTRI</th><th>KODE</th><th>NO AJU</th><th>NO REG</th><th>KAT SPPMP</th><th>PERUSAHAAN</th><th>STATUS</th><th>HASIL</th><th>KET</th><th>KT2 KH5</th><th>TAGIH</th><th>KWT</th><th>BUKTI BAYAR</th><th>WAKTU</th><th>BY</th><th>EXE</th><th>EXE</th></tr></thead><tbody>";
$no=1;

$query = "SELECT * from barcode WHERE lintas='".$_GET['l']."' and no_aju LIKE '%-".$_GET['b']."-%' and ( (last_status='4' and sppmp='NonSPPMP') or  last_status='5' or  last_status='6') order by last_status asc,last_antri asc";

$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);
if ($data['last_status']=="5") {$st="<td class=green>Sudah Notifikasi</td>";$inp="<input type=submit value='Valid' name=submit>"; $inp2=""; 
if ($data['last_ket']!="") {
$this->kirimsms($id,"Tagihan PNBP ".$data['last_ket'].". NoAju ".$data['no_aju']." NoReg ".substr($data['no_reg'],-7)."");
}
} elseif ($data['last_status']=="6") {$st="<td class=green>Sudah Dibayar</td>";$inp="<input type=submit value='Valid' name=submit>"; $inp2="<input type=submit value='Invalid' name=submit>"; 
} else {$st="<td class=red>Belum Notifikasi PNBP</td>"; $inp="<input type=submit value='Start'>";$inp2="";  }

echo "<tr valign='top'><td>".$no."</td>".$st."<td>".$data['last_antri']."</td><td>".$data['kode']."</td><td>".$data['no_aju']."</td><td>".$data['no_reg']."</td><td>".$data['sppmp']."</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td><td>".app_baca("m_status","status='".$data['last_status']."'","ket")."(".$data['last_status'].")</td><td>".$data['last_hasil']."</td><td>".$data['last_ket']."</td>
<td><a target='_blank' href='../../../prioqklik/dok/k/".$data['dok_k']."'>".substr($data['dok_k'],0,6)."</a></td>
<td><a target='_blank' href='../../../prioqklik/dok/t/".$data['dok_t']."'>".substr($data['dok_t'],0,6)."</a></td>
<td><a target='_blank' href='../../../prioqklik/dok/w/".$data['dok_w']."'>".substr($data['dok_w'],0,6)."</a></td>
<td><a target='_blank' href='../../../prioqklik/dok/b/".$data['bukti_bayar']."'>".substr($data['bukti_bayar'],0,6)."</a></td>
<td>".$data['last_waktu']."</td><td>".$data['last_oleh']."</td><form method=post><td><input type=hidden name='k' value='".$data['kode']."'>".$inp."</td></form><form method=post><td><input type=hidden name='k' value='".$data['kode']."'>".$inp2."</td></form></tr>";

$no+=1; 

}
echo "</tbody></table>";



}	



function konfirmasi() {
$db = new database();
$db->connect(app_db());
$k=str_replace(" ","",$_POST['k']);
if ($k!="") {
$idb=app_baca("barcode","(no_aju='".$k."' or no_aju='0300-".$k."' or kode='".$k."') and no_aju LIKE '%-".$_GET['b']."-%'","id");
if ($idb!="") {
app_insert("antrian", "NULL,'".$idb."','".$_GET['l']."','6','Valid',NULL,'".now()."','".user_id()."','0','0'");
app_update("barcode","id='".$idb."'","last_status='6',last_hasil='Valid',last_ket=NULL,last_waktu='".now()."',last_oleh='".user_id()."'");
$rep=date("H:i:s")." berhasil";
} else {$rep=date("H:i:s")." GAGAL";}
}
echo "<form method=post>Validasi -> No Aju / Kode Dropbox: <input type=text name=k autofocus> <input type=submit value='Exe'> ".$rep."</form>
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>AKSI</th><th>WAKTU ANTRI</th><th>KODE DROPBOX</th><th>NO AJU</th><th>NO REG</th><th>KAT SPPMP</th><th>PERUSAHAAN</th><th>STATUS</th><th>HASIL</th><th>KET</th><th>WAKTU</th><th>BY</th><th>EXE</th></tr></thead><tbody>";
$no=1;

$query = "SELECT * from barcode WHERE last_lintas='".$_GET['l']."' and no_aju LIKE '%-".$_GET['b']."-%' and (last_status='4' or last_status='5') order by last_status asc,last_antri asc";

$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);
if ($data['last_status']=="5") {$st="<td class=green>Sudah Divalidasi</td>";$inp=""; } elseif ($data['last_status']=="4") {$st="<td class=yellow>Sudah Bayar</td>";$inp="<input type=submit value='Valid'>"; } else  {$st="<td class=red>Belum Bayar</td>"; $inp=""; }

echo "<tr valign='top'><td>".$no."</td>".$st."<td>".$data['last_antri']."</td><td>".$data['kode']."</td><td>".$data['no_aju']."</td><td>".$data['no_reg']."</td><td>".$data['sppmp']."</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td><td>".app_baca("m_status","status='".$data['last_status']."'","ket")."(".$data['last_status'].")</td><td>".$data['last_hasil']."</td><td>".$data['last_ket']."</td><td>".$data['last_waktu']."</td><td>".$data['last_oleh']."</td><form method=post><td><input type=hidden name='k' value='".$data['kode']."'>".$inp."</td></form></tr>";

$no+=1; 

}

echo "</tbody></table>";
}	
	

function requestbilling() {
$db = new database();
$db->connect(app_db());
if ($_POST['submit']=="Invalid") {
app_insert("antrian", "NULL,'".$_POST['id']."','E','5','Bukti Bayar Tidak Valid',NULL,'".now()."','".user_id()."','0','0'");
app_update("barcode","id='".$_POST['id']."'","last_status='5',last_hasil='Bukti Bayar Tidak Valid',last_waktu='".now()."',last_oleh='".user_id()."'");

} 
elseif ($_POST['submit']=="Valid") {
app_insert("antrian", "NULL,'".$_POST['id']."','E','7','Valid',NULL,'".now()."','".user_id()."','0','0'");
app_update("barcode","id='".$_POST['id']."'","last_status='7',last_hasil='Valid',last_waktu='".now()."',last_oleh='".user_id()."'");

} 

echo "<form method=post>Validasi -> No Aju / Kode Dropbox: <input type=text name=k autofocus> <input type=submit value='Exe'> ".$rep."</form>
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>KET</th><th>TGL CETAK</th><th>KODE</th><th>PERUSAHAAN</th><th>NO AJU</th><th>NO REG</th><th>VOLUME</th><th>DESKRIPSI</th><th>HASIL</th><th>KET</th><th>DRAFT</th><th>TAGIH KWT BUKTI</th><th>WAKTU</th><th>BY</th><th>EXE</th><th>EXE</th></tr></thead><tbody>";
$no=1;

$query = "SELECT * from barcode JOIN request_billing ON barcode.id=request_billing.id_barcode WHERE lintas='E' and (respon='0' or last_status='4'  or  last_status='5' or  last_status='6')  order by tgl_cetak asc,input_time asc";

$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);

if ($data['last_status']=="5") {$st="<td class=green>Sudah Notifikasi</td>";$inp="<input type=submit value='Valid' name=submit>"; $inp2=""; 

if ($data['last_ket']!="") {$this->kirimsms($id,"Tagihan PNBP ".$data['last_ket'].". NoAju ".$data['no_aju']." NoReg ".substr($data['no_reg'],-7)."");}
$act="";
} elseif ($data['last_status']=="6") {$st="<td class=green>Sudah Dibayar</td>";$inp="<input type=submit value='Valid' name=submit>"; $inp2="<input type=submit value='Invalid' name=submit>"; $act="";
} else {$st="<td class=red>Belum Notifikasi PNBP</td>"; $inp="<input type=submit value='Start'>";$inp2="";$act="action='?t=NotifikasiPNBP'"; }

$inid="<input type=hidden name='id' value='".$data['id_barcode']."'>";
echo "<tr valign='top'><td>".$no."</td>".$st."<td>".$data['tgl_cetak']."</td><td>".$data['kode']."</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td><td>".$data['no_aju']."</td><td>".substr($data['no_reg'],-8)."</td><td>".$data['volume']."</td><td>".$data['ket']."</td><td>".$data['last_hasil']."</td><td>".$data['last_ket']."</td>
<td><a target='_blank' href='../../../prioqklik/phyto/form_adm.php?d=".$data['id_barcode']."'>Draft</a></td>
<td><a target='_blank' href='../../../prioqklik/dok/t/".$data['dok_t']."'>".substr($data['dok_t'],0,6)."</a> 
<a target='_blank' href='../../../prioqklik/dok/w/".$data['dok_w']."'>".substr($data['dok_w'],0,6)."</a> 
<a target='_blank' href='../../../prioqklik/dok/b/".$data['bukti_bayar']."'>".substr($data['bukti_bayar'],0,6)."</a></td>
<td>".$data['last_waktu']."</td><td>".$data['last_oleh']."</td>
<form method=post ".$act."><td><input type=hidden name='k' value='".$data['kode']."'>".$inp.$inid."</td></form><form method=post><td><input type=hidden name='k' value='".$data['kode']."'>".$inp2.$inid."</td></form>
</tr>";

$no+=1; 

}

echo "</tbody></table>";
}	
	

function kirimnsw() {
$db = new database();
$db->connect(app_db());
$k=str_replace(" ","",$_POST['k']);
if ($k!="") {
$idb=app_baca("barcode","(no_aju='".$k."' or no_aju='0300-".$k."' or kode='".$k."') and no_aju LIKE '%-".$_GET['b']."-%'","id");
if ($idb!="") {
app_insert("antrian", "NULL,'".$idb."','".$_GET['l']."','9','KirimNSW','KT-2/KH-5 Telah diKirim','".now()."','".user_id()."','0','0'");
app_update("barcode","id='".$idb."'","last_status='9',last_hasil='KirimNSW',last_ket='KT-2/KH-5 Telah diKirim',last_waktu='".now()."',last_oleh='".user_id()."'");
$rep=date("H:i:s")." berhasil";
} else {$rep=date("H:i:s")." GAGAL";}
}
echo "<form method=post>Sudah DiUpload-> No Aju / Kode Dropbox: <input type=text name=k autofocus> <input type=submit value='Exe'> ".$rep."</form>
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>AKSI</th><th>WAKTU ANTRI</th><th>KODE DROPBOX</th><th>NO AJU</th><th>NO REG</th><th>KAT SPPMP</th><th>PERUSAHAAN</th><th>STATUS</th><th>HASIL</th><th>KET</th><th>WAKTU</th><th>BY</th><th>EXE</th></tr></thead><tbody>";
$no=1;
$query = "SELECT no_aju,last_antri,kode,no_reg,sppmp,last_status,last_hasil,last_ket,last_waktu,last_oleh from barcode WHERE lintas='".$_GET['l']."' and no_aju LIKE '%-".$_GET['b']."-%' and last_status='7' order by last_status asc,last_antri asc";

$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);
echo "<tr valign='top'><td>".$no."</td><td class=red>Belum Kirim</td><td>".$data['last_antri']."</td><td>".$data['kode']."</td><td>".$data['no_aju']."</td><td>".$data['no_reg']."</td><td>".$data['sppmp']."</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td><td>".app_baca("m_status","status='".$data['last_status']."'","ket")."(".$data['last_status'].")</td><td>".$data['last_hasil']."</td><td>".$data['last_ket']."</td><td>".$data['last_waktu']."</td><td>".$data['last_oleh']."</td><form method=post><td><input type=hidden name='k' value='".$data['kode']."'><input type=submit value='Sudah'></td></form></tr>";

$no+=1; 

}

echo "</tbody></table>";

}	
		
function selesai() {
$db = new database();
$db->connect(app_db());
$k=str_replace(" ","",$_POST['k']);
if ($k!="") {
$idb=app_baca("barcode","(no_aju='".$k."' or no_aju='0300-".$k."' or kode='".$k."') and no_aju LIKE '%-".$_GET['b']."-%'","id");
if ($idb!="") {
app_insert("antrian", "NULL,'".$idb."','".$_GET['l']."','8',NULL,NULL,'".now()."','".user_id()."'");
app_update("barcode","id='".$idb."'","last_status='8',last_hasil=NULL, last_ket=NULL, last_waktu='".now()."',last_oleh='".user_id()."'");
$rep=date("H:i:s")." berhasil";
} else {$rep=date("H:i:s")." GAGAL";}
}
echo "<form method=post>No Aju / Kode Dropbox: <input type=text name=k autofocus> <input type=submit value='Exe'> ".$rep."</form>
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>AKSI</th><th>WAKTU ANTRI</th><th>KODE DROPBOX</th><th>NO AJU</th><th>NO REG</th><th>PERUSAHAAN</th><th>STATUS</th><th>HASIL</th><th>KET</th><th>WAKTU</th><th>BY</th><th>EXE</th></tr></thead><tbody>";
$no=1;
$query = "SELECT * from barcode WHERE last_lintas='".$_GET['l']."' and no_aju LIKE '%-".$_GET['b']."-%' and last_status='2' order by last_status asc,last_antri asc";

$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);
echo "<tr valign='top'><td>".$no."</td><td class=red>Belum Selesai</td><td>".$data['last_antri']."</td><td>".$data['kode']."</td><td>".$data['no_aju']."</td><td>".$data['no_reg']."</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td><td>".app_baca("m_status","status='".$data['last_status']."'","ket")."(".$data['last_status'].")</td><td>".$data['last_hasil']."</td><td>".$data['last_ket']."</td><td>".$data['last_waktu']."</td><td>".$data['last_oleh']."</td><form method=post><td><input type=hidden name='k' value='".$data['kode']."'><input type=submit value='Selesai'></td></form></tr>";

$no+=1; 

}

echo "</tbody></table>";



}	
	
		

function monitoring() {

$vi=explode("_",$_GET['via']);
$db = new database();
$db->connect(app_db());
$w=$_GET['w'];
if ($w=="") {$w="00";}

if ($_POST['no_reg']!="") { $wreg="and no_reg LIKE '%".$_POST['no_reg']."%' "; }
echo "".$this->form_periode()."
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>KODE DROP</th><th>WAKTU DROPPING</th><th>NO AJU</th><th>NO REG</th><th>KAT SPPMP</th><th>PERUSAHAAN</th><th>STATUS</th><th>HASIL</th><th>KET</th><th>TGL PERIKSA</th><th>VERIF</th><th>BY</th><th>REKOM</th><th>BY</th><th>DURASI</th><th>KH2 KH5</th><th>SPPMP</th><th>TAGIHAN</th><th>PHYTO</th></tr></thead><tbody>";
$no=1;
$query = "SELECT tgl_periksa,id,no_reg,last_status,last_antri,kode,no_aju,sppmp,last_hasil,last_ket,last_waktu,last_oleh,dok_k,dok_s,dok_t from barcode WHERE via='".$vi[2]."' and lintas='".$vi[1]."' and no_aju LIKE '%-".$vi[0]."-%' and last_antri <='".$this->ss()." 23:59:59' and last_antri>='".$this->mm()." 00:00:00' and no_aju LIKE '%".$_POST['no_aju']."%' and kode LIKE '%".$_POST['kode']."%' ".$wreg." and wilker='".$w."' order by last_antri";
$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);
$id=$data['id'];
$vt=app_baca("antrian","id_barcode='".$id."' and status='2' order by waktu","waktu");
$vb=app_baca("antrian","id_barcode='".$id."' and status='2' order by waktu","oleh");
$rt=app_baca("antrian","id_barcode='".$id."' and status='3' order by waktu","waktu");
$rb=app_baca("antrian","id_barcode='".$id."' and status='3' order by waktu","oleh");
$v=substr($vt,11,2).substr($vt,14,2);
$r=substr($rt,11,2).substr($rt,14,2);
$du=durasi($vt,$rt);
if ($v<"1230" and $r>"1230") {$du=($du-60); }
if ($du<0) {$du="0"; }
echo "<tr valign='top' ".$this->bg_status($data['last_status'],$data['last_hasil'])."><td>".$no."</td><td>".$data['kode']."</td><td>".$data['last_antri']."</td><td>".$data['no_aju']."</td><td>".substr($data['no_reg'],-8)."</td><td>".$data['sppmp']."</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td><td>".app_baca("m_status","status='".$data['last_status']."'","ket")."(".$data['last_status'].")</td><td>".$data['last_hasil']."</td><td>".$data['last_ket']."</td><td>".$data['tgl_periksa']."</td><td>".$vt."</td><td>".$vb."</td><td>".$rt."</td><td>".$rb."</td><td>".$du."</td>
<td><a target='_blank' href='../../../1/?k=".$data['id']."'>".$data['dok_k']."</a></td>
<td><a target='_blank' href='../../../1/?s=".$data['id']."'>".$data['dok_s']."</a></td>
<td><a target='_blank' href='../../../prioqklik/dok/t/".$data['dok_t']."'>".$data['dok_t']."</a></td><td><a target='_blank' href='../../../prioqklik/phyto/form_adm.php?d=".$id."'>Draft</a></td></tr>";

$no+=1; 

}

echo "</tbody></table>";

}	



function welcome() {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM klik_log_view_today order by jam";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$s=(date("H")*1);
if ($data['jam']>$s) { $h1.="'".$data['jam']."', "; $d1.="'".$data['jml']."', ";} else {$h2.="'".$data['jam']."', "; $d2.="'".$data['jml']."', ";$tot+=$data['jml'];}

}
echo "<span style='width:45%;float:left'><span style='float:right'>Total: ".rp($tot)." viewer</span><canvas id='canvas'></canvas></span>
	<script>
		var config = {
			type: 'line',
			data: {
				labels: [".$h2."],
				datasets: [{
					label: 'PrioqKlik Access (Today)',
					backgroundColor: 'rgb(255, 205, 86)',
					borderColor: 'rgb(75, 192, 192)',
					borderDash: [5, 5],
					data: [".$d2."
					],
					fill: true,
				}]
			},
			options: {
				responsive: true,
				title: {
					display: false,
					text: ''
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Time'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Viewer'
						}
					}]
				}
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = new Chart(ctx, config);
		};
	</script>";

}	


function grafik0() {
$tgl=$_POST['mm'];
if ($tgl=="") {$tgl=today();}
$db = new database();
$db->connect(app_db());
$query = "SELECT id,kode,last_antri FROM barcode WHERE via='L' and lintas='".$_GET['l']."' and bidang='".$_GET['b']."'  and last_hasil!='Tunda' and last_antri LIKE '".$tgl."%' order by last_antri";
$results = $db->get_results( $query );
foreach( $results as $data )
{
//$h2.="'".substr($data['last_antri'],11,5)."',";

$tv=app_baca("antrian","id_barcode='".$data['id']."' and status='2' and waktu >='".$data['last_antri']."' order by waktu","waktu");
$dv=((durasi($data['last_antri'],$tv))*1);
if (nama_hari($tgl)=="Sat") {} elseif ($data['last_antri']<$tgl." 12:30" and $tv>$tgl." 12:30") {$dv=$dv-60;}
$tr=app_baca("antrian","id_barcode='".$data['id']."' and status='3' and waktu >='".$data['last_antri']."' order by waktu","waktu");
$dr=((durasi($data['last_antri'],$tr))*1);

if (nama_hari($tgl)=="Sat") {} elseif ($tv<$tgl." 12:30" and $tr>$tgl." 12:30") {$dr=$dr-60;}

$hd.="'".substr($data['last_antri'],11,5)." ".$data['kode']."',";
$d1.="'".$dv."',";
$d2.="'".$dr."',";
$d3.="'".($dr-$dv)."',";
//$s=(date("H")*1);
//if ($data['jam']>$s) { $h1.="'".$data['jam']."', "; $d1.="'".$data['jml']."', ";} else {$h2.="'".$data['jam']."', "; $d2.="'".$data['jml']."', ";$tot+=$data['jml'];}
$tot++;
}
echo "<form method='post'><input type=date name=mm value='".$this->mm()."'><input type='submit' value='Show'></form>
<span style='width:90%;float:left'><span style='float:right'>Total: ".rp($tot)." data</span><canvas id='canvas'></canvas></span>
	<script>
		var config = {
			type: 'line',
			data: {
				labels: [".$hd."],
				datasets: [{
					label: 'Wait',
					borderColor: 'rgb(231, 152, 0)',
					borderDash: [3, 3],
					data: [".$d1."
					],
					fill: true,
				},{
					label: 'Respon',
					borderColor: 'rgb(0, 141, 231)',
					borderDash: [3, 3],
					data: [".$d2."
					],
					fill: true,
				},{
					label: 'SLA',
					borderColor: 'rgb(0, 154, 11)',
					data: [".$d3."
					],
					fill: false,
				}]
			},
			options: {
				responsive: true,
				title: {
					display: false,
					text: ''
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Dropping Time'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Duration'
						}
					}]
				}
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = new Chart(ctx, config);
		};
	</script>
	
	";

}	

function grafik() {
$tgl=$_POST['mm'];
if ($tgl=="") {$tgl=today();}
$db = new database();
$db->connect(app_db());
$query = "SELECT id,kode,last_antri FROM barcode WHERE via='L' and lintas='".$_GET['l']."' and bidang='".$_GET['b']."'  and last_hasil!='Tunda' and last_antri LIKE '".$tgl."%' order by last_antri";
$results = $db->get_results( $query );
foreach( $results as $data )
{
//$h2.="'".substr($data['last_antri'],11,5)."',";
$ta=app_baca("antrian","id_barcode='".$data['id']."' and status='1' order by id","waktu");
$tv=app_baca("antrian","id_barcode='".$data['id']."' and status='2' and waktu >='".$ta."' order by waktu","waktu");
$dv=((durasi($ta,$tv))*1);
//if (nama_hari($tgl)=="Sat") {} elseif ($tv>$tgl." 12:30") {} elseif ($data['last_antri']<$tgl." 12:30" and $tv>$tgl." 12:30") {$dv=$dv-60;}


$tr=app_baca("antrian","id_barcode='".$data['id']."' and status='3' and waktu >='".$tv."' order by waktu","waktu");
$tn=app_baca("antrian","id_barcode='".$data['id']."' and status='4' and waktu >='".$tr."' order by waktu","waktu");

$dr=((durasi($ta,$tr))*1);
$dn=((durasi($ta,$tn))*1);
//if (nama_hari($tgl)=="Sat") {} elseif ($tv<$tgl." 12:30" and $tr>$tgl." 12:30") {$dr=$dr-60;}
$ver=($dr-$dv);
if (nama_hari($tgl)=="Sat") {} elseif ($tv<$tgl." 12:30" and $tr>$tgl." 12:30") {$ver=$ver-60;}
$sla=($dn-$dv);
if (nama_hari($tgl)=="Sat") {} elseif ($tv<$tgl." 12:30" and $tn>$tgl." 12:30") {$sla=$sla-60;}
$tunda=app_baca("antrian","id_barcode='".$data['id']."' and status='3' and hasil='Tunda' order by waktu","id");
if ($data['kode']=="G8L") {
//echo $ta." ".$tv." ".$tr." ".$tn." ".$tunda."<br>";	
}

if ($tunda>"0") {$sla=$ver;}
$hd.="'".substr($data['last_antri'],11,5)." ".$data['kode']."',";
if ($dv>"420") {$dv="360";}
$d1.="'".$dv."',";
if ($dr>"420") {$dr="360";}
$d2.="'".$dr."',";
if ($dn>"420") {$dn="360";}
$d4.="'".$dn."',";
if ($ver>"420") {$ver="360";}
$d3.="'".$ver."',";
if ($sla>"420") {$sla="360";}
$d5.="'".$sla."',";
if ($sla<="90") {$b+=1;}
//$s=(date("H")*1);
//if ($data['jam']>$s) { $h1.="'".$data['jam']."', "; $d1.="'".$data['jml']."', ";} else {$h2.="'".$data['jam']."', "; $d2.="'".$data['jml']."', ";$tot+=$data['jml'];}
$tot++;

}
$jm=$tot;
$cap=(($b/$tot)*100);
if ($cap>="100") {$r="Sasaran tercapai, selanjutnya dapat dipelihara sumber daya agar sasaran selalu dapat tercapai";$rek="Sasaran tercapai, selanjutnya untuk dipertahankan";} 
elseif ($cap>="80") {$r="Sasaran tercapai diatas 80 persen, selanjutnya dapat dipelihara dan tingkatkan sumber daya meliputi sumber daya manusia (verifikator), kecepatan jaringan internet, dan infrastruktur yang lainnya";$rek="Tercapai diatas 80 %, untuk tingkatkan";}
else {$r="Sasaran tidak tercapai, persentase capaian dibawah 80 persen, selanjutnya dapat dilakukan perbaikan diantaranya:<br>
1. Penambahan jumlah verifikator<br>
2. Perbaikan infrastruktur (printer, komputer, dan jaringan)<br>
3. Mendorong pengguna jasa menyampaikan permohonan seawal mungkin (pagi hari)
";$rek="Sasaran tidak tercapai, selanjutnya untuk dilakukan perbaikan";}
$datanya= "<b>Tindakan Pemeriksaan Dokumen Impor</b><br>Tgl: ".tgl_p($tgl)."<br>Total permohonan <b>$jm</b> dokumen<br>Capaian SLA: ( < 90 menit): <b>$b dok (".des($cap)." % )</b>.";
$username="198402072009011009";
$no_dok=  $username."_ABCH_".$tgl."_dok";
$lokasi="Kantor Induk, BBKP Tanjung Priok";
$hasil="Laporan terlampir.<br>Rekomendasi: ".$rek;
$ak="0.04";
$tglny=tgl_aju($tgl);
if (strstr($tgl,"2016")) { $nospt="5s/KP.430/L.7.A/01/2016"; 	$tgl_spt="2016-01-03";} elseif (strstr($tgl,"2017")) { $nospt="10a/KP.430/K.7.A/01/2017"; $tgl_spt="2016-01-02";} elseif (strstr($tgl,"2018")) { $nospt="3a/KP.430/K.7.A/01/2018"; $tgl_spt="2018-01-02";}
if ($tot>0 and $_GET['l']=="I" and $_GET['b']=="2") {
//db_replace("k7915699_poptdb1","a2","'".$username."', '$tglny', '$tglny', '$nospt', '$datanya', '$hasil', 'ABCH', 'Teguh Prayitno', '$no_dok', '$lokasi', 'ABCH', '".$ak."', '".$ak."', '1', NULL, '0', '".now()."'");

}







echo "<form method='post'><input type=date name=mm value='".$this->mm()."'><input type='submit' value='Show'> Total :".$tot."; Capaian SLA: ".des(($b/$tot)*100)." % </form>";

echo "
<div style='width: 98%;'>
  <canvas id='myChart'></canvas>
</div>
<script>
var data = {
  datasets: [{label: 'Wait',
                borderColor: 'rgb(244, 0, 0)',
                borderDash: [3, 3],
                data: [".$d1."],
                fill: true
            },{
					label: 'Respon',
					borderColor: 'rgb(231, 152, 0)',
					borderDash: [3, 3],
					data: [".$d2."
					],
					fill: true,
			},{
					label: 'NotifDok',
					borderColor: 'rgb(0, 141, 231)',
					borderDash: [3, 3],
					data: [".$d4."
					],
					fill: true,
			},{
					label: 'Verify',
					borderColor: 'rgb(0, 154, 11)',
					data: [".$d3."
					],
					fill: false,
			},{
					label: 'SLA',
					borderColor: 'rgb(170,0, 0)',
					data: [".$d5."
					],
					fill: false,
			}],
  labels: [".$hd."]
};

$(document).ready(
  function() {
    var canvas = document.getElementById(\"myChart\");
    var ctx = canvas.getContext(\"2d\");
    var myNewChart = new Chart(ctx, {
      type: 'line',
      data: data
    });

    canvas.onclick = function(evt) {
      var activePoints = myNewChart.getElementsAtEvent(evt);
      if (activePoints[0]) {
        var chartData = activePoints[0]['_chart'].config.data;
        var idx = activePoints[0]['_index'];

        var label = chartData.labels[idx];
        var value = chartData.datasets[0].data[idx];
        $.get(\"exe/rand.php?l=\"+label, function(hasil, status){

        alert(hasil);
        });
        
      }
    };
  }
);
</script>";

}

function draftphyto() {
$db = new database();
$db->connect(app_db());
echo "<form method='post'>No Aju: <input type='text' value='".$_POST['no_aju']."' name='no_aju'> No Reg: <input type='text' value='".$_POST['no_reg']."' name='no_reg' size=7> Kode: <input type='text' value='".$_POST['kode']."' name='kode' size=5> <input type='submit' value='Show'> <input type='hidden' value='list' name='tab'></form>
<table class=table id='dt2' width=100%>
<thead>
<tr><th>NO</th><th>KODE DROP</th><th>TGL DROPPING</th><th>NO AJU</th><th>NO REG</th><th>PERUSAHAAN</th><th>PHYTO &ATCH</th><th>LOG</th></tr></thead><tbody>";
$no=1;


if ($_POST['no_aju']!="" or $_POST['no_reg']!="" or $_POST['kode']!="") {
if ($_POST['no_aju']!="") {$wh1="and no_aju LIKE '%".$_POST['no_aju']."%'";}
if ($_POST['no_reg']!="") {$wh2="and no_reg LIKE '%".$_POST['no_reg']."'";}
if ($_POST['kode']!="") {$wh3="and kode='".$_POST['kode']."'";}
$query = "SELECT no_aju,id,kode,no_reg,last_antri from barcode WHERE lintas='E' ".$wh1." ".$wh2." ".$wh3." order by no_reg";
} else {$query = "SELECT no_aju,pc_e.id as id,kode,no_reg,last_antri from barcode join pc_e ON barcode.id=pc_e.id WHERE lintas='E' order by last_update DESC limit 0,5";}


$results = $db->get_results( $query );
$n=0;
foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);
$id=$data['id'];
echo "<tr valign='top' ".$cls."><td>".$no."</td><td>".$data['kode']."</td><td>".$data['last_antri']."</td><td>".$data['no_aju']."</td><td>".$data['no_reg']."</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td><td><a target='_blank' href='../../../prioqklik/phyto/form_adm.php?d=".$id."'>Draft</a></td><td>".$this->draftphyto_log($id)."</tr>";

$no+=1; 

}

echo "</tbody></table>";

}	


function draftphyto_log($id) {
$db = new database();
$db->connect(app_db());
$no=1;

$query = "SELECT last_update,id,entry_oleh from pc_e_log WHERE id_barcode='".$id."' ORDER BY last_update DESC";

$results = $db->get_results( $query );
$n=0;
foreach( $results as $data )
{
$dt.= "<a target='_blank' href='../../../prioqklik/phyto/form_log.php?l=".$data['id']."'>".$data['last_update']." by ".$data['entry_oleh']."</a><br>";
}

return $dt;
}	


function logsms() {
$db = new database();
$db->connect("smsd");
echo "<form method='post'>Tanggal: <input type=date name=mm value='".$this->mm()."'> sd. <input type=date name=ss value='".$this->ss()."'><input type='submit' value='Show'> </form>
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>WAKTU KIRIM</th><th>NO HP PENERIMA</th><th>ISI PESAN</th><th>PENGIRIMAN</th></tr></thead><tbody>";
$no=1;
$query = "SELECT * from outbox WHERE UpdatedInDB<='".$this->ss()." 23:59:59' and UpdatedInDB>='".$this->mm()." 00:00:00' order by UpdatedInDB desc limit 0,10";
$results = $db->get_results( $query );
foreach( $results as $data )
{
echo "<tr valign='top'><td>".$no."</td><td>".$data['SendingDateTime']."</td><td>".$data['DestinationNumber']."</td><td>".$data['TextDecoded']."</td><td>Menunggu</td></tr>";
$no+=1; 
}

$query = "SELECT * from sentitems WHERE SendingDateTime<='".$this->ss()." 23:59:59' and SendingDateTime>='".$this->mm()." 00:00:00' order by SendingDateTime desc limit 0,10";
$results = $db->get_results( $query );
foreach( $results as $data )
{
echo "<tr valign='top'><td>".$no."</td><td>".$data['SendingDateTime']."</td><td>".$data['DestinationNumber']."</td><td>".$data['TextDecoded']."</td><td>Terkirim</td></tr>";
$no+=1; 
}

echo "</tbody></table>";

}	



	
}
