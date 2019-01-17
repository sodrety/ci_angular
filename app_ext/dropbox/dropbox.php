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
<?php
include "css/css.css"; 
?>
</style>
<link href="css/css-.css" rel="stylesheet">
<link href="css/simple-sidebar.css" rel="stylesheet">
<link href="css/treev.css" rel="stylesheet">
    
  <script src="js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
<script type="text/javascript" src="js/DataTables/datatables.min.js"></script>

    <link href="js/select2/css/select2.css" rel="stylesheet"/>
    <script src="js/select2/js/select2.js"></script>
    <script src="js/js.js"></script>
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
<span class='akun'><?php echo db_baca("user_login","karyawan","id='".user_id()."'","nama");?><a href='../../'>X</a></span>
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
