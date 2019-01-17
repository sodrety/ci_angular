<?php
function durasi($t0,$t1) {
if ($t0=="" or $t1=="" or $t0=="0000-00-00 00:00:00" or $t1=="0000-00-00 00:00:00") {return "";} else {
if ($t0<=$t1) { $min="+";
$diff = strtotime($t1) - strtotime($t0);
} else { $min="-";
$diff = strtotime($t0) - strtotime($t1);
}
$d=(gmdate("d", $diff)-1);
$h=gmdate("H", $diff);
$i=gmdate("i", $diff);
if ($d<=0) {$dd=""; } else {$dd="<b>".(gmdate("d", $diff)-1)."</b>h";}
//return "<b>$min</b> $dd <b>".$h."</b>:<b>".$i."</b>";
$menit=($d*24*60)+($h*60)+$i;
return $min.$menit;
//return "<b>".gmdate("H", $diff)."</b>:<b>".gmdate("i", $diff)."</b>:<b>".gmdate("s", $diff)."</b>";
}
}

function wkt($t0) {
if ($t0=="" or $t0=="0000-00-00 00:00:00") {return "";} else { return $t0; }
}

function des($n) {
if ($n>0) {return number_format($n, 2, '.', ',');} else {return ""; }
}

function des_en($n) {
if ($n>0) {return number_format($n, 0, '', '');} else {return "0"; }
}

function angk($n) {
if ($n>0) {return ($n*1);} else {return ""; }
}

function frek($n) {
if ($n>0) {return $n;} else {return ""; }
}

function keatas($j) {
$jp = explode(".", $j);
$js=$jp[1];
if ($jp[1]<=0) {$js=$j;} else {$js=$jp[0]+1;}
return $js;
}

 function rp($rp) {return number_format($rp,0,",",".");}

 function rp_asli($rp) {return number_format($rp,0,"","");}
 
 function rp_satuan($angka,$debug)
{
$a_str['1']="Satu";
$a_str['2']="Dua";
$a_str['3']="Tiga";
$a_str['4']="Empat";
$a_str['5']="Lima";
$a_str['6']="Enam";
$a_str['7']="Tujuh";
$a_str['8']="Delapan";
$a_str['9']="Sembilan";

$panjang=strlen($angka);
for ($b=0;$b<$panjang;$b++)
{
$a_bil[$b]=substr($angka,$panjang-$b-1,1);
}

if ($panjang>2)
{
if ($a_bil[2]=="1")
{
$terbilang=" Seratus";
}
else if ($a_bil[2]!="0")
{
$terbilang= " ".$a_str[$a_bil[2]]. " Ratus";
}
}

if ($panjang>1)
{
if ($a_bil[1]=="1")
{
if ($a_bil[0]=="0")
{
$terbilang .=" Sepuluh";
}
else if ($a_bil[0]=="1")
{
$terbilang .=" Sebelas";
}
else
{
$terbilang .=" ".$a_str[$a_bil[0]]." Belas";
}
return $terbilang;
}
else if ($a_bil[1]!="0")
{
$terbilang .=" ".$a_str[$a_bil[1]]." Puluh";
}
}

if ($a_bil[0]!="0")
{
$terbilang .=" ".$a_str[$a_bil[0]];
}
return $terbilang;

}

