<?php
$this->load->view('template/head'); ?>
<?php $this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        KH
        <small>Perencanaan Penugasan</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li class="active">Cuti</li> -->
    </ol>
</section>

<section class="content">
	<div class="box">
		<div class="box-header">
			<a href="<?php echo site_url('perencanaan_kh/updateRealisasi');?>"><button class="btn btn-primary btn-md">Update Jumlah SPT</button></a>
		</div>
		<div class="box-body">
			<div class="table">
				<table class="table table-bordered" id="table1">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Jenjang</th>
							<th>Jumlah</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; foreach ($pegawai as $p) { ?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo $p->nama;?></td>
							<td><?php echo $p->jenjang;?></td>
							<td><?php echo $p->jumlah;?></td>
						</tr>
						<?php $no++; } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="box">
		<div class="box-body">
			<div class="table">
				<table class="table table-bordered" id="table2">
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal Periksa</th>
							<th>No Reg</th>
							<th>Nama Perusahaan</th>
							<th>Jumlah Petugas</th>
							<th>Lokasi</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<form method="post" action="<?php echo site_url('perencanaan_kh/tambahDokumen') ?>">
							<td></td>
							<td></td>
							
							<td><input type="number" name="no_reg" required></td>
							<td></td>
							<td><input type="number" name="jumlah" required></td>
							<td></td>
							<td><button class="btn btn-sm btn-success" type="submit"><i class="fa fa-plus"></i></button></td>

							</form>
						</tr>
						<?php $no=1; foreach ($dokumen as $d) { ?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo $d->tgl_periksa;?></td>
							<td><?php echo $d->no_permohonan;?></td>
							<td><?php echo $d->perusahaan;?></td>
							<td><?php echo $d->jumlah;?></td>
							<td></td>
							<td><a href="<?php echo site_url('perencanaan_kh/hapusDokumen');?>/hapus/<?php echo $d->id;?>" class="btn btn-danger"><i class="fa fa-times"></i></a></td>

						</tr>
						<?php $no++; } ?> 
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="box">
		<div class="box-header">
			<form class="form-horizontal" action="<?php echo site_url('perencanaan_kh/tambahPetugas');?>" method="post">
				<label class="col-md-2">Tambah Petugas</label>
				<div class="col-md-2">
				<select class="col-md-3 form-control" name="petugas">
					<?php foreach($petugas_kh as $p){?>
					<option value="<?php echo $p->id ?>"><?php echo $p->nama?></option>
					<?php }?>
				</select>
				</div>
				<label class="col-md-1">No Reg</label>
				<div class="col-md-2">
				<select class="col-md-2 form-control" name="no_reg">
					<?php foreach($dokumen as $d){?>
					<option value="<?php echo $d->no_permohonan?>"><?php echo $d->no_permohonan; ?></option>
					<?php } ?>
				</select>
				</div>
				<div class="col-md-1">
					<button type="submit" class="btn btn-success btn-sm">Tambah</button>
				</div>
			</form>
		</div>
	</div>
	<div class="box">
		<div class="box-body">
			<h3>Distribusi Final</h3>
			<div class="table-scrollable">
				<table class="table table-responsive" id="table3">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Nama</th>
						<th>No Reg</th>
						<th>Jenjang</th>
						<th>Perusahaan</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1; foreach ($distribusi as $d) { ?>
					<tr>
						<td><?php echo $no;?></td>
						<td><?php echo $d->tgl_periksa;?></td>
						<td><?php echo $d->nama;?></td>
						<td><?php echo $d->no_permohonan;?></td>
						<td><?php echo $d->jenjang;?></td>
						<td><?php echo $d->perusahaan;?></td>
						<td><a href="<?php echo site_url('perencanaan_kh/hapusDistribusi');?>/hapus/<?php echo $d->id_distribusi;?>" class="btn btn-danger"><i class="fa fa-times"></i></a></td>

					</tr>
					<?php $no++; } ?>
					
				</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="box">
		<div class="box-body">
			<a class="text-center" href="<?php echo site_url('perencanaan_kh/acakPetugas');?>"><button class="btn btn-lg btn-success">Random Sekarang</button></a>
		</div>
	</div>
</section>

<script type="text/javascript">
	$(function(){
    $('#table1').DataTable();
    $('#table2').DataTable();
    $('#table3').DataTable();
});
</script>

<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>