<?php
$this->load->view('template/head'); ?>
<?php $this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <small>Dashboard</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cuti</li>
    </ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3><?php echo $notifProses;?></h3>
					<p>Permohonan Cuti</p>
				</div>
				<div class="icon">
					<i class="ion ion-clipboard"></i>
				</div>
				<p class="small-box-footer"></p>
			</div>
        </div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-green">
				<div class="inner">
					<h3><?php echo $jumlahSerapan;?></h3>
					<p>Serapan</p>
				</div>
				<div class="icon">
					<i class="fa fa-percent"></i>
				</div>
				<p class="small-box-footer"></p>
			</div>
        </div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-red">
				<div class="inner">
					<h3><?php echo $jumlahSurat;?></h3>
					<p>Surat Masuk</p>
				</div>
				<div class="icon">
					<i class="ion ion-clipboard"></i>
				</div>
				<p class="small-box-footer"></p>
			</div>
      </div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3><?php echo $jumlahTugas;?></h3>
					<p>Penugasan</p>
				</div>
				<div class="icon">
					<i class="ion ion-checkmark-circled"></i>
				</div>
				<p class="small-box-footer"></p>
			</div>
    </div>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-green">
				<div class="inner">
					<h3><?php echo $notifSelesai;?></h3>
					<p>Jumlah Cuti</p>
				</div>
				<div class="icon">
					<i class="ion ion-checkmark-circled"></i>
				</div>
				<p class="small-box-footer"></p>
			</div>
    </div>
	</div>
	<div class="row">
		<div class="box-body" ">
			<div class="col-md-6">
				<a href="#" class="text-center"><label class="text-center">Jumlah Antrian</label></a>
				<canvas id="myChart" style="border: 1px red;border-opacity: 0.5;"></canvas>
			</div>
		</div>
		<div class="box-body">
			<div class="col-md-6">
				<canvas id="anggaranChart"></canvas>
			</div>
		</div>
	</div>
</section>

<script>
var antrian = document.getElementById("myChart").getContext('2d');
var anggaran = document.getElementById("anggaranChart").getContext('2d');
var myChart = new Chart(antrian, {
    type: 'bar',
    data: {
        labels: ["Antrian KT", "Antrian KH", "Ekspor KT"],
        datasets: [{
            label: 'Antrian',
            data: [
            <?php
            foreach ($antrian as $a) {
            	echo $a->i_kt.','.$a->i_kh.','.$a->e_kt;
            }
            ?>
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

var myChart = new Chart(anggaran, {
    type: 'doughnut',
    data: {
        labels: ["Sisa","SPM", "SPTB","Usulan"],
        datasets: [{
            label: 'Antrian',
            data: [
            <?php
            foreach ($anggarans as $a) {
            	echo $a->sisa.','.$a->spm.','.$a->sptb.','.$a->usulan;
            }
            ?>
            ],
            backgroundColor: [
                'rgba(255, 0, 0, 0.5)',
				'rgba(0, 0, 255, 0.5)',
				'rgba(0, 128, 0, 0.5)',
				'rgba(255, 216, 0, 0.5)'
            ],
            borderColor: [
                 '#fff'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>
