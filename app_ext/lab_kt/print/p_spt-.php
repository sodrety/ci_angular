<?php
session_start();
//error_reporting(E_ALL & ~E_NOTICE);
?>
<?php
require_once( '../class/class.php' );
$id=$_GET['id'];

function pukul($p){
if ($p!="") {
return " Pukul ".$p; }
}

function petugaslist_depan($id_spt) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * from spt_petugas where id_spt='$id_spt' order by no";
$results = $db->get_results( $query );
$no=1;
foreach( $results as $data )
{	
if ($no==1) {$kepada="Kepada"; $sa=":";} else {$kepada="";$sa="";}
$all.="
<tr valign='top' class=petugas><td>$kepada</td><td>$sa</td><td>$no</td> <td>Nama/NIP</td><td>:</td><td>".$data['nama']."/".$data['nip']." $spd</td></tr>

<tr valign='top' class=petugas><td></td><td></td><td></td><td>Pangkat/Gol.Ruang</td><td>:</td><td>".pangkat(strtolower($data['gol']))." / ".strtolower($data['gol'])."</td></tr>
<tr valign='top' class=petugas><td></td><td></td><td></td><td>Jabatan</td><td>:</td><td>".$data['jab']."</td></tr>

";
$no++;
}
if ($no>6) {
echo "<tr valign='top' class=petugas><td>Kepada</td><td>:</td><td></td> <td>Terlampir</td><td></td><td></td></tr>";
} else { echo $all;	
}
}

echo "
<style>
* {font-size:14px; font-family:arial,times,time;}
body { margin:57mm 25mm 20mm 25mm; width:160mm; }
#judul {text-align:center; font-weight:700; font-size:17px;
}
.border tr td {text-align:justify;}
hr { border-top:1px solid #555; margin:5px 0 0 0;}
.barcode {position:fixed;left:25mm;bottom:5mm;}
</style>";

$id=$_GET['id'];
$tgl=app_baca("spt","id='$id'","tgl");
$no_spt=app_baca("spt","id='$id'","no_spt")."/".app_baca("spt_global","name='nomor'","value")."/".substr($tgl,5,2)."/".substr($tgl,0,4);
$p1=app_baca("spt","id='$id'","p1");
$tujuan=app_baca("spt","id='$id'","tujuan");
$waktu_mulai=app_baca("spt","id='$id'","waktu_mulai");
$waktu_selesai=app_baca("spt","id='$id'","waktu_selesai");
$lokasi=app_baca("spt","id='$id'","lokasi");
$tahun=app_baca("spt","id='$id'","tahun");
$mak=app_baca("spt","id='$id'","mak");
if ($tahun>="2018") {$mak=db_baca("b_realisasi_".$tahun,"pok","no='".$mak."'","mak");}

$kep_jab=app_baca("spt","id='$id'","kep_jab");
$kep_nama=app_baca("spt","id='$id'","kep_nama");
$kep_nip=app_baca("spt","id='$id'","kep_nip");
$unik=app_baca("spt","id='$id'","unik");
$kota=app_baca("spt","id='$id'","kota");
$tembusan=app_baca("spt","id='$id'","tembusan");
$dip=app_baca("spt","id='$id'","dipa");

$pukul=app_baca("spt","id='$id'","pukul");
if ($tahun!="") {$th=" Tahun Anggaran ".$tahun;}
if ($dip=="" or $dip=="-") {$dipa="-";} else {$dipa=$dip." ".$th;}
echo "
<center><u><span id=judul>S U R A T &nbsp; T U G A S</span></u>
<br> No: ".str_replace("  ", "&nbsp; ",$no_spt)."
</center><br>";
if ($mak!="") {
$makk=", Mata Anggaran Kegiatan $mak";
} else {$makk="."; }
$clear="<tr height='10px'><td colspan='6'></td></tr>";
echo "
<table cellpadding='' cellspacing='0'>
<tr height='1px'><td width='9%'></td><td width='1%'></td><td width='3%'></td><td width='10%'></td><td width='2%'></td><td></td></tr>";
if ($p1=="") {$n2="1";$ds="Dasar";$smd=":";} else {echo "
<tr valign='top'><td>Dasar</td><td>:</td><td>1.</td><td colspan='3' align='justify'>$p1;</td></tr>";$n2="2";}
echo "
<tr valign='top'><td>$ds</td><td>$smd</td><td>$n2.</td><td colspan='3'  align='justify'>Daftar Isian Pelaksanaan Anggaran (DIPA) ".app_baca("spt_global","name='app_org'","value")." Tahun Anggaran $tahun</td></tr>
$clear
<tr height='10px'><td colspan='6' align='center'>Memberi Tugas</td></tr>
$clear
";
petugaslist_depan($id,"rb");
echo "
$clear
<tr valign='top'><td>Untuk</td><td>:</td><td>1.</td><td colspan='3' align='justify'>$tujuan di $lokasi, $kota pada hari ".waktu($waktu_mulai,$waktu_selesai).pukul($pukul).".</td></tr>

<tr valign='top'><td></td><td></td><td>2.</td><td colspan='3'  align='justify'>Biaya perjalanan dinas ini dibebankan pada ".$dipa."".$makk."</td></tr>
<tr valign='top'><td></td><td></td><td>3.</td><td colspan='3' align='justify'>Segera membuat laporan tertulis hasil pelaksanaan kegiatan kepada Kepala ".app_baca("spt_global","name='app_org'","value").".</td></tr>
</table>
<br>
<table align='right' width='100%'><tr><td width='60%'></td><td align='center' width='40%'>
Bekasi, ".tgl_p($tgl)."<br>$kep_jab<br><br><br><br><u>".db_baca(real_db(),"karyawan","id='".$kep_nama."'","nama")."</u><br>NIP. ".db_baca(real_db(),"karyawan","id='".$kep_nama."'","nip")."
</td><td></td></tr></table>
<table cellpadding='' cellspacing='0' width='100%'>
<tr><td><br>";
if ($tembusan!="") { echo "Tembusan:<br><ol style='margin:0 0 0 -25px;'><li>".str_replace("\n", "</li><li>", $tembusan)."</li></ol>"; }
 
echo "
</td></tr></table>
";
echo "<div class='barcode'><img src='../barcode/barcode.php?id=$unik' height='30px'></div>";
?>

</body></html>
