<?php
require_once( '../class/class.php' );
if ($_POST) {		
app_update("uji","id='".$_POST['id']."'","distribusi_tgl='".$_POST['distribusi_tgl']."',distribusi_kondisi='".$_POST['distribusi_kondisi']."',distribusi_oleh='".$_POST['distribusi_oleh']."'");
}