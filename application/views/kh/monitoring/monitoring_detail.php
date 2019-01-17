<?php
$this->load->view('template/head'); ?>
<?php $this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Detail
        <small>Penugasan</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li class="active">Cuti</li> -->
    </ol>
</section>

<section class="content">
	<div class="box">
		<div class="box-header border">
			<h3 class="text-center">Detail Tugas</h3>
		</div>
		<div class="box-body">
			<?php foreach($detail as $d){ ?>
			<form class="form-horizontal" action="<?php echo site_url('monitoring_kh/tambahGambar');?>" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<div class="col-md-12">
						<textarea name="isi" id="editor1" placeholder="Place some text here" 
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $d->isi; ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-12">
						<label>Choose Files</label>
						<input type="file" name="gambar">
						<input type="hidden" name="id_dis" value="<?php echo $this->uri->segment(3);?>">
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<ul class="gallery">
							<?php if(!empty($files)){ foreach($files as $file){ ?>
							<li class="item" style="float: left;">
								<a href="<?php echo base_url($file->path);?>" data-fancybox="preview">
								<img style="width:300px;height:300px;"  src="<?php echo base_url($file->path); ?>" ></a>
								<p>Uploaded On <?php echo $file->created_date; ?></p>
								<a class="btn btn-sm btn-danger" href="<?php echo site_url('monitoring_kh/hapusGambar/'.$file->id);?>">hapus</a>
							</li>
							<?php } }else{ ?>
							<p>Image(s) not found.....</p>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<input type="submit" class="btn btn-success pull-right" name="fileSubmit" value="Simpan"/>
					</div>				
				</div>
			</form>
			<?php } ?>
		</div>
	</div>
</section>

<script type="text/javascript">
		 CKEDITOR.replace( 'editor1' );

		$('[data-fancybox]').fancybox({
			protect: true
		});
</script>

<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>