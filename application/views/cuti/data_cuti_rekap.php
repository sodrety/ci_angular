<?php
$this->load->view('template/head'); ?>
<?php $this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Cuti
        <small>Permohonan Cuti</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cuti</li>
    </ol>
</section>
<section class="content">
	<div class="box">
		<!--<div class="box-header">	
			<form class="form-horizontal" action="<?php echo site_url('data_cuti/cutiDarurat'); ?>" method="post">
				<div class="form-group">
					<label class="col-sm-1">Tambah</label>
					<div class="col-sm-3">
						<select class="form-control select2" name="id_pegawai" required>
							<option value=""></option>
							<?php foreach($allKaryawan as $k){?>
							<option value="<?php echo $k->id?>"><?php echo $k->nama;?></option>
							<?php }?>
						</select>
		 <input type="text" id="reservation"> 
					</div>
					<div class="col-sm-2">
						<input type="number" class="form-control" name="jumlah" placeholder="Total Cuti" required>
					</div>
					<div class="col-md-4">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
						</div>
						<input type="text" class="form-control" id="reservation1" name="tanggal" required>
					</div>
					  </div>
					<div class="col-sm-2">
						<button type="submit" class="btn btn-success">Simpan</button>
					</div>
				</div>
			</form>
		</div>-->
		<div class="box-body">
			<h4>Pilih Tanggal untuk melihat rekap<h4>
			
			<div class="col-md-12">
				<form class="form-horizontal" action="<?php echo site_url('data_cuti/pilihRekap');?>" method="post" enctype="multipart/form-data">
					<div class="form-group">
					  <div class="col-md-4">
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" class="form-control" id="reservation" name="tanggal" required>
						</div>
					  </div>
					</div>
					<div class="form-group">
					  <div class="col-md-4">
						<button class="btn btn-primary" type="submit">Pilih</button>
					  </div>
					</div>
				</form>
			</div>
		  
		 <!--  <div class="col-md-12">
			<form class="form-horizontal" action="<?php echo site_url('data_cuti/pilihRekap');?>" method="post" enctype="multipart/form-data">
				<div class="form-group">
				  <div class="col-md-4">
					<div class="input-group">
					  <div class="input-group-addon">
						<i class="fa fa-calendar"></i>
					  </div>
					  <input type="text" class="form-control" id="datepicker" name="tanggal" required>
					</div>
				  </div>
				</div>
				<div class="form-group">
				  <div class="col-md-4">
					<button class="btn btn-primary" type="submit">Pilih</button>
				  </div>
				</div>
			</form>
		  </div> -->
		</div>
	</div>
</section>

<script type="text/javascript">

	function buka(){
		var x = document.getElementById("formCuti");
		  if (x.style.display === "none") {
			x.style.display = "block";
		  } else {
			x.style.display = "none";
		  }
	}
    $(document).ready(function(){
        $('#table1').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true
        });
    });

$(function () {
	$('.select2').select2()
    $("#datepicker").datepicker( {
		autoclose: true,
		format: "mm-yyyy",
		startView: "months",
		minViewMode: "months"
	});
});

$(function () {
    $('#reservation').daterangepicker({
        "linkedCalendars": false,
        "showCustomRangeLabel": true,
        "alwaysShowCalendars": true
    }, function(start, end, label) {
      console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ' '+jumlah+')');
    });
})
$(function () {
    $('#reservation1').daterangepicker({
        "linkedCalendars": false,
        "showCustomRangeLabel": true,
        "alwaysShowCalendars": true
    }, function(start, end, label) {
      console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ' '+jumlah+')');
    });
})
</script>

<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>
