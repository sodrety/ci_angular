<?php

function sk_menu() {
$ap="sk.php";	
return "<a href='".$ap."?t=Tambah'>Tambah</a> <a href='".$ap."?t=Arsip'>Arsip</a> <a href='".$ap."?t=Pengiriman'>Pengiriman</a>";	
}
function sk_disposisi(){
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM sk join sk_disposisi ON sk.id=sk_disposisi.id_sm WHERE kepada='".user_id()."' and dis_pada>='".tgl_pilih("m")."' and dis_pada<='".tgl_pilih("s")."' and hal LIKE '%".tgl_pilih("h")."%' order by dis_pada desc";
$results = $db->get_results( $query );
$n=0;
echo tgl_pilih_f()."<table class='table' width=100% id=example>
<thead>
<tr><th>NO</th><th>DARI</th><th>WAKTU</th><th>TGL SURAT</th><th>NO SURAT</th><th>HAL</th><th>PENERIMA</th><th>DOKUMEN</th><th></th></tr>
</thead><tbody>";



foreach( $results as $data )
{
	$n++;
echo "<tr valign='top' class='dibaca".$data['dibaca']."'><td align=center>$n</td><td>".sk_disposisi_dari($data['dari'])."</td><td>".$data['dis_pada']."</td><td>".$data['tgl_surat']."</td><td>".$data['no_surat']."</td><td>".$data['hal']."</td><td>".$data['penerima']."</td><td>".sk_media($data['id_sm'])."</td><td align=center><a href='?t=View&id=".$data['id_sm']."'><img src='css/view.png' height='15px'></a></td></tr>";
}
echo "</tbody></table>";
}


function sk_arsip(){
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM sk WHERE tgl_surat>='".tgl_pilih("m")."' and tgl_surat<='".tgl_pilih("s")."' and hal LIKE '%".tgl_pilih("h")."%' order by update_pada desc";
$results = $db->get_results( $query );
$n=0;
echo tgl_pilih_f();

echo "<table class='table' width=100% id=example>
<thead>
<tr><th>NO</th><th>TGL SURAT</th><th>NO SURAT</th><th>HAL</th><th>PENERIMA</th><th>DOKUMEN</th><th></th><th>PENERIMA&nbsp;INTERNAL</th><th>PENERIMA&nbsp;EKSTERNAL</th></tr>
</thead><tbody>";

foreach( $results as $data )
{
	$n++;
echo "<tr valign='top'><td align=center>$n</td><td>".$data['tgl_surat']."</td><td>".$data['no_surat']."</td><td>".$data['hal']."</td><td>".$data['penerima']."</td><td>".sk_media($data['id'])."</td><td align=center><a href='?t=Edit&id=".$data['id']."'><img src='css/edit.png' height='15px'></a></td><td class='small'>".sk_disposisi_tree($data['id'])."</td><td></td></tr>";
}
echo "</tbody></table>
<div style='text-align:center'><a target='_blank' href='print/r_sk.php?m=".tgl_pilih("m")."&s=".tgl_pilih("s")."'>Print to PDF</a> &nbsp; <a target='_blank' href='print/x_sk.php?m=".tgl_pilih("m")."&s=".tgl_pilih("s")."'>Export to XLS</a></div>";
}

function sk_disposisi_tree($unik) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM sk_disposisi WHERE id_sm ='".$unik."' order by dis_pada";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $data )
{
	$n++;
$row.= "<div>- ".db_baca(real_db(),"karyawan","id='".$data['kepada']."'","nama")."</div>";
}
return $row;
}

