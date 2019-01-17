<?php
require_once('../../../class/class.php');
$id=$_GET['id'];
$idk=$_GET['idk'];
$file=koleksi_baca("koleksi_foto","id='".$id."'","file");
$ket=koleksi_baca("koleksi_foto","id='".$id."'","ket");
echo "<img src='../foto/".$file."'><a href='?id=".$idk."&idf=".$id."&do=del'>Hapus</a><br>".$ket;

