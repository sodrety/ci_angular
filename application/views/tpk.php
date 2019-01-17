<?php
$this->load->view('template/head'); ?>
<?php $this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Rekap
        <small>Keterlambatan</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cuti</li>
    </ol>
</section>
<section class="content">
	<div class="box-header">
		<a href="<?php echo site_url('dashboard/tampilRekapExcel');?>" class="btn btn-danger">Print</a>
	</div>
	<div class="box-body">
		<div class="table-scrollable hide">
			<table class="table table-responsive table-stripped">
				<thead>
					<tr>
						<th>No</th>
						<th>Perusahaan</th>
						<th>Terlambat</th>
						<th>Frek</th>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1; foreach ($data as $d) { ?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $d->perusahaan;?></td>
						<td><?php echo $controller->rekapMax($d->perusahaan);?></td>
						<td><?php echo $controller->rekapfrek($d->perusahaan);?></td>
						<td><?php echo $controller->rekap($d->perusahaan);?></td>
					</tr>
					<?php $no++; } ?>
				</tbody>
			</table>
		</div>
		<div class="table-scrollable">
			<table class="table table-responsive table-stripped" id="table1">
				<thead>
					<tr>
						<th>No</th>
						<th>Perusahaan</th>
						<th>Terlambat</th>
						<th>Frek</th>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
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
		</div>
	</div>
</section>

<script type="text/javascript">
	$(function(){
	    $('#table1').DataTable({
	      "paging": true,
	      "lengthChange": true,
	      "searching": true,
	      "ordering": true,
	      "info": true
	    });
	});
</script>
<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>