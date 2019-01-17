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
if ($data['id']==$id) {$ret1="<option value='".$data['id']."'>".substr($data['nama'],0,20)."</option>";}
$ret.="<option value='".$data['id']."'>".substr($data['nama'],0,20)."</option>";
} }
return $ret1.$ret;
}
