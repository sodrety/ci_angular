<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=1; foreach ($tes as $t) { ?>
			<tr> 
				<td><?php echo $no;?></td>
				<td><input type="text" id="dat" onchange="tes()" value="<?php echo $t->nama;?>"></td>
			</tr>
			<?php $no++; } ?>
		</tbody>
	</table>
</body>
</html>
<script src="<?php echo base_url('assets/jQuery/jquery.min.js') ?>"></script>
<script type="text/javascript">

	function tes(){
		var data = document.getElementById("dat");
		console.log = data;
		alert(data);
	};

	$(document).ready(function(){
		var link = "http://192.168.0.12/prioqnet/index.php/data_cuti/tesData";
		console.info(link);
		$.ajax({
		   type: "POST",
		   data: tes,
		   dataType: 'json',
		   url: link,
		   success: function(data){
		    console.log(data);
		   }
		});
	});
</script>