<?php

function user_id() {
return $_SESSION['user_id'];
}


function user() {
$user=$_COOKIE['user'];
return strtoupper($user);
}

function akun_pj() {
return substr(user(),0,7);
}

class dropbox {
	
function menu() {
$ap="dropbox.php";	

$dt=array("Antri","Verifikasi","Rekomendasi","NotifikasiDokumen","Pengesahan","NotifikasiPNBP","KirimNSW","Monitoring","Grafik");
$s=0;
foreach ($dt as $d) {
$mi2.="<li><a href='?b=2&l=I&via=2_I_L&t=".$d."'>".$d."</a></li>";
$mi1.="<li><a href='?b=1&l=I&via=1_I_L&t=".$d."'>".$d."</a></li>";
$s+=1;
}
$dt=array("Antri","Respon","Selesai","Monitoring");
$s=0;
foreach ($dt as $d) {
$me2.="<li><a href='?l=E&b=2&s=".$s."&t=".$d."'>".$d."</a></li>";
$s+=1;
}
$dt=array("Antri","Notifikasi","Selesai","Monitoring");
$s=0;
foreach ($dt as $d) {
$mc2.="<li><a href='?l=E&b=2&s=".$s."&t=".$d."'>".$d."</a></li>";
$s+=1;
}

return "<ul id='myUL'>
  <li><span class='box'>Pengguna Jasa</span>
    <ul class='nested'>
      <li><a href='?t=PrintBarcode'>PrintBarcode</a></li>
      <li><a href='?t=Perusahaan'>Perusahaan</a></li>
      <li><a href='?t=PerusahaanTerblokir'>Perusahaan Terblokir</a></li>
      <li><a href='?t=LogSMS'>Log SMS</a></li>
      </ul>
  </li>
<li><span class='box'>Impor KT</span>
    <ul class='nested'>".$mi2."</ul>
</li> 
<li><span class='box'>Impor KH</span>
    <ul class='nested'>".$mi1."</ul>
</li>  
<li><span class='box'>Ekspor KT</span>
    <ul class='nested'>
              <li><a href='?t=Antri&l=E&b=2&s=0&via=2_E_L'>Antri</a></li>
          <li><a href='?t=Respon&l=E&b=2&s=0&via=2_E_L'>Respon</a></li>
      <li><a href='?t=Monitoring&l=E&b=2&s=0&via=2_E_L'>Monitoring</a></li>
    </ul>
</li> 
  <li><span class='box'>Ekspor KT Paperless</span>
    <ul class='nested'>
      <li><a href='?t=Respon&l=E&b=2&s=0&via=2_E_P'>Respon</a></li>
      <li><a href='?t=Monitoring&l=E&b=2&s=0&via=2_E_P'>Monitoring</a></li>
      </ul>
  </li>
  
<li><span class='box'>Cetak Phyto</span>
    <ul class='nested'><li><a href='?t=AntriPhyto'>Antri</a></li>  
    <li><a href='?t=RequestBilling'>Request Billing</a></li>  
    <li><a href='?t=DraftPhyto'>Draft Phyto</a></li></ul>
</li> 
<li><span class='box'><a href='/sma_display.php'>Display</a></span></li> 
<li><span class='box'>Ekspor Pos Jkt</span>
    <ul class='nested'>
              <li><a href='?t=Antri&l=E&b=2&s=0&via=2_E_L&w=03'>Antri</a></li>
          <li><a href='?t=Respon&l=E&b=2&s=0&via=2_E_L&w=03'>Respon</a></li>
      <li><a href='?t=Monitoring&l=E&b=2&s=0&via=2_E_L&w=03'>Monitoring</a></li>
    </ul>
</li> 

</ul>

<br><br><br><br>
";	
/*
echo "<script>
$(document).ready(function(){
    $(\"#kode\").keyup(function(){
        var txt = $(\"#kode\").val();
        $.post(\"exe/log.php\", {kode: txt}, function(result){
            $(\"#log\").html(result);
        });
    });
});
</script>
<div class=log_data>
Log:<br><input type='text' id=kode name='kode'><br>
<div id='log'></div>
</div>";
*/
}

function content($t) {
$content=new content();
$t=strtolower($t);
if ($t!="") { $content->$t();	} else {$content->monitoring_all();}
}


function klik($t) {
$content=new klik();
$t=strtolower($t);
if ($t!="") { $content->$t();	} else {$content->profile();}
}



function title() {
$vi=explode("_",$_GET['via']);
$l=$vi[1];
$b=$vi[0];
if ($l=="I") {$ll="Impor";} elseif ($l=="E") {$ll="Ekspor";} elseif ($l=="C") {$ll="Cetak Phytosanitary Certificate";}
if ($b=="1") {$bb="Karantina Hewan";} elseif ($b=="2") {$bb="Karantina Tumbuhan";} 
return $ll." ".$bb. " - ";	
}	


}




class code_gen {

function ah($a) {
$a=$this->bawah($a);
$h=array(0,1,2,3,4,5,6,7,8,9,"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");	
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

function del0($k) {
if (substr($k,0,1)=="0") {$k=substr($k,1,11); }
if (substr($k,0,1)=="0") {$k=substr($k,1,11); }
if (substr($k,0,1)=="0") {$k=substr($k,1,11); }
if (substr($k,0,1)=="0") {$k=substr($k,1,11); }
if ($k=="") {$k="0";}
return $k;
}


function kodex($id) {
$kg=new code_gen();
return $kg->gen($id);
if ($id=="1296") {$k="100";} elseif ($id=="46656") {$k="1000";}  elseif ($id=="1679616") {$k="1000";} else {$k=del0($kg->gen($id));}
return $k;
}

function kode($id) {
$db = new database();
$db->connect(app_db());
$query = "SELECT * FROM m_kode WHERE id_kode='".$id."'";
$results = $db->get_results( $query );
foreach( $results as $data) {
$k=$data['e'].$data['d'].$data['c'].$data['b'].$data['a'];
}
return del0($k);
}


function unik() {
$unik=date("YmdHis").user_id().ip();
$unik=str_replace(".","",$unik);
$unik=str_replace(" ","",$unik);
$unik=str_replace(":","",$unik);
$unik=str_replace("-","",$unik);
return $unik;
}



