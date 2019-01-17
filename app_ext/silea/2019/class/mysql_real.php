<?php
function rq_db() {	
return "rq_2019_priok";
}

function rq_insert($tb,$dt) {
$db = new database();
$db->connect(rq_db());
$add_query = $db->insert($tb,$dt);
}

function rq_replace($tb,$dt) {
$db = new database();
$db->connect(rq_db());
$add_query = $db->replace($tb,$dt);
}

function rq_delete($tb,$wh) {
$db = new database();
$db->connect(rq_db());
$add_query = $db->delete($tb,$wh);
}

function rq_update($tb,$wh,$dt) {
$db = new database();
$db->connect(rq_db());
$add_query = $db->update($tb,$wh,$dt);
}

function rq_baca($tb,$wh,$fd) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT $fd FROM $tb WHERE $wh LIMIT 0,1";
$results = $db->get_results( $query );
foreach( $results as $row) {
return $row[$fd];
}

}

function rq_sum($tb,$wh,$fd) {
$db = new database();
$db->connect(rq_db());
$query = "SELECT $fd FROM $tb WHERE $wh";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $row) {
$n+=$row[$fd];
}
return $n;
}



function pok_topnya($no) {
$top=rq_baca("pok","no='".$no."'","top");
//if ($top=="") {} else {
//pok_topnya($top);
return $top;
//}
}

function db_replace($dbn,$tb,$dt) {
$db = new database();
$db->connect($dbn);
$add_query = $db->replace($tb,$dt);
}

function db_insert($dbn,$tb,$dt) {
$db = new database();
$db->connect($dbn);
$add_query = $db->insert($tb,$dt);
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

function db_update($dbn,$tb,$wh,$dt) {
$db = new database();
$db->connect($dbn);
$add_query = $db->update($tb,$wh,$dt);
}

function db_jml($dbn,$tb,$wh,$fd) {
$db = new database();
$db->connect($dbn);
$query = "SELECT $fd FROM $tb WHERE $wh";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $row) {
//return $row[$fd];
$n++;
}
return $n;
}

function db_sum($dbn,$tb,$wh,$fd) {
$db = new database();
$db->connect($dbn);
$query = "SELECT $fd FROM $tb WHERE $wh";
$results = $db->get_results( $query );
$n=0;
foreach( $results as $row) {
$n+=$row[$fd];
}
return $n;
}
