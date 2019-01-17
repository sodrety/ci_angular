<!doctype html>
<html>

<head>
    <title>Laporan Dokumen Impor</title>
    <script src="js/Chart.bundle.js"></script>
    <style>
    canvas{
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
	* {font-family:arial;}
	html, body{padding:0;margin:0;width:100%;}
	.wrap {padding:0 0 0 20mm; width:85%;}
	h2 {font-size:12px; text-align:center;}
	.content,table{font-size:12px; font-weight:100; text-align:justify;}
	#myChart1 { width:150mm !important;   height:70mm !important;
}
#myChart { width:100mm !important;   height:50mm !important;
}
    </style>
</head>
<img src='kop.png' width='100%'>
<body>
<div class=wrap>
<?php
$dok="1,2,3,4,5";
$label='"a","b"';
$diterima="1,2";
$selesai="10,12";
?>
 <canvas id="myChart1"></canvas>
 <canvas id="myChart"></canvas>
<script>

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["Total", "Selesai", "Ditunda", "< 90 menit", "> 90 menit"],
                    datasets: [{
                            label: '# of Votes',
                            data: [<?php echo $dok ?>],
                            backgroundColor: [
                                'rgba(255, 159, 64, 0.5)',
                                'rgba(54, 162, 235, 0.5)',
                                'rgba(255, 206, 86, 0.5)',
                                'rgba(75, 192, 192, 0.5)',
                                'rgba(153, 102, 255, 0.5)',
                                'rgba(255, 99, 132, 0.5)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 3
                        }]
                },
   options: {
                responsive: true,
                title:{
                    display:true,
                    text:''
                },
				legend:{
                    display:false,
                    position:'bottom'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Status',
							fontSize: 25
                        },
						ticks: {
						fontColor: "#000000", // this here
						fontSize: 25,
						}
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Jumlah Dokumen',
							fontSize: 25
                        },
						ticks: {
						fontColor: "#000000", // this here
						fontSize: 25,
						}
                    }]
                }
            }

 });

        // Define a plugin to provide data labels
        Chart.plugins.register({
            afterDatasetsDraw: function(chart, easing) {
                // To only draw at the end of animation, check for easing === 1
                var ctx = chart.ctx;

                chart.data.datasets.forEach(function (dataset, i) {
                    var meta = chart.getDatasetMeta(i);
                    if (!meta.hidden) {
                        meta.data.forEach(function(element, index) {
                            // Draw the text in black, with the specified font
                            ctx.fillStyle = 'rgb(0, 0, 0)';

                            var fontSize = 20;
                            var fontStyle = 'normal';
                            var fontFamily = 'arial';
                            ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

                            // Just naively convert to string for now
                            var dataString = dataset.data[index].toString();

                            // Make sure alignment settings are correct
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';

                            var padding = 5;
                            var position = element.tooltipPosition();
                            ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
                        });
                    }
                });
            }
        });
		
var ctx1 = document.getElementById("myChart1").getContext('2d');
var myChart1 = new Chart(ctx1, {
    type: 'line',
    data: {
        labels: [<?php echo $label ?>],
        datasets: [{
            label: 'Diterima',
			data: [<?php echo $diterima ?>],
            backgroundColor: 'red',
            borderColor:'red',
			fill: false,
            borderWidth: 3
        }, {
            label: 'Selesai',
			data: [<?php echo $selesai ?>],
            backgroundColor: 'blue',
            borderColor:'blue',
			fill: false,
            borderWidth: 3
        }
		]
    },
   options: {
                responsive: true,
                title:{
                    display:true,
                    text:''
                },
				legend:{
                    display:true,
                    position:'bottom',
						ticks: {
						fontSize: 20,
						}
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Pukul',
							fontSize: 20
                        },
						ticks: {
						fontColor: "#000000", // this here
						fontSize: 20,
						}
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Jumlah Dokumen',
							fontSize: 20
                        },
						ticks: {
						fontColor: "#000000", // this here
						fontSize: 20,
						}
                    }]
                }
            }
});

</script>
<?php
$cap=($tcp/($tdk_tcp+$tcp))*100;
if ($cap>="100") {$r="Sasaran tercapai, selanjutnya dapat dipelihara sumber daya agar sasaran sesalu dapat tercapai";} 
elseif ($cap>="80") {$r="Sasaran tercapai diatas 80 persen, selanjutnya dapat dipelihara dan tingkatkan sumber daya meliputi sumber daya manusia (verifikator), kecepatan jaringan internet, dan infrastruktur yang lainnya";}
else {$r="Sasaran tidak tercapai, persentase capaian dibawah 80 persen, selanjutnya dapat dilakukan perbaikan diantaranya:<br>
1. Penambahan jumlah verifikator<br>
2. Perbaikan infrastruktur (printer, komputer, dan jaringan)<br>
3. Mendorong pengguna jasa menyampaikan permohonan seawal mungkin (pagi hari)
";}
echo "
<b>C. Kesimpulan</b><br>
Capaian Pelayanan: <span style='font-size:15px;font-weight:700;'>".des($cap)." %</span><br>
<b>C. Rekomendasi</b><br>
$r
</div>";

$data= "Capaian layanan tindakan pemeriksaan dokumen impor yaitu: total permohonan <b>$jm</b> dokumen, tercapai dibawah 90 menit <b>$tcp</b> permohonan atau sebesar <b>".des($cap)."</b> persen.<br>Rekomendasi:<br>".$r;
$username="prayitno35";
$nospt="10a/KP.430/K.7.A/01/2017";
$no_dok=  $username."_ABCH_".$tgl;
$lokasi="Kantor Induk, BBKP Tanjung Priok";
$hasil="Laporan";
$ak="0.04";
if ($jm>0) {
popt_replace("a2","'".$username."', '$tgl', '$tgl', '$nospt', '$data', '$hasil', 'ABCH', 'Teguh Prayitno', '$no_dok', '$lokasi', 'ABCH', '".$ak."', '".$ak."', '1', '".$ab."', '', '".now()."'");
}
if ($tgl=="2017-11-31") {exit;}
 //echo " <meta http-equiv=\"refresh\" content=\"1; URL=?tgl=".next_date($tgl)."\">"; 
?>
<table align=right>
<tr><td>Jakarta, <?php echo tgl_p(next_date($tgl)) ?><br>Petugas Karantina Tumbuhan<br><br><br>Teguh Prayitno, SP.<br>NIP. 198402072009011009</td></tr>
</table>
</div>
</body>

</html>
