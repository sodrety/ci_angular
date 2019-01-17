<?php

class klik {

function mm($l) {
if ($_POST['mm']!="") {$mm=$_POST['mm'];} else {
$tgl=app_baca_limit("barcode","no_aju LIKE '%".akun_pj()."%' and lintas='".$l."' order by update_time desc","update_time","20");
//$mm=date("Y-m-d");
$mm=substr($tgl,0,10);
}	
return $mm;
}	


function ss() {
if ($_POST['ss']!="") {$ss=$_POST['ss'];} else {$ss=date("Y-m-d"); }	
return $ss;	
}	

function li($l) {
if ($l=="I") {$li="Import";} elseif ($l=="E") {$li="Ekspor";}
return $li;	
}	

function via($l) {
if ($l=="L") {$li="Loket";} elseif ($l=="P") {$li="Pplss";}
return $li;	
}

function spp($l) {
if ($l=="Bc23") {$sppmp="BC-23 BNH PLB";} else {$sppmp=$l;}
return $sppmp;	
}



function profile() {
$db = new database();
$db->connect(app_db());
if ($_POST) {app_update("akun_pj","akun='".akun_pj()."'", "hp='".$_POST['hp']."', email='".$_POST['email']."'");
app_replace("akun_kontak","'".akun_pj()."', '".$_POST['h1']."', '".$_POST['e1']."', '".$_POST['h2']."', '".$_POST['e2']."', '".$_POST['h3']."', '".$_POST['e3']."', '".$_POST['h4']."', '".$_POST['e4']."', '".$_POST['h5']."', '".$_POST['e5']."', '".now()."'");
}
echo "<form method=post>
<table>
";

$query = "SELECT * from akun_pj WHERE akun='".akun_pj()."' limit 0,1";
$results = $db->get_results( $query );
foreach( $results as $data )
{
}

echo "<tr><td>Akun</td><td>:</td><td colspan=6>".$data['akun']."</td></tr>
<tr><td>Perusahaan</td><td>:</td><td colspan=6>".$data['perusahaan']."</td></tr>
<tr><td>Kontak Utama</td><td>:</td><td>HP</td><td></td><td><input type=number value='".$data['hp']."' name=hp></td><td>Email</td><td></td><td><input type=text value='".$data['email']."' name=email></td></tr>";

$query = "SELECT * from akun_kontak WHERE akun='".akun_pj()."' limit 0,1";
$results = $db->get_results( $query );
foreach( $results as $data )
{
}
echo "
<tr><td>Kontak 1</td><td>:</td><td>HP</td><td></td><td><input type=number value='".$data['h1']."' name=h1></td><td>Email</td><td></td><td><input type=text value='".$data['e1']."' name=e1></td></tr>
<tr><td>Kontak 2</td><td>:</td><td>HP</td><td></td><td><input type=number value='".$data['h2']."' name=h2></td><td>Email</td><td></td><td><input type=text value='".$data['e2']."' name=e2></td></tr>
<tr><td>Kontak 3</td><td>:</td><td>HP</td><td></td><td><input type=number value='".$data['h3']."' name=h3></td><td>Email</td><td></td><td><input type=text value='".$data['e3']."' name=e3></td></tr>
<tr><td>Kontak 4</td><td>:</td><td>HP</td><td></td><td><input type=number value='".$data['h4']."' name=h4></td><td>Email</td><td></td><td><input type=text value='".$data['e4']."' name=e4></td></tr>
<tr><td>Kontak 5</td><td>:</td><td>HP</td><td></td><td><input type=number value='".$data['h5']."' name=h5></td><td>Email</td><td></td><td><input type=text value='".$data['e5']."' name=e5></td></tr>
<tr><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td colspan=6><input type=submit value='Simpan'></td></tr>";

echo "</table></form>
*) Kontak akan digunakan untuk menerima notifikasi";

}	


