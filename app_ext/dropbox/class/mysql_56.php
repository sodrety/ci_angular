<?php
function tugasdb() {
return "tugasdb";	
}


function db56_query($dbn,$q) {
$db = new database56();
$db->connect($dbn);
$add_query = $db->query($q);
}

function db56_insert($dbn,$tb,$dt) {
$db = new database56();
$db->connect($dbn);
$add_query = $db->insert($tb,$dt);
}

function db56_replace($dbn,$tb,$dt) {
$db = new database56();
$db->connect($dbn);
$add_query = $db->replace($tb,$dt);
}

function db56_delete($dbn,$tb,$wh) {
$db = new database56();
$db->connect($dbn);
$add_query = $db->delete($tb,$wh);
}

function db56_update($dbn,$tb,$wh,$dt) {
$db = new database56();
$db->connect($dbn);
$add_query = $db->update($tb,$wh,$dt);
}

function db56_baca($dbn,$tb,$wh,$fd) {
$db = new database56();
$db->connect($dbn);
$query = "SELECT $fd FROM $tb WHERE $wh LIMIT 0,1";
$results = $db->get_results( $query );
foreach( $results as $row) {
return $row[$fd];
}

}
function db56_jml($dbn,$tb,$wh,$fd) {
$db = new database56();
$db->connect($dbn);
$query = "SELECT $fd FROM $tb WHERE $wh";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $row) {
$n+=1;
}
return $n;
}
