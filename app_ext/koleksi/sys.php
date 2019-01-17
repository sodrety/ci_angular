<?php
error_reporting(1);
require_once( 'class/class.php' );
if (user_id()=='') { 
//echo "Access denied <a href='../../prioqnet'>";
//exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Koleksi Media Pembawa, OPTK, & HPHK</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="js/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<style>
<?php include "css/css2.css"; ?>
</style>
  <script src="js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
<script type="text/javascript" src="js/DataTables/datatables.min.js"></script>

    <link href="js/select2/css/select2.css" rel="stylesheet"/>
    <script src="js/select2/js/select2.js"></script>
    
<script type="text/javascript">
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

$(document).ready(function() {  $('#dt1').DataTable({
        "lengthMenu": [[-1, 20, 10, 50, 100, 200, -1], ["All", 20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#dt2').DataTable({
        "lengthMenu": [[20, 10, 50, 100, 200, -1], [20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#dt3').DataTable({
        "lengthMenu": [[20, 10, 50, 100, 200, -1], [20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#dt4').DataTable({
        "lengthMenu": [[20, 10, 50, 100, 200, -1], [20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#dt5').DataTable({
        "lengthMenu": [[20, 10, 50, 100, 200, -1], [20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#dt6').DataTable({
        "lengthMenu": [[20, 10, 50, 100, 200, -1], [20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#dt7').DataTable({
        "lengthMenu": [[20, 10, 50, 100, 200, -1], [20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#dt8').DataTable({
        "lengthMenu": [[20, 10, 50, 100, 200, -1], [20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#dt9').DataTable({
        "lengthMenu": [[20, 10, 50, 100, 200, -1], [20, 10, 50, 100, 200, "All"]]
    } );} );
$(document).ready(function() {  $('#dta').DataTable({
        "lengthMenu": [[-1, 20, 10, 50, 100, 200, -1], ["All", 20, 10, 50, 100, 200, "All"]]
    } );} );
    
$(document).ready(function() { $("#sct1").select2(); });
        $(document).ready(function() { $("#sl2").select2(); });
        $(document).ready(function() { $("#sl3").select2(); });
        $(document).ready(function() { $("#sl4").select2(); });
        $(document).ready(function() { $("#sl5").select2(); });
        $(document).ready(function() { $("#sl6").select2(); });
        $(document).ready(function() { $("#sl7").select2(); });
        $(document).ready(function() { $("#sl8").select2(); });
        $(document).ready(function() { $("#sl9").select2(); });
        $(document).ready(function() { $("#sl10").select2(); });
        $(document).ready(function() { $("#sl11").select2(); });
        $(document).ready(function() { $("#sl12").select2(); });
        $(document).ready(function() { $("#sl13").select2(); });
        $(document).ready(function() { $("#sl14").select2(); });
        $(document).ready(function() { $("#sl15").select2(); });
        $(document).ready(function() { $("#sl16").select2(); });
        $(document).ready(function() { $("#sl17").select2(); });
        $(document).ready(function() { $("#sl18").select2(); });
        $(document).ready(function() { $("#sl19").select2(); });
        $(document).ready(function() { $("#sl20").select2(); });
</script>
</head>
<body>
<div class=header>
<div class='h2'>Koleksi Media Pembawa & <?php echo $n ?></div>
</div>
<div class="topnav" id="myTopnav">
  <a href="?" class="active">Home</a>
  <?php echo "<a href='?func=form&tab=new&b=".$b."'>Tambah</a><a style='float:right;' href='../../'>X</a><a href='?t=Profile' style='float:right;'>BBKP Tanjung Priok (".user_id().")</a>"; 
  ?>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()"> <img src='css/menu.png' style='height:18px;'> </a>
</div>
<div class=content>
<?php
if ($_GET['func']=="form") {form();} else {arsip($b);}
?>
</tbody>
</table>
</div>



</body>
</html>
