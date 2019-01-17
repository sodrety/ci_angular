<?php
require_once( '../class/class.php' );
$no=$_GET['no'];
$cost=db_sum("rq_2018_priok","cost","no='".$no."'","harga");
echo $cost;