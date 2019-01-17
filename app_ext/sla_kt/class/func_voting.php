<?php
function voting_korfung() {
$db = new database();
$db->connect(app_db());


if ($_POST) {
if ($_POST['c1']=="" or $_POST['c2']=="" or $_POST['c3']=="" or $_POST['c2']==$_POST['c3']) {$re= "Gagal";
} else {
app_replace("voting_hasil","'".user_id()."','".$_POST['c1']."','".$_POST['c2']."','".$_POST['c3']."','".now()."'");
//$jml_c1=app_jml("voting_hasil","c1='".$_POST['c1']."' or c2='".$_POST['c1']."' or c3='".$_POST['c1']."'","id_popt");
//$jml_c2=app_jml("voting_hasil","c1='".$_POST['c2']."' or c2='".$_POST['c2']."' or c3='".$_POST['c2']."'","id_popt");
//$jml_c3=app_jml("voting_hasil","c1='".$_POST['c3']."' or c2='".$_POST['c3']."' or c3='".$_POST['c3']."'","id_popt");
//app_update("voting_calon","id_popt='".$_POST['c1']."'","jml='".$jml_c1."'");
//app_update("voting_calon","id_popt='".$_POST['c2']."'","jml='".$jml_c2."'");
//app_update("voting_calon","id_popt='".$_POST['c3']."'","jml='".$jml_c3."'");

$re= "Tersimpan";}
}
$query1 = "SELECT * FROM voting_hasil WHERE id_popt='".user_id()."'";
$results1 = $db->get_results( $query1 );
foreach( $results1 as $data1 )
{
}

$query = "SELECT * FROM voting_calon JOIN popt ON voting_calon.id_popt=popt.id order by nama";
$results = $db->get_results( $query );
foreach( $results as $data )
{

if ($data['id']==$data1['c1']) {$nm1=$data['nama'];}
if ($data['id']==$data1['c2']) {$nm2=$data['nama'];}
if ($data['id']==$data1['c3']) {$nm3=$data['nama'];}

$n++;
//if (user_id()=="137" and $_GET['k']!="") {}
$h1=app_jml("voting_hasil","c1='".$data['id']."'","id_popt");$h2=app_jml("voting_hasil","c2='".$data['id']."'","id_popt");$h3=app_jml("voting_hasil","c3='".$data['id']."'","id_popt");$hall=($h2+$h3);
$jab=db_baca("user_login","karyawan","id='".$data['id']."'","jabatan");
$datanya.="<tr><td>".$n."</td><td>".$data['nama']."</td><td>".$jab."</td><td>".$h1."</td><td>".$h2."</td><td>".$h3."</td><td>".$hall."</td></tr>";
$opt="<option value='".$data['id']."'>".$data['nama']."</option>";
if (strstr(strtolower($jab),"madya")) {$optmy.=$opt; } else {$optmd.=$opt;}
$optp.=$opt;
}


$jmlh=app_jml("voting_hasil","id_popt>='0'","id_popt");

echo "<h2>PEMILIHAN CALON KOORFUNG POPT TH. 2019</h2>
Persentase <b>".des(($jmlh/133)*100)."</b> % ( $jmlh dari 133 )";

if (now()<="2018-12-31 11:00:00") {
echo "<form method=post>
<h3>Pilihan Anda:</h3>
#PRIORITAS <select name='c1' id='select1'><option value='".$data1['c1']."'>".$nm1."</option>".$optp."</select> #MADYA <select name='c2' id='select2'><option value='".$data1['c2']."'>".$nm2."</option>".$optmy."</select> #MUDA <select name='c3' id='select3'><option value='".$data1['c3']."'>".$nm3."</option>".$optmd."</select>
<input type=submit value='Simpan'> ".$re."</form>"; }

echo "
<h3>Daftar Calon</h3>
<table class='table' width=100% id=example2>
<thead>
<tr><th>NO</th><th>NAMA</th><th>JABATAN</th><th>#Prior</th><th>#Madya</th><th>#Muda</th><th></th></tr>
</thead><tbody>".$datanya."</tbody></table>";

$query = "SELECT id,nama FROM popt order by nama";
$results = $db->get_results( $query );
foreach( $results as $data )
{

$su=app_baca("voting_hasil","id_popt='".$data['id']."'","id_popt");
if ($su>0) {$sud="Sudah";$bel="";} else  {$sud="";$bel="Belum";$n3++;
//$datanya3.="<tr><td>".$n3."</td><td>".$data['nama']."</td><td>".$sud."</td><td>".$bel."</td></tr>";
$dtny.=$n3." ".$data['nama']."<br>";
}
//$datanya3.="<tr><td>".$n3."</td><td>".$data['nama']."</td><td>".$sud."</td><td>".$bel."</td></tr>";
}
echo "
<h3>Tidak Memilih:</h3>".$dtny;

}