function m($s) {
$j=0;

if ($s==1) { //status belum diantrikan 
$j=app_jml("barcode"," last_status='0' and no_aju LIKE '%".akun_pj()."%'","no_aju");
}
if ($s==2) { //status sudah diantrikan dalam proses antri, verifikasi, rekomendasi,
$j=app_jml("barcode","no_aju LIKE '%".akun_pj()."%' and (last_status='0' or last_status='1' or last_status='2' or (last_status='3' and last_hasil!='Tunda'))","no_aju");
}
if ($s==3) { //status Tunda (Rekom and Tunda
$j=app_jml("barcode","no_aju LIKE '%".akun_pj()."%' and last_status='3' and last_hasil='Tunda'","no_aju");
}
if ($s==4) { //ada Tagihan PNBP  3 - 4 - 5
$j=app_jml("barcode","no_aju LIKE '%".akun_pj()."%' and (last_status='5' or last_status='6')","no_aju");
}
if ($s==5) { //Selesai NSW KT-2 / KH-5 terkirim atau SPPMP udh terbit
$j=app_jml("barcode","no_aju LIKE '%".akun_pj()."%' and last_status='9'","no_aju");
}
if ($j>0) {return "<span class=note>".$j."</span>";}
}	

function status($s) {
$k=app_baca("m_status","status='".$s."'","ket");
if ($s!="") {return $k." (".$s.")";}

}	

function opt_via() {
$db = new database();
$db->connect(app_db());

$query = "SELECT m_via.id_via,via from m_via JOIN via_pj ON m_via.id_via=via_pj.id_via WHERE via_pj.akun='".akun_pj()."' order by id_via";
$results = $db->get_results( $query );
//$tgl_p="<input type=hidden name=tgl_periksa value='1999-01-01'>";
foreach( $results as $data )
{
 $dt.="<option value='".$data['id_via']."'>".$data['via']."</option>";
 if ($data['id_via']=="2_E_P") {$tgl_p=" Tgl Periksa: <input type=date name=tgl_periksa value='".next_date(today())."'>";}
}

$query = "SELECT * from m_via order by id_via";
$results = $db->get_results( $query );
foreach( $results as $data )
{
if (substr($data['id_via'],-2)=="_L") { $dt.="<option value='".$data['id_via']."'>".$data['via']."</option>"; }
}
return "<select name=via id='sct1'>".$dt."</select>".$tgl_p;
}

function opt_kon() {
$db = new database();
$db->connect(app_db());
 $dt.="<option value='0'>0 : ".app_baca("akun_pj","akun='".akun_pj()."'","hp")." - ".app_baca("akun_pj","akun='".akun_pj()."'","email")."</option>";
 
$query = "SELECT * FROM akun_kontak WHERE akun='".akun_pj()."' limit 0,1";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$a=1;
while ($a<=5) {
$h="h".$a;
$e="e".$a;
 $dt.="<option value='".$a."'>".$a." : ".$data[$h]." - ".$data[$e]."</option>";
 $a+=1;
 }
}

return " Kontak <select name=kontak id='sct2'>".$dt."</select>";
}


