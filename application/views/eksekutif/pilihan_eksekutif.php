<?php
$this->load->view('template/head'); ?>
<?php $this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Data Eksekutif
        <small>Pilihan</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cuti</li>
    </ol>
</section>
<section class="content">
	<div class="body">
		<div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#tabKT" data-toggle="tab">KT</a></li>
				<li><a href="#tabKH" data-toggle="tab">KH</a></li>
				<li class="pull-left header">Pilih Metode Pencarian</li>
            </ul>
            <div class="tab-content ">
				<!-- Morris chart - Sales -->
				<div class="tab-pane active" id="tabKT" >
					<div class="box box-default collapsed-box" style="width:70%;">
						<div class="box-header">
						  <!-- tools box -->
						  <div class="pull-right box-tools">
							<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
									data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
								<i class="fa fa-plus"></i></button>
							</div>
							<h3 class="box-title">
							By Komoditas
							</h3>
						</div>
						<div class="box-body">
							<div style="height: 250px; width: 100%;">
								<form class="form-horizontal" action="<?php echo site_url('eksekutif') ?>" method="post">
									<div class="form-group">
										<div class="col-md-10">
											<input class="form-control" name="kom">
											<input type="hidden" class="form-control" name="bid" value="kt">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-10">
											<select class="form-control" name="jenis">
												<option name="impor">Impor</option>
												<option name="ekspor">Ekspor</option>
												<option name="domestik">Domestik</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-2">
											<input type="submit" class="btn btn-primary" value="Tampilkan">
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- /.box-body-->
						<div class="box-footer no-border">
							<div class="row">
							</div>
						  <!-- /.row -->
						</div>
					</div>
					<div class="box box-default collapsed-box" style="width:70%;">
						<div class="box-header">
							<!-- tools box -->
							<div class="pull-right box-tools">
								<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
									data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
								<i class="fa fa-plus"></i></button>
							</div>
							<h3 class="box-title">
							By Rentang
							</h3>
						</div>
						<div class="box-body">
							<div style="height: 250px; width: 100%;">
								<form class="form-horizontal" action="<?php echo site_url('eksekutif') ?>" method="post" enctype="multipart/form-data">
									<div class="form-group">
										<label class="col-md-2">Komoditas</label>
										<div class="col-md-10">
											<input class="form-control" name="kom" placeholder="optional">
											<input type="hidden" class="form-control" name="bid" value="kt">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2">Rentang</label>
										<div class="col-md-10">
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<input type="text" class="form-control pull-right reservation" id="reservation" name="rentang">
											
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-10">
											<select class="form-control" name="jenis">
												<option value="impor">Impor</option>
												<option value="ekspor">Ekspor</option>
												<option value="domestikMasuk">Domestik Masuk</option>
												<option value="domestikKeluar">Domestik Keluar</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-2">
											<input type="submit" class="btn btn-primary" value="Tampilkan">
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- /.box-body-->
						<div class="box-footer no-border">
							<div class="row">
							</div>
							<!-- /.row -->
						</div>
					 </div>
				</div>
				<div class="tab-pane" id="tabKH">
					
					<div class="box box-default collapsed-box" style="width:70%;">
						<div class="box-header">
							<!-- tools box -->
							<div class="pull-right box-tools">
								<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
									data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
								<i class="fa fa-plus"></i></button>
							</div>
							<h3 class="box-title">
							By Rentang
							</h3>
						</div>
						<div class="box-body">
							<div style="height: 250px; width: 100%;">
								<form class="form-horizontal" action="<?php echo site_url('eksekutif') ?>" method="post" enctype="multipart/form-data">
									<div class="form-group">
										<label class="col-md-2">Komoditas</label>
										<div class="col-md-10">
											<input class="form-control" name="kom" placeholder="optional">
											<input type="hidden" class="form-control" name="bid" value="kh">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2">Rentang</label>
										<div class="col-md-10">
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<input type="text" class="form-control pull-right reservation" id="reservation2" name="rentang">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-2">
											<input type="submit" class="btn btn-primary" value="Tampilkan">
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- /.box-body-->
						<div class="box-footer no-border">
							<div class="row">
							</div>
							<!-- /.row -->
						</div>
					</div>
				</div>
            </div>
         </div>
	</div>
</section>

<script>
	var serverDate = '<?= date('m-d-Y')?>';

	var str = serverDate.toString();
	var serverDates = str.split('-').join('/');
	var dd = serverDates.substr(3,2)-5;
	var year = serverDates.substr(6,10);
	var mm = serverDates.substr(0,2);
	// var bulan = bulan(mm);
	console.info('asd',serverDate);
	
	var today = serverDates;
	var limitDate = mm + '/' + dd + '/' + year;
$(function(){	
	$('#reservation').daterangepicker({
	//"minDate":limitDate,
	"startDate":today,
        "linkedCalendars": false,
        "showCustomRangeLabel": false,
        "alwaysShowCalendars": true,
        locale: {
                format: 'YYYY-MM-DD'
            }
    },
     function(start, end, label) {
      console.log('New date range selected: ' + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY') + ' (predefined range: ' + label + ' '+jumlah+')');
    });
});
$(function(){	
	$('#reservation2').daterangepicker({
	//"minDate":limitDate,
	"startDate":today,
        "linkedCalendars": false,
        "showCustomRangeLabel": false,
        "alwaysShowCalendars": true,
        locale: {
                format: 'YYYY-MM-DD'
            }
    },
     function(start, end, label) {
      console.log('New date range selected: ' + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY') + ' (predefined range: ' + label + ' '+jumlah+')');
    });
});
</script>

<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>