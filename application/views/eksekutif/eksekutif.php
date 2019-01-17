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
						<?php if($this->input->post('bid')=="kt"){ ?>
						<th>No</th>
						<th>Komoditas</th>
						<th>Komoditas</th>
						<th>Peruntukan</th>
						<!-- <th>Tanggal</th> -->
						<!-- <th>Nomor</th>
						<th>No aju</th> -->
						<th>Tanggal</th>
						<th>Negara Asal</th>
						<th>Perusahaan Penerima</th>
						<th>Volume Netto</th>
						<th>Satuan</th>
						<?php }else{ ?>
						<th>No</th>
						<th>Komoditas</th>
						<th>Komoditas</th>
						<!--<th>Peruntukan</th> -->
						<!-- <th>Tanggal</th> -->
						<!-- <th>Nomor</th>
						<th>No aju</th> -->
						<th>Negara Asal</th>
						<th>Perusahaan Penerima</th>
						<!-- <th>Nama Pelabuhan</th> -->
						<th>Volume Netto</th>
						<th>Satuan</th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php $no=1; foreach($eksekutif as $e){ ?>
					<tr>
						<?php if($this->input->post('bid')=="kt"){ ?>
							<td><?php echo $no; ?></td>
							<td><?php echo $e->nama_en; ?></td>
							<td><?php echo $e->nama_tum; ?></td>
							<td><?php echo $e->peruntukan; ?></td>
							<!-- <td><?php echo $e->tanggal; ?></td> -->
							<!-- <td><?php echo $e->nomor; ?></td>
							<td><?php echo $e->no_aju; ?></td> -->
							<td><?php echo $e->tanggal; ?></td>
							<td><?php echo $e->nama; ?></td>
							<td><?php echo $e->nama_penerima; ?></td>
							<td><?php echo $e->volume_netto; ?></td>
							<td><?php echo $e->nama_satuan; ?></td>
						<?php }else{ ?>
							<td><?php echo $no; ?></td>
							<td><?php echo $e->nama_en; ?></td>
							<td><?php echo $e->nama_tum; ?></td>
							<!-- <td><?php echo $e->tanggal; ?></td> -->
							<!-- <td><?php echo $e->nomor; ?></td>
							<td><?php echo $e->no_aju; ?></td> -->
							<td><?php echo $e->nama_negara; ?></td>
							<td><?php echo $e->nama_penerima; ?></td>
							<!-- <td><?php echo $e->nama_pelabuhan; ?></td> -->
							<td><?php echo $e->netto; ?></td>
							<td><?php echo $e->nama_sat; ?></td>
						<?php } ?>
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