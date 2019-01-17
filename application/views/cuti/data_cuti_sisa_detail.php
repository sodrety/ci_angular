<?php
$this->load->view('template/head'); ?>
<?php $this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Detail
        <small>Sisa Cuti</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cuti</li>
    </ol>
</section>
<section class="content">
	<div class="box-header"></div>
	<div class="box-body">
		<table class="table table-responsive">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Tanggal Mulai</th>
					<th>Tanggal Selesai</th>
					<th>Jumlah</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1; foreach($detail as $d){?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $d->nama;?></td>
					<td><?php echo $d->tanggal_mulai;?></td>
					<td><?php echo $d->tanggal_berakhir;?></td>
					<td><?php echo $d->jumlah_cuti;?></td>
				</tr>
				<?php $no++; }?>
			</tbody>
		</table>
	</div>
</section>

<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>