<?php
function if_insert($dbn,$tb,$dt) {
$db = new database7();
$db->connect($dbn);
$add_query = $db->insert($tb,$dt);
}

function if_replace($dbn,$tb,$dt) {
$db = new database7();
$db->connect($dbn);
$add_query = $db->replace($tb,$dt);
}
	
function if_delete($dbn,$tb,$wh) {
$db = new database7();
$db->connect($dbn);
$add_query = $db->delete($tb,$wh);
}

function if_update($dbn,$tb,$wh,$dt) {
$db = new database7();
$db->connect($dbn);
$add_query = $db->update($tb,$wh,$dt);
}

function if_baca($dbn,$tb,$wh,$fd) {
$db = new database7();
$db->connect($dbn);
$query = "SELECT $fd FROM $tb WHERE $wh LIMIT 0,1";
$results = $db->get_results( $query );
foreach( $results as $row) {
return $row[$fd];
}
}

function if_jml($dbn,$tb,$wh,$fd) {
$db = new database7();
$db->connect($dbn);
$query = "SELECT $fd FROM $tb WHERE $wh";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $row) {
$n+=1;
}
return $n;
}