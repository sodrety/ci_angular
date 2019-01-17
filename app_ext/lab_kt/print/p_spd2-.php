<?php include "../class/class.php"; 
//include "db_include.php";
$id=$_GET['id'];
$id_spt=$_GET['id_spt'];

$wid="610px"; $m="margin: 15mm 0 0 25mm;";

echo "
<html><head>
<style>
* { font-family:arial, sans; font-size:13px;}
body { $m width:$wid;}
#judul { text-align:center;}
td {padding:2;}
#lam * {font-size:9px;}
#border { border-top:1px solid #000; border-right:1px solid #000; }
#bor2 { border:1px solid #000; }
#borl { border-left:1px solid #000; }
#border * td{ border-left:1px solid #000; padding:4px;}
#bo td {border-bottom:1px solid #000;}
#bot td {border-top:1px solid #000;}
</style>";
$ppkn=db_baca(real_db(),"karyawan","id='".app_baca("spt","id='$id_spt'","ppk_nama")."'","nama");
$ppknip=db_baca(real_db(),"karyawan","id='".app_baca("spt","id='$id_spt'","ppk_nama")."'","nip");
echo "
</head>
<body>


<center>
 <img src=garuda.jpg height=70px><br>MENTERI KEUANGAN<br>REPUBLIK INDONESIA
 </center>
<table width='100%'  cellspacing=0 cellpadding=0 id=bor2>

<tr valign='top'><td rowspan=4 colspan=3 width='50%'>&nbsp;</td><td rowspan=4 width='10px' align=center id=borl>I.&nbsp;</td><td width='120px'>Berangkat dari<br>(Tempat Kedudukan)</td><td>: ".app_baca("spt","id='$id_spt'","dari")."</td></tr>

<tr valign='top'><td>Ke</td><td>: ".app_baca("spt","id='$id_spt'","kota")."</td></tr>
<tr valign='top'><td>Pada Tanggal</td><td>: ".tgl_p(app_baca("spt","id='$id_spt'","waktu_mulai"))."</td></tr>
<tr valign='top'><td colspan=2 align=center>".app_baca("spt","id='$id_spt'","kep_jab")."<br><br><br><br>
".db_baca(real_db(),"karyawan","id='".app_baca("spt","id='$id_spt'","kep_nama")."'","nama")."<br>
NIP. ".db_baca(real_db(),"karyawan","id='".app_baca("spt","id='$id_spt'","kep_nama")."'","nip")."&nbsp;</td></tr>

<tr valign='top' id=bot><td width='10px' rowspan=4 align=center>II.</td><td  width='70px'>Tiba di</td><td>: ".app_baca("spt","id='$id_spt'","kota")."</td><td rowspan=4 id=borl>&nbsp;</td><td>Berangkat dari</td><td>: ".app_baca("spt","id='$id_spt'","kota")."</td></tr>
<tr valign='top'><td>Pada Tanggal</td><td>: ".tgl_p(app_baca("spt","id='$id_spt'","waktu_mulai"))."</td><td>Ke</td><td>:  ".app_baca("spt","id='$id_spt'","dari")."</td></tr>
<tr valign='top'><td>Kepala</td><td>:</td><td>Pada Tanggal</td><td>: ".tgl_p(app_baca("spt","id='$id_spt'","waktu_selesai"))."</td></tr>
<tr valign='top'><td colspan=2>
<br><br><br>
. . . . . . . . . . . . .  . . . . . . . . . . . . . . . . . . . . . .  . . .<br>

</td><td colspan=2>Kepala<br><br><br>
. . . . . . . . . . . . .  . . . . . . . . . . . . . . . . . . . . . .  . . .<br>

</td></tr>
<tr valign='top' id=bot><td width='10px' rowspan=4 align=center>III.</td><td>Tiba di</td><td width='100px'>:</td><td rowspan=4 id=borl>&nbsp;</td><td>Berangkat dari</td><td>: </td></tr>
<tr valign='top'><td>Pada Tanggal</td><td>:</td><td>Ke</td><td>:</td></tr>
<tr valign='top'><td>Kepala</td><td>:</td><td>Pada Tanggal</td><td>:</td></tr>
<tr valign='top'><td colspan=2>
<br><br><br>
. . . . . . . . . . . . .  . . . . . . . . . . . . . . . . . . . . . .  . . .<br>

</td><td colspan=2>Kepala<br><br><br>
. . . . . . . . . . . . .  . . . . . . . . . . . . . . . . . . . . . .  . . .<br>

</td></tr>
<tr valign='top' id=bot><td width='10px' rowspan=4 align=center>IV.</td><td>Tiba di</td><td width='100px'>:</td><td rowspan=4 id=borl>&nbsp;</td><td>Berangkat dari</td><td>:</td></tr>
<tr valign='top'><td>Pada Tanggal</td><td>:</td><td>Ke</td><td>:</td></tr>
<tr valign='top'><td>Kepala</td><td>:</td><td>Pada Tanggal</td><td>:</td></tr>
<tr valign='top'><td colspan=2>
<br><br><br>
. . . . . . . . . . . . .  . . . . . . . . . . . . . . . . . . . . . .  . . .<br>
 
</td><td colspan=2>Kepala<br><br><br>
. . . . . . . . . . . . .  . . . . . . . . . . . . . . . . . . . . . .  . . .<br>

</td></tr>

<tr valign='top' id=bot><td width='10px' rowspan=3 align=center>V.</td><td>Tiba di<br>(Tempat Kedudukan)</td><td width='100px'>: Bekasi</td><td rowspan=3 id=borl>&nbsp;</td><td rowspan=2 colspan=2>Telah diperiksa dengan keterangan bahwa perjalanan
tersebut atas perintahnya dan semata-mata untuk
kepentingan jabatan dalam waktu yang sesingkat-
singkatnya.</td></tr>
<tr valign='top'><td>Pada Tanggal</td><td>: ".tgl_p(tgl_aju(app_baca("spt","id='$id_spt'","waktu_selesai")))."</td></tr>
<tr valign='top'><td colspan=2 align=center>
Pejabat Pembuat Komitmen<br><br><br><br>
".$ppkn."<br>
NIP. ".$ppknip."
</td><td colspan=2 align=center>Pejabat Pembuat Komitmen<br><br><br><br>
".$ppkn."<br>
NIP. ".$ppknip."
</td></tr>
<tr valign='top' id=bot><td>VI.</td><td colspan=5>Catatan Lain-Lain</td></tr>
<tr valign='top' id=bot><td>VII.</td><td colspan=5>PERHATIAN :<br>
PPK yang menerbitkan SPD, pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan
tanggal berangkat/tiba, serta bendahara pengeluaran bertanggung jawab berdasarkan peraturan-
peraturan Keuangan Negara apabila negara menderita rugi akibat kesalahan, kelalaian, dan
kealpaannya.
</td></tr>
</table>
</body>
</html>
"; 

?>
