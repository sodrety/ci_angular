<html>
<head>

<style>
* {font-family:arial;font-size:13px;}
h2 {font-size:17px;}
* input {width:100%;}
table {border-left:1px solid #ccc; border-top:1px solid #ccc; border-spacing: 0px; border-collapse: separate;}

table tr td,table tr th {border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
</style>
</head>
<body>
<?php
require_once( '../class/class.php' );
$nom_id=$_GET['nom_id'];
if ($_GET['id_spt']!="") {
db_update("tugasdb","spt","id='".$id_spt."'","nom_id='".$nom_id."'");
}

$db = new database();
$db->connect("tugasdb");
$top=$_GET['top'];
$query = "SELECT no FROM spt WHERE nom_id='".$nom_id."' order by no";
$results = $db->get_results( $query );
foreach( $results as $data )
{
echo $data['no']." ";
$no+=1;
}
?>
</body>
</html>
