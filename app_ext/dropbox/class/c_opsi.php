<?php
class opsi{

function m_ll($id) {
$db = new database();
$db->connect(app_db());
$results = $db->get_results("SELECT * from m_ll order by ll");
foreach( $results as $data )
{
if ($data['id']==$id) {$ret1="<option value='".$data['id']."'>".$data['ll']."</option>";}
$ret.="<option value='".$data['id']."'>".$data['ll']."</option>";
}
return $ret1.$ret;
}

function m_lokasi($id) {
$db = new database();
$db->connect(app_db());
$results = $db->get_results("SELECT * from m_lokasi order by lokasi");
foreach( $results as $data )
{
if ($data['id_lokasi']==$id) {$ret1="<option value='".$data['id_lokasi']."'>".$data['lokasi']."</option>";}
$ret.="<option value='".$data['id_lokasi']."'>".$data['lokasi']."</option>";
}
return $ret1."<option></option>".$ret;
}

function m_jenis($jenis) {
$db = new database();
$db->connect(app_db());
$results = $db->get_results("SELECT distinct(jenis) from m_optk order by jenis");
foreach( $results as $data )
{
if ($data['jenis']==$jenis) {$ret1="<option value='".$data['jenis']."'>".$data['jenis']."</option>";} elseif (strlen($data['jenis'])>3) {
$ret.="<option value='".$data['jenis']."'>".$data['jenis']."</option>"; }
}
return $ret1.$ret;
}


function m_optk() {
$db = new database();
$db->connect(app_db());
$results = $db->get_results("SELECT * from m_optk order by nama_latin");
foreach( $results as $data )
{
$ret.="<option value='".$data['id']."'>".$data['nama_latin']."</option>";
}
return "<option value=''></option>".$ret;
}

function m_negara() {
$db = new database();
$db->connect(app_db());
$results = $db->get_results("SELECT nama from m_negara order by nama");
foreach( $results as $data )
{
$ret.="<option value='".$data['nama']."'>".$data['nama']."</option>";
}
return $ret;
}

function m_metode($id) {
$db = new database();
$db->connect(app_db());
$results = $db->get_results("SELECT * from m_metode order by metode");
foreach( $results as $data )
{
if ($data['id']==$id) {$ret1="<option value='".$data['id']."'>".$data['metode']."</option>";}
$ret.="<option value='".$data['id']."'>".$data['metode']."</option>";
}
return $ret1.$ret;
}

function h_uji($id) {
$hasil=app_baca("uji_hasil","id='".$id."'","hasil");
$ret.="<option value='".$hasil."'>".$hasil."</option>";
$ret.="<option value=''></option>";
$ret.="<option value='Positif'>Positif</option>";
$ret.="<option value='Negatif'>Negatif</option>";
return $ret;
}

}
