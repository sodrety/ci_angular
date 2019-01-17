<html>
<head>
<title>Realisasi Anggaran</title>
<style>
<?php include "css/css.css"; ?>

</style>
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
</script>

    <script src="js/Chart.bundle.js"></script>
</head>
<body>
<?php
$t=$_GET['t'];
?> 
<div class=header>
<div class='h2'>
<table><tr><td><img src='css/menu.png' onclick="openNav()"  style="font-size:30px;cursor:pointer"></td><td><h2>REALISASI ANGGARAN</h2></td></tr></table>
</div>
<div class=menu>
&nbsp;&nbsp;<a><?php echo strtoupper($t); ?></a><span style='float:right;'><i><?php echo rq_baca("global","kolom='nama_unit'","isi"); ?></i></span>
</div>
</div>
<div class=content>
<?php
if ($t=="Usulan") {rq_usulan(""); }elseif ($t=="SPTB") {rq_sptb(); }elseif ($t=="SPM") {rq_spm(); } elseif ($t=="POK") {rq_pok(); } elseif ($t=="POK All") {rq_pok_all(); } elseif ($t=="Print") {rq_print_all(); } elseif ($t=="Setting") {rq_setting(); }elseif ($t=="Periodik") {rq_pok_tree(); } else {rq_monitor(); }
?>
</div>
<div id="myNav" class="overlay">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><img src='css/close.png'></a>
  <div class="overlay-content">
<p>
Anggaran:
<a href='?t=Monitoring'> Monitoring</a>
<a href='?t=Print'> Print</a>
<a href='?t=Periodik'> Periodik (SP2D)</a>
</p><p>
Usulan:
<a href='?t=Usulan'> List</a>
<a href='?t=POK All&do=Usulan'> Tambah</a>
</p><p>
SPTB:
<a href='?t=SPTB'> List SPTB</a> 
<a href='?t=SPTB&do=New&cara=LS'> Tambah LS</a>
<a href='?t=SPTB&do=New&cara=GU'> Tambah GU</a>
</p><p>
SPM: 
<a href='?t=SPM'> List SPM</a>
<a href='?t=SPM&do=New'> Tambah</a>
</p><p>
RKAKL:
<a href='?t=POK'> POK</a><a href='?t=POK All'> POK All</a>
</p><p>
System:
<a href='?t=Setting'> Setting</a>
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
</body>
</html>
