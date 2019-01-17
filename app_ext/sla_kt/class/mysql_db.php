<?php
function db_insert($dbn,$tb,$dt) {
$db = new database();
$db->connect($dbn);
$add_query = $db->insert($tb,$dt);
}

function db_replace($dbn,$tb,$dt) {
$db = new database();
$db->connect($dbn);
$add_query = $db->replace($tb,$dt);
}
	
function db_delete($dbn,$tb,$wh) {
$db = new database();
$db->connect($dbn);
$add_query = $db->delete($tb,$wh);
}

function db_update($dbn,$tb,$wh,$dt) {
$db = new database();
$db->connect($dbn);
$add_query = $db->update($tb,$wh,$dt);
}

function db_baca($dbn,$tb,$wh,$fd) {
$db = new database();
$db->connect($dbn);
$query = "SELECT $fd FROM $tb WHERE $wh LIMIT 0,1";
$results = $db->get_results( $query );
foreach( $results as $row) {
return $row[$fd];
}
}


function db_jml($dbn,$tb,$wh,$fd) {
$db = new database();
$db->connect($dbn);
$query = "SELECT $fd FROM $tb WHERE $wh";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $row) {
$n+=1;
}
return $n;
}