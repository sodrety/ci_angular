<?php
$this->load->view('template/head'); ?>
<?php $this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        User Management
        <small>KH</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cuti</li>
    </ol>
</section>

<section class="content">
	<div class="box">
		<div class="box-header">
			<form class="form-horizontal" action="<?php echo site_url('monitoring_kh/tambahKh'); ?>" method="post">
				<div class="form-group">
					<label class="col-sm-2">Tambah/Update</label>
					<div class="col-sm-3">
						<select class="form-control select2" name="id" required>
							<?php foreach($allKaryawan as $k){?>
							<option value="<?php echo $k->id?>"><?php echo $k->nama;?></option>
							<?php }?>
						</select>
					</div>
					<div class="col-sm-2">
						<select class="form-control" name="jenjang" placeholder="jenjang" required>
							<option>MEDIK</option>
							<option>PARAMEDIK</option>
						</select>
					</div>
					<div class="col-sm-2">
						<button type="submit" class="btn btn-success">Simpan</button>
					</div>
				</div>
			</form>
		</div>
		<div class="box-body">
			<table class="table table-responsive table-stripped" id="table1">
				<thead>
					<tr>
						<th width="10px">No</th>
						<th>Nama</th>
						<th>Jenjang</th>
						<th width="10%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1; foreach($karyawan as $k){ ?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo $k->nama;?></td>
						<td><?php echo $k->jenjang;?></td>
						<td>
							<a href="<?php echo site_url('monitoring_kh') ?>/hapus/<?php echo $k->id?>" type="button" class="btn btn-md btn-danger"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
					<?php $no++; } ?>
				</tbody>
			</table>
		</div>
	</div>
</section>
<script>
$(function(){
	$('.select2').select2()
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
