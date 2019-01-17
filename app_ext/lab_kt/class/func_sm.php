<?php
function sm_menu() {
$ap="sm.php";	
return "
  <h4>Proses</h4>
<a href='".$ap."?t=Tambah'>Tambah</a> <a href='".$ap."?t=Arsip'>Arsip</a> <a href='".$ap."?t=Disposisi'>Disposisi</a>
  <h4>Laporan</h4>
<a href='".$ap."?t=Temuan'>Temuan Uji</a> <a href='".$ap."?t=Metode'>Metode Uji</a> <a href='".$ap."?t=Penugasan'>Penugasan</a>
";	
}

function sm_disposisi(){
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM sm join sm_disposisi ON sm.id=sm_disposisi.id_sm WHERE kepada='".user_id()."' and dis_pada>='".tgl_pilih("m")."' and dis_pada<='".tgl_pilih("s")."' and hal LIKE '%".tgl_pilih("h")."%' order by dis_pada desc";
$results = $db->get_results( $query );
$n=0;
echo tgl_pilih_f()."<table class='table' width=100% id=example>
<thead>
<tr><th>NO</th><th>WAKTU</th><th>DARI</th><th>UNTUK</th><th>TANGGAL</th><th>NO AGENDA</th><th>TGL SURAT</th><th>NO SURAT</th><th>HAL</th><th>PENGIRIM</th><th>DOKUMEN</th><th>DISPOSISI&nbsp;KEPADA</th><th></th></tr>
</thead><tbody>";

foreach( $results as $data )
{
	$n++;
echo "<tr valign='top' class='dibaca".$data['dibaca']."'><td align=center>$n</td><td>".$data['dis_pada']."</td><td>".sm_disposisi_dari($data['dari'])."</td><td>".$data['untuk']."</td><td>".$data['tgl']."</td><td>".$data['agenda']."</td><td>".$data['tgl_surat']."</td><td>".$data['no_surat']."</td><td>".$data['hal']."</td><td>".$data['pengirim']."</td><td>".sm_media($data['id_sm'])."</td><td>".sm_disposisi_kepada($data['id_sm'])."</td><td align=center><a href='?t=View&id=".$data['id_sm']."'><img src='css/edit.png' height='15px'></a></td></tr>";
}
echo "</tbody></table>";
}





function sm_arsip(){
$db = new database();
$db->connect(app_db());

$query = "SELECT * FROM sm WHERE tgl>='".tgl_pilih("m")."' and tgl<='".tgl_pilih("s")."' and hal LIKE '%".tgl_pilih("h")."%' order by update_pada desc";
$results = $db->get_results( $query );
$n=0;
echo tgl_pilih_f()."".tgl_pilih("h")."<table class='table' width=100% id=example>
<thead>
<tr><th>NO</th><th>TANGGAL</th><th>NO AGENDA</th><th>TGL SURAT</th><th>NO SURAT</th><th>HAL</th><th>PENGIRIM</th><th>DOKUMEN</th><th></th><th>DISPOSISI&nbsp;MONITORING</th></tr>
</thead><tbody>";

foreach( $results as $data )
{
	$n++;
echo "<tr valign='top'><td align=center>$n</td><td>".$data['tgl']."</td><td>".$data['agenda']."</td><td>".$data['tgl_surat']."</td><td>".$data['no_surat']."</td><td>".$data['hal']."</td><td>".$data['pengirim']."</td><td>".sm_media($data['id'])."</td><td align=center><a href='?t=Edit&id=".$data['id']."'><img src='css/edit.png' height='15px'></a></td><td class='small'>".sm_disposisi_tree($data['id'])."</td></tr>";
}
echo "</tbody></table><div style='text-align:center'><a target='_blank' href='print/r_sm.php?m=".tgl_pilih("m")."&s=".tgl_pilih("s")."'>Print to PDF</a> &nbsp; <a target='_blank' href='print/x_sm.php?m=".tgl_pilih("m")."&s=".tgl_pilih("s")."'>Export to XLS</a></div>";
}

function sm_disposisi_tree($unik) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM sm_disposisi WHERE dari='0' and id_sm ='".$unik."' order by dis_pada";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $data )
{
	$n++;
$row.= "<div>- ".db_baca(real_db(),"karyawan","id='".$data['kepada']."'","nama")."</div>";
$row.=disposisi_tree2($unik,$data['kepada']);
}
return $row;
}

function disposisi_tree2($unik,$dari) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM sm_disposisi WHERE dari='".$dari."' and id_sm ='".$unik."' order by dis_pada";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $data )
{
	$n++;
	$ada=app_baca("sm_disposisi","dari='".$data['kepada']."' and id_sm ='".$unik."'","kepada");
$row.= "<div style='margin:0 0 0 10px'>- ".db_baca(real_db(),"karyawan","id='".$data['kepada']."'","nama")."";
if ($ada>0) { 
$row.=disposisi_tree2($unik,$data['kepada']);
}
$row.= "</div>";
}
return $row;
}

