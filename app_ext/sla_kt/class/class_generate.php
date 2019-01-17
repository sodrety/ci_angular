<?php



function step1() {
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE kode LIKE '1822%' order by no desc";
$results = $db->get_results( $query );

foreach( $results as $data )
{
//echo "<tr><td>".$data['no']."</td><td>".$data['top']."</td><td>".$t."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td>".$data['vol']."</td><td>".$data['sat']."</td><td>".$data['hargasat']."</td><td>".$data['jumlah']."</td><td>".$data['sdana']."</td></tr>";
rq_update("pok","no='".$data['no']."'","top='1'");
}
}

function step2() { // 211
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok order by no desc";
$results = $db->get_results( $query );

foreach( $results as $data )
{
if ($data['kode']<=999 and $data['kode']>0) {
$ntop=rq_baca("pok","no<'".$data['no']."' and top='1' order by no desc","no");

//echo "<tr><td>".$data['no']."</td><td>".$ntop."</td><td>".$t."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td>".$data['vol']."</td><td>".$data['sat']."</td><td>".$data['hargasat']."</td><td>".$data['jumlah']."</td><td>".$data['sdana']."</td></tr>";
rq_update("pok","no='".$data['no']."'","top='$ntop'");
}
}
}

function step3() { // A B C dst
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE kode NOT LIKE '5%' order by no desc";
$results = $db->get_results( $query );

foreach( $results as $data )
{
if ($data['top']>0) {} else {
$ntop=rq_baca("pok","no<'".$data['no']."' and top>'0' order by no desc","no");

//echo "<tr><td>".$data['no']."</td><td>".$ntop."</td><td>".$data['top']."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td>".$data['vol']."</td><td>".$data['sat']."</td><td>".$data['hargasat']."</td><td>".$data['jumlah']."</td><td>".$data['sdana']."</td></tr>";
rq_update("pok","no='".$data['no']."'","top='$ntop'");
}
}
}

function step4() { // 52xxxx
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE kode LIKE '5%' order by no desc";
$results = $db->get_results( $query );

foreach( $results as $data )
{
if ($data['top']>0) {} else {
$ntop=rq_baca("pok","no<'".$data['no']."' and top>'0' order by no desc","no");

//echo "<tr><td>".$data['no']."</td><td>".$ntop."</td><td>".$data['top']."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td>".$data['vol']."</td><td>".$data['sat']."</td><td>".$data['hargasat']."</td><td>".$data['jumlah']."</td><td>".$data['sdana']."</td></tr>";
rq_update("pok","no='".$data['no']."'","top='$ntop'");
}
}
}

function step5() { // AKUN
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok order by no desc";
$results = $db->get_results( $query );

foreach( $results as $data )
{
if ($data['top']>0) {} elseif  ($data['sat']=='') {
$ntop=rq_baca("pok","no<'".$data['no']."' and top>'0' order by no desc","no");

//echo "<tr><td>".$data['no']."</td><td>".$ntop."</td><td>".$data['top']."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td>".$data['vol']."</td><td>".$data['sat']."</td><td>".$data['hargasat']."</td><td>".$data['jumlah']."</td><td>".$data['sdana']."</td></tr>";
rq_update("pok","no='".$data['no']."'","top='$ntop'");
}
}
}


function step6() { // AKUN
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok order by no desc";
$results = $db->get_results( $query );

foreach( $results as $data )
{
if ($data['top']>0) {} else {
$ntop=rq_baca("pok","no<'".$data['no']."' and top>'0' order by no desc","no");

//echo "<tr><td>".$data['no']."</td><td>".$ntop."</td><td>".$data['top']."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td>".$data['vol']."</td><td>".$data['sat']."</td><td>".$data['hargasat']."</td><td>".$data['jumlah']."</td><td>".$data['sdana']."</td></tr>";
rq_update("pok","no='".$data['no']."'","top='$ntop'");
rq_update("pok","no='".$data['no']."'","mak='".pok_kodenya($data['no'])."'");
}
}
}


