<?php
session_start();
require_once( 'class/class.php' );
require_once( 'class/func_app1_admin.php');
if (user_id()=="") {header("location:index.php");}
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
        "lengthMenu": [[-1, 10, 50, 100, 200, -1], ["All", 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#example1').DataTable({
        "lengthMenu": [[-1, 10, 50, 100, 200, -1], ["All", 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#example2').DataTable({
        "lengthMenu": [[-1, 10, 50, 100, 200, -1], ["All", 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#example3').DataTable({
        "lengthMenu": [[-1, 10, 50, 100, 200, -1], ["All", 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#example4').DataTable({
        "lengthMenu": [[-1, 10, 50, 100, 200, -1], ["All", 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#example9').DataTable({
        "lengthMenu": [[-1, 20, 50, 100, 200, -1], ["All", 20, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#example10').DataTable({
        "lengthMenu": [[-1, 20, 50, 100, 200, -1], ["All", 20, 50, 100, 200, "All"]]
    } );} );
</script>
    <script>
        $(document).ready(function() { $("#select1").select2(); });
        $(document).ready(function() { $("#select2").select2(); });
        $(document).ready(function() { $("#select3").select2(); });
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
elseif ($t=="Distribusi") { distribusi0(); } 
elseif ($t=="Distribusi2") { distribusi(); } 
elseif ($t=="SLA-Fisik") { sla_fisik(); } 
?>
</div>
<div id="myNav" class="overlay">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><img src='css/close.png'></a>
  <div class="overlay-content">
<p>SLA
<a href='?t=SLA-Dokumen'>SLA-Dokumen</a><a href='?t=SLA-Fisik'>SLA-Fisik</a>
</p>
<p>
<a href='?t=POPT'>POPT</a> <a href='?t=Lokasi'>Lokasi</a><a href='?t=Penempatan'>Penempatan</a><!--<a href='?t=Realisasi'>Realisasi</a><a href='?t=Jadwal'>Jadwal</a><a href='?t=Alokasi'>Alokasi</a>--><a href='?t=Distribusi'>Distribusi</a>
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
<table><tr><td><img src='css/menu.png' onclick="openNav()"  style="font-size:30px;cursor:pointer"></td><td><h2>APLIKASI SLA & SCHEDULE PENUGASAN POPT</h2></td></tr></table>
</div>
<div class=menu>
&nbsp;<a href='?t=SLA-Dokumen'>SLA-Dokumen</a><a href='?t=SLA-Fisik'>SLA-Fisik</a>
<?php
//if (db_baca("user_login","akses","user_id='".user_id()."' and aplikasi='ANGGARAN'","hak_akses")=="TULIS") { ?>
| <a href='?t=POPT'>POPT</a> <a href='?t=Lokasi'>Lokasi</a><a href='?t=Penempatan'>Penempatan</a> <a href='?t=Realisasi'>Realisasi</a><a href='?t=Jadwal'>Jadwal</a><a href='?t=Alokasi'>Alokasi</a><a href='?t=Distribusi'>Distribusi</a> <?php //} ?>
<span style='float:right;'><i>Balai Besar Karantina Pertanian Tanjung Priok</i></span>
</div>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header"> <h3 class="modal-title">Documents Editor</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
               
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
      
    </div>
</div>
<script>
$(document).ready(function(){
    $('.openPopup').on('click',function(){
        var dataURL = $(this).attr('data-href');
        $('.modal-body').load(dataURL,function(){
            $('#myModal').modal({show:true});
        });
    }); 
});

$('.openBtn').on('click',function(){
    $('.modal-body').load('getContent.php?id=2',function(){
        $('#myModal').modal({show:true});
    });
});
</script>
   
    <script src="js/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
</body>
<iframe style='width:0;height:0;border:0;' name=iframe></iframe>
</html>
