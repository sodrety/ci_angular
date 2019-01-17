<?php
$this->load->view('template/head'); ?>
<?php $this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Perencanaan
        <small>Jadwal</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"></li>
    </ol>
</section>
<section class="content">
	<div class="box">
		<div class="box-header">
			<?php if($this->uri->segment(2)==jadwalAdmin){?>
			<form class="form-horizontal" action="<?php echo site_url('perencanaan_kh/jadwalAdmin');?>" method="get">
			<?php } ?>	
			<?php if($this->uri->segment(2)==jadwal){?>
			<form class="form-horizontal" action="<?php echo site_url('perencanaan_kh/jadwal');?>" method="get">
			<?php } ?>	
				<label class="col-md-1">Tahun</label>
				<div class="col-md-1">
				<select class="form-control" name="tahun">
					<option value="<?php echo $tahun;?>"><?php echo $tahun;?></option>
				</select>
				</div>
				<label class="col-md-1">Bulan</label>
				<div class="col-md-1">
					<select class="form-control" name="bulan">
						<option value="<?php echo $bulan;?>"><?php echo $bulan;?></option>
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
							<option value="11">12</option>
					</select>
				</div>
				<?php if($this->uri->segment(2)=="jadwalAdmin"){?>
				<div class="col-md-2">
					<select class="form-control select2" name="lokasi" >
						<option value="0"></option>
						<?php foreach ($lokasi as $l ) {?>
						<option value="<?php echo $l->id_lokasi;?>"><?php echo $l->lokasi;?></option>	
						<?php } ?>
						
					</select>	
				</div>
				<?php } ?>
				<div class="col-md-1">
					<button class="btn btn-primary" type="submit">Cari</button>
				</div>
			</form>
		</div>
		
		<div class="box-body">
			<div style="overflow-x:auto;">
				<table class="table table-responsive table-stripped table-scrollable" id="mydata">
					<thead>
						<tr>
							<th>No</th>
							<th>Tahun</th>
							<th>Bulan</th>
							<th>Nama</th>
							<th>Lokasi</th>
							<?php echo $head;  ?>
						</tr>
					</thead>
					<tbody>
						<?php $n=1; foreach($penempatan as $j){ ?>
						<tr>	
							<td><?php echo $n;?></td>
							<td><?php echo $j->tahun; ?></td>
							<td><?php echo $j->bulan; ?></td>
							<td><?php echo $j->nama; ?></td>
							<td><?php echo $j->lokasi; ?></td>
							<?php echo $controller->checkJadwal($j->id,$j->tahun,$j->bulan)?>
						</tr>
						<?php $n++;} ?>
					</tbody>
				</table>
			</div>
			<div id="jdwl">
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	function coba(a,s,d){
		alert('ada');
	}
	function updateJadwal(_this,tgl,tes){
		var st = <?php echo $status?>;
		if(tes==1){
			var msg = tgl+"Berhasil Dihapus";	
			_this.style.backgroundColor= "red";
		}else{
			var msg = tgl+"Berhasil Ditambah";
			if(st==0){
				alert('Harap hubungi koordinator untuk menambah jadwal');
				return;
			}
			_this.style.backgroundColor= "green";
		}
		console.info(_this.style.backgroundColor);
		alert(msg);
		$.ajax({
			type : "POST",
			url  : "<?php echo site_url('perencanaan_kh/updateJadwal')?>",
			dataType : "JSON",
			data : {tanggal:tgl},
			success: function(data){
				document.getElementById('jdwl').innerHTML=""; 
				var response = responseText;
				document.getElementById('jdwl').innerHTML = response;
			}
		}).then(function successCallback(response){
			if(response.status==200){
				document.getElementById('#jdwl').innerHTML=""; 
				document.getElementById('#jdwl').innerHTML = response;
			}
		});
		return false;
	}
	
	$(document).ready(function(){
		$('.select2').select2()
        show_product(); //call function show all product
         
        $('#mydata').dataTable();
          
        //function show all product
        function show_product(){
            $.ajax({
                type  : 'ajax',
                url   : '<?php echo site_url('perencanaan_kh/jadwalData')?>',
                async : true,
                dataType : 'json',
                success : function(data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<tr>'+
                                '<td>'+data[i].nama+'</td>'+
                                '<td>'+data[i].jabatan+'</td>'+
								'<td style="text-align:center;witdh:50px;">'+
                                    '<a href="javascript:void(0);" class="btn btn-info btn-sm item_edit" data-product_code="'+data[i].id+'" data-product_name="'+data[i].product_name+'" data-price="'+data[i].product_price+'">Edit</a>'+' '+
                                    '<a href="javascript:void(0);" class="btn btn-danger btn-sm item_delete" data-product_code="'+data[i].id+'">Delete</a>'+
                               	'</td>'+
								'</tr>';
                    }
                    $('#show_data').html(html);
                }
 
            });
        }
	});
</script>
<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>