function prosesaju() {

if (strstr($_POST['no_aju'],"0300-") and strstr(strtoupper($_POST['no_aju']),strtoupper(akun_pj()))) {
$no_aju=str_replace(" ","",$_POST['no_aju']);
$no_aju=str_replace("	","",$no_aju);
$idc=app_baca("barcode","no_aju='".$no_aju."'","id");
if ($idc=="") {
$vi=explode("_",$_POST['via']);
if ($_POST['tgl_periksa']=="") {$tgl_p="NULL";} else {$tgl_p="'".$_POST['tgl_periksa']."'";}

app_query("INSERT INTO barcode (`no_aju`,`input_time`,`update_time`,`bidang`,`lintas`,`via`,`tgl_periksa`,`kontak`,`last_status`) VALUES ('".$no_aju."', '".now()."', '".now()."', '".$vi[0]."', '".$vi[1]."', '".$vi[2]."', ".$tgl_p.",'".$_POST['kontak']."','0')");
$idc=app_baca("barcode","no_aju='".$no_aju."'","id");
echo "Berhasil";
if (strstr($_POST['via'],"_E_P")) {
app_insert("antrian", "NULL,'".$idc."','E','1',NULL,NULL,'".now()."',NULL,'0','0'");
app_update("barcode","id='".$idc."'","last_antri='".now()."',last_status='1'");
}

} else {//app_update("barcode","no_aju='".$no_aju."'","update_time='".now()."',via='".$_POST['via']."',tgl_periksa='".$_POST['tgl_periksa']."'"); 
echo "GAGAL: No Aju ".$no_aju." sudah Pernah Diajukan dengan NoReg ".app_baca("barcode","no_aju='".$no_aju."'","no_reg");
}
app_update("barcode","id='".$idc."'","kode='".kode($idc)."'");

}

echo "<form method=post>No Aju: <input type=text name=no_aju size=40> Via: ".$this->opt_via()." ".$this->opt_kon()." <input type=submit value=Tambah></form>";

//$query = "SELECT * from barcode WHERE (last_status='0' or last_status='1' or last_status='2' or (last_status='3' and last_hasil!='Tunda') or last_status='9')  and no_aju LIKE '%".akun_pj()."%' order by last_status asc,id desc limit 0,100";
$query = "SELECT * from barcode WHERE  no_aju LIKE '%".akun_pj()."%' and ( last_status<'9' or last_waktu LIKE '".today()."%' or last_antri LIKE '".today()."%') order by last_status asc,id desc limit 0,50";

$this->proses_tabel($query);
echo "**) Untuk Draft Phyto & Selesai Verifikasi dilihat di menu Mon Ekspor";
}

function monitoringekspor() {
$this->monitoring("E");
}

function monitoringimpor() {
$this->monitoring("I");
}

function monitoring($l) {
$db = new database();
$db->connect(app_db());
echo "<form method='post'>Tanggal: <input type=date name=mm value='".$this->mm($l)."'> sd. <input type=date name=ss value='".$this->ss()."'> No Aju: <input type='text' value='".$_POST['no_aju']."' name='no_aju'> Kode: <input type='text' value='".$_POST['kode']."' name='kode' size=5> NoReg <input type='text' value='".$_POST['no_reg']."' name='no_reg'><input type='submit' value='Show'> <input type='hidden' value='list' name='tab'></form>";
$query = "SELECT * from barcode WHERE input_time<='".$this->ss()." 23:59:59' and input_time>='".$this->mm($l)." 00:00:00' and no_aju LIKE '%".akun_pj()."%' and no_aju LIKE '%".$_POST['no_aju']."%' and kode LIKE '%".$_POST['kode']."%' and lintas='".$l."' order by last_antri desc limit 0,20";
$this->proses_tabel($query);
}		



function proses_tabel($query) {
$db = new database();
$db->connect(app_db());
echo "
<table class=table id='dta' width=100%>
<thead>
<tr><th>NO</th><th>VIA</th><th>WAKTU DROPPING</th><th>KODE</th><th>NO AJU</th><th>TGL PERIKSA</th><th>STATUS</th><th>HASIL</th><th>KET</th><th>NO REG</th><th>KAT SPPMP</th><th>KT2 KH5</th><th>SPPMP</th><th>TGH</th><th>KWT</th><th>PHYTO</th><th>BILLING</th></tr></thead><tbody>";
$no=1;
$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);
$id=$data['id'];

if (strstr($data['no_aju'],"-1-")) {$bid="KH";} else {$bid="KT";}

