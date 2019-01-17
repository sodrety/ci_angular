<?php 
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Rekap-Tpk.xls");
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

<table style="border:1px solid black;border-collapse:collapse;">
    <thead style="border:1px solid black;">
        <tr style="border:1px solid black;">
            <th style="font-weight:bold; background-color:yellow; padding:15px;">No</th>
            <th style="font-weight:bold; background-color:yellow; padding:15px;">Nama Perusahaan</th>
            <th style="font-weight:bold; background-color:yellow; padding:15px;">Jumlah Terlambat(Max)</th>
            <th style="font-weight:bold; background-color:yellow; padding:15px;">Frekuensi(Kontainer)</th>
            <th style="font-weight:bold; background-color:yellow; padding:15px;">Jumlah</th>
        </tr>
    </thead>
    <tbody style="border:1px solid black;">
		<?php $no=1; foreach ($rekap as $d) { ?>
		<tr>
			<td><?php echo $no;?></td>
			<td><?php echo $d->nama;?></td>
			<td><?php echo $controller->rekapMaxFinal($d->nama);?></td>
			<td><?php echo $controller->rekapfrek($d->nama);?></td>
			<td><?php echo $controller->rekap($d->nama);?></td>
		</tr>
		<?php $no++; } ?>
	</tbody>
</table>