function rp_terbilang($angka,$debug)
{

$angka = str_replace(“.",",",$angka);

list ($angka, $desimal) = explode(“,",$angka);
$panjang=strlen($angka);
for ($b=0;$b<$panjang;$b++)
{
$myindex=$panjang-$b-1;
$a_bil[$b]=substr($angka,$myindex,1);
}
if ($panjang>9)
{
$bil=$a_bil[9];
if ($panjang>10)
{
$bil=$a_bil[10].$bil;
}

if ($panjang>11)
{
$bil=$a_bil[11].$bil;
}
if ($bil!="" && $bil!="000")
{
$terbilang .= rp_satuan($bil,$debug)." Milyar";
}

}

if ($panjang>6)
{
$bil=$a_bil[6];
if ($panjang>7)
{
$bil=$a_bil[7].$bil;
}

if ($panjang>8)
{
$bil=$a_bil[8].$bil;
}
if ($bil!="" && $bil!="000")
{
$terbilang .= rp_satuan($bil,$debug)." Juta";
}

}

if ($panjang>3)
{
$bil=$a_bil[3];
if ($panjang>4)
{
$bil=$a_bil[4].$bil;
}

if ($panjang>5)
{
$bil=$a_bil[5].$bil;
}
if ($bil!="" && $bil!="000")
{
$terbilang .= rp_satuan($bil,$debug)." Ribu";
}

}

$bil=$a_bil[0];
if ($panjang>1)
{
$bil=$a_bil[1].$bil;
}

if ($panjang>2)
{
$bil=$a_bil[2].$bil;
}
//die($bil);
if ($bil!="" && $bil!="000")
{
$terbilang .= rp_satuan($bil,$debug);
}
return trim($terbilang);
}


function terbilang($rp) {  
$rpp=rp_terbilang($rp,"");
if (substr ($rpp, 0, 9)=="Satu Ribu") {
return str_replace("Satu Ribu", "Seribu",$rpp);	
} else {
	return $rpp;
	
}

}

function lama($t0,$t1) {
if ($t0=="" or $t1=="") {return "";} else {
$start = strtotime($t0);
$end = strtotime($t1);

$days_between = ceil(abs($end - $start) / 86400);

return ($days_between+1);
}
}
function next_date($date) {
$next_date = date('Y-m-d', strtotime($date .' +1 day'));
return $next_date; }

function next_date_plus($date,$plus) {
$next_date = date('Y-m-d', strtotime($date .' +'.$plus.' day'));
return $next_date; }

function tgl_p($tanggal) {
$array_bulan = array(1=>" Januari"," Februari"," Maret", " April", " Mei", " Juni"," Juli"," Agustus"," September"," Oktober", " November"," Desember");
$tgl_p = substr ($tanggal, 8, 2)." ".$array_bulan[(substr ($tanggal, 5, 2)*1)]." ".substr ($tanggal, 0, 4);
return $tgl_p; }

function tgl_wkt_p($tanggal) {
$array_bulan = array(1=>" Januari"," Februari"," Maret", " April", " Mei", " Juni"," Juli"," Agustus"," September"," Oktober", " November"," Desember");
$tgl_p = substr ($tanggal, 8, 2)." ".$array_bulan[(substr ($tanggal, 5, 2)*1)]." ".substr ($tanggal, 0, 4);
return $tgl_p." ".substr ($tanggal, 11, 5).""; }


function tgl($tanggal) {
$tgl_p = substr ($tanggal, 8, 2)."/".substr ($tanggal, 5, 2)."/".substr ($tanggal, 0, 4);
return $tgl_p; }

function bulannya($t) {
$array_bulan = array(1=>" Januari"," Februari"," Maret", " April", " Mei", " Juni"," Juli"," Agustus"," September"," Oktober", " November"," Desember");
return $array_bulan[($t*1)]; }

function tgl_aja($tanggal) {
$tgl_p = substr ($tanggal, 8, 2);
return $tgl_p; }

function tgl2($tanggal) {
$tgl_p = substr ($tanggal, 8, 2)."-".substr ($tanggal, 5, 2)."-".substr ($tanggal, 0, 4);
return $tgl_p; }

function bln_p($bln) {
$array_bulan = array(1=>" Januari"," Pebruari"," Maret", " April", " Mei", " Juni"," Juli"," Agustus"," September"," Oktober", " November"," Desember");
$tgl_p = $array_bulan[($bln*1)];
return $tgl_p; }

function bln_thn($tanggal) {
$array_bulan = array(1=>" Januari"," Pebruari"," Maret", " April", " Mei", " Juni"," Juli"," Agustus"," September"," Oktober", " November"," Desember");
$tgl_p = $array_bulan[(substr ($tanggal, 5, 2)*1)]." ".substr ($tanggal, 0, 4);
return $tgl_p; }

function bln_thn_aja($tanggal) {

$tgl_p = substr ($tanggal, 0, 4)."-".substr ($tanggal, 5, 2);
return $tgl_p; }

function bln_thn_no($tanggal) {

$tgl_p = substr ($tanggal, 5, 2)."/".substr ($tanggal, 0, 4);
return $tgl_p; }

function dua_angka($no) {
$n="00".$no;
$m=strlen($n)-2;
$tgl_p = substr ($n, $m, 2);
return $tgl_p; 
}


function tgl_ini() {
return date("Y-m-d");
}

function now() {
return date("Y-m-d")." ".date("H:i:s");
}

function ip() {
return $_SERVER['SERVER_ADDR'];
}

function jml_hari_bulan($bln,$thn) {
  $bln=$bln*1;
  if ($bln=="1" or $bln=="3" or $bln=="5" or $bln=="7" or $bln=="8" or $bln=="10" or $bln=="12") { return "31";} elseif ($bln=="2" and ($thn=="2016" or $thn=="2020")) {return "29";} elseif  ($bln=="2") {return "28";} else {return "30";}
  
}

function tglpilih($name,$value,$id) {
$h="http://".$_SERVER['HTTP_HOST']."/user_login/";
return "<input type=\"text\" id=\"$id\" name=\"$name\" value='$value'/>
  <script>
$( \"#".$id."\" ).datepicker({
			changeMonth: true,
			changeYear: true
});
  </script>";
}
function tglpilih2($name,$value,$id) {
$h="http://".$_SERVER['HTTP_HOST']."/user_login/";
return "<input type=\"text\" id=\"$id\" size=\"10\" name=\"$name\" value='$value'/>
  <script type=\"text/jsdemo\" charset=\"utf-8\" class=\"demojs\">
  $('#$id').datepicker({showOn: 'both', showOtherMonths: true, 
    showWeeks: false, firstDay: 1, changeFirstDay: false,
    buttonImageOnly: true, buttonImage: '".$h."js/date/style/img/calendar.gif'});  
  </script>";
}



function datepick_head() {

$h="http://".$_SERVER['HTTP_HOST']."/user_login/";
echo "
<link rel='stylesheet' href='".$h."js/date/style/flora.datepicker.css' type='text/css' media='screen' title='Flora (Default)' />
<script src='".$h."js/date/js/jquery-1.2.3.min.js' type='text/javascript'></script>
<script type='text/javascript' src='".$h."js/date/js/ui.datepicker.js'></script>
";
}

function datepick_foot() {
echo "
<script type=\"text/javascript\">
if (!window.console) {
  window.console = {
    log: function() {
      alert(arguments[0]);  
    }
  }
}

$(window).bind(\"load\",function(){
  $.datepicker.setDefaults($.datepicker.regional['']);
  $(\".demojs\").each(function () {
    $(this).before('' +
      '<pre style=\"display: none;\">' + $(this).html() + '</pre>');
    $('.codeLink').click(function() {
      $(this).hide().siblings('pre').show();
    });
    eval($(this).html());
  });
});
</script>";
}