if ($data['last_status']=="0") {$bg="#fff";} elseif ($data['last_status']=="1") {$bg="#eee";} elseif ($data['last_status']=="2") {$bg="#ddd";} elseif ($data['last_status']=="3") {$bg="#ccc";} else {$bg="#fff";}
$cls="style='background:".$bg.";'";
if ($data['last_status']=="9") {$cls="class='green_all'";} elseif ($data['last_status']=="3" and $data['last_hasil']=="Tunda") {$cls="class='red_all'";} 
$status=app_baca("m_status","status='".$data['last_status']."'","ket_pj");

if ($data['lintas']=="E") {
$phy="<a target='_blank' href='phyto/form.php?a=".md5(date("His"))."i".md5(date("hs"))."&d=".$id."&u".md5(date("si"))."'>Draft</a>";
$respon=app_baca("request_billing","id_barcode='".$data['id']."'","respon");
if ($respon=="") {$req="<a href='?t=RequestBilling&a=".md5(date("His"))."i".md5(date("hs"))."&d=".$id."&u".md5(date("si"))."'>Request</a>";} elseif ($respon=="0") {$req="<a href='?t=RequestBilling&a=".md5(date("His"))."i".md5(date("hs"))."&d=".$id."&u".md5(date("si"))."'>Edit Request</a>";} else {$req="Sudah Direspon";}
if ($data['last_status']=="4") {$status="Request Billing";}
} else {$phy="";$req="";}


echo "<tr valign='top' ".$cls."><td>".$no."</td><td>".$data['bidang']."-".$bid." ".$this->li($data['lintas'])." ".$this->via($data['via'])."</td><td>".$data['last_antri']."</td><td><a target='_blank' href='print/barcode.php?d=".$data['id']."'>".$data['kode']."</a></td><td>".$data['no_aju']."</td><td>".$data['tgl_periksa']."</td><td>".$status."</td><td>".$data['last_hasil']."</td><td>".$data['last_ket']."</td><td>".substr($data['no_reg'],-8)."</td><td>".$this->spp($data['sppmp'])."</td>

<td><a target='_blank' href='../../1/?k=".$data['id']."'>".substr($data['dok_k'],0,6)."</a></td>
<td><a target='_blank' href='../../1/?s=".$data['id']."'>".substr($data['dok_s'],0,6)."</a></td> 
<!--<td><a target='_blank' href='dok/k/".$data['dok_k']."'>".substr($data['dok_k'],0,6)."</a></td>
<td><a target='_blank' href='dok/s/".$data['dok_s']."'>".substr($data['dok_s'],0,6)."</a></td>-->

<td><a target='_blank' href='dok/t/".$data['dok_t']."'>".substr($data['dok_t'],0,6)."</a></td>
<td><a target='_blank' href='dok/w/".$data['dok_w']."'>".substr($data['dok_w'],0,6)."</a></td><td>".$phy."</td><td>".$req."</td></tr>";

$no+=1; 

}

echo "</tbody></table>";

}	


