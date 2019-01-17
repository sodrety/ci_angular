<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Rekap-cuti-$today.xlm");
header("Pragma: no-cache");
header("Expires: 0");
?>

<style type="text/css">
table{
  border-collapse: collapse;
}
table td{
  border: 1px solid black;
}

table th{
  border: 1px solid black;
}
</style>
<center><h3>Rekap Cuti </h3></center>
<table style="border:1px solid black;border-collapse:collapse;">
    <thead style="border:1px solid black;">
        <tr style="border:1px solid black;">
            <th style="font-weight:bold; background-color:yellow; padding:15px;">No</th>
            <th style="font-weight:bold; background-color:yellow; padding:15px;">Nama</th>
            <th style="font-weight:bold; background-color:yellow; padding:15px;">Tanggal Mulai</th>
            <th style="font-weight:bold; background-color:yellow; padding:15px;">Tanggal Berakhir</th>
            <th style="font-weight:bold; background-color:yellow; padding:15px;">Jenis Cuti</th>
            <th style="font-weight:bold; background-color:yellow; padding:15px;">Jumlah Cuti</th>
            <th style="font-weight:bold; background-color:yellow; padding:15px;">Status</th>
            <th style="font-weight:bold; background-color:yellow; padding:15px;">Ket</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; foreach ($data_cuti as $k) { ?>
        <tr>
            <td style="padding:15px;"><?php echo $i; ?></td>
            <td style="padding:15px;"><?php echo $k->nama_karyawan;?></td>
            <td style="padding:15px;"><?php echo $k->tanggal_mulai;?></td>
            <td style="padding:15px;"><?php echo $k->tanggal_berakhir;?></td>
            <td style="padding:15px;"><?php echo $k->jenis_cuti;?></td>
            <td class="text-center"><?php echo $k->jumlah_cuti;?>&nbsp<?php echo $k->nama_satuan;?></td>
            <?php if($k->status==1){?>
                <td>Menunggu Konfirmasi Kepegawaian</td>
            <?php } ?>
            <?php if($k->status==2){?>
                <td>Menunggu Konfirmasi Atasan Langsung</td>
            <?php } ?>
            <?php if($k->status==3){?>
                <td>Menunggu Konfirmasi Pejabat Berwenang</td>
            <?php } ?>
            <?php if($k->status==4){?>
                <td>Selesai</td>
            <?php } ?>
            <?php if($k->status==5){?>
                <td>Ditolak</td>
            <?php } ?>
            <?php if($k->status==6){?>
                <td>Menunggu Rekomendasi 2</td>
            <?php } ?>
            <?php if($k->status==7){?>
                <td>Rekomendasi Diterima</td>
            <?php } ?>
            <?php if($k->status==8){?>
                <td>Rekomendasi Ditolak</td>
            <?php } ?>
            <?php if($k->status==9){?>
                <td>Menunggu Rekomendasi 1</td>
            <?php } ?>
            <?php if($k->status==10){?>
                <td>Menunggu Rekomendasi 3</td>
            <?php } ?>
            <td style="padding:15px;">ptg cuti 2017 (<?php echo $k->ket_cuti_n1?>)&nbsp ptg cuti 2018 (<?php echo $k->ket_cuti;?>)</td>
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>
