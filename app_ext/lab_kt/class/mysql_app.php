<?php
function app_db() {	
return "lab";
}

function app_query($q) {
$db = new database();
$db->connect(app_db());
$add_query = $db->query($q);
}

function app_insert($tb,$dt) {
$db = new database();
$db->connect(app_db());
$add_query = $db->insert($tb,$dt);
}

function app_replace($tb,$dt) {
$db = new database();
$db->connect(app_db());
$add_query = $db->replace($tb,$dt);
}

function app_delete($tb,$wh) {
$db = new database();
$db->connect(app_db());
$add_query = $db->delete($tb,$wh);
}

function app_update($tb,$wh,$dt) {
$db = new database();
$db->connect(app_db());
$add_query = $db->update($tb,$wh,$dt);
}

function app_baca($tb,$wh,$fd) {
$db = new database();
$db->connect(app_db());
$query = "SELECT $fd FROM $tb WHERE $wh LIMIT 0,1";
$results = $db->get_results( $query );
foreach( $results as $row) {
return $row[$fd];
}

}
function app_jml($tb,$wh,$fd) {
$db = new database();
$db->connect(app_db());
$query = "SELECT $fd FROM $tb WHERE $wh";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $row) {
$n+=1;
}
return $n;
}

function app_sum($tb,$wh,$fd) {
$db = new database();
$db->connect(app_db());
$query = "SELECT $fd FROM $tb WHERE $wh";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $row) {
$n+=$row[$fd];
}
return $n;
}