function requestbilling() {
$id=$_GET['d'];
$db = new database();
$db->connect(app_db());
$respon=app_baca("request_billing","id_barcode='".$id."'","respon");
if ($respon>0) {$rep= "&nbsp;".now()." GAGAL: Request sudah direspon"; }
elseif ($_POST['volume']=="" and $_POST) {$rep= "&nbsp;".now()." GAGAL: Data tidak lengkap"; }

elseif ($_POST['tgl_cetak']>today()) {
app_replace("request_billing","'".$id."', '".$_POST['tgl_cetak']."', '".$_POST['volume']."', '".$_POST['ket']."', '".now()."', '".user()."','0',NULL,NULL");
app_update("barcode","id='".$id."'","last_status='4',last_hasil=NULL,last_ket=NULL, last_waktu='".now()."'");
$rep= "&nbsp;".now()." Tersimpan";
} elseif ($_POST) {$rep= "<b>&nbsp;".now()." Gagal</b>: Request maksimal H-1 sebelum Cetak";}

$query = "SELECT * FROM request_billing WHERE id_barcode='".$id."'";
$results = $db->get_results($query);
$tgl_cetak=next_date(today());

foreach( $results as $data )
{
$ket=$data['ket'];
$vo=$data['volume'];
$tgl_cetak=$data['tgl_cetak'];
if ($vo=="Tetap") {$ch1="checked";} else {$ch2="checked";}
}

echo $rep;
if ($respon<=0) {
echo "
<table width='100%' class=table><form method=post enctype='multipart/form-data'>
<tr><td width='10%'>No Aju</td><td>:</td><td>".app_baca("barcode","id='".$id."'","no_aju")."</td></tr>
<tr><td>No Reg</td><td>:</td><td>".app_baca("barcode","id='".$id."'","no_reg")."</td></tr>
<tr><td>Tgl Cetak Phyto</td><td>:</td><td><input type=date name='tgl_cetak' value='".$tgl_cetak."'></td></tr>
<tr><td>Perubahan </td><td>:</td><td><input type='radio' name='volume' value='Tetap' ".$ch1."> Tidak ada Perubahan Volume Komoditas (<b>sama</b> dengan PPK Online)
</td></tr>
<tr><td></td><td></td><td>
<input type='radio' name='volume' value='Ubah' ".$ch2."> Terdapat Perubahan Volume Komoditas (<b>berbeda</b> dengan PPK Online)<br>Keterangan Perubahan<br>
<textarea style='width:100%;border:1px solid #ccc;' name='ket'>".$ket."</textarea>
</td></tr>
<tr><td></td><td></td><td><input type=submit value='Ajukan'> <a href='?t=Monitoring'>Selesai</a></td></tr>
</form>
</table>";
}
}

function tunda() {
$content=new content();
$db = new database();
$db->connect(app_db());
echo "
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>BID</th><th>LIN</th><th>VIA</th><th>WAKTU DROPPING</th><th>KODE</th><th>NO AJU</th><th>WAKTU RESPON</th><th>STATUS</th><th>ALASAN</th></tr></thead><tbody>";
$no=1;
$query = "SELECT * from barcode WHERE no_aju LIKE '%".akun_pj()."%' and last_status='3' and last_hasil='Tunda' order by last_waktu desc";
$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);
$id=$data['id'];

if (strstr($data['no_aju'],"-1-")) {$bid="KH";} else {$bid="KT";}
echo "<tr valign='top' ".$cls."><td>".$no."</td><td>".$bid."</td><td>".$this->li($data['lintas'])."</td><td>".$this->via($data['via'])."</td><td>".$data['last_antri']."</td><td><a target='_blank' href='print/barcode.php?d=".$data['id']."'>".$data['kode']."</a></td><td>".$data['no_aju']."</td><td>".$data['last_waktu']."</td><td><b>TUNDA</b></td><td>".$data['last_ket']."</td></tr>";

$no+=1; 

}

echo "</tbody></table>";

}	


