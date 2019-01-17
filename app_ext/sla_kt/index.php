<?php
session_start();
require_once( 'class/class.php' );
require_once( 'class/func_app1.php');
if (user_id()=="") {header("location:../../../prioqnet/");}
$popt_id=app_baca("popt","id='".user_id()."'","id");
if ($popt_id=="") {exit;}
?>
<html>
<head>
<title>Aplikasi SLA & POPT</title>
<link href="js/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<style>
<?php include "css/css.css"; ?>
.modal-content {width:600px;}
</style>
  <script src="js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
<script type="text/javascript" src="js/DataTables/datatables.min.js"></script>

    <link href="js/select2/css/select2.css" rel="stylesheet"/>
    <script src="js/select2/js/select2.js"></script>
<script>
$(document).ready(function() {  $('#example').DataTable({
        "lengthMenu": [[-1, 20, 10, 50, 100, 200, -1], ["All", 20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#example1').DataTable({
        "lengthMenu": [[-1, 20, 10, 50, 100, 200, -1], ["All", 20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#example2').DataTable({
        "lengthMenu": [[-1, 20, 10, 50, 100, 200, -1], ["All", 20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#example3').DataTable({
        "lengthMenu": [[-1, 20, 10, 50, 100, 200, -1], ["All", 20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#example4').DataTable({
        "lengthMenu": [[-1, 20, 10, 50, 100, 200, -1], ["All", 20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#example10').DataTable({
        "lengthMenu": [[-1, 10, 20, 50, 100, 200, -1], ["All", 10, 20, 50, 100, 200, "All"]]
    } );} );
</script>
    <script>
        $(document).ready(function() { $("#select1").select2(); });
        $(document).ready(function() { $("#select2").select2(); });
        $(document).ready(function() { $("#select3").select2(); });
        $(document).ready(function() { $("#select4").select2(); });
    </script>
<script>
function createRequest(){ 
        var oAJAX = false;

        try {
          oAJAX = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
          try {
             oAJAX = new ActiveXObject("Microsoft.XMLHTTP");
          } catch (e2) {
             oAJAX = false;
          }
        }

        
        if (!oAJAX && typeof XMLHttpRequest != 'undefined') {
            oAJAX = new XMLHttpRequest();
        }

        if (!oAJAX){
           alert("Error saat membuat XMLHttpRequest!");
        }        
        return oAJAX;
}

function requestContent(link,area){
  oRequest = createRequest();
  var url = link;
var areanya = area;
  // Buka komunikasi dengan server
  oRequest.open("GET", url, true);

  // menunggu respon dari server
  oRequest.onreadystatechange = function () {                                                                                                                     
      document.getElementById(areanya).innerHTML=
      "";                                                           

      if (oRequest.readyState == 4) {
		  // baca data respon dari server                                                                        	  
		  var response = oRequest.responseText;
		  document.getElementById(areanya).innerHTML = response;                                                             
      }
  }

  // Send the request
  oRequest.send(null);
}

function requestContent2(link,area,sou){
  oRequest = createRequest();
  var url = link;
var areanya = area;
var sounya = sou;
var x = document.getElementById(sounya).value;
  // Buka komunikasi dengan server
  oRequest.open("GET", url+x, true);

  // menunggu respon dari server
  oRequest.onreadystatechange = function () {                                                                                                                     
      document.getElementById(areanya).innerHTML=
      "";                                                           

      if (oRequest.readyState == 4) {
		  // baca data respon dari server                                                                        	  
		  var response = oRequest.responseText;
		  document.getElementById(areanya).innerHTML = response;                                                             
      }
  }

  // Send the request
  oRequest.send(null);
}

</script>

    <script src="js/Chart.bundle.js"></script>
</head>
<body>
<?php
$t=$_GET['t'];
?> 

<div class=content>

<?php
echo "<div class=h2>$t</div>";
if ($t=="POPT") { popt(); } 
elseif ($t=="Lokasi") { lokasi(); } 
elseif ($t=="Penempatan") { penempatan(); } 
elseif ($t=="Realisasi") { realisasi2(); } 
elseif ($t=="Jadwal") { jadwal(); } 
elseif ($t=="Alokasi") { alokasi(); } 
elseif ($t=="Distribusi") { distribusi(); } 
elseif ($t=="SLA-Fisik") { sla_fisik(); } 
elseif ($t=="SLA-Dokumen") { sla_doc(); }
elseif ($t=="DokumenHarian") { sla_doc_harian(); }
else {jadwal();}
?>
</div>
<div id="myNav" class="overlay">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><img src='css/close.png'></a>
  <div class="overlay-content">
<p>SLA
<a href='?t=SLA-Dokumen'>SLA-Dokumen</a><a href='?t=DokumenHarian'>SLA-DokHarian</a><a href='?t=SLA-Fisik'>SLA-Fisik</a>
</p>
<p>PENEMPATAN & PENUGASAN
<a href='?t=POPT'>POPT</a> <a href='?t=Lokasi'>Lokasi</a> <a href='?t=Penempatan'>Penempatan</a> <a href='?t=Realisasi'>Realisasi</a><a href='?t=Jadwal'>Jadwal</a><a href='?t=Distribusi'>Distribusi</a> 
</p>
</div>
</div>
<script>
function openNav() {
    document.getElementById("myNav").style.width = "180px";
}

function closeNav() {
    document.getElementById("myNav").style.width = "0%";
}
</script>
<div class=header>
<div class='h2'>
<table><tr><td><img src='css/menu.png' onclick="openNav()"  style="font-size:30px;cursor:pointer"></td><td><h2>PENEMPATAN & PENUGASAN & SLA KT </h2></td></tr></table>
</div>
<div class=menu>
&nbsp;
<?php
if (app_baca("admin","id='".user_id()."'","id")>"0") { echo "<a href='sla.php?t=POPT'>Admin</a> | "; } ?>
<a href='?'>Home</a><a href='?t=SLA-Dokumen'>SLA-Dokumen</a><a href='?t=SLA-Fisik'>SLA-Fisik</a> <a href='?t=POPT'>POPT</a> <a href='?t=Lokasi'>Lokasi</a> <a href='?t=Penempatan'>Penempatan</a> <a href='?t=Realisasi'>Realisasi</a><a href='?t=Jadwal'>Jadwal</a><a href='?t=Distribusi'>Distribusi</a> 
<span style='float:right;'><i>Balai Besar Karantina Pertanian Tanjung Priok</i></span>
</div>
</div>
<iframe style='width:0;height:0;border:0;' name=iframe></iframe>
</body>
</html>
