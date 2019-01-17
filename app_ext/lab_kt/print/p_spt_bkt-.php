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
echo "<center><b>BUKTI KEHADIRAN PELAKSANAAN PERJALANAN DINAS JABATAN<br>
NO SURAT TUGAS : ".$no_spt=app_baca("spt","id='$id'","no_spt")."/".app_baca("spt_global","name='nomor'","value")."/".substr($tgl,5,2)."/".substr($tgl,0,4)."<br>
DALAM KOTA KURANG DARI 8 JAM</b></center><br><br>
<table  cellpadding='3' cellspacing='0' class=border width=100%>
<tr><th rowspan='2' width='10px'>NO</th><th width='220px' rowspan='2'>NAMA/NIP</th><th width='100px' rowspan='2'>HARI</th><th width='150px' rowspan='2'>TANGGAL</th><th colspan=3>PEJABAT / PETUGAS YANG MENGESAHKAN </th></tr>
<tr><th width='200px'>NAMA</th><th width='200px'>JABATAN</th><th width='200px'>TANDA TANGAN / STEMPEL</th></tr>
";
$tgl=app_baca("spt","id='$id'","waktu_selesai");
$hari=nama_hari_id($tgl);
$tglp=tgl_p($tgl);
$no=1;
foreach( $results as $data )
{
$spd=$data['spd'];
$id=$data['id'];
echo "<tr valign=top><td>".$no."</td><td>".$data['nama']."<br>NIP. ".$data['nip']."</td><td align='center'>".$hari." </td><td align='center'>".$tglp."</td><td></td><td></td><td></td></tr>";
$no++;
}
echo "</table>
<p align=right>Bekasi, ".tgl_p($tgl)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</p>
";
?>

</body>
</html>