function tagihanpnbp() {
$content=new content();
$db = new database();
$db->connect(app_db());
if ($_POST['id']!="") {
$target_dir = "dok/b/";
$target_file = $target_dir . basename($_FILES["bukti_bayar"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$namefile=$target_dir . $_POST['id'].".".$imageFileType;
move_uploaded_file($_FILES["bukti_bayar"]["tmp_name"], $namefile);
app_update("barcode","id='".$_POST['id']."'","bukti_bayar='".$_POST['id'].".".$imageFileType."'");
app_insert("antrian", "NULL,'".$_POST['id']."',NULL,'6','Konfirmasi','Sudah Bayar','".now()."',NULL,'0','0'");
app_update("barcode","id='".$_POST['id']."'","last_status='6',last_waktu='".now()."'");

}

echo "
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>VIA</th><th>WAKTU DROPPING</th><th>KODE</th><th>NO AJU</th><th>NO REG</th><th>HASIL</th><th>KET</th><th>STATUS</th><th>KT2 KH5</th><th>TAGIHAN</th><th>KWT</th><th>BUKTI BAYAR</th><th>UPLOAD BUKTI BAYAR</th></tr></thead><tbody>";
$no=1;
$query = "SELECT * from barcode WHERE no_aju LIKE '%".akun_pj()."%' and (last_status='5' or last_status='6' or last_status='7') order by last_waktu desc";
$results = $db->get_results( $query );
$n=0;

foreach( $results as $data )
{
$akun=substr($data['no_aju'],5,7);
$id=$data['id'];

if (strstr($data['no_aju'],"-1-")) {$bid="KH";$do="KH-5";} else {$bid="KT";$do="KT-2";}
if ($data['sppmp']=="Bc23") {$sppmp="BC-23 BNH PLB";} else {$sppmp=$data['sppmp'];}

echo "<tr valign='top' ".$cls."><td>".$no."</td><td>".$data['bidang']."-".$bid." ".$this->li($data['lintas'])." ".$this->via($data['via'])."</td><td>".$data['last_waktu']."</td><td><a target='_blank' href='print/barcode.php?d=".$data['id']."'>".$data['kode']."</a></td><td>".$data['no_aju']."</td><td>".substr($data['no_reg'],-8)."</td><td>".$data['last_hasil']."</td><td>".$data['last_ket']."</td><td>".app_baca("m_status","status='".$data['last_status']."'","ket_pj")."</td>
<td><a target='_blank' href='../../1/?k=".$data['id']."'>".substr($data['dok_k'],0,6)."</a></td>
<td><a target='_blank' href='dok/t/".$data['dok_t']."'>".substr($data['dok_t'],0,6)."</a></td>
<td><a target='_blank' href='dok/w/".$data['dok_w']."'>".substr($data['dok_w'],0,6)."</a>
</td><td><a target='_blank' href='dok/b/".$data['bukti_bayar']."'>".substr($data['bukti_bayar'],0,6)."</a></td>
<form method=post enctype='multipart/form-data'><input type=hidden name=id value='".$id."'><td><input type=file name=bukti_bayar onchange=\"javascript:this.form.submit();\"></td></form></tr>";

$no+=1; 

}

echo "</tbody></table>";

}	

function alert() {
$content=new content();
$db = new database();
$db->connect(app_db());
$query = "SELECT * from akun_blokir WHERE akun='".akun_pj()."' and aktif='1' order by waktu desc";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$dt.="<div>".$data['alasan']."</div>";
$no++;
}
if ($no>0) {$re.= "<div class='alert_blokir'><div><b>PERINGATAN!</b></div>".$dt."</div>"; }
$hp=app_baca("akun_pj","akun='".akun_pj()."'","hp");
$e=app_baca("akun_pj","akun='".akun_pj()."'","email");
if ($hp=="" or $e=="") {$re.= "<div class='alert_noti'><div><b>PERHATIAN!</b></div><div>Kontak Utama belum diisi, silahkan isi <a href='?t=Profile'>disini</a></div></div>"; }
return $re;

}

function penggunajasa() {
if ($_POST) {
$user=$_POST['q'];
$p=$_POST['p'];
$s=$_POST['s'];
$sc=$_POST['sc'];
if ($user!="" and strlen($user)>6 and substr($user,0,2)=="03" and $p!="" and $s==$sc)	{ 
app_insert("klik_log","NULL,'".$user."','".$p."','".now()."'");
setcookie("user", $user, time()+(3600*24*7));
echo " <meta http-equiv=\"refresh\" content=\"0; URL=index.php\">";
exit;
 	} else {$g="GAGAL";}
} 
else {}
$a=rand(1,5);$b=rand(1,4);
echo "<table align=center class='login'><form method=post>
<tr><td colspan=3></td></tr>
<tr><td>Akun</td><td>:</td><td><input type=text name='q' autofocus></td></tr>
<tr><td>Password</td><td>:</td><td><input type=password name='p'></td></tr>
<tr><td align='right'><b>".$a." + ".$b."</b></td><td>=</td><td><input type=text name='s' size=3></td></tr>
<input type=hidden name='sc' value='".($a+$b)."'>
<tr><td colspan=3><input type=submit class=submit value=Login></td></tr>
<tr><td colspan=3 align=center>".$g."</td></tr>
</form>
</table>";
}

function antrian() {
$content=new content();
$db = new database();
$db->connect(app_db());
$date=today();
$query = "SELECT * from barcode WHERE last_antri LIKE '".$date."%' and last_antri<='".$date." 14:00:00' order by last_antri asc";
$results = $db->get_results( $query );
echo "<div class=h2>Antrian Hari Ini</div>
<table class=table id='dt1' width=100%>
<thead>
<tr><th>NO</th><th>LAYANAN</th><th>WAKTU DROPPING</th><th>KODE</th><th>NO AJU</th><th>PERUSAHAAN</th><th>STATUS</th></tr></thead><tbody>";
foreach( $results as $data )
{
$no++;
if ($data['lintas']=="I") {$lintas="Impor";} elseif ($data['lintas']=="E") {$lintas="Ekspor";} 
if (strstr($data['no_aju'],"-1-")) {$bid="Hewan";$do="KH-5";} else {$bid="Tumbuhan";$do="KT-2";}
$akun=substr($data['no_aju'],5,7);
echo "<tr valign='top' ".$cls."><td>".$no."</td><td>".$lintas." ".$bid."</td><td>".$data['last_antri']."</td><td>".$data['kode']."</td><td>".substr($data['no_aju'],13,20)."</td><td>".app_baca("akun_pj","akun='".$akun."'","perusahaan")."</td><td>".app_baca("m_status","status='".$data['last_status']."'","ket_pj")."</td>
</tr>";
}
echo "</tbody></table>";
}

function cekdokumen() {
$a=rand(1,5);$b=rand(1,4);
echo "<div class=h2>Cek Dokumen</div>
<table class=cek><form method=post>
<tr><td colspan=3></td></tr>
<tr><td>Nomor</td><td>:</td><td><input type=number name='q' value='".$_POST['q']."' autofocus></td></tr>
<tr><td>Key</td><td>:</td><td><input type=number name='k' value='".$_POST['k']."'></td></tr>
<tr><td align='right'><b>".$a." + ".$b."</b></td><td>=</td><td><input type=text name='s' size=3 placeholder='...?'></td></tr>
<input type=hidden name='sc' value='".($a+$b)."'>
<tr><td></td><td></td><td align=right><input type=submit class=submit value='Cari'></td></tr>
<tr><td colspan=3 align=center>".$g."</td></tr>
</form>
</table>";
$q=$_POST['q'];
$k=$_POST['k'];
$s=$_POST['s'];
$sc=$_POST['sc'];
if ($_POST and $s==$sc and strlen($q)>2) {
$content=new content();
$db = new database();
$db->connect(app_db());
$query = "SELECT dok_k,dok_s,id from barcode WHERE no_reg LIKE '".$q."%' and id='".$k."'";
$results = $db->get_results( $query );
$no=0;
foreach( $results as $data )
{
if ($data['dok_k']!="") {$dok_k="KH5/KH7/KT2";} else {$dok_k="";} 
if ($data['dok_s']!="") {$dok_s="SPPMP";} else {$dok_s="";} 
$dt.="<a target='_blank' href='../../1/?k=".$data['id']."'>".$dok_k."</a> <a target='_blank' href='../../1/?s=".$data['id']."'>".$dok_s."</a>";
$no++;
}
if ($no>0) {echo "Cek Dokumen Berhasil : ".$dt;} else {echo "Gagal";} 
}

}


}
