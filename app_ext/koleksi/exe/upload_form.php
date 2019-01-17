<!DOCTYPE html>
<html xml:lang="en" lang="en">
<head>
 	    <title>Foto Koleksi</title>
<style>
body {margin:10px;  }
a 
</style>
<?php
require_once('class/class.php');
$id=$_GET['id'];
if ($id=="") {exit;}
if ($_GET['do']=="del") {
$filenya=app_baca("koleksi_foto","id='".$_GET['idf']."'","file");
unlink("../foto/".$filenya);
app_delete("koleksi_foto","id='".$_GET['idf']."'");
echo "<meta http-equiv=\"refresh\" content=\"0; URL=?id=".$id."\">";
exit;
}
echo "</head><body>";

$uploaddir ="../foto/";
if ($_POST) {
require_once('../../../class/ImageManipulator.php');	
	$validExtensions = array('.jpg', '.jpeg', '.gif', '.png', '.JPG', '.JPEG', '.GIF', '.PNG');
	// get extension of the uploaded file
	$fileExtension = strrchr($_FILES['fileToUpload']['name'], ".");
	// check if file Extension is on the list of allowed ones
	if (in_array($fileExtension, $validExtensions)) {
		$manipulator = new ImageManipulator($_FILES['fileToUpload']['tmp_name']);
		$width 	= $manipulator->getWidth();
		$height = $manipulator->getHeight();
			$size=700;
		if ($width>$size or $height>$size) {$newImage = $manipulator->resample($size, $size);}
			$path = $_FILES['fileToUpload']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$file=$_POST['id']."_".date("YmdHis").".".$ext;
			$manipulator->save($uploaddir.$file);
			koleksi_tambah("koleksi_foto","'','".$file."','".$_POST['ket']."','".now()."'");
			echo " File Image ".$_FILES['fileToUpload']['name']." sudah terupload: ".$_POST['ket'];
			
	} else {
echo "Gagal, hanya file Image yang diijinkan";	

//$uploadfile = $uploaddir . basename($_FILES['fileToUpload']['name']);
//move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadfile);
//echo "$uploadfile berhasil diupload.\n";
} 
}
echo "
<form enctype='multipart/form-data' method='POST'>
    <input type='hidden' name='MAX_FILE_SIZE' value='3000000' />
	    <input type='hidden' name='id' value='".$id."' />
    <input name='fileToUpload' type='file' /><br>
Deskripsi : <textarea name='ket' style='width:500px;height:40px;'></textarea> 

    <input type='submit' value='Send File' /></form>";

$db=new database();
$db->koleksi_konek();
$daftar=$db->tampilDataWhere("koleksi_foto","file LIKE '".$id."_%'");
foreach((array)$daftar as $data){
echo "<a  style='display:block;' onClick=\"javascript:requestContent('foto.php?id=".$data['id']."&idk=".$id."','foto'); \"  title='Upload'><img src='../../../class/thumb.php?size=120&src=../app/koleksi/foto/".$data['file']."' style='float:left;margin:0 10px 5px 0;'></a>";	
}
echo  "<div style='clear:both;'></div><div id=foto></div>";
?>
</body></html>
