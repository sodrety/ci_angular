<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "class/class.php";
?>
<!DOCTYPE html> 
<html xml:lang="en" lang="en">
<head>
<style>
* {font-size:13px;font-family:arial;}
</style>
 	    <title>EDIT MASTER DATA</title>
</head>
<body>
<body>
<?php
$t=$_GET['t'];
echo "<h2>$t</h2>";
if ($_POST) {
app_replace($t,"'".$_POST['kode']."'");
}
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM ".$t." WHERE kode!='' order by kode";
$results = $db->get_results( $query );
foreach( $results as $data) {
echo $data['kode']."<br>";
}
echo "<form method=post>Tambah : <input type=text name=kode><input type=submit value=Simpan></form>";
?>

</body>
<?php //ui_foot(); ?>
</html>

