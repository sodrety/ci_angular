<?php

function karyawan_opt($id) {
$db = new database();
$db->connect("user_login");
$query = "SELECT id,nama FROM karyawan order by nama";
$results = $db->get_results( $query );
foreach( $results as $data )
{
$popt=db_baca("acak_popt","popt","id='".$data['id']."'","id");
if ($popt!="") {
	$rt="<option value='".$data['id']."'>".substr($data['nama'],0,20)."</option>";
if ($data['id']==$id) {$ret1=$rt;}
$ret.=$rt;
} }
if ($id=="") {$ret0="<option value=''></option>";}
return $ret0.$ret1.$ret;
}
