<?php $this->load->view('template/head'); ?>
<?php $this->load->view('template/topbar');
$this->load->view('template/sidebar');

?>

<section class="content">
        <div class="box">
            <!--<div class="box-header">
                <form class="form-horizontal" action="<?php echo site_url('data_cuti/editTotal'); ?>" method="post">
					<div class="form-group">
						<label class="col-sm-2">Tambah/Update</label>
						<div class="col-sm-3">
							<select class="form-control select2" name="nama" required>
								<option value=""></option>
								<?php foreach($allKaryawan as $k){?>
								<option value="<?php echo $k->id?>"><?php echo $k->nama;?></option>
								<?php }?>
							</select>
             <input type="text" id="reservation"> 
						</div>
						<div class="col-sm-2">
							<select class="form-control" name="tahun" required>
								<option value="n"><?php echo $year;?></option>
								<option value="n1"><?php echo $year1;?></option>
							</select>
						</div>
						<div class="col-sm-2">
							<input type="number" class="form-control" name="jumlah" placeholder="Total Cuti" required>
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-success">Simpan</button>
						</div>
					</div>
				</form>
            </div>-->
			<div class="box-header">	
				<form class="form-horizontal" action="<?php echo site_url('data_cuti/cutiDarurat'); ?>" method="post">
					<div class="form-group">
						<label class="col-sm-1">Cuti Darurat</label>
						<div class="col-sm-3">
							<select class="form-control select2" name="id_pegawai" required>
								<option value=""></option>
								<?php foreach($allKaryawan as $k){?>
								<option value="<?php echo $k->id?>"><?php echo $k->nama;?></option>
								<?php }?>
							</select>
			 <!--<input type="text" id="reservation"> -->
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
			</div>
			<div class="box-body">
        <div style="overflow-x:auto;">
				<table class="table table-responsive" id="example">
					<thead>
						<tr>
							<th width="10px">No</th>
							<!-- <th>userId</th> -->
							<th>Nama</th>
							<th>Tahun N</th>
							<th>Tahun N1</th>
							<th>Total</th>
							<th>Sisa Cuti</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; foreach($data_cuti as $k){?>
						<tr>
							<td><?php echo $no; ?></td>
							<!-- <td><?php echo $k->user_id; ?></td> -->
							<td><?php echo $k->nama; ?></td>
							<td><input type="text" oninput="this.value=this.value.replace(/[^0-12]/g,'');" class="form-control" name="n" value="<?php echo $k->n; ?>" onchange="updateTotal(this.value,this.name,<?php echo $k->user_id; ?>);"></td>
							<td><input type="text" oninput="this.value=this.value.replace(/[^0-6]/g,'');" class="form-control" name="n1" value="<?php echo $k->n1; ?>" onchange="updateTotal(this.value,this.name,<?php echo $k->user_id; ?>);"></td>
							<td><?php echo $k->n1+$k->n; ?></td>
							<td><?php echo 18-$k->n1+$k->n; ?></td>
							<td><a href="<?php echo site_url('data_cuti/detailSisa')?>/<?php echo $k->user_id?>">Detail</a></td>
						</tr>
						<?php $no++; } ?>
					</tbody>
				</table>
      </div>
			</div>
    </div>
</section>

<script>
$(function(){
	$('.select2').select2()
    $('#example').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true
    });
	$('#reservation1').daterangepicker({
        "linkedCalendars": false,
        "showCustomRangeLabel": true,
        "alwaysShowCalendars": true
    }, function(start, end, label) {
      console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ' '+jumlah+')');
    });
});

function updateTotal(val,th,user){
	if(th=="n"){
		var field = "n";
	}else{
		var field = "n1";
	}	
	console.info(field);
	$.ajax({
		type : "POST",
		url  : "<?php echo site_url('data_cuti/updateTotal')?>",
		dataType : "JSON",
		data : {field:field, id:user, val:val},
		success: function(data){
			
		}
	}).then(function successCallback(response){
		if(response.status==200){
			alert('berhasil');
		}
	});
	return false;
	
}
var hans_data = {};
$(document).ready(function(){
    $.ajax({
        url:'<?php echo base_url();?>data_cuti/tesData',
        type:'POST',
        dataType:"jSON",
        success:function(data){
            handson(data.data_cuti);
        }
    });
});

function handson(_data){
$('#example').handsontable({
    data:_data,
    colHeaders:["Nama Karyawan","Sisa Cuti","Sisa Cuti N1","aksi"],
    columns:[
        {data:"nama"},
        {data:"sisa_cuti_n"},
        {data:"sisa_cuti_n1"},
        {data:"aksi"}
    ],
    rowHeaders:true,
    minSpareRows:1,
});
hans_data= $('#example').data('handsontable');
}
</script>

<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>
