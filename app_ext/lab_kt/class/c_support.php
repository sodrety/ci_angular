<?php
class sup {

function no_srt_kirim($id,$ll) {
$kirim_tgl=app_baca("uji","id='".$id."' ","kirim_tgl");
if ($id=="") {$no="/M-OPTK/".$ll."/".date("m")."/".date("Y");} else {$no= "/MP-OPTK/".$ll."/".bln_thn_no($kirim_tgl);}
return $no;
}


}
