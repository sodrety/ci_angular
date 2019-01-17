<?php
$this->load->view('template/head'); ?>
<?php $this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        User Management
        <small>Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Cuti</li>
        <li class="active">Edit CUti</li>
    </ol>
</section>
<section class="content">
	<div class="row">
            <div class="box">
                <div class="box-body">
                <form class="form-horizontal" action="<?php echo site_url('data_cuti/updateProfil'); ?>" method="post" enctype="multipart/form-data">
					<?php foreach ($karyawan as $p){ ?>
						<div class="form-group">
						<label class="col-md-3">NIP</label>
							<div class="col-md-9">
								<input type="hidden" class="form-control" name="id" value="<?php echo $p->id;?>">
								<input type="text" class="form-control" name="nip" value="<?php echo $p->nip;?>" disabled>
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">Nama</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="nama" value="<?php echo $p->nama;?>">
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">Pangkat</label>
							<div class="col-md-9">
								<select class="form-control" name="pangkat"><option value="<?php echo $p->golongan;?>"><?php echo $p->golongan;?></option>
									<?php foreach ($gol as $g){ ?>
									<option value="<?php echo $g->gol;?>"><?php echo $g->gol;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">Jabatan</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="jabatan" value="<?php echo $p->jabatan;?>">
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">HP</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="hp" value="<?php echo $p->hp;?>">
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">Email</label>
							<div class="col-md-9">
								<input type="email" class="form-control" name="email" value="<?php echo $p->email;?>">
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">WhatsApp</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="wa" value="<?php echo $p->wa;?>">
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">Username </label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="username" value="<?php echo $p->username;?>">
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">Password</label>
							<div class="col-md-9">
								<input type="password" class="form-control" name="password">
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">Ulangi Password</label>
							<div class="col-md-9">
								<input type="password" class="form-control" name="ul_password">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">Bidang</label>
							<div class="col-md-9">
								<input type="radio" name="bid" value="0" <?php if($p->status_kh == 0){ echo "checked";}?>>Tumbuhan
								<input type="radio" name="bid" value="1" <?php if($p->status_kh == 1){ echo "checked";}?>>Hewan
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">Bagian</label>
							<div class="col-md-9">
								<input type="radio" name="bag" value="st" <?php if($p->kode_jab == 'st'){ echo "checked";}?>>Umum
								<input type="radio" name="bag" value="fk" <?php if($p->kode_jab == 'fk'){ echo "checked";}?>>Fungsional
							</div>
						</div>
				  </div>
				  <div class="modal-footer">
					<button type="submit" class="btn btn-success">Update</button>
				  </div>
				</div>
				<?php } ?>
				</form>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
$(function () {
    $('.select2').select2();
    //Date picker
    $('input[name="tglmulai"]').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy'
    });

    $('input[name="tglakhir"]').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy'
    });

});
</script>

<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>