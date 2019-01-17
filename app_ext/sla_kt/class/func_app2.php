<?php

function sla_fisik(){
$db = new database();
$db->connect(app_db());
if ($_POST['tgl']=="") {$tgl=$tglm=today();} else {$tgl=$_POST['tgl'];$tglm=$_POST['tglm'];}
$n=0;
echo "
<form method=post>
Lokasi: <select id='select1' name=lokasi ><option>".$_POST['lokasi']."</option><option></option>".lokasi_opt()."
    </select> Tgl: <input type=date value='".$tglm."' name='tglm'> s.d <input type=date value='".$tgl."' name='tgl'>
<input type=submit name=cari value=Cari style='padding:3px;'></form>
";
$id_lokasi=app_baca("lokasi","lokasi='".$_POST['lokasi']."'","id_lokasi");

if ($_POST['simpan']=="Simpan") {
$ada=app_baca("sla_fisik","no_reg='".$_POST['no_reg']."'","no_reg");
$q="'".$id_lokasi."', '".$_POST['no_reg']."', '".$_POST['sampling']."', '".$_POST['total']."', '".$_POST['feet']."', '".$_POST['status']."', '".$_POST['dp1']." ".$_POST['dp1t']."', '".$_POST['tgl']." ".$_POST['tglt']."', '".now()."', '".user_id()."','".$_POST['seri']."'";
app_replace("sla_fisik",$q);
}

if ($id_lokasi!="") {$whl="and lokasi.id_lokasi='".$id_lokasi."'"; }
$query = "SELECT * FROM sla_fisik JOIN lokasi ON sla_fisik.id_lokasi=lokasi.id_lokasi WHERE kt9<='".$tgl." 23:59:59' and kt9>='".$tglm." 00:00:00' ".$whl." order by pada desc";
$results = $db->get_results( $query );

if ($id_lokasi!="" and strlen($tgl)=="10") {
$jab=app_baca("sla_f_ttd","id='".$tgl."_".$id_lokasi."'","jab");
$id_popt=app_baca("sla_f_ttd","id='".$tgl."_".$id_lokasi."'","id_popt");
$nama_popt=app_baca("popt","id='".$id_popt."'","nama");
$a="<form target='ttd' method=post action='exe/ttd.php?tgl=".$tgl."&id_lokasi=".$id_lokasi."'><b><a onclick=\"requestContent('ajx/f_sla_fisik.php?tglm=".$tglm."&tgl=".$tgl."&lokasi=".$_POST['lokasi']."','formdiv')\">Tambah</a></b> ttd: <select name=jab> <option value='".$jab."'>".$jab."</option><option value='Penanggungjawab TPK/Wilker'>Penanggungjawab TPK/Wilker</option><option value='an. Penanggungjawab TPK/Wilker <br>Ketua Tim'>an. Penanggungjawab TPK/Wilker <br>Ketua Tim</option></select><select name=id_popt id='select3'><option value='".$id_popt."'>".$nama_popt."</option>".popt_opt()."</select><input type=submit value='Update' name=ttd><iframe name=ttd style='border:0px;height:20px;width:60px;'></iframe> <a href='print/lap.php?tgl=".$tgl."&id_lokasi=".$id_lokasi."' target='_blank'>Print</a></form> ";}
echo "
<div id=formdiv>$a</div>
<table class='table' width=100% id=example2>

<thead>
<tr><th>NO</th><th>LOKASI</th><th>NO DOKUMEN</th><th>SAMPLING</th><th>TOTAL</th><th>STATUS</th><th>WAKTU AWAL (DP-1)</th><th>WAKTU NSW (KT-9)</th><th>DURASI (MENIT)</th><th>SERI</th><th>HAPUS</th></tr>
</thead>

<tbody>";


foreach( $results as $data )
{
	$n++;
$du=durasi($data['dp1'],$data['kt9']);
if ($id_lokasi!="" and strlen($tgl)=="10") {$del="<a href='exe/del.php?no_reg=".$data['no_reg']."' target='ttd' >x</a>"; } else {$del="";}
echo "<tr valign='top' align=center><td>$n</td><td>".$data['lokasi']."</td><td>".$data['no_reg']."</td><td>".$data['sampling']."</td><td>".$data['total']."</td><td>".$data['status']."</td><td>".$data['dp1']."</td><td>".$data['kt9']."</td><td>".$du."</td><td>".$data['seri']."</td><td>".$del."</td></tr>";
$sam+=$data['sampling'];
$to+=$du;
$kon+=$data['total'];
if ($du<=(24*60)) {$cap+=1;}
}
echo "</tbody><tfoot>
<tr valign='top' align=center><td></td><td></td><td></td><td><b>".rp($sam)."</b></td><td><b>".rp($kon)."</b></td><td></td><td></td><td></td><td><b>".des($to/$n)."</b></td><td></td><td></td></tr>
</tfoot>
</table>
Capaian SLA : <b>".des(($cap/$n)*100)." %</b>";
}