function nicedit_head() {
echo "
<script src='nicEdit.js' type='text/javascript'></script>
<script type='text/javascript'>
     bkLib.onDomLoaded(function() {
          var myNicEditor = new nicEditor();
          myNicEditor.setPanel('myNicPanel');
          myNicEditor.addInstance('myInstance1');
          myNicEditor.addInstance('myInstance2');
          myNicEditor.addInstance('myInstance3');
     });
</script>
";
}

function today() {
return date("Y-m-d");	
}

function ui_foot() {
$h="http://".$_SERVER['HTTP_HOST']."/user_login/";
echo "
<script>

$( \"#accordion\" ).accordion();



var availableTags = [
	\"ActionScript\",
	\"AppleScript\",
	\"Asp\",
	\"BASIC\",
	\"C\",
	\"C++\",
	\"Clojure\",
	\"COBOL\",
	\"ColdFusion\",
	\"Erlang\",
	\"Fortran\",
	\"Groovy\",
	\"Haskell\",
	\"Java\",
	\"JavaScript\",
	\"Lisp\",
	\"Perl\",
	\"PHP\",
	\"Python\",
	\"Ruby\",
	\"Scala\",
	\"Scheme\"
];
$( \"#autocomplete\" ).autocomplete({
	source: availableTags
});

$( \"#karyawan_autocomplete\" ).autocomplete({
	source: '".$h."ajx/karyawan_autocomplete.php'
});

$( \"#karyawan_autocomplete2\" ).autocomplete({
	source: '".$h."ajx/karyawan_autocomplete.php'
});

$( \"#kepala_autocomplete\" ).autocomplete({
	source: '".$h."ajx/kepala_autocomplete.php'
});

$( \"#importir_kt_autocomplete\" ).autocomplete({
	source: '".$h."ajx/importir_kt_autocomplete.php'
});

$( \"#pengurus_kt_autocomplete\" ).autocomplete({
	source: '".$h."ajx/pengurus_kt_autocomplete.php'
});
$( \"#rekening_kt_autocomplete\" ).autocomplete({
	source: '".$h."ajx/rekening_kt_autocomplete.php'
});
$( \"#koleksi_ordo\" ).autocomplete({
	source: '".$h."ajx/koleksi_ordo.php'
});
$( \"#koleksi_family\" ).autocomplete({
	source: '".$h."ajx/koleksi_family.php'
});
$( \"#button\" ).button();
$( \"#radioset\" ).buttonset();



$( \"#tabs\" ).tabs();



$( \"#dialog\" ).dialog({
	autoOpen: false,
	width: 400,
	buttons: [
		{
			text: \"Ok\",
			click: function() {
				$( this ).dialog( \"close\" );
			}
		},
		{
			text: \"Cancel\",
			click: function() {
				$( this ).dialog( \"close\" );
			}
		}
	]
});

// Link to open the dialog
$( \"#dialog-link\" ).click(function( event ) {
	$( \"#dialog\" ).dialog( \"open\" );
	event.preventDefault();
});



$( \"#datepicker\" ).datepicker({
			changeMonth: true,
			changeYear: true
});



$( \"#slider\" ).slider({
	range: true,
	values: [ 17, 67 ]
});



$( \"#progressbar\" ).progressbar({
	value: 20
});



$( \"#spinner\" ).spinner();



$( \"#menu\" ).menu();



$( \"#tooltip\" ).tooltip();



$( \"#selectmenu\" ).selectmenu();


// Hover states on the static widgets
$( \"#dialog-link, #icons li\" ).hover(
	function() {
		$( this ).addClass( \"ui-state-hover\" );
	},
	function() {
		$( this ).removeClass( \"ui-state-hover\" );
	}
);
</script>
<script type=\"text/javascript\" src=\"".$h."js/table/script.js\"></script>
	<script type=\"text/javascript\">
	var sorter = new TINY.table.sorter('sorter','table',{
		headclass:'head',
		ascclass:'asc',
		descclass:'desc',
		evenclass:'evenrow',
		oddclass:'oddrow',
		evenselclass:'evenselected',
		oddselclass:'oddselected',
		paginate:true,
		size:20,
		colddid:'columns',
		currentid:'currentpage',
		totalid:'totalpages',
		startingrecid:'startrecord',
		endingrecid:'endrecord',
		totalrecid:'totalrecords',
		hoverid:'selectedrow',
		pageddid:'pagedropdown',
		navid:'tablenav',
		sortcolumn:0,
		sortdir:0,		
		columns:[{index:7, format:'%', decimals:1},{index:8, format:'$', decimals:0}],
		init:true
	});
  </script>

";
}

function ui_head() {
$h="http://".$_SERVER['HTTP_HOST']."/user_login/";
echo "<link href='".$h."js/ui/jquery-ui.css' rel='stylesheet'>
<script src='".$h."js/ui/external/jquery/jquery.js'></script>
<script src='".$h."js/ui/jquery-ui.js'></script>
<link href='".$h."js/table/style.css' rel='stylesheet'>
<style>
a, * a {cursor: pointer;}
</style>
<script>
function createRequest(){ 
        var oAJAX = false;

        try {
          oAJAX = new ActiveXObject(\"Msxml2.XMLHTTP\");
        } catch (e) {
          try {
             oAJAX = new ActiveXObject(\"Microsoft.XMLHTTP\");
          } catch (e2) {
             oAJAX = false;
          }
        }

        
        if (!oAJAX && typeof XMLHttpRequest != 'undefined') {
            oAJAX = new XMLHttpRequest();
        }

        if (!oAJAX){
           alert(\"Error saat membuat XMLHttpRequest!\");
        }        
        return oAJAX;
}

function requestContent(link,area){
  oRequest = createRequest();
  var url = link;
var areanya = area;
  // Buka komunikasi dengan server
  oRequest.open(\"GET\", url, true);

  // menunggu respon dari server
  oRequest.onreadystatechange = function () {                                                                                                                     
      document.getElementById(areanya).innerHTML=
      \"Loading...\";                                                           

      if (oRequest.readyState == 4) {
		  // baca data respon dari server                                                                        	  
		  var response = oRequest.responseText;
		  document.getElementById(areanya).innerHTML = response;                                                             
      }
  }

  // Send the request
  oRequest.send(null);
}
</script>

<script src='".$h."js/nicedit/nicEdit.js' type='text/javascript'></script>
<script type=\"text/javascript\">
bkLib.onDomLoaded(function() {
	new nicEditor({iconsPath : '".$h."js/nicedit/nicEditorIcons.gif',fullPanel : true}).panelInstance('area2');
});
</script>

";
}


function nama_hari($tgl) {
      $d=date('D', strtotime($tgl));
  return $d;
}

function nama_hari_id($tgl) {
      $d=date('D', strtotime($tgl));
	  	  $dayList = array(
	'Sun' => 'Minggu',
	'Mon' => 'Senin',
	'Tue' => 'Selasa',
	'Wed' => 'Rabu',
	'Thu' => 'Kamis',
	'Fri' => 'Jumat',
	'Sat' => 'Sabtu' );
	  	  
  return $dayList[$d];
}

function tgl_aju($tgl) {
if ($tgl=="2017-08-16") {$tgl="2017-08-17";}
$timestamp = strtotime($tgl);
$day = date('w', $timestamp);
//var_dump($day);
if ($day=="5") {$next_date = date('Y-m-d', strtotime($tgl .' +3 day'));} elseif ($day=="6") {$next_date = date('Y-m-d', strtotime($tgl .' +2 day'));} else  {$next_date = date('Y-m-d', strtotime($tgl .' +1 day'));} 
return $next_date;
}

function daerah($kota) {
  if (strstr($kota,"Jakarta")) { return "dalam daerah"; } else { return "luar daerah"; }
}

function checked($n) {
if ($n>0) {return "checked";}	
}

function data_sama($s,$d) {
	
if ($s==$d) {return "1";}	
}

function jam($tgl) {
return substr ($tgl, 11, 5);
}

function tglnya($wkt) {
return substr ($wkt, 0, 10);
}
function jamnya($wkt) {
return substr ($wkt, 11, 5);
}

function tglnumonly($tgl) {
$tgl=str_replace(".","",$tgl);
$tgl=str_replace(":","",$tgl);
$tgl=str_replace(" ","",$tgl);
$tgl=str_replace("-","",$tgl);
return $tgl;
}





