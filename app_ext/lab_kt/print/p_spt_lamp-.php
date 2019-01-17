<html>
<head>
<style>
* { font-family:arial; font-size:15px;color:#000;}
body {padding:25mm 20mm 20mm 25mm;}
.border {border-top:1px solid #000;border-left:1px solid #000;}
.border tr td, .border tr th {border-bottom:1px solid #000;border-right:1px solid #000;}
</style>
<?php
include  "../class/class.php";

?>
</head>
<body>

<?php
$id_spt=$_GET['id'];
$db = new database();
$db->connect(app_db());
$query = "SELECT * from spt_petugas where id_spt='$id_spt' order by no";
$results = $db->get_results( $query );
$tgl=app_baca("spt","id='$id'","tgl");
echo "
<table>
<tr><td>Lampiran</td><td></td><td></td></tr>
<tr><td>Surat Tugas</td><td>:</td><td>".$no_spt=app_baca("spt","id='$id'","no_spt")."/".app_baca("spt_global","name='nomor'","value")."/".substr($tgl,5,2)."/".substr($tgl,0,4)."</td></tr>
<tr><td>Tanggal</td><td>:</td><td>".tgl_p(app_baca("spt","id='$id_spt'","tgl"))."</td></tr>
<tr><td colspan='3'><br>Ditugaskan kepada:</td></tr>
</table>

<table  cellpadding='3' cellspacing='0' class=border>
<tr><th>No.</th><th width='220px'>Nama/NIP</th><th width='140px'>Gol/Ruang</th><th width='160px'>Jabatan</th></tr>
";
$no=1;
foreach( $results as $data )
{
$spd=$data['spd'];
$id=$data['id'];
echo "<tr valign=top><td>".$no."</td><td>".$data['nama']."<br>NIP. ".$data['nip']."</td><td align='center'>".pangkat($data['gol'])." / ".$data['gol']." </td><td align='center'>".$data['jab']."</td></tr>";
$no++;
}
echo "</table>";
?>

</body>
</html>