<?php

function user_id() {
return $_SESSION['user_id'];
}

function pok_kodenya($no) {
$a=pok_topnya($no);
$b=pok_topnya($a);
$c=pok_topnya($b);
$d=pok_topnya($c);
$e=pok_topnya($d);
$f=pok_topnya($e);
$g=pok_topnya($f);
$h=pok_topnya($g);
$i=pok_topnya($h);
$j=pok_topnya($i);
$k=rq_baca("pok","no='".$no."'","kode");
$ka=rq_baca("pok","no='".$a."'","kode");
$kb=rq_baca("pok","no='".$b."'","kode");
$kc=rq_baca("pok","no='".$nomic."'","kode");
$kd=rq_baca("pok","no='".$d."'","kode");
$ke=rq_baca("pok","no='".$e."'","kode");
$kf=rq_baca("pok","no='".$f."'","kode");
$kg=rq_baca("pok","no='".$g."'","kode");
$kh=rq_baca("pok","no='".$h."'","kode");
$ki=rq_baca("pok","no='".$i."'","kode");
$kj=rq_baca("pok","no='".$j."'","kode");
$kk="".$kj.".".$ki.".".$kh.".".$kg.".".$kf.".".$ke.".".$kd.".".$kc.".".$kb.".".$ka.".".$k."";
$ko=str_replace ("..","",$kk);
$p=strlen($ko);
if (substr ($ko, 0, 1)==".") {$ko=substr ($ko, 1, $p);}
return $ko;
}

function rq_monitor() {
$db = new database();
$db->connect(rq_db());
$no=$_GET['no'];
if ($no<1) {$no=1;}
$query = "SELECT * FROM pok WHERE top='".$no."' order by kode";
$results = $db->get_results( $query );
$n=0;
$print.= "<table class='table' width=100%>
<thead>
<tr><th rowspan='3'>KODE</th><th rowspan='3'>URAIAN</th><th rowspan='3'>JUMLAH</th><th colspan='8'>REALISASI</th>
<th colspan='2' rowspan='2'>REALISASI TOTAL</th><th rowspan='3'>SALDO</th></tr>
<tr><th colspan='2'>USULAN</th><th colspan='2'>SPTB</th><th colspan='2'>SPM</th><th colspan='2'>SP2D</th></tr>
<tr><th>RP</th><th>%</th><th>RP</th><th>%</th><th>RP</th><th>%</th><th>RP</th><th>%</th><th>RP</th><th>%</th></tr>
</thead><tbody>";
rq_update("pok","mak LIKE '1823.101%'","ppk_nama='Mochamad Ischaq, SP, M.Si', ppk_nip='196307081983031002'");
rq_update("pok","mak NOT LIKE '1823.101%'","ppk_nama='drh. Hari Yuwono Ady, M.Si', ppk_nip='197609082001121003'");
foreach( $results as $data )
{
$n+=1;
if ($data['sat']=="") {$w="style='font-weight:400'";
$jml=pok_sum($data['no']);
$rl_usulan=rq_relisasi($data['mak'],"usulan");
$rl_sptb=rq_relisasi($data['mak'],"sptb");
$rl_spm=rq_relisasi($data['mak'],"spm");
$rl_sp2d=rq_relisasi($data['mak'],"sp2d");
} else {$w="";
$jml=$data['jumlah'];
//$real=rq_jml_cost($data['no']);
$rl_usulan=rq_jml_cost($data['no'],"usulan");
$rl_sptb=rq_jml_cost($data['no'],"sptb");
$rl_spm=rq_jml_cost($data['no'],"spm");
$rl_sp2d=rq_jml_cost($data['no'],"sp2d");
}
$real=$rl_usulan+$rl_sptb+$rl_spm;

$print.= "<tr><td><a href='?no=".$data['no']."'>".$data['kode']."</a></td><td><a href='?no=".$data['no']."'>".$data['uraian']."</a></td><td align=right $w>".rp($jml)."</td><td align=right $w>".rp($rl_usulan)."</td><td align=right $w>".des(($rl_usulan/$jml)*100)."</td><td align=right $w>".rp($rl_sptb)."</td><td align=right $w>".des(($rl_sptb/$jml)*100)."</td><td align=right $w>".rp($rl_spm)."</td><td align=right $w>".des(($rl_spm/$jml)*100)."</td><td align=right $w>".rp($rl_sp2d)."</td><td align=right $w>".des(($rl_sp2d/$jml)*100)."</td><td align=right $w>".rp($real)."</td><td align=right $w>".des(($real/$jml)*100)."</td><td align=right $w>".rp($jml-$real)."</td></tr>";
$label.='"'.$data['kode'].'",';
$diterima.=''.des_en($jml/1000000).',';
$selesai.=''.des_en($real/1000000).',';
$jum+=$jml;
$rl+=$real;
$rl_usu+=$rl_usulan;
$rl_spt+=$rl_sptb;
$rl_sp+=$rl_spm;
$rl_sp2+=$rl_sp2d;
}
$w="style='font-weight:700'";
$print.= "<tr><td></td><td><b>TOTAL</a></td><td align=right $w>".rp($jum)."</td>
<td align=right $w>".rp($rl_usu)."</td><td align=right $w>".des(($rl_usu/$jum)*100)."</td>
<td align=right $w>".rp($rl_spt)."</td><td align=right $w>".des(($rl_spt/$jum)*100)."</td>
<td align=right $w>".rp($rl_sp)."</td><td align=right $w>".des(($rl_sp/$jum)*100)."</td>
<td align=right $w>".rp($rl_sp2)."</td><td align=right $w>".des(($rl_sp2/$jum)*100)."</td>
<td align=right $w>".rp($rl)."</td><td align=right $w>".des(($rl/$jum)*100)."</td><td align=right $w>".rp($jum-$rl)."</td></tr>";
if ($no=="") {
db_replace("user_login","app_anggaran","'".today()."', '".$jum."', '".$rl_usu."', '".$rl_spt."', '".$rl_sp."', '".($jum-$rl)."'");
db_replace("user_login","app_serapan","'".today()."','".(des(($rl_sp/$jum)*100))." %'");
}
$print.= "</tbody></table>";

$dok="".des_en(($jum-$rl)/1000000).",".des_en($rl_sp/1000000).",".des_en($rl_spt/1000000).",".des_en($rl_usu/1000000)."";
//$label4="'Umum','K. Tumbuan','K. Hewan','Wasdak'";
$query4 = "SELECT * FROM serapan_bidang where bidang!='' order by bidang";
$results4 = $db->get_results( $query4 );
foreach( $results4 as $data4 )
{
$label4.="'".$data4['ket']." (".des(($data4['sp2d']/$data4['jumlah'])*100)."%)',";	
$anggaran4.="'".$data4['jumlah']."',";	
$usulan4.="'".$data4['cost']."',";
$sp2d4.="'".$data4['sp2d']."',";
}

echo "
<center>
 <canvas id=\"myChart\" style='max-width:600px;float:left;margin-top:0px;'></canvas>
   <canvas id=\"myChart3\" style='max-width:700px;float:left;margin-top:0px;'></canvas>   
 <canvas id=\"myChart4\" style='max-width:700px;float:left;margin-top:0px;'></canvas>
 <canvas id=\"myChart1\" style='max-width:700px;float:left;margin-top:0px;'></canvas>

</center>".$print."

<script>


var ctx1 = document.getElementById(\"myChart1\").getContext('2d');
var myChart1 = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: [".$label."],
        datasets: [{
            label: 'Anggaran (Rp. ".rp($jum).")',
			data: [".$diterima."],
            backgroundColor: 'rgba(255, 0, 0, 0.5)',
            borderColor:'#ddd',
			fill: false,
            borderWidth: 1
        }, {
            label: 'Realisasi (Rp. ".rp($rl).")',
			data: [".$selesai."],
            backgroundColor: 'rgba(0, 128, 0, 0.5)',
            borderColor:'#ddd',
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
                            labelString: 'Kode',
							fontSize: 12
                        },
						ticks: {
						fontColor: \"#000000\", // this here
						fontSize: 12,
						}
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Nominal (dalam Juta Rupiah)',
							fontSize: 12
                        },
						ticks: {
						fontColor: \"#000000\", // this here
						fontSize: 12,
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

var ctx = document.getElementById(\"myChart\").getContext('2d');
var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [\"Saldo ".des((($jum-$rl)/$jum)*100)." %\", \"SPM ".des((($rl_sp)/$jum)*100)." %\", \"SPTB ".des((($rl_spt)/$jum)*100)." %\", \"Usulan ".des((($rl_usu)/$jum)*100)." %\"],
                    datasets: [{
                            label: '',
                            data: [".$dok."],
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


 });



var ctx1 = document.getElementById(\"myChart3\").getContext('2d');
var myChart1 = new Chart(ctx1, {
    type: 'line',
    data: {
        labels: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
        datasets: [{
            label: 'Anggaran (rata-rata)',
			data: ['".($jum/12)."','".($jum/12)."','".($jum/12)."','".($jum/12)."','".($jum/12)."','".($jum/12)."','".($jum/12)."','".($jum/12)."','".($jum/12)."','".($jum/12)."','".($jum/12)."','".($jum/12)."'],
            backgroundColor: 'red',
            borderColor:'red',
			fill: false,
            borderWidth: 1
        }, {
            label: 'Usulan',
			data: [".rq_jml_mak(rq_baca("pok","no='".$no."'","mak"),"usulan")."],
            backgroundColor: 'orange',
            borderColor:'orange',
			fill: false,
            borderWidth: 1
        }, {
            label: 'SPTB',
			data: [".rq_jml_mak(rq_baca("pok","no='".$no."'","mak"),"sptb")."],
            backgroundColor: 'green',
            borderColor:'green',
			fill: false,
            borderWidth: 1
        }, {
            label: 'SPM',
			data: [".rq_jml_mak(rq_baca("pok","no='".$no."'","mak"),"spm")."],
            backgroundColor: 'blue',
            borderColor:'blue',
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
                            labelString: 'Kode',
							fontSize: 12
                        },
						ticks: {
						fontColor: \"#000000\", // this here
						fontSize: 12,
						}
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Nominal (dalam Juta Rupiah)',
							fontSize: 12
                        },
						ticks: {
						fontColor: \"#000000\", // this here
						fontSize: 12,
						}
                    }]
                }
            }
});


var ctx1 = document.getElementById(\"myChart4\").getContext('2d');
var myChart1 = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: [".$label4."],
        datasets: [{
            label: 'Anggaran',
			data: [".$anggaran4."],
            backgroundColor: 'rgba(255, 0, 0, 0.5)',
            borderColor:'#ddd',
			fill: false,
            borderWidth: 1
        }, {
            label: 'Usulan',
			data: [".$usulan4."],
            backgroundColor: 'rgba(188, 116, 2, 0.5)',
            borderColor:'#ddd',
			fill: false,
            borderWidth: 1
        }, {
            label: 'SP2D',
			data: [".$sp2d4."],
            backgroundColor: 'rgba(0, 0, 255, 0.5)',
            borderColor:'#ddd',
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
                            labelString: 'Kode',
							fontSize: 12
                        },
						ticks: {
						fontColor: \"#000000\", // this here
						fontSize: 12,
						}
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Nominal (dalam Rupiah)',
							fontSize: 12
                        },
						ticks: {
						fontColor: \"#000000\", // this here
						fontSize: 12,
						}
                    }]
                }
            }
});


var ctx1 = document.getElementById(\"myChart5\").getContext('2d');
var myChart1 = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: [".$label5."],
        datasets: [{
            label: 'Anggaran',
			data: [".$anggaran5."],
            backgroundColor: 'rgba(255, 0, 0, 0.5)',
            borderColor:'#ddd',
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
                            labelString: 'Kode',
							fontSize: 12
                        },
						ticks: {
						fontColor: \"#000000\", // this here
						fontSize: 12,
						}
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Nominal (dalam Rupiah)',
							fontSize: 12
                        },
						ticks: {
						fontColor: \"#000000\", // this here
						fontSize: 12,
						}
                    }]
                }
            }
});


</script>

";


}

function rq_jml($mak) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT jumlah FROM pok WHERE mak LIKE '".$mak."%' and sat!='' order by mak";
$results = $db->get_results( $query );

foreach( $results as $data )
{
$jml+=$data['jumlah'];
}
return $jml;
}

function rq_jml_mak($mak,$s) {
$db = new database();
$db->connect(rq_db());
if ($s=="usulan") {
$query = "SELECT cost.harga,cost.tgl FROM pok JOIN cost ON pok.no=cost.no WHERE pok.mak LIKE '".$mak."%' and pok.sat!=''";
}
if ($s=="sptb") {
$query = "SELECT cost.harga,cost.tgl,id_sptb FROM pok JOIN cost ON pok.no=cost.no WHERE pok.mak LIKE '".$mak."%' and pok.sat!='' AND cost.id_sptb>0";
}
if ($s=="spm") {
$query = "SELECT cost.harga,cost.tgl,id_spm FROM pok JOIN cost ON pok.no=cost.no WHERE pok.mak LIKE '".$mak."%' and pok.sat!='' AND cost.id_spm>0";
}
if ($s=="sp2d") {
$query = "SELECT cost.harga,cost.tgl,id_spm FROM pok JOIN cost ON pok.no=cost.no JOIN spm ON cost.id_spm=spm.id_spm WHERE pok.mak LIKE '".$mak."%' and pok.sat!='' AND spm.nomor_sp2d>0";
}
$results = $db->get_results( $query );

foreach( $results as $data )
{
$j=$data['harga'];

if ($s=="sptb") { $tgl=rq_baca("sptb","id_sptb='".$data['id_sptb']."'","tgl");}
if ($s=="spm") { $tgl=rq_baca("spm","id_spm='".$data['id_spm']."'","tgl");}
if ($s=="sp2d") { $tgl=rq_baca("spm","id_spm='".$data['id_spm']."'","tgl_sp2d");}
else {$tgl=$data['tgl'];}

if (strstr($tgl,"-01-")) {$j1+=$j;}
if (strstr($tgl,"-02-")) {$j2+=$j;}
if (strstr($tgl,"-03-")) {$j3+=$j;}
if (strstr($tgl,"-04-")) {$j4+=$j;}
if (strstr($tgl,"-05-")) {$j5+=$j;}
if (strstr($tgl,"-06-")) {$j6+=$j;}
if (strstr($tgl,"-07-")) {$j7+=$j;}
if (strstr($tgl,"-08-")) {$j8+=$j;}
if (strstr($tgl,"-09-")) {$j9+=$j;}
if (strstr($tgl,"-10-")) {$j10+=$j;}
if (strstr($tgl,"-11-")) {$j11+=$j;}
if (strstr($tgl,"-12-")) {$j12+=$j;}
}
return "'".$j1."','".$j2."','".$j3."','".$j4."','".$j5."','".$j6."','".$j7."','".$j8."','".$j9."','".$j10."','".$j11."','".$j12."'";
}


function rq_relisasi($mak,$kat) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT no FROM pok WHERE mak LIKE '".$mak."%' and sat!='' order by mak";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$jml+=rq_jml_cost($data['no'],$kat);
}
return $jml;
}

function rq_jml_cost($no,$kat) {
$db = new database();
$db->connect(rq_db());
if ($kat=="usulan") {$wh=" AND id_sptb<1";} elseif ($kat=="sptb") {$wh=" AND id_sptb>0 AND id_spm<1 ";} elseif ($kat=="spm") {$wh=" AND id_spm>0";}else {$wh="";}
if ($kat=="sp2d") {
$query = "SELECT harga FROM cost join spm ON spm.id_spm=cost.id_spm WHERE cost.no='".$no."'";
	} else { $query = "SELECT harga FROM cost WHERE no='".$no."' ".$wh.""; }

$results = $db->get_results( $query );
foreach( $results as $data )
{
$jml+=$data['harga'];
}
return $jml;
}



function rq_pok() {
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE top='1' order by kode";
$results = $db->get_results( $query );
$no=0;
echo "<div class='pok'>
POK &nbsp; <b>".rp(pok_sum(1))."</b> &nbsp; <a href='exe/item.php?top=1' target='_blank'><img src='css/edit.png'></a> ".rp(r_cost_all_sum(1))."";
foreach( $results as $data )
{
echo "<p><a onClick=\"javascript:requestContent('mak2.php?top=".$data['no']."&no=".$no."','a".$no."');\">".$data['kode']."</a> ".$data['uraian']."  &nbsp; <b>".rp(pok_sum($data['no']))."</b> &nbsp; <a href='exe/item.php?top=".$data['no']."' target='_blank'><img src='css/edit.png'></a> ".rp(r_cost_all_sum($data['no']))."
</p>
<div id='a".$no."'></div>
";
$no+=1;
}
echo "</div>";
}

function rq_pok_all() {
echo "<form method=get><input type=hidden name=t value='".$_GET['t']."'><input type=hidden name=do value='".$_GET['do']."'><input type=hidden name=id value='".$_GET['id']."'>
Cari Akun:<input type=text name=mak value='".$_GET['mak']."'> Uraian: <input type=text name=uraian value='".$_GET['uraian']."'> <input type=submit value='Cari'></form><form method=post>
<table class='table' width=100%><thead>
<tr><th>NO</th><th>ID</th><th>TOP</th><th>AKUN (MAK)</th><th></th><th>KODE</th><th>URAIAN</th><th>VOL</th><th>SAT</th><th>HARGASAT</th><th>JUMLAH</th><th>REALISASI</th><th>SALDO</th><th>DANA</th><th>VIEW</th><th>EXE</th></tr></thead><tbody>
";
$id=$_GET['id'];
if ($_POST) {
if ($id>0) {
$sisa_ang=(rq_baca("pok","no='".$_POST['no']."'","jumlah"))-((r_cost_all($_POST['no']))-(rq_baca("cost","id='".$id."'","harga")));
//echo $sisa_ang." ii ".$_POST['harga']."<br>";
//if (strstr($make,"1823.994.902.001") or $sisa_ang>=$_POST['harga']) {
	
rq_update("cost","id='$id'","no='".$_POST['no']."',tgl='".$_POST['tgl']."', harga='".$_POST['harga']."', kepada='".$_POST['kepada']."', untuk='".$_POST['untuk']."', id_sptb='0', id_spm='0',update_oleh='".user_id()."',update_time='".now()."', ppn='".$_POST['ppn']."', pph='".$_POST['pph']."', no_spby='".$_POST['no_spby']."', tgl_spby='".$_POST['tgl_spby']."', ttd='".$_POST['ttd'].$_POST['ttd1']."', bidang='".$_POST['bidang']."'");
//} else {echo "<span style='color:red;'>GAGAL: Sisa Anggaran Tidak Mencukupi</span>";} 
 } else {
	 
	 if ($_POST['untuk']=="") {$untuk=rq_baca("pok","no='".$_POST['no']."'","uraian");;} else {$untuk=$_POST['untuk'];}
$sisa_ang=(rq_baca("pok","no='".$_POST['no']."'","jumlah"))-(r_cost_all($_POST['no']));
$make=rq_baca("pok","no='".$_POST['no']."'","mak");
/*
if (strstr($make,"1823.994.902.001")) {
	if (strstr($make,"511129")) {echo "<span style='color:red;'>GAGAL: Sisa Anggaran Tidak Mencukupi</span>";} elseif (strstr($make,"512211")) {echo "<span style='color:red;'>GAGAL: Sisa Anggaran Tidak Mencukupi</span>";} else {
rq_insert("cost","'".$_POST['no']."', NULL, '".$_POST['tgl']."', NULL, '".$_POST['harga']."', NULL, '', '".$_POST['tgl_spby']."', NULL, '".$_POST['no_spby']."', '".$_POST['kepada']."', '".$untuk."', NULL, NULL, '0', '0','".user_id()."',NULL,'".now()."',NULL, '".$_POST['ppn']."', '".$_POST['pph']."', '".$_POST['ttd'].$_POST['ttd1']."', '".$_POST['bidang']."'");	}
} elseif ($sisa_ang<$_POST['harga']) {echo "<span style='color:red;'>GAGAL: Sisa Anggaran Tidak Mencukupi</span>";} else {
rq_insert("cost","'".$_POST['no']."', NULL, '".$_POST['tgl']."', NULL, '".$_POST['harga']."', NULL, '', '".$_POST['tgl_spby']."', NULL, '".$_POST['no_spby']."', '".$_POST['kepada']."', '".$untuk."', NULL, NULL, '0', '0','".user_id()."',NULL,'".now()."',NULL, '".$_POST['ppn']."', '".$_POST['pph']."', '".$_POST['ttd'].$_POST['ttd1']."', '".$_POST['bidang']."'"); } */
//echo $sisa_ang." ii ".$_POST['harga']."<br>";
if (strstr($make,"1823.994.902.001") or $sisa_ang>=$_POST['harga']) {
rq_insert("cost","'".$_POST['no']."', NULL, '".$_POST['tgl']."', NULL, '".$_POST['harga']."', NULL, '', '".$_POST['tgl_spby']."', NULL, '".$_POST['no_spby']."', '".$_POST['kepada']."', '".$untuk."', NULL, NULL, '0', '0','".user_id()."',NULL,'".now()."',NULL, '".$_POST['ppn']."', '".$_POST['pph']."', '".$_POST['ttd'].$_POST['ttd1']."', '".$_POST['bidang']."'"); 
} else {echo "<span style='color:red;'>GAGAL: Sisa Anggaran Tidak Mencukupi</span>";} 
echo "<meta http-equiv=\"refresh\" content=\"1; URL=?t=Usulan\">";
}
}

echo "
<script>
function FillBilling(f,d) {
var dt=d;
f.untuk.value = dt;
}
</script>";

$db = new database();
$db->connect(rq_db());
if ($id>0) {
$nony=rq_baca("cost","id='$id'","no");
$wh="OR no='".$nony."'";
} else {$nospby=rq_baca("cost","no_spby>'0' order by no_spby desc","no_spby")+1;}
$pieces = explode(" ", $_GET['uraian']);
foreach($pieces as $element)
{
$whu.="AND uraian LIKE '%".$element."%' ";
}

$query = "SELECT * FROM pok WHERE (mak LIKE '%".$_GET['mak']."%' $whu) $wh order by mak";
$results = $db->get_results( $query );

foreach( $results as $data )
{

$n++;

//rq_update("pok","no='".$data['no']."'","mak='".pok_kodenya($data['no'])."'");

if ($data['sat']=="") {
	$jumlah=pok_sum($data['no']);
$pilih="";
$saldo="0";
if ($_GET['do']=="Usulan") {$ex="<a href='?t=POK All&do=Usulan&mak=".$data['mak']."&id=".$id."'>ex</a>";} else {$ex="";$it="<a href='exe/item.php?top=".$data['no']."' target='_blank'><img src='css/edit.png'></a>";
$view="<a href='?no=".$data['no']."'><img src='css/view.png'></a>";}
} else {$it="";$ex="";$view="";
if ($_GET['do']=="Usulan") {
	$jumlah=$data['jumlah'];
$ck="";
$real=r_cost_all($data['no']);
$saldo=$jumlah-$real;
if ($data['no']==$nony) {$ck="checked";}
$pilih="<input type='radio' name='no' value='".$data['no']."' $ck onclick=\"FillBilling(this.form,'".$data['uraian']."')\">"; } else {$pilih="";}
}
echo "<tr><td>".$n."</td><td>".$data['no']."</td><td>".$data['top']."</td><td>".$data['mak']."</td><td>$ex</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td align=right>".rp($data['vol'])."</td><td align=center>".$data['sat']."</td><td align=right>".rp($data['hargasat'])."</td><td align=right>".rp($jumlah)."</td><td align=right>".rp($real)."</td><td align=right>".rp($saldo)."</td><td>".$data['dana']."</td><td align=center>$view</td><td align=center>".$it."".$pilih." </td></tr>";

}

echo "</tbody></table>";
if ($_GET['do']=="Usulan") {
if ($id=="") {$tgl=$tgl_spby=today();} else {$tgl=rq_baca("cost","id='$id'","tgl");$tgl_spby=rq_baca("cost","id='$id'","tgl_spby");}

echo "<div class='fix_bottom'>
Untuk: <input type=text name=untuk value='".rq_baca("cost","id='$id'","untuk")."' style='width:90%;'><br>
Kepada/A.N: <input type=text name=kepada value='".rq_baca("cost","id='$id'","kepada")."' style='width:90%;'><br>
Nominal: Rp.<input type=number name=harga value='".rq_baca("cost","id='$id'","harga")."'> Pajak PPN: Rp.<input type=number name=ppn value='".rq_baca("cost","id='$id'","ppn")."'> PPH: Rp.<input type=number name=pph value='".rq_baca("cost","id='$id'","pph")."'><br>
Tgl Kwitansi<input type=date name=tgl value='".$tgl."'> No SPBY<input type=number name=no_spby value='".$nospby.rq_baca("cost","id='$id'","no_spby")."'>Tgl SPBY<input type=date name=tgl_spby value='".$tgl_spby."'><br>
Bidang: <select name='bidang'><option value='".rq_baca("cost","id='$id'","bidang")."'>".rq_baca("cost","id='$id'","bidang")."</option>
<option value='um'>um</option><option value='kt'>kt</option><option value='kh'>kh</option><option value='ws'>ws</option></select>
TTD: <select name='ttd'><option value='".rq_baca("cost","id='$id'","ttd")."'>".rq_baca("cost","id='$id'","ttd")."</option>
<option value='Yang Membayarkan : Bendahara Pengeluran'>Yang Membayarkan : Bendahara Pengeluran</option><option value=''>Lainnya:</option></select><input type=text name=ttd1 value=''>
<input type=submit value='Simpan'> <a target='_blank' href='print/kwt.php?id=".$id."'>Kwt</a> <a target='_blank' href='print/spby.php?id=".$id."'>Spby</a></div>"; }
echo "</form>";
}


function rq_print_all() {
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok order by mak,no";
$results = $db->get_results( $query );
echo "<table class='table' width=100%>
<tr><th>KODE</th><th>URAIAN</th><th>JUMLAH</th><th>REALISASI</th><th>SALDO</th><th>PERSENTASE</th></tr>";
//$jml=rq_jml("");$real=rq_relisasi("");
$w=$wt="style='font-weight:700'";

foreach( $results as $data )
{

$n++;

//rq_update("pok","no='".$data['no']."'","mak='".pok_kodenya($data['no'])."'");
if ($data['sat']=="") {$w="style='font-weight:400'";

$rl_usulan=rq_relisasi($data['mak'],"usulan");
$rl_sptb=rq_relisasi($data['mak'],"sptb");
$rl_spm=rq_relisasi($data['mak'],"spm");
$w="style='font-weight:700'"; $jml=pok_sum($data['no']);
$lnk="mak=".$data['mak'];
} else {$w="";
$jml=$data['jumlah'];
$rl_usulan=rq_jml_cost($data['no'],"usulan");
$rl_sptb=rq_jml_cost($data['no'],"sptb");
$rl_spm=rq_jml_cost($data['no'],"spm");
$w="";
$lnk="no=".$data['no'];
$jm+=$data['jumlah'];
$rl+=($rl_usulan+$rl_sptb+$rl_spm);
}

$real=$rl_usulan+$rl_sptb+$rl_spm;

if ($jml<=0) {$pre=0;} else {$pre=des(($real/$jml)*100);}


$print.= "<tr><td>".$data['kode']."</td><td>".$data['uraian']."</td><td align=right $w>".rp($jml)."</td><td align=right $w>".rp($real)."</td><td align=right $w>".rp($jml-$real)."</td><td align=right $w><a target='_blank' href='print/usulan.php?".$lnk."'>".des($pre)."</a></td></tr>";

}
echo "<tr><td $wt>".rq_baca("global","kolom='kode'","isi")."</td><td $wt>".rq_baca("global","kolom='nama_unit'","isi")."</td><td align=right $wt>".rp($jm)."</td><td align=right $wt>".rp($rl)."</td><td align=right $wt>".rp($jm-$rl)."</td><td align=right $wt>".des(($rl/$jm)*100)."</td></tr>";
echo $print;
echo "</tbody></table>";

}

function rq_usulan($id_sptb) {
$db = new database();
$db->connect(rq_db());
if ($id_sptb!="") {$tm="<input type=submit value='Tambahkan'>";$wh="AND id_sptb<=0";}
//if ($_GET['no']!="") {$wh2="and no='".$_GET['no']."'";}
$query = "SELECT * FROM cost WHERE id LIKE '%".$_POST['id_us']."%' and untuk LIKE '%".$_POST['untuk']."%' $wh order by id desc";
$results = $db->get_results( $query );
echo "<form method=post>
Cari Nomor:<input type=text name=id_us value='".$_POST['id_us']."'> Uraian: <input type=text name=untuk value='".$_POST['untuk']."'><input type=submit value='Cari'><input type=hidden name=tabel value='cost'></form>
<table class='table' width=100% id='example'>
<a href='?t=usulanExcel'>Export</a>
<thead>
<tr><th>URUT</th><th>NOMOR ID</th><th>&nbsp;</th><th>TGL USULAN</th><th>BIDANG</th><th>AKUN</th><th>URAIAN</th><th>KETERANGAN</th><th>KEPADA</th><th>NOMINAL</th><th>SPTB</th><th>SPM</th><th>DANA</th><th>INPUT BY</th><th>EDIT BY</th><th>EXE</th><th>KWT</th><th>SPBY</th><th></th></tr></thead><tbody>
";

foreach( $results as $data )
{

$n++;
if ($data['id_sptb']>0) {$edit="";} else {$edit="<a href='?t=POK%20All&do=Usulan&id=".$data['id']."'><img src='css/edit.png'></a>";}
//if (rq_baca("sptb","id_sptb='".$data['id_sptb']."'","cara")=="GU") {
//$spby="<a target='_blank' href='print/spby.php?id=".$data['id']."'>Spby</a>";
//} else {$spby="";}
$spby="<a target='_blank' href='print/spby.php?id=".$data['id']."'><img src='css/print.png'></a>";
echo "<tr><td align=center>".$n."</td><td align=center>".$data['id']."</td><td align=center>".$data['no']."</td><td width='85px' align='center'>".$data['tgl']."</td><td width='40px' align='center'>".$data['bidang']."</td><td>".rq_baca("pok","no='".$data['no']."'","mak")."</td><td>".rq_baca("pok","no='".$data['no']."'","uraian")."</td><td>".$data['untuk']."</td><td>".$data['kepada']."</td><td align=right><b>".rp($data['harga'])."</b></td><td>".rq_baca("sptb","id_sptb='".$data['id_sptb']."'","nomor")."".rq_baca("sptb","id_sptb='".$data['id_sptb']."'","cara")."</td><td>".$data['id_spm']."</td><td>".rq_baca("pok","no='".$data['no']."'","dana")."</td><td>".$data['input_oleh']."</td><td>".$data['update_oleh']."</td><td align=center>".$edit."</td><td align=center><a target='_blank' href='print/kwt.php?id=".$data['id']."'><img src='css/print.png'></a></td><td align=center>".$spby."</td><form method=post><input type=hidden name=id_cost value='".$data['id']."'><input type=hidden name=tabel value='cost'><input type=hidden name=id value='".$_POST['id']."'><input type=hidden name=untuk value='".$_POST['untuk']."'><td>$tm</td></form></tr>";

}
echo "</tbody></table>";
}

function rq_usulanExcel($id_sptb) {
$db = new database();
$db->connect(rq_db());
if ($id_sptb!="") {$tm="<input type=submit value='Tambahkan'>";$wh="AND id_sptb<=0";}
//if ($_GET['no']!="") {$wh2="and no='".$_GET['no']."'";}
$query = "SELECT * FROM cost WHERE id LIKE '%".$_POST['id_us']."%' and untuk LIKE '%".$_POST['untuk']."%' $wh order by id desc";
$results = $db->get_results( $query );
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Periodik.xlm");
header("Pragma: no-cache");
header("Expires: 0");
echo "
<thead>
<tr><th>NOMOR</th><th>TGL USULAN</th><th>AKUN</th><th>URAIAN</th><th>KETERANGAN</th><th>KEPADA</th><th>NOMINAL</th><th>SPTB</th><th>SPM</th><th>DANA</th><th>INPUT BY</th><th>EDIT BY</th><th>EXE</th><th>KWT</th><th>SPBY</th><th></th><th></th></tr></thead><tbody>
";

foreach( $results as $data )
{

$n++;
if ($data['id_sptb']>0) {$edit="";} else {$edit="<a href='?t=POK%20All&do=Usulan&id=".$data['id']."'><img src='css/edit.png'></a>";}
//if (rq_baca("sptb","id_sptb='".$data['id_sptb']."'","cara")=="GU") {
//$spby="<a target='_blank' href='print/spby.php?id=".$data['id']."'>Spby</a>";
//} else {$spby="";}
$spby="<a target='_blank' href='print/spby.php?id=".$data['id']."'><img src='css/print.png'></a>";
echo "<tr><td align=center>".$data['id']."</td><td width='85px' align='center'>".$data['tgl']."</td><td>".rq_baca("pok","no='".$data['no']."'","mak")."</td><td>".rq_baca("pok","no='".$data['no']."'","uraian")."</td><td>".$data['untuk']."</td><td>".$data['kepada']."</td><td align=right><b>".rp($data['harga'])."</b></td><td>".rq_baca("sptb","id_sptb='".$data['id_sptb']."'","nomor")."".rq_baca("sptb","id_sptb='".$data['id_sptb']."'","cara")."</td><td>".$data['id_spm']."</td><td>".rq_baca("pok","no='".$data['no']."'","dana")."</td><td>".$data['input_oleh']."</td><td>".$data['update_oleh']."</td><td align=center>".$edit."</td><td align=center><a target='_blank' href='print/kwt.php?id=".$data['id']."'><img src='css/print.png'></a></td><td align=center>".$spby."</td><form method=post><input type=hidden name=id_cost value='".$data['id']."'><input type=hidden name=tabel value='cost'><input type=hidden name=id value='".$_POST['id']."'><input type=hidden name=untuk value='".$_POST['untuk']."'><td>$tm</td></form></tr>";

}
echo "</tbody></table>";
}

function rq_sptb_usulan($id_sptb) {
$db = new database();
$db->connect(rq_db());
if ($_POST['submit']=="X") {
rq_update("cost","id='".$_POST['id']."'","id_sptb='0'");
}
$query = "SELECT * FROM cost WHERE id_sptb='".$id_sptb."' order by id desc";
$results = $db->get_results( $query );
foreach( $results as $data )
{

$n++;
if ($data['id_spm']>0) {$edit="";} else {$edit="<input name=submit type=submit value='X'>";}
if (rq_baca("sptb","id_sptb='".$data['id_sptb']."'","cara")=="GU") {
$spby="<a target='_blank' href='print/spby.php?id=".$data['id']."'>Spby</a>";
} else {$spby="";}
echo "<tr>
<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>$n</td>
<td align=center>".$data['id']."</td><td>".$data['tgl']."</td><td>".rq_baca("pok","no='".$data['no']."'","mak")."</td><td>".rq_baca("pok","no='".$data['no']."'","uraian")."</td><td>".$data['untuk']."</td><td align=right>".rp($data['harga'])."</td><td>".$data['oleh']."</td><form method=post><input type=hidden name=id value='".$data['id']."'><td>".$edit."</td></form><td align=center><a target='_blank' href='print/kwt.php?id=".$data['id']."'><img src='css/print.png'></a></td><td align=center>".$spby."</td></tr>";

}

}

function rq_sptb() {
$do=$_GET['do'];

$id=$_GET['id'];
if ($_POST['tabel']=="sptb") {
if ($id>0) {
rq_update("sptb","id_sptb='$id'","nomor='".$_POST['nomor']."',tgl='".$_POST['tgl']."', tgl_update='".now()."', cara='".$_POST['cara']."', oleh='".user_id()."'");
 } else {
rq_insert("sptb","'', '".$_POST['nomor']."', '".$_POST['tgl']."', '".$_POST['cara']."', '".now()."', '".user_id()."', '0'");

}
}

if ($_POST['id_cost']!="") {

rq_update("cost","id='".$_POST['id_cost']."'","id_sptb='".$id."'");
}
if ($do!="") {
if ($do=="New") { $cara=$_GET['cara']; $nomor=rq_baca("sptb","id_sptb!='' and cara='$cara' order by nomor desc","nomor")+1; $tgl=today();}
else {$nomor=rq_baca("sptb","id_sptb='".$id."'","nomor"); $tgl=rq_baca("sptb","id_sptb='".$id."'","tgl");$cara=rq_baca("sptb","id_sptb='".$id."'","cara");$wh="WHERE id_sptb='$id'";}

echo "<form method=post>Cara : <input type=text name=cara value='".$cara."'><input type=hidden name=id value='".$_GET['id']."'>
Nomor:<input type=number name=nomor value='".$nomor."'> Tgl: <input type=date name=tgl value='".$tgl."'> <input type=submit value='$do'><input type=hidden name=tabel value='sptb'></form>
";
}
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM sptb $wh order by id_sptb desc";
$results = $db->get_results( $query );
echo "<table class='table' width=100%><thead>
<tr><th></th><th>TGL SPTB</th><th>NO SPTB</th><th>CARA</th><th>BY</th><th>EXE</th><th>SPTB</th><th></th><th>NO USUL</th><th>TGL USUL</th><th>AKUN</th><th>URAIAN</th><th>KETERANGAN</th><th>NOMINAL</th><th>BY</th><th>EXE</th><th>KWT</th><th></th></tr></thead><tbody>
";
foreach( $results as $data )
{
if ($data['id_spm']>0) {$edit="";} else {$edit="<a href='?t=SPTB&do=Edit&id=".$data['id_sptb']."'>Edit</a>";}
$n++;
echo "<tr><td>".$n."</td><td>".$data['tgl']."</td><td align=center>".$data['nomor']."</td><td>".$data['cara']."</td><td>".$data['oleh']."</td><td align=center>".$edit."</td><td align=center><a target='_blank' href='print/sptb.php?id_sptb=".$data['id_sptb']."&p=1'><img src='css/print2.png'></a></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>".$data['oleh']."</td><td></td><td></td></tr>";
rq_sptb_usulan($data['id_sptb']);
}
echo "</tbody></table>";
if ($id>0) {
echo "<br><b>Tambah Usulan ke SPTB:</b><br>";
rq_usulan($id);
 }
}


function rq_spm() {
$do=$_GET['do'];

$id=$_GET['id'];
if ($_POST['tabel']=="spm") {
if ($id>0) {
rq_update("spm","id_spm='$id'","nomor='".$_POST['nomor']."',tgl='".$_POST['tgl']."', tgl_update='".now()."', oleh='".user_id()."', nomor_sp2d='".$_POST['nomor_sp2d']."',tgl_sp2d='".$_POST['tgl_sp2d']."'");
 } else {
rq_insert("spm","'', '".$_POST['nomor']."', '".$_POST['tgl']."', '".now()."', '".user_id()."','".$_POST['nomor_sp2d']."', '".$_POST['tgl_sp2d']."'");

}
}

if ($_POST['id_sptb']!="") {

rq_update("sptb","id_sptb='".$_POST['id_sptb']."'","id_spm='".$id."'");
}
if ($do!="") {
if ($do=="New") {$nomor=""; $tgl=today();}
else {$nomor=rq_baca("spm","id_spm='".$id."'","nomor"); $tgl=rq_baca("spm","id_spm='".$id."'","tgl");$wh="WHERE id_spm='$id'";
$nomor_sp2d=rq_baca("spm","id_spm='".$id."'","nomor_sp2d"); $tgl_sp2d=rq_baca("spm","id_spm='".$id."'","tgl_sp2d");$wh="WHERE id_spm='$id'";
}

echo "<form method=post><input type=hidden name=id value='".$_GET['id']."'>
Nomor SPM:<input type=text name=nomor value='".$nomor."'> Tgl SPM: <input type=date name=tgl value='".$tgl."'> Nomor SP2D:<input type=text name=nomor_sp2d value='".$nomor_sp2d."'> Tgl SPM: <input type=date name=tgl_sp2d value='".$tgl_sp2d."'><input type=submit value='$do'><input type=hidden name=tabel value='spm'></form>
";
}
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM spm $wh order by id_spm desc";
$results = $db->get_results( $query );
echo "<table class='table'><thead>
<tr><th></th><th>TGL SPM</th><th>NO SPM</th><th>TGL SP2D</th><th>NO SP2D</th><th>EXE</th><th></th><th>TGL SPTB</th><th>NO SPTB</th><th>CARA</th><th>NOMINAL</th><th>BY</th><th>EXE</th><th>PRINT</th></tr></thead><tbody>
";
foreach( $results as $data )
{

$n++;
echo "<tr><td>".$n."</td><td>".$data['tgl']."</td><td align=center>".$data['nomor']."</td><td>".$data['tgl_sp2d']."</td><td align=center>".$data['nomor_sp2d']."</td><td align=center><a href='?t=SPM&do=Edit&id=".$data['id_spm']."'>Edit</a></td><td></td><td></td><td></td><td></td><td></td><td>".$data['oleh']."</td><td></td><td></td></tr>";
rq_spm_sptb($data['id_spm']);
}
echo "</tbody></table>";
if ($id>0) {
echo "<br><b>Tambah SPTB ke SPM:</b><br>";
rq_spm_sptb_tambah($id);
 }
}


function rq_spm_sptb($id_spm) {
$db = new database();
$db->connect(rq_db());
if ($_POST['submit']=="x") {
rq_update("sptb","id_sptb='".$_POST['id_sptb']."'","id_spm='0'");
rq_update("cost","id_sptb='".$_POST['id_sptb']."'","id_spm='0'");
}
if ($_POST['submit']=="+") {
rq_update("sptb","id_sptb='".$_POST['id_sptb']."'","id_spm='".$id_spm."'");
rq_update("cost","id_sptb='".$_POST['id_sptb']."'","id_spm='".$id_spm."'");
}
$query = "SELECT * FROM sptb WHERE id_spm='".$id_spm."' order by tgl";
$results = $db->get_results( $query );
foreach( $results as $data )
{

$n++;
$rp=rq_jml_sptb($data['id_sptb']);
echo "<tr>
<td></td><td></td><td></td><td></td><td></td><td></td><td>$n</td>
<td>".$data['tgl']."</td><td>".$data['nomor']."</td><td>".$data['cara']."</td><td align=right>".rp($rp)."</td><td>".$data['oleh']."</td><form method=post><input type=hidden name=id_sptb value='".$data['id_sptb']."'><td><input name=submit type=submit value='x'></td></form><td align=center><a target='_blank' href='print/sptb.php?id_sptb=".$data['id_sptb']."&p=1'>SPTB</a></td></tr></tr>";

}
}

function rq_spm_sptb_tambah($id_spm) {
$db = new database();
$db->connect(rq_db());
if ($_POST['tabel']=="sptb" ) {$wh="AND nomor LIKE '%".$_POST['nomor']."%'";}
$query = "SELECT * FROM sptb WHERE id_spm<=0 $wh order by id_sptb desc";
$results = $db->get_results( $query );
echo "
<form method=post>
Cari Nomor SPTB:<input type=text name=nomor value='".$_POST['nomor']."'><input type=submit value='Cari'><input type=hidden name=tabel value='sptb'></form>
<table class='table'>
<thead><tr><th></th><th>TGL SPTB</th><th>NO SPTB</th><th>CARA</th><th>NOMINAL</th><th>BY</th><th>EXE</th><th>PRINT</th></tr></thead><tbody>";
foreach( $results as $data )
{

$n++;
$rp=rq_jml_sptb($data['id_sptb']);
echo "<tr><td>".$n."</td>
<td>".$data['tgl']."</td><td>".$data['nomor']."</td><td>".$data['cara']."</td><td align=right>".rp($rp)."</td><td>".$data['oleh']."</td><form method=post><input type=hidden name=id_sptb value='".$data['id_sptb']."'><td><input name=submit type=submit value='+'></td></form><td align=center><a target='_blank' href='print/sptb.php?id_sptb=".$data['id_sptb']."&p=1'>SPTB</a></td></tr></tr>";

}
echo "</tbody></table>";
}

function rq_jml_sptb($id_sptb) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT harga FROM cost WHERE id_sptb='".$id_sptb."'";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$jml+=$data['harga'];
}
return $jml;
}


function rq_setting() {
$db = new database();
$db->connect(rq_db());

if ($_POST){
foreach($_POST as $key => $value){
rq_update("global","kolom='".$key."'","isi='".$value."'");
}
}

$query = "SELECT * FROM global";
$results = $db->get_results( $query );
echo "<table class='table' width=100%><form method=post>";
foreach( $results as $data )
{

$n++;

echo "<tr>
<td width=10%>".$data['kolom']."</td><td width=1%>:</td><td><input type=text style='width:100%;' name='".$data['kolom']."' value='".$data['isi']."'></td></tr>";

}
echo "<tr><td colspan=3 align=center><input type=submit value=Simpan></td></tr>
</form></tbody></table>";
}