function sm_form($tab) {

if ($tab=="Tambah") {
$unik=unik();
app_insert("sm"," '".$unik."', '".today()."', '', '".today()."', '', ' ', '', '".user_id()."', '".now()."', '".user_id()."', '".now()."'");	
echo "<meta http-equiv=\"refresh\" content=\"0; URL=?t=Edit&id=".$unik."\">";
$tgl=today();
$tgl_surat=today();
$no_surat=$agenda=$hal=$pengirim="";
}
if ($tab=="Edit") {
$id=$_GET['id'];
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM sm WHERE id = '".$id."' order by id desc";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	
$unik=$data['id'];
$tgl=$data['tgl'];
$tgl_surat=$data['tgl_surat'];
$no_surat=$data['no_surat'];
$agenda=$data['agenda'];
$hal=$data['hal'];
$pengirim=$data['pengirim'];
$oleh=$data['oleh'];
$pada=$data['pada'];

}
}	
	
echo "<form method='post' action='exe/sm_simpan.php' target='simpan'>
<table cellspacing='0' cellpadding='3' style='width:98%;'>
<tr><td colspan=3></td></tr>
<tr><td  style='width:10%;'>Tanggal</td><td style='width:1%;'>:</td><td><input type='date' name='tgl' value='$tgl' onchange=\"javascript:this.form.submit();\" ></td></tr>
<tr><td>Nomor Agenda</td><td>:</td><td><input type='text' name='agenda' value='$agenda' style='width:200px;' onkeyup=\"javascript:this.form.submit();\" ></td></tr>
<tr><td>Tanggal Surat</td><td  style='width:10px;'>:</td><td><input type='date' name='tgl_surat' value='$tgl_surat' onchange=\"javascript:this.form.submit();\" ></td></tr>
<tr><td>Nomor Surat</td><td>:</td><td><input type='text' name='no_surat' value='$no_surat'  style='width:66%;' onkeyup=\"javascript:this.form.submit();\" ></td></tr>
<tr><td>Hal</td><td>:</td><td><input type='text' name='hal' value='$hal' style='width:99%;' onkeyup=\"javascript:this.form.submit();\" ></td></tr>
<tr><td>Pengirim</td><td>:</td><td><input type='text' name='pengirim' value='$pengirim' style='width:99%;' onkeyup=\"javascript:this.form.submit();\" ></td></tr>
<tr><td>Reference</td><td>:</td><td>$unik<input type='hidden' name='unik' value='$unik'></td></tr>
<input type='hidden' name='oleh' value='$oleh'><input type='hidden' name='pada' value='$pada'>
</table>
<iframe src='' name='simpan' style='width:99%;height:0px;border:0px;'></iframe>
</form>";

media("sm",$unik);
}

function sm_view($unik) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM sm join sm_disposisi ON sm.id=sm_disposisi.id_sm WHERE kepada='".user_id()."' and sm.id= '".$unik."'order by sm.id desc";
$results = $db->get_results( $query );
foreach( $results as $data )
{

$dis_id=$data['dis_id'];
$unik=$data['id'];
$tgl=$data['tgl'];
$tgl_surat=$data['tgl_surat'];
$no_surat=$data['no_surat'];
$agenda=$data['agenda'];
$hal=$data['hal'];
$pengirim=$data['pengirim'];
$oleh=$data['oleh'];
$pada=$data['pada'];
$update_oleh=$data['update_oleh'];
$update_pada=$data['update_pada'];
}

	
echo "
<table cellspacing='0' cellpadding='3'>
<tr><td colspan=3></td></tr>
<tr><td  style='width:90px;'>Tanggal</td><td>:</td><td>$tgl</td></tr>
<tr><td>Nomor Agenda</td><td>:</td><td>$agenda</td></tr>
<tr><td>Tanggal Surat</td><td  style='width:10px;'>:</td><td>$tgl_surat</td></tr>
<tr><td>Nomor Surat</td><td>:</td><td>$no_surat</td></tr>
<tr><td>Hal</td><td>:</td><td>$hal</td></tr>
<tr><td>Pengirim</td><td>:</td><td>$pengirim</td></tr>
<tr><td>Reference</td><td>:</td><td>$unik</td></tr>
<tr><td>Diinput</td><td>:</td><td>$pada $oleh </td></tr>
<tr><td>Diupdate</td><td>:</td><td>$update_pada $update_oleh</td></tr>
<tr><td>Scan File</td><td>:</td><td>".sm_media($data['id_sm'])."</td></tr>
<tr><td>Disposisi dari</td><td>:</td><td>".sm_disposisi_dari($data['dari'])."</td></tr>
<tr><td>Disposisi kepada</td><td>:</td><td></td></tr>
</table>";
echo "
<form action='exe/sm_disposisi.php?id_sm=".$unik."' method='POST' target='disposisi'> Nama: <select id='select1' name=nama ><option></option>".karyawan_opt()."</select>
Untuk : <input type='text' name='untuk' size=70 /> <input type='submit' value=Tambah > <input type='hidden' name='unik' value='$unik'>
<iframe src='exe/sm_disposisi.php?id_sm=".$unik."' name='disposisi' style='width:99%;height:200px;border:0px;'></iframe></form>
"; 
app_update("sm_disposisi","dis_id='".$dis_id."'","dibaca='1'");
}




function sm_disposisi_kepada($unik) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM sm_disposisi WHERE dari='".user_id()."' and id_sm ='".$unik."' order by dis_pada desc";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $data )
{
	$n++;
$row.= "".$n.". ".db_baca(real_db(),"karyawan","id='".$data['kepada']."'","nama")."<br>";
}
return $row;
}

function sm_disposisi_dari($id) {
if ($id==0) { return "Penerima Surat"; } else {	return db_baca(real_db(),"karyawan","id='".$id."'","nama");}
}


function sm_media($id) {
return	ofc_media("sm/".$id);
}