function sk_form($tab) {

if ($tab=="Tambah") {
$unik=unik();
$no_s="/".app_baca("sk_global","name='app_num'","value")."/".date("m")."/".date("Y");
app_insert("sk"," '".$unik."', '".today()."', '".$no_s."', ' ', '', '".user_id()."', '".now()."', '".user_id()."', '".now()."','\n','Kepala','1'");	
echo "<meta http-equiv=\"refresh\" content=\"0; URL=?t=Edit&id=".$unik."\">";
$tgl=today();
$tgl_surat=today();
$no_surat=$agenda=$hal=$pengirim="";
}
if ($tab=="Edit") {
$id=$_GET['id'];
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM sk WHERE id = '".$id."' order by id desc";
$results = $db->get_results( $query );
foreach( $results as $data )
{
	
$unik=$data['id'];
$tgl_surat=$data['tgl_surat'];
$no_surat=$data['no_surat'];
$hal=$data['hal'];
$penerima=$data['penerima'];
$oleh=$data['oleh'];
$pada=$data['pada'];
$isi=$data['isi'];
$kep_jab=$data['kep_jab'];
$kep_nama=$data['kep_nama'];
}
}	
	
echo "
<form method='post' action='exe/sk_simpan.php' target='simpan'>
<table cellspacing='0' cellpadding='3' style='width:98%;'>
<tr><td colspan=3></td></tr>
<tr><td style='width:10%;'>Tanggal Surat</td><td  style='width:1%;'>:</td><td><input type='date' name='tgl_surat' value='$tgl_surat' onchange=\"javascript:this.form.submit();\" ></td></tr>
<tr><td>Nomor Surat</td><td>:</td><td><input type='text' name='no_surat' value='$no_surat'  style='width:250px;text-align:right' onkeyup=\"javascript:this.form.submit();\" ></td></tr>
<tr><td>Hal</td><td>:</td><td><input type='text' name='hal' value='$hal' style='width:99%;' onkeyup=\"javascript:this.form.submit();\" ></td></tr>
<tr><td>Penerima</td><td>:</td><td><input type='text' name='penerima' value='$penerima' style='width:99%;' onkeyup=\"javascript:this.form.submit();\" ></td></tr>

<tr><td></td><td></td><td><input type='submit'value=' &nbsp; Simpan &nbsp; ' ></td></tr>
<tr><td>Reference</td><td>:</td><td>$unik<input type='hidden' name='unik' value='$unik'></td></tr>
<input type='hidden' name='oleh' value='$oleh'><input type='hidden' name='pada' value='$pada'>
</table>
<iframe src='' name='simpan' style='width:99%;height:0px;border:0px;'></iframe>
</form>";
media("sk",$unik);
echo "
<form action='exe/sk_disposisi.php?id_sm=".$unik."' method='POST' target='disposisi'> Kirim kepada: <select id='select2' name=nama style='font-size:11px;'><option></option>".karyawan_opt()."</select> <input type='submit' value=Tambah > <input type='hidden' name='unik' value='$unik'>
<iframe src='exe/sk_disposisi.php?id_sm=".$unik."' name='disposisi' style='width:99%;height:200px;border:0px;'></iframe></form>
"; 
}

function sk_view($unik) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM sk join sk_disposisi ON sk.id=sk_disposisi.id_sm WHERE kepada='".user_id()."' and sk.id= '".$unik."'order by sk.id desc";
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
$penerima=$data['penerima'];
$oleh=$data['oleh'];
$pada=$data['pada'];
$update_oleh=$data['update_oleh'];
$update_pada=$data['update_pada'];
}

	
echo "
<table cellspacing='0' cellpadding='3'>
<tr><td colspan=3></td></tr>
<tr><td style='width:90px;'>Tanggal Surat</td><td  style='width:10px;'>:</td><td>$tgl_surat</td></tr>
<tr><td>Nomor Surat</td><td>:</td><td>$no_surat</td></tr>
<tr><td>Hal</td><td>:</td><td>$hal</td></tr>
<tr><td>Penerima</td><td>:</td><td>$penerima</td></tr>
<tr><td>Reference</td><td>:</td><td>$unik</td></tr>
<tr><td>Diinput</td><td>:</td><td>$pada $oleh </td></tr>
<tr><td>Diupdate</td><td>:</td><td>$update_pada $update_oleh</td></tr>
<tr><td>Scan File</td><td>:</td><td>".sk_media($data['id_sm'])."</td></tr>
<tr><td>Dikirim oleh</td><td>:</td><td>".sk_disposisi_dari($data['dari'])."</td></tr>
</table>";
app_update("sk_disposisi","dis_id='".$dis_id."'","dibaca='1'");
}


function sk_disposisi_dari($id) {
if ($id==0) { return "Pengirim Surat"; } else {	return db_baca(real_db(),"karyawan","id='".$id."'","nama");}
}

function sk_media($id) {
return	ofc_media("sk/".$id);
}

