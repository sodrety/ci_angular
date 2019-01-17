<?php
$this->load->view('template/head'); ?>
<?php $this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Data Eksekutif KT
        <small>By Komoditas</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Eksekutif</li>
    </ol>
</section>
<section class="content">
	<div class="box-header">
		<a href="<?php echo site_url('eksekutif/export/'.$this->input->post('bid')); ?>" class="btn btn-success">Print</a>
	</div>
	<div class="box">
		<div class="box-body">
			<table class="table table-responsive table-bordered" id="table1">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Perusahaan</th>
						<th>Kapal Tiba</th>
						<th>Tanggal Lapor</th>
						<th>Tanggal Pemeriksaan</th>
						<th>Pelepasan</th>
						<th>Durasi</th>
						<th>Pelabuhan</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1; foreach($eksekutif as $e){ ?>
					<tr>
                        <td><?php echo $no; ?></td>
						<td><?php echo $e->nama_pemohon; ?></td>
                        <td><?php echo $e->tglkt2; ?></td>
                        <td><?php echo $e->tglsp1; ?></td>
                        <td><?php echo $e->tgldp5; ?></td>
                        <td><?php echo $e->tglkt9; ?></td>
                        <td><?php echo $controller->durasi($e->tglsp1,$e->tglkt9); ?></td>
                        <td><?php echo $e->pelabuhan_gudang; ?></td>
					</tr>
					<?php $no++; }?>
				</tbody>
			</table>
		</div>
	</div>
</section>

<script>
$('.select2').select2()
$(function(){	
//$('#table1').DataTable({
  //    "paging": true,
    //  "lengthChange": true,
      //"searching": true,
      //"ordering": true,
      //"info": true
    //});
});
</script>

<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>