<html>
<head>

<style>
* {font-family:arial;font-size:13px;}
h2 {font-size:17px;}
* input {width:100%;}
table {border-left:1px solid #ccc; border-top:1px solid #ccc; border-spacing: 0px; border-collapse: separate;}

table tr td,table tr th {border-right:1px solid #ccc; border-bottom:1px solid #ccc; padding:3px;}
</style>
</head>
<body>
<?php
require_once( '../class/class.php' );
$db = new database();
$db->connect("tugasdb");
$nom_id=$_GET['nom_id'];


function petugas_spt($id,$tgl) {
$db = new database();
$db->connect("tugasdb");
$query = "SELECT nama,id_user FROM spt_petugas WHERE id_spt='".$id."' order by no,id";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$nm.=$data['nama']." ".petugas_cek($data['id_user'],$tgl)."<br>";	
}	
return "".$nm;
}


function petugas_cek($id_user,$tgl) {
$db = new database();
$db->connect("tugasdb");
$query = "SELECT id_user FROM spt_petugas join spt ON spt_petugas.id_spt=spt.id WHERE id_user='".$id_user."' and waktu_selesai='".$tgl."' and kat='TKT' and nom_id>'0' limit 2,3";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$nm++;	
}	
return "<span style='color:red'>".$nm."</span>";
}

if ($_GET['del_id']!="") {
db_update("tugasdb","spt","id='".$_GET['del_id']."'","nom_id='0'");
}


if ($_GET['id_spt']=="semua") {
$query1 = "SELECT id FROM spt where mak='".$_GET['mak']."' and nom_id<1 and waktu_selesai<'".$_GET['tgl']."' and tahun='2018' order by waktu_selesai";
$results1 = $db->get_results( $query1 );

foreach( $results1 as $data1 )
{	
db_update("tugasdb","spt","id='".$data1['id']."'","nom_id='".$nom_id."'");	
}	

} elseif ($_GET['id_spt']!="") {
db_update("tugasdb","spt","id='".$_GET['id_spt']."'","nom_id='".$nom_id."'");
}



$top=$_GET['top'];
$query = "SELECT * from spt where nom_id='$nom_id' order by waktu_mulai,waktu_selesai";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$rp=db_sum("tugasdb","realisasi","id_spt='".$data['id']."'","nilai");
$pet=db_jml("tugasdb","spt_petugas","id_spt='".$data['id']."'","id");
$to+=$rp;
$nomer+=$pet;
$no+=1;
$jml_petugas+=$pet;
$dt.="<tr valign=top><td>".($nomer-1)."<br>".$nomer."</td><td>".$data['no']."</td><td>".$data['waktu_selesai']."</td><td>".petugas_spt($data['id'],$data['waktu_selesai'])."</td><td>".rp($rp)."</td><td><a href='?nom_id=".$nom_id."&del_id=".$data['id']."'> x </a></td><td><a target='_blank' href='../../tugas/st.php?tab=edit&id=".$data['id']."'>ed-spt</a></td><td><a target='_blank' href='../../tugas/print/dalkot.php?id=".$data['id']."'>dalkot</a></td></tr>";


}
echo "Rp. <b>".rp($to)."</b><br>
<table>
".$dt."</table>";
db_update("tugasdb","nominatif","id='".$nom_id."'","jml_spt='".$no."', jml_petugas='".$jml_petugas."', jml_nom='".$to."'");
?>
</body>
</html>
