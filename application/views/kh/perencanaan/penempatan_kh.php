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
<?php 

$bulan_post = "";
$tahun_post = "";
$tahun_post = $this->input->get('tahun'); 
$bulan_post = $this->input->get('bulan'); 

?>
<section class="content">
	<div class="box">
		<div class="box-header">
			<form method="get" action="<?php echo site_url('perencanaan_kh/penempatan');?>">
				<div class="form-group">
					<label class=" col-sm-1">Tahun</label>
					<div class="col-md-1">
						<select class="form-control" name="tahun">
							<option value="<?php echo $tahun;?>"><?php echo $tahun;?></option>
							<option value="2018">2018</option>
						</select>	
					</div>
					<div class="col-md-1">
						<label>Bulan</label>	
					</div>
					<div class="col-md-1">
						<select class="form-control" name="bulan">
							<option value="<?php echo $bulan;?>"><?php echo $this->input->get('bulan');?></option>
							<option value="01">01</option>
							<option value="02">02</option>
							<option value="03">03</option>
							<option value="04">04</option>
							<option value="05">05</option>
							<option value="06">06</option>
							<option value="07">07</option>
							<option value="08">08</option>
							<option value="09">09</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
						</select>
					</div>
					<div class="col-md-1">
						<label>Lokasi</label>	
					</div>
					<div class="col-md-2">
						<select class="form-control select2" name="lokasi">
							<option value="0"></option>
							<?php foreach ($lokasi as $l ) {?>
							<option value="<?php echo $l->id_lokasi;?>"><?php echo $l->lokasi;?></option>	
							<?php } ?>
							
						</select>	
					</div>
					<div class="col-md-1">
						<button class="btn btn-primary" type="submit">Cari</button>
					</div>
				</div>
			</form>
			<br>
			<br>
			<br>
			<?php if ($this->input->get('tahun')!=null){ ?>
			<div id="divIsi" class="col-md-12" ">
				<form method="post" action="<?php echo site_url('perencanaan_kh/tambahPenempatan?tahun='.$tahun_post.'&bulan='.$bulan_post);?>">
					<div class="form-group">
						<label class="col-md-2">Tambahkan Petugas</label>
						<div class="col-md-3">
							<select class="form-control" name="lokasi" >
								<?php foreach ($lokasi_2 as $l ) {?>
								<option value="<?php echo $l->id_lokasi;?>" selected ><?php echo $l->lokasi;?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-3">
							<select class="form-control select2" name="petugas">
								<option value="0"  selected></option>
								<?php foreach ($petugas as $p ) {?>
								<option value="<?php echo $p->id;?>"><?php echo $p->nama;?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<select class="form-control" name="status">
							<option value="0"></option>
							<option value="1">Koordinator</option>		
						</select>					
					</div>
					<div class="form-group">
						<button class="btn btn-primary" type="submit">Tambah</button>
					</div>
				</form>
			</div>
			<?php } ?>
		</div>
		<div class="box-body">
			<div class="table">
				<table class="table table-bordered" id="table1">
					<thead>
						<tr>
							<th>No</th>
							<th>Tahun</th>
							<th>Bulan</th>
							<th>Nama</th>
							<th>Lokasi</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php $n=1; foreach ($penempatan as $p) {?>
						<tr>
						<td width="10px"><?php echo $n;?></td>
						<td><?php echo $p->tahun;?></td>
						<td><?php echo $p->bulan;?></td>
						<td><?php echo $p->nama;?></td>
						<td><?php echo $p->lokasi;?></td>
						<?php if($p->status==1){ ?>
							<td>Koordinator</td>
						<?php }else{ ?>
							<td></td>
						<?php } ?>
						</tr>
						<?php $n++; } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">

	$(function(){
		$('.select2').select2()
	    $('#table1').DataTable();
	    $('#table2').DataTable();
	});

	function show() {
	    var x = document.getElementById("divIsi");
	    if (x.style.display === "none") {
	        x.style.display = "block";
	    } else {
	        x.style.display = "none";
	    }
	}

</script>

<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>