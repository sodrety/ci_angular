<?php
session_start();
require_once( 'class/class.php' );
if (user_id()=='') { 
echo "Access denied <a href='../../prioqnet'>";
exit;
}
?>

<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Dropbox</title>
<link href="js/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<style>
<?php include "css/css.css"; ?>
<?php include "css/simple-sidebar.css"; ?>
<?php include "css/treev.css"; ?>
</style>
    
  <script src="js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
<script type="text/javascript" src="js/DataTables/datatables.min.js"></script>

    <link href="js/select2/css/select2.css" rel="stylesheet"/>
    <script src="js/select2/js/select2.js"></script>
<script>
$(document).ready(function() {  $('#dt1').DataTable({
        "lengthMenu": [[-1, 20, 10, 50, 100, 200, -1], ["All", 20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#dt2').DataTable({
        "lengthMenu": [[-1, 20, 10, 50, 100, 200, -1], ["All", 20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#dt3').DataTable({
        "lengthMenu": [[-1, 20, 10, 50, 100, 200, -1], ["All", 20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#dt4').DataTable({
        "lengthMenu": [[-1, 20, 10, 50, 100, 200, -1], ["All", 20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#dt5').DataTable({
        "lengthMenu": [[-1, 20, 10, 50, 100, 200, -1], ["All", 20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#dt6').DataTable({
        "lengthMenu": [[-1, 20, 10, 50, 100, 200, -1], ["All", 20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#dt7').DataTable({
        "lengthMenu": [[-1, 20, 10, 50, 100, 200, -1], ["All", 20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#dt8').DataTable({
        "lengthMenu": [[-1, 20, 10, 50, 100, 200, -1], ["All", 20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#dt9').DataTable({
        "lengthMenu": [[-1, 20, 10, 50, 100, 200, -1], ["All", 20, 10, 50, 100, 200, "All"]]
    } );} );
</script>
    <script>
        $(document).ready(function() { $("#select1").select2(); });
        $(document).ready(function() { $("#select2").select2(); });
        $(document).ready(function() { $("#select3").select2(); });
        $(document).ready(function() { $("#select4").select2(); });
        $(document).ready(function() { $("#select5").select2(); });
        $(document).ready(function() { $("#select6").select2(); });
        $(document).ready(function() { $("#select7").select2(); });
        $(document).ready(function() { $("#select8").select2(); });
        $(document).ready(function() { $("#select9").select2(); });
        $(document).ready(function() { $("#select10").select2(); });
        $(document).ready(function() { $("#select11").select2(); });
        $(document).ready(function() { $("#select12").select2(); });
        $(document).ready(function() { $("#select13").select2(); });
        $(document).ready(function() { $("#select14").select2(); });
        $(document).ready(function() { $("#select15").select2(); });
        $(document).ready(function() { $("#select16").select2(); });
        $(document).ready(function() { $("#select17").select2(); });
        $(document).ready(function() { $("#select18").select2(); });
        $(document).ready(function() { $("#select19").select2(); });
        $(document).ready(function() { $("#select20").select2(); });
$(document).ready(function() { $("#sct1").select2(); });
        $(document).ready(function() { $("#sct2").select2(); });
        $(document).ready(function() { $("#sct3").select2(); });
        $(document).ready(function() { $("#sct4").select2(); });
        $(document).ready(function() { $("#sct5").select2(); });
        $(document).ready(function() { $("#sct6").select2(); });
        $(document).ready(function() { $("#sct7").select2(); });
        $(document).ready(function() { $("#sct8").select2(); });
        $(document).ready(function() { $("#sct9").select2(); });
        $(document).ready(function() { $("#sct10").select2(); });
        $(document).ready(function() { $("#sct11").select2(); });
        $(document).ready(function() { $("#sct12").select2(); });
        $(document).ready(function() { $("#sct13").select2(); });
        $(document).ready(function() { $("#sct14").select2(); });
        $(document).ready(function() { $("#sct15").select2(); });
        $(document).ready(function() { $("#sct16").select2(); });
        $(document).ready(function() { $("#sct17").select2(); });
        $(document).ready(function() { $("#sct18").select2(); });
        $(document).ready(function() { $("#sct19").select2(); });
        $(document).ready(function() { $("#sct20").select2(); });
$(document).ready(function() { $("#slct1").select2(); });
        $(document).ready(function() { $("#slct2").select2(); });
        $(document).ready(function() { $("#slct3").select2(); });
        $(document).ready(function() { $("#slct4").select2(); });
        $(document).ready(function() { $("#slct5").select2(); });
        $(document).ready(function() { $("#slct6").select2(); });
        $(document).ready(function() { $("#slct7").select2(); });
        $(document).ready(function() { $("#slct8").select2(); });
        $(document).ready(function() { $("#slct9").select2(); });
        $(document).ready(function() { $("#slct10").select2(); });
        $(document).ready(function() { $("#slct11").select2(); });
        $(document).ready(function() { $("#slct12").select2(); });
        $(document).ready(function() { $("#slct13").select2(); });
        $(document).ready(function() { $("#slct14").select2(); });
        $(document).ready(function() { $("#slct15").select2(); });
        $(document).ready(function() { $("#slct16").select2(); });
        $(document).ready(function() { $("#slct17").select2(); });
        $(document).ready(function() { $("#slct18").select2(); });
        $(document).ready(function() { $("#slct19").select2(); });
        $(document).ready(function() { $("#slct20").select2(); });
$(document).ready(function() { $("#sle1").select2(); });
        $(document).ready(function() { $("#sle2").select2(); });
        $(document).ready(function() { $("#sle3").select2(); });
        $(document).ready(function() { $("#sle4").select2(); });
        $(document).ready(function() { $("#sle5").select2(); });
        $(document).ready(function() { $("#sle6").select2(); });
        $(document).ready(function() { $("#sle7").select2(); });
        $(document).ready(function() { $("#sle8").select2(); });
        $(document).ready(function() { $("#sle9").select2(); });
        $(document).ready(function() { $("#sle10").select2(); });
        $(document).ready(function() { $("#sle11").select2(); });
        $(document).ready(function() { $("#sle12").select2(); });
        $(document).ready(function() { $("#sle13").select2(); });
        $(document).ready(function() { $("#sle14").select2(); });
        $(document).ready(function() { $("#sle15").select2(); });
        $(document).ready(function() { $("#sle16").select2(); });
        $(document).ready(function() { $("#sle17").select2(); });
        $(document).ready(function() { $("#sle18").select2(); });
        $(document).ready(function() { $("#sle19").select2(); });
        $(document).ready(function() { $("#sle20").select2(); });submit
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
if ($t=="") { $t="Welcome";}
$dropbox=new dropbox();
?> 
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-nav">
            
            
<?php echo $dropbox->menu();	 ?>

        
		</div></div>
        <!-- /#sidebar-wrapper -->
        <div id="page-content-wrapper">
<div class=content>
<?php
echo "<div class=h2>".$dropbox->title()." $t</div>
<iframe style='width:0;height:0;border:0;' name=iframe></iframe>
";
$dropbox->content($t);
?>
</div>
        </div>

    </div>


<div class=header>
<div class='h2'>
<table width='100%'><tr><td width='30px'><img src='css/barantan.png' style="width:30px;"></td><td><h2><?php echo "<b>Sistem Antrian Dropbox Barcode</b>"; ?></h2></td><td class='org'>Balai Besar Karantina Pertanian Tanjung Priok</td></tr></table>
</div>
<div class=menu>
<a id="menu-toggle"><img src='css/menu.png' style="width:20px;height:12px;"></a> &nbsp; <?php echo $menu." ".tgl_p(today()); ?>
<span class='akun'><i><?php echo db_baca("user_login","karyawan","id='".user_id()."'","nama");?></i></span>
</div>
</div>

   
    <script src="js/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
    <script>
var toggler = document.getElementsByClassName("box");
var i;

for (i = 0; i < toggler.length; i++) {
  toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nested").classList.toggle("active");
    this.classList.toggle("check-box");
  });
}
</script>
</body>
</html>