function sla_doc(){
$db = new database();
$db->connect("movedb");
if ($_POST['tgl']=="") {$tgl=$tglm=today();} else {$tgl=$_POST['tgl'];$tglm=$_POST['tglm'];}
$n=0;
echo "
<form method=post>
Tgl: <input type=date value='".$tglm."' name='tglm'> s.d <input type=date value='".$tgl."' name='tgl'>
<input type=submit name=cari value=Cari style='padding:3px;'></form>
";
$query = "SELECT * from sla_doc where tabel='kt_impor' and tgl<='".$tgl."' and tgl>='".$tglm."' and jml>'0' order by tgl";
$results = $db->get_results( $query );




foreach( $results as $data )
{
	$n++;
$tgln.="'".$data['tgl']."',";
$jml.="'".$data['jml']."',";
$sla.="'".$data['sla']."',";
$cap+=$data['jml'];
$red.="'100',";
$datanya.="<tr valign='top' align=center><td>$n</td><td>".$data['tgl']."</td><td>".$data['jml']."</td><td>".$data['sla']."</td></tr>";
}
/*
echo "
<table class='table' width=100% id=example10>

<thead>
<tr><th>NO</th><th>TANGGAL</th><th>JML DOKUMEN</th><th>CAPAIAN</th></tr>
</thead>

<tbody>".$datanya."</tbody><tfoot>
<tr valign='top' align=center><td></td><td></td><td></td><td><b>".rp($sam)."</b></td></tr>
</tfoot>
</table>";
*/
//$tgln=substr($tgln,0,-1);
echo "
<center>
   <canvas id=\"myChart3\"></canvas>
</center>

<script>



var ctx1 = document.getElementById(\"myChart3\").getContext('2d');
var myChart1 = new Chart(ctx1, {
    type: 'line',
    data: {
        labels: [".$tgln."],
        datasets: [{
            label: 'Capaian SLA',
			data: [".$sla."],
            backgroundColor: 'blue',
            borderColor:'blue',
			fill: false,
            borderWidth: 1
        }, {
            label: 'Jumlah Antrian',
			data: [".$jml."],
            backgroundColor: 'red',
            borderColor:'red',
			fill: false,
            borderWidth: 1
        }, {
            label: '',
			data: [".$red."],
            backgroundColor: 'yellow',
            borderColor:'yellow',
			fill: false,
            borderWidth: 1
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
                    position:'top',
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
                            labelString: 'Bulan',
							fontSize: 10
                        },
						ticks: {
						fontColor: \"#000000\", // this here
						fontSize: 10,
						}
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: '',
							fontSize: 10
                        },
						ticks: {
						fontColor: \"#000000\", // this here
						fontSize: 10,
						}
                    }]
                }
            }
});

/*
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

                            var fontSize = 10;
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
*/

</script>

";


}


function sla_doc_harian(){
$db = new database();
$db->connect("dropbox");
if ($_POST['tgl']=="") {$tgl=today();} else {$tgl=$_POST['tgl'];}
$n=0;
echo "
<form method=post>
Tgl: <input type=date value='".$tgl."' name='tgl'>
<input type=submit name=cari value=Cari style='padding:3px;'></form>
";
$query = "SELECT id,last_antri from barcode where bidang='2' and via='L' and lintas='I' and last_antri LIKE '".$tgl."%' order by last_antri";
$results = $db->get_results( $query );

foreach( $results as $data )
{
	$n++;
	$j=(substr($data['last_antri'],11,2))*1;

if ($j=="7") {$n7+=1;} elseif($j=="8") {$n8+=1;} elseif ($j=="9") {$n9+=1;} elseif ($j=="10") {$n10+=1;} elseif ($j=="11") {$n11+=1;} elseif ($j=="12") {$n12+=1;} elseif ($j=="13") {$n13+=1;} elseif ($j=="14") {$n14+=1;} elseif ($j=="15") {$n15+=1;} elseif ($j=="16") {$n16+=1;}

$sl=db_baca("dropbox","antrian","status='4' and id_barcode='".$data['id']."' and waktu>='".$data['last_antri']."' order by waktu","waktu");
if ($sl=="") {$sl=db_baca("dropbox","antrian","status='3' and id_barcode='".$data['id']."' and waktu>='".$data['last_antri']."' order by waktu","waktu");}
	$s=(substr($sl,11,2))*1;
if ($s=="7") {$ns7+=1;} elseif($s=="8") {$ns8+=1;} elseif ($s=="9") {$ns9+=1;} elseif ($s=="10") {$ns10+=1;} elseif ($s=="11") {$ns11+=1;} elseif ($s=="12") {$ns12+=1;} elseif ($s=="13") {$ns13+=1;} elseif ($s=="14") {$ns14+=1;} elseif ($s=="15") {$ns15+=1;} elseif ($s=="16") {$ns16+=1;}

$datanya.=$data['last_antri']." ".$s."<br>";
$du=durasi($data['last_antri'],$sl);
if ($du<="90") {$tc++;} 
}
$antri.="'".$n7."','".$n8."','".$n9."','".$n10."','".$n11."','".$n12."','".$n13."','".$n14."','".$n15."','".$n16."',";
$selesai.="'".$ns7."','".$ns8."','".$ns9."','".$ns10."','".$ns11."','".$ns12."','".$ns13."','".$ns14."','".$ns15."','".$ns16."',";
$t=7;
while ($t<17) {
$tt=substr("0".$t,-2);
$jam.="'".$tt."',";
$t++;
}

echo "
<center>
   <canvas id=\"myChart3\" width='500px'></canvas>
</center>
Tanggal Layanan : ".tgl_p($tgl)."<br>
Total Pengajuan: ".$n."<br>
SLA Tercapai (<=90 menit) : ".$tc."<br>
Capaian : <b>".des(($tc/$n)*100)." %</b><br>
<script>



var ctx1 = document.getElementById(\"myChart3\").getContext('2d');
var myChart1 = new Chart(ctx1, {
    type: 'line',
    data: {
        labels: [".$jam."],
        datasets: [ {
            label: 'Terima',
			data: [".$antri."],
            backgroundColor: 'red',
            borderColor:'red',
			fill: false,
            borderWidth: 2
        }, {
            label: 'Selesai',
			data: [".$selesai."],
            backgroundColor: 'blue',
            borderColor:'blue',
			fill: false,
            borderWidth: 2
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
                    position:'top',
						ticks: {
						fontSize: 30,
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
							fontSize: 15
                        },
						ticks: {
						fontColor: \"#000000\", // this here
						fontSize: 15,
						}
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: '',
							fontSize: 15
                        },
						ticks: {
						fontColor: \"#000000\", // this here
						fontSize: 15,
						}
                    }]
                }
            }
});

</script>

";


}