/*

function step4($t) {
$nxt=rq_baca("pok","no>'$t' and top='0'","no");

$db = new database();
$db->connect(rq_db());
if ($nxt=="") {$query = "SELECT * FROM pok WHERE no>'$t' order by no";} else {
$query = "SELECT * FROM pok WHERE no>'$t' and no<'$nxt' order by no"; }
$results = $db->get_results( $query );
foreach( $results as $data )
{
if (strlen($data['kode'])=="3") { // Like 221
echo "<tr><td>".$data['no']."</td><td>".$data['top']."</td><td>".$t."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td>".$data['vol']."</td><td>".$data['sat']."</td><td>".$data['hargasat']."</td><td>".$data['jumlah']."</td><td>".$data['sdana']."</td></tr>";
rq_update("pok","no='".$data['no']."'","top='".$t."'");
step5($data['no']);
}
}

}

function step5($t) {
$nxt=rq_baca("pok","no>'$t' and top!=''","no");

$db = new database();
$db->connect(rq_db());
if ($nxt=="") {$query = "SELECT * FROM pok WHERE no>'$t' order by no";} else {
$query = "SELECT * FROM pok WHERE no>'$t' and no<'$nxt' order by no"; }
$results = $db->get_results( $query );
foreach( $results as $data )
{
if (strlen($data['kode'])=="1" or strlen($data['kode'])=="2") {  // like AB
echo "<tr><td>".$data['no']."</td><td>".$data['top']."</td><td>".$t."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td>".$data['vol']."</td><td>".$data['sat']."</td><td>".$data['hargasat']."</td><td>".$data['jumlah']."</td><td>".$data['sdana']."</td></tr>";
rq_update("pok","no='".$data['no']."'","top='".$t."'");
step6($data['no']);
}
}

}

function step6($t) {
$nxt=rq_baca("pok","no>'$t' and top!=''","no");

$db = new database();
$db->connect(rq_db());
if ($nxt=="") {$query = "SELECT * FROM pok WHERE no>'$t' order by no";} else {
$query = "SELECT * FROM pok WHERE no>'$t' and no<'$nxt' order by no"; }
$results = $db->get_results( $query );
foreach( $results as $data )
{
if (strlen($data['kode'])=="6") {  // like 524111
echo "<tr><td>".$data['no']."</td><td>".$data['top']."</td><td>".$t."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td>".$data['vol']."</td><td>".$data['sat']."</td><td>".$data['hargasat']."</td><td>".$data['jumlah']."</td><td>".$data['sdana']."</td></tr>";
rq_update("pok","no='".$data['no']."'","top='".$t."'");
//step7($data['no']);
}
}

}

function step7($t) {
//$nxt=rq_baca("pok","no>'$t' and top!=''","no");

$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE top!='' order by no";
$results = $db->get_results( $query );
foreach( $results as $data )
{

echo "<tr><td>".$data['no']."</td><td>".$data['top']."</td><td>".$t."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td>".$data['vol']."</td><td>".$data['sat']."</td><td>".$data['hargasat']."</td><td>".$data['jumlah']."</td><td>".$data['sdana']."</td></tr>";
//rq_update("pok","no='".$data['no']."'","top='".$t."'");
step8($data['no']);
}

}

function step8($t) {
$nxt=rq_baca("pok","no>'$t' and top!=''","no");

$db = new database();
$db->connect(rq_db());
if ($nxt=="") {$query = "SELECT * FROM pok WHERE no>'$t' order by no";} else {
$query = "SELECT * FROM pok WHERE no>'$t' and no<'$nxt' order by no"; }
$results = $db->get_results( $query );
foreach( $results as $data )
{
if (strlen($data['kode'])=="0") {  
echo "<tr><td>".$data['no']."</td><td>".$data['top']."</td><td>".$t."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td>".$data['vol']."</td><td>".$data['sat']."</td><td>".$data['hargasat']."</td><td>".$data['jumlah']."</td><td>".$data['sdana']."</td></tr>";
rq_update("pok","no='".$data['no']."'","top='".$t."'");
//step7($data['no']);
}
}

}


echo "<table border=1>";
//step("kode LIKE '1822%'");
step7($t);
echo "</table><br>";
function step2($wh,$t) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE $wh order by no";
$results = $db->get_results( $query );
foreach( $results as $data )
{
if (strlen($data['kode'])=="8") {
echo "<tr><td>".$data['no']."</td><td>".$data['top']."</td><td>".$t."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td>".$data['vol']."</td><td>".$data['sat']."</td><td>".$data['hargasat']."</td><td>".$data['jumlah']."</td><td>".$data['sdana']."</td></tr>";
//rq_update("pok","no='".$data['no']."'","top='".$t."'");
step3("kode LIKE '".$data['kode']."%'",$data['no']);
}
}

}

function step3($wh,$t) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE $wh order by no desc";
$results = $db->get_results( $query );
foreach( $results as $data )
{
if (strlen($data['kode'])=="12") {
echo "<tr><td>".$data['no']."</td><td>".$data['top']."</td><td>".$t."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td>".$data['vol']."</td><td>".$data['sat']."</td><td>".$data['hargasat']."</td><td>".$data['jumlah']."</td><td>".$data['sdana']."</td></tr>";
rq_update("pok","no='".$data['no']."'","top='".$t."'");
step4a($data['no']);
}
}

}

function step4a($t) {
//$nxt=rq_baca("pok","no>'$t' and top!=''","no");

$db = new database();
$db->connect(rq_db());
$query = "SELECT * FROM pok WHERE no>'$t' and top!='' order by no";
$results = $db->get_results( $query );
foreach( $results as $data )
{
if (strlen($data['kode'])=="3") { // Like 221
echo "<tr><td>".$data['no']."</td><td>".$data['top']."</td><td>".$t."</td><td>".$data['kode']."</td><td>".$data['uraian']."</td><td>".$data['vol']."</td><td>".$data['sat']."</td><td>".$data['hargasat']."</td><td>".$data['jumlah']."</td><td>".$data['sdana']."</td></tr>";
rq_update("pok","no='".$data['no']."'","top='".$t."'");
//step5($data['no']);
}
}

}




