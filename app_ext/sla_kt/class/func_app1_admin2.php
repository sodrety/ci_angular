<?php

function distribusi0(){

if ($_GET['tgl_periksa']=="") {$tgl_periksa=next_date(today());} else {$tgl_periksa=$_GET['tgl_periksa'];}


if ($_POST['tambah']=="Tambah") {
$no_reg="2019.2.0300.0.S01.".$_POST['kode'].".".substr("000000".$_POST['no_permohonan'],-6);

if ($_POST['kode']=="E") { $no_aju=db_baca("dropbox","barcode","no_reg='".$no_reg."'","no_aju"); } 
else {$no_aju=db_baca("dropbox","barcode","no_reg='".((substr($no_reg,-6))*1)."' and bidang='2' and lintas='I' order by last_antri desc","no_aju"); }

$akun=substr($no_aju,5,7);
$pers=db_baca("dropbox","akun_pj","akun='".$akun."'","perusahaan");	
	//$pers=db_baca("movedb","kt_ekspor","no_permohonan='".$no_reg."'","perusahaan");
//}
//if ($_POST['kode']=="I") {//$pers=db_baca("movedb","kt_impor","no_reg='".$no_reg."'","nama_pemilik");
//}
// var_dump($pers);exit();
app_replace("alokasi","'".$_POST['id']."','".$tgl_periksa."','".$no_reg."','".$pers."','".$_POST['kota']."','".$_POST['jumlah']."','0'");	
}

if ($_POST['del_doc']==" X ") {
if ($_POST['src']=="ori") {	app_replace("alokasi_del","'".$_POST['no_permohonan']."'");	 }
if ($_POST['src']=="add") {	app_delete("alokasi","no_permohonan='".$_POST['no_permohonan']."'"); }
app_delete("distribusi","no_permohonan='".$_POST['no_permohonan']."'");

}

if ($_POST['del_popt']==" X ") {
app_delete("jadwal","id_jadwal='".$tgl_periksa."_".$_POST['id_popt']."'");
}

if ($_POST['alokasi']=="Simpan") {
$jen=app_baca("popt","id='".$_POST['untuk']."'","jenjang");
app_replace("distribusi","'".$tgl_periksa."_".$_POST['untuk']."','".$tgl_periksa."','".$_POST['untuk']."','".$_POST['no']."','".$jen."','','".app_baca("alokasi","no_permohonan='".$_POST['no']."'","kota")." : ".app_baca("alokasi","no_permohonan='".$_POST['no']."'","perusahaan")."','1'");	
}
if ($_POST['do']=="new_group") {
app_insert("alokasi_group","'', '".$tgl_periksa."'");
}
jml_rand($tgl_periksa);
alokasi_sort($tgl_periksa);
$n=0;
echo "
<form method=get>
Tgl Periksa <input type=date value='".$tgl_periksa."' name='tgl_periksa'>
<input type=hidden name=t value='Distribusi' >
<input type=submit name=cari value=Cari style='padding:3px;'></form>
";

$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM alokasi_group WHERE tgl_periksa LIKE '".$tgl_periksa."%' order by id desc";
$results = $db->get_results( $query );

echo "
<h3>DOKUMEN PERIKSA</h3>
<form method=post><input type=submit name=tambah value='Add New Group'><input type=hidden name=do value='new_group'></form>
<table class='table' width=100% id=example10>
<thead>
<tr><th>NO</th><th>TANGGAL PERIKSA</th><th>GROUP ID</th><th>TAMBAH</th><th>PERUSAHAAN</th><th>NO REG</th><th>JUMLAH PETUGAS</th><th>KOTA</th><th></th><th></th></tr>
</thead>
<tbody>";
$nn=1;
$n=1;
$np=0;
foreach( $results as $data )
{


$query2 = "SELECT * FROM alokasi WHERE group_id='".$data['id']."' order by no_permohonan";
$results2 = $db->get_results( $query2 );
if ($n%2) { $bg="";} else {$bg="#cccccc";}
$nd=0;
$jml_p=0;
foreach( $results2 as $data2 )
{
$no_opt.="<option value='".$data2['no_permohonan']."'>".$data2['no_permohonan']."</option>";
	$lokasi=$data2['kota'];
if ($nd==0) {$aa="<a href=\"javascript:void(0);\" data-href=\"form.php?id=".$data['id']."\" class=\"openPopup\">Tambah</a>"; } else {$aa="";}

if (strstr($data2['no_permohonan'],"E")) { 
$no_aju=db_baca("dropbox","barcode","no_reg='".$data2['no_permohonan']."'","no_aju"); } else {$no_aju=db_baca("dropbox","barcode","no_reg='".((substr($data2['no_permohonan'],-6))*1)."' and bidang='2' and lintas='I' order by last_antri desc","no_aju"); }
$akun=substr($no_aju,5,7);
$pt=db_baca("dropbox","akun_pj","akun='".$akun."'","perusahaan");
//$akun=substr($no_aju,5,7);
//$pt=db_baca("dropbox","akun_pj","akun='".$akun."'","perusahaan");
//db_update("dropbox","akun_pj","akun='".$akun."'","kota='".$data2['kota']."'");
app_update("alokasi","no_permohonan='".$data2['no_permohonan']."'","perusahaan='".$pt."'");
echo "<tr valign='top' bgcolor='".$bg."'><td align=center>$nn</td><td>".$data['tgl_periksa']."</td><td>".$data['id']."</td><td>".$aa."</td><td>".$pt."</td><td>".substr($data2['no_permohonan'],-8)."</td><td>".$data2['jml_petugas']."</td><td>".$data2['kota']."</td><form method=post><td><input type=hidden name=no_permohonan value='".$data2['no_permohonan']."'><input type=hidden name=src value=add><input type=submit name=del_doc value=' X ' class=x></td><td><a href='?t=Distribusi&tgl_periksa=".$tgl_periksa."&no=".$data2['no_permohonan']."&kota=".$data2['kota']."&pt=".$data['perusahaan']."'>d</a></td></form></tr>";
$jml_p+=$data2['jml_petugas'];
$dat.=$dtanya;
$nn+=1;
$nd+=1;
$np+=1;
}
if ($nd<=0) {
echo "<tr valign='top'><td align=center>$nn</td><td>".$data['tgl_periksa']."</td><td>".$data['id']."</td><td><a href=\"javascript:void(0);\" data-href=\"form.php?id=".$data['id']."\" class=\"openPopup\">Tambah</a></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
$nn+=1;
} else {$ng+=1;}
$jma.=" ".$nd." ";
if ($nd==1) {$jmlp+=$jml_p;} elseif ($nd>1) {$jmlp+=$nd;}
$n+=1;
}

echo "</tbody></table>";
//data_ekspor($tgl_periksa);
$db->connect(app_db());
$query = "SELECT * FROM jadwal JOIN popt ON jadwal.id_popt=popt.id JOIN realisasi_jml ON realisasi_jml.id_popt=popt.id WHERE tgl='".$tgl_periksa."' order by jml_rand,jnj,jml";
$results3 = $db->get_results( $query );

$ns=1;
foreach( $results3 as $data )
{
$id_lokasi=app_baca("penempatan","id_penempatan='".substr($tgl_periksa,0,4)."_".substr($tgl_periksa,5,2)."_".$data['id_popt']."'","id_lokasi");
$lokasi=app_baca("lokasi","id_lokasi='".$id_lokasi."'","lokasi");
$dtp.=	$data['nama']." :: ".$data['id_popt']." :: ".$lokasi."|||";
if ($ns<=$jmlp) {
$bg=""; 
} else {$bg="bgcolor='#cccccc'";}
$ada=app_baca("distribusi","tgl_periksa='".$tgl_periksa."' and id_popt='".$data['id_popt']."'","id");
if ($ada!="") {$nama="<b>".$data['nama']."</b>";} else {$nama="".$data['nama']."";}
$dt_peg.= "<tr valign='top' ".$bg."><td align=center>$ns</td><td>".$data['tgl']."</td><td>".$nama."</td><td>".$data['id_popt']."</td><td>".$data['jenjang']."</td><td>".$lokasi."</td><td>".$data['jml_rand']."</td><td>".$data['jnj']."</td><td>".$data['jml']."</td><form method=post><td><input type=hidden name=id_popt value='".$data['id_popt']."'><input type=submit name=del_popt value=' X ' class=x></td></form></tr>";
$ns+=1;	
$popt_opt.="<option value='".$data['id_popt']."'>".$data['nama']."</option>";
}
echo "
<h3>JADWAL PETUGAS</h3>
<table class='table' width=100% id=example2>
<thead>
<tr><th>NO</th><th>JADWAL</th><th>NAMA</th><th>ID</th><th>JENJANG</th><th>PENEMPATAN</th><th>AKUMULASI RANDOM</th><th>AUTO SORT</th><th>AKUMULASI PERJALANAN</th><th></th></tr>
</thead><tbody>";
echo $dt_peg;
echo "</tbody></table>";
echo "<form method=post><input type=hidden name=no value='".$_GET['no']."'>Tambah <select name=untuk id=select2><option></option>".popt_opt()."</select> PT <select name=no id=select3><option value='Unknown'></option>".$no_opt."</select><input type=submit name=alokasi value=Simpan></form>";
dis_alocate2($tgl_periksa);
echo "<center><br><a href='?t=Distribusi2&tgl_periksa=".$tgl_periksa."' style='font-size:21px;'>Random Sekarang / Random Ulang</a></center>";
if ($tgl_periksa<=today()) {
//echo "<meta http-equiv=\"refresh\" content=\"1; URL=?t=Distribusi&tgl_periksa=".next_date($tgl_periksa)."\">";
}
}

function distribusi(){

if ($_GET['tgl_periksa']=="") {$tgl_periksa=next_date(today());} else {$tgl_periksa=$_GET['tgl_periksa'];}
$n=0;
echo "
<form method=get>
Tgl Periksa <input type=date value='".$tgl_periksa."' name='tgl_periksa'>
<input type=hidden name=t value='Distribusi' >
<input type=submit name=cari value=Cari style='padding:3px;'></form>
";
to_zero($tgl_periksa);
jml_rand($tgl_periksa);
alokasi_sort($tgl_periksa);
jenjang_sort($tgl_periksa);


$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM alokasi_group WHERE tgl_periksa LIKE '".$tgl_periksa."%' order by id desc";
$results = $db->get_results( $query );

echo "
<h3>DOKUMEN PERIKSA</h3>
<form method=post><input type=submit name=tambah value='Add New Group'><input type=hidden name=do value='new_group'></form>
<table class='table' width=100% id=example10>
<thead>
<tr><th>NO</th><th>TANGGAL PERIKSA</th><th>GROUP ID</th><th>PERUSAHAAN</th><th>NO REG</th><th>JUMLAH PETUGAS</th><th>KOTA</th></tr>
</thead>
<tbody>";
$nn=1;
$n=1;
$np=0;
foreach( $results as $data )
{


$query2 = "SELECT * FROM alokasi WHERE group_id='".$data['id']."' order by urut";
$results2 = $db->get_results( $query2 );
if ($n%2) { $bg="";} else {$bg="#cccccc";}
$nd=0;
$jml_p=0;
foreach( $results2 as $data2 )
{
	$lokasi=$data2['kota'];
echo "<tr valign='top' bgcolor='".$bg."'><td align=center>".($np+1)."</td><td>".$data['tgl_periksa']."</td><td>".$data['id']."</td><td>".$data2['perusahaan']."</td><td>".substr($data2['no_permohonan'],-8)."</td><td>".$data2['jml_petugas']."</td><td>".$data2['kota']."</td></td></td></td></form></tr>";
$jml_p+=$data2['jml_petugas'];
//if (strstr($lokasi,"ekasi")) {$bk+=1;}
//if ($bk=="1") {$datb.=$dtanya;} else {$dat.=$dtanya;}
$dat.=$dtanya;
$nn+=1;
$nd+=1;
$np+=1;
}
if ($nd<=0) {
$nn+=1;
} else {$ng+=1;}
$jma.=" ".$nd." ";
if ($nd==1) {$jmlp+=$jml_p;} elseif ($nd>1) {$jmlp+=$nd;}
$n+=1;
}

echo "</tbody></table>";
  
$db->connect(app_db());
$query = "SELECT * FROM jadwal JOIN popt ON jadwal.id_popt=popt.id JOIN realisasi_jml ON realisasi_jml.id_popt=popt.id WHERE tgl='".$tgl_periksa."' and jnj>'0' order by jnj";
$results3 = $db->get_results( $query );

$ns=1;
foreach( $results3 as $data )
{
$id_lokasi=app_baca("penempatan","id_penempatan='".substr($tgl_periksa,0,4)."_".substr($tgl_periksa,5,2)."_".$data['id_popt']."'","id_lokasi");
$lokasi=app_baca("lokasi","id_lokasi='".$id_lokasi."'","lokasi");
$dtp.=	$data['nama']." :: ".$data['id_popt']." :: ".$lokasi."|||";
if ($ns<=$jmlp) {
$bg=""; 
if ($data['id_popt']=="137") {$bkt="cek";}
} else {$bg="bgcolor='#cccccc'";}
$dt_peg.= "<tr valign='top' ".$bg."><td align=center>$ns</td><td>".$data['tgl']."</td><td>".$data['nama']."</td><td>".$data['jenjang']."</td><td>".$lokasi."</td><td>".$data['jml_rand']."</td><td>".$data['jnj']."</td><td>".$data['jml']."</td></tr>";
$ns+=1;	
}
echo "
<h3>JADWAL PETUGAS</h3>
<table class='table' width=100% id=example2>
<thead>
<tr><th>NO</th><th>JADWAL</th><th>NAMA</th><th>JENJANG</th><th>PENEMPATAN</th><th>AKUMULASI RANDOM</th><th>AUTO SORT</th><th>AKUMULASI PERJALANAN</th></tr>
</thead><tbody>";
echo $dt_peg;
echo "</tbody></table>";

echo "
<h3>SIMULASI RANDOM</h3>
<table class='table' width=100% id=example3>
<thead>
<tr><th>NO</th><th>TGL</th><th>GROUP</th><th>NAMA-1</th><th>DOKUMEN</th><th>KETERANGAN</th><th>NAMA-2</th></tr>
</thead><tbody>";
$dtp = str_replace("|||FNL", "", $dtp."FNL");
$dtp = explode("|||", $dtp);
$npp=0;
foreach( $results as $data )
{
$jm=app_jml("alokasi","group_id='".$data['id']."'","no_permohonan");
if ($jm>0) {
$ng++;
$query2 = "SELECT * FROM alokasi WHERE group_id='".$data['id']."' order by no_permohonan";
$results2 = $db->get_results( $query2 );
foreach( $results2 as $data2 )
{
$dtd=$data2['no_permohonan']." :: ".$data2['kota']." :: ".$data2['perusahaan']."";
if ($jm==1) {
if ($data2['jml_petugas']>0) {
echo running($tgl_periksa,$ng,$dtp[$npp],$dtd,$npp,$np,$jm);
$npp+=1;	
}
if ($data2['jml_petugas']>1) {
echo running($tgl_periksa,$ng,$dtp[$npp],$dtd,$npp,$np,$jm);
$npp+=1;	
}
if ($data2['jml_petugas']>2) {
echo running($tgl_periksa,$ng,$dtp[$npp],$dtd,$npp,$np,$jm);
$npp+=1;	
}	
} else {
echo running($tgl_periksa,$ng,$dtp[$npp],$dtd,$npp,$np,$jm);
$npp+=1;
}	
}
}
}
echo "</tbody></table>";
$query2 = "SELECT * FROM alokasi WHERE tgl_periksa='".$tgl_periksa."' and group_id>'0' order by no_permohonan";
$results2 = $db->get_results( $query2 );
foreach( $results2 as $data2 )
{
$jmlp=$data2['jml_petugas'];
$alok=app_jml("distribusi","no_permohonan='".$data2['no_permohonan']."' and tgl_periksa='".$tgl_periksa."'","id_popt");
$jml=($jmlp-$alok);	
if ($jml>0) {
//$idpopt=app_baca("jadwal JOIN popt ON jadwal.id_popt=popt.id JOIN realisasi_jml ON realisasi_jml.id_popt=popt.id JOIN penempatan ON penempatan.id_popt=popt.id","jenjang!='".$jen."' and tgl='".$tgl_periksa."' and jnj>'".$np."' and pick='0' order by jnj","id");

//app_replace("distribusi","'".$tgl_periksa."_".$idpopt."','".$tgl_periksa."','".$idpopt."','".$data2['no_permohonan']."','".app_baca("popt","id='".$idpopt."'","jenjang")."','draft','".$data2['kota']." : ".$data2['perusahaan']."','0'");
//app_update("realisasi_jml","id_popt='".$idpopt."'", "pick='1'");
}
	
}



dis_alocate2($tgl_periksa);
if (nama_hari($tgl_periksa)=="Mon") { $t1=$tgl_periksa." 11:00:00";$t2=next_date(next_date(today())).date(" H:i:s");} else {$t1=$tgl_periksa." 11:00:00";$t2=next_date(today()).date(" H:i:s");}
echo $t1." &nbsp; ".$t2;
if ($t1<=$t2) {
$ket=app_baca("distribusi","tgl_periksa='".$tgl_periksa."' and id_popt='137'","ket");
if (strstr($ket,"ekasi") or strstr($ket,"arawang") or strstr($ket,"ogor")) {} elseif ($_GET['k']<11) { echo "<meta http-equiv=\"refresh\" content=\"0; URL=?t=Distribusi2&tgl_periksa=".$tgl_periksa."&k=".($_GET['k']+1)."\">";} else {}
echo "<center><br><a href='?t=Distribusi2&tgl_periksa=".$tgl_periksa."' style='font-size:21px;'>Random Ulang</a> &nbsp; &nbsp; &nbsp; <a href='?t=Distribusi&tgl_periksa=".$tgl_periksa."' style='font-size:21px;'>Selesai</a></center>
"; }
}

function jml_rand($tgl_periksa) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM jadwal JOIN popt ON jadwal.id_popt=popt.id JOIN realisasi_jml ON realisasi_jml.id_popt=popt.id WHERE tgl='".$tgl_periksa."'";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $data )
{
$jml=app_jml("distribusi","id_popt='".$data['id_popt']."' and nomor='1' and tgl_periksa>='".date("Y-m-01")."'","nomor");	
app_update("realisasi_jml","id_popt='".$data['id_popt']."'","jml_rand='".($jml*1)."'");
//echo $data['nama']." ".($jml*1)." <br>";
$n++;
}
}


function jenjang_sort($tgl_periksa) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM alokasi_group WHERE tgl_periksa LIKE '".$tgl_periksa."%' order by id desc";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$jm=app_jml("alokasi","group_id='".$data['id']."'","no_permohonan");
if ($jm>0) {
$query2 = "SELECT * FROM alokasi WHERE group_id='".$data['id']."' order by no_permohonan";
$results2 = $db->get_results( $query2 );
foreach( $results2 as $data2 )
{
if ($jm==1) {$npp+=$data2['jml_petugas'];} elseif ($jm>1) {$npp+=1;}
}
}
}

$query = "SELECT * FROM jadwal JOIN popt ON jadwal.id_popt=popt.id JOIN realisasi_jml ON realisasi_jml.id_popt=popt.id WHERE tgl='".$tgl_periksa."'order by jml_rand,jml limit 0,".$npp."";
$results = $db->get_results( $query );
$tr=-1;
$ah=0;
foreach( $results as $data )
{
$n++;
if ($data['jenjang']=="AHLI") {$dtah.=($ah+=2)."|||";}
if ($data['jenjang']=="TERAMPIL") {$dttr.=($tr+=2)."|||";}
}

$dttr = str_replace("|||FNL", "", $dttr."FNL");
$dttr = str_replace("||||||", "|||", $dttr);
$dtah = str_replace("|||FNL", "", $dtah."FNL");
$dtah = str_replace("||||||", "|||", $dtah);

$dttr = explode("|||", $dttr);
$dtah = explode("|||", $dtah);
shuffle ($dttr);
shuffle ($dtah);
$nah=0;
$ntr=0;
foreach( $results as $data )
{
if ($data['jenjang']=="AHLI") {
	app_update("realisasi_jml","id_popt='".$data['id_popt']."'","jnj='".$dtah[$nah]."'");
//	$xx.=$dtah[$nah]." a ";
$nah++;
	}
if ($data['jenjang']=="TERAMPIL") {
	app_update("realisasi_jml","id_popt='".$data['id_popt']."'","jnj='".$dttr[$ntr]."'");
	//$xx.=" ".$dttr[$ntr]." ";
	$ntr+=1;}	
$n++;

}
}



function dis_alocate2($tgl_periksa){
if ($_POST['del_rand']==" x ") {app_delete("distribusi","id='".$_POST['id']."'");}	
	


  $db = new database();
$db->connect(app_db());
if (date("Y-m-d H:i:s")<=$tgl_periksa." 08:00:00") {$wh="and nomor='1'";}
$query = "SELECT * FROM distribusi JOIN popt ON distribusi.id_popt=popt.id JOIN alokasi ON distribusi.no_permohonan=alokasi.no_permohonan WHERE distribusi.tgl_periksa='".$tgl_periksa."' ".$wh." order by group_id,distribusi.no_permohonan,nomor desc";
$results = $db->get_results( $query );

$nn=0;
echo "
<h3>DISTRIBUSI FINAL</h3>
<table class='table' width=100% id=example4>
<thead>
<tr><th>NO</th><th>TGL</th><th>GROUP</th><th>NAMA</th><th>ID</th><th>DOKUMEN</th><th>PERUSAHAAN</th><th>KETERANGAN</th><th>HAPUS</th></tr>
</thead><tbody>";
foreach( $results as $data )
{ 	
	$n+=1;
if ($data['nomor']=="0") {$bg="bgcolor='#cccccc'";} else {$bg="";}
if (strstr($data['no_permohonan'],"E")) { 
$no_aju=db_baca("dropbox","barcode","no_reg='".$data['no_permohonan']."'","no_aju"); } else {
$no_aju=db_baca("dropbox","barcode","no_reg='".((substr($data['no_permohonan'],-6))*1)."' and bidang='2' and lintas='I' order by last_antri desc","no_aju");  }
$akun=substr($no_aju,5,7);
$pt=db_baca("dropbox","akun_pj","akun='".$akun."'","perusahaan");
echo "<tr valign='top' ".$bg."><td align=center>$n</td><td>".$data['tgl_periksa']."</td><td>".$data['group_id']."</td><td>".$data['nama']."</td><td>".$data['id_popt']."</td><td>".$pt."</td><td>".$data['no_permohonan']."</td><td>".$data['ket']."</td><form method=post><td><input type=submit name='del_rand'value=' x '><input type=hidden name=id value='".$data['tgl_periksa']."_".$data['id_popt']."'</td></form></tr>";
} 
echo "</tbody></table>";
}
