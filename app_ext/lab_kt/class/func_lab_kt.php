<?php

function user_id() {
return $_SESSION['user_id'];
}
class lab_kt {
	
function menu() {
$ap="lab_kt.php";	
return "
  <h4>Pengujian</h4>
<a href='".$ap."?t=Kirim'>Kirim Sampel</a> <a href='".$ap."?t=Terima'>Terima Sampel</a> <a href='".$ap."?t=Distribusi'>Distribusi Sampel</a> <a href='".$ap."?t=Hasil'>Hasil Uji</a>
  <h4>Laporan</h4>
<a href='".$ap."?t=Temuan'>Temuan Uji</a> <a href='".$ap."?t=Metode'>Metode Uji</a> <a href='".$ap."?t=Penugasan'>Penugasan</a>
";	
}

function content($t) {
$content=new content();
$t=strtolower($t);
$content->$t();	
}
}


class code_gen {

function ah($a) {
$a=$this->bawah($a);
$h=array(0,1,2,3,4,5,6,7,8,9,"a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");	
//return $h[$a];
if ($h[$a]=="") {return "0";} else {return $h[$a];}
} 

function plus($a) {
	if ($a>=0) {return $a;}
}
function bawah($a) {
$jp = explode(".", $a);
return $jp[0];
}

function gen($a) {

if ($a>pow(36,6)) {$s6=$this->plus($a-pow(36,6));$l6=$a/pow(36,6);} else {$s6=$a;}
if ($a>pow(36,5)) {$s5=$this->plus($s6-pow(36,5));$l5=$s6/pow(36,5);} else {$s5=$a;}
if ($a>pow(36,4)) {$s4=$this->plus($s5-pow(36,4));$l4=$s5/pow(36,4);} else {$s4=$a;}
if ($a>pow(36,3)) {$s3=$this->plus($s4-pow(36,3));$l3=$s4/pow(36,3);} else {$s3=$a;}
if ($a>pow(36,2)) {$s2=$this->plus($s3-pow(36,2));$l2=$s3/pow(36,2);} else {$s2=$a;}
if ($a>=36) {$s1=$this->plus($s2-36);$l1=$s2/36;} else {$s1=$a;}
if ($a>0) {$l0=($a-(36*($this->bawah($a/36))));}

return $this->ah($l4).$this->ah($l3).$this->ah($l2).$this->ah($l1).$this->ah($l0);

}
}








