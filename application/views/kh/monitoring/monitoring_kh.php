<?php
$this->load->view('template/head'); ?>
<?php $this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        KH
        <small>Penugasan</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li class="active">Cuti</li> -->
    </ol>
</section>

<section class="content">
	<div class="box">
		<div class="box-body">
			<div class="table">
				<table class="table table-responsive" id="table1">
					<thead>
						<tr>
							<th width="10px" class="text-center">No</th>
							<th>Nama</th>
							<th>Tanggal</th>
							<th>Status</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; foreach($monitoring as $m){ ?>
						<tr>
							<td class="text-center"><?php echo $no;?></td>
							<td><?php echo $m->nama;?></td>
							<td><?php echo $m->tgl_periksa;?></td>
							<?php if($m->isi==null && $m->status==1){?>
                                <td><span class="label label-warning">Pending</span></td>
                            <?php } ?>
							<?php if($m->isi!=null && $m->status==1){?>
                                <td><span class="label label-primary">Proses</span></td>
                            <?php } ?>
							<td class="text-center"><a href="<?php echo site_url('monitoring_kh');?>/proses/<?php echo $m->id_distribusi;?>" title="Proses" class="btn btn-info"><i class="fa fa-edit"></i></a></td>
						</tr>
						<?php $no++; }?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
    $('#table1').DataTable();
</script>

<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>