<?php
$id=$_GET['id'];
// include Barcode39 class 
include "Barcode39.php"; 

// set Barcode39 object 
$bc = new Barcode39($id); 

// display new barcode 
$bc->draw();
?>