<?php
require_once( '../class/class.php' );
if ($_POST) {

app_query("REPLACE INTO uji_elisa VALUES ('".$_POST['idt']."', '".$_POST['antibodi_v']."', '".$_POST['antibodi_k']."', '".$_POST['antibodi_w']."', '".$_POST['antibodi_t']."', '".$_POST['antigen_v']."', '".$_POST['antigen_k']."', '".$_POST['antigen_w']."', '".$_POST['antigen_t']."', '".$_POST['blocking_v']."', '".$_POST['blocking_k']."', '".$_POST['blocking_w']."', '".$_POST['blocking_t']."', '".$_POST['probe_v']."', '".$_POST['probe_k']."', '".$_POST['probe_w']."', '".$_POST['probe_t']."', '".$_POST['conjugate_v']."', '".$_POST['conjugate_k']."', '".$_POST['conjugate_w']."', '".$_POST['conjugate_t']."', '".$_POST['substrat_v']."', '".$_POST['substrat_k']."', '".$_POST['substrat_w']."', '".$_POST['substrat_t']."', '".$_POST['kontrol_p_abs_1']."', '".$_POST['kontrol_p_abs_2']."', '".$_POST['kontrol_p_warna_1']."', '".$_POST['kontrol_p_warna_2']."', '".$_POST['kontrol_p_kesimpulan']."', '".$_POST['kontrol_n_abs_1']."', '".$_POST['kontrol_n_abs_2']."', '".$_POST['kontrol_n_warna_1']."', '".$_POST['kontrol_n_warna_2']."', '".$_POST['kontrol_n_kesimpulan']."', '".$_POST['kontrol_b_abs_1']."', '".$_POST['kontrol_b_abs_2']."', '".$_POST['kontrol_b_warna_1']."', '".$_POST['kontrol_b_warna_2']."', '".$_POST['kontrol_b_kesimpulan']."')");
echo "REPLACE INTO uji_elisa VALUES ('".$_POST['idt']."', '".$_POST['antibodi_v']."', '".$_POST['antibodi_k']."', '".$_POST['antibodi_w']."', '".$_POST['antibodi_t']."', '".$_POST['antigen_v']."', '".$_POST['antigen_k']."', '".$_POST['antigen_w']."', '".$_POST['antigen_t']."', '".$_POST['blocking_v']."', '".$_POST['blocking_k']."', '".$_POST['blocking_w']."', '".$_POST['blocking_t']."', '".$_POST['probe_v']."', '".$_POST['probe_k']."', '".$_POST['probe_w']."', '".$_POST['probe_t']."', '".$_POST['conjugate_v']."', '".$_POST['conjugate_k']."', '".$_POST['conjugate_w']."', '".$_POST['conjugate_t']."', '".$_POST['substrat_v']."', '".$_POST['substrat_k']."', '".$_POST['substrat_w']."', '".$_POST['substrat_t']."', '".$_POST['kontrol_p_abs_1']."', '".$_POST['kontrol_p_abs_2']."', '".$_POST['kontrol_p_warna_1']."', '".$_POST['kontrol_p_warna_2']."', '".$_POST['kontrol_p_kesimpulan']."', '".$_POST['kontrol_n_abs_1']."', '".$_POST['kontrol_n_abs_2']."', '".$_POST['kontrol_n_warna_1']."', '".$_POST['kontrol_n_warna_2']."', '".$_POST['kontrol_n_kesimpulan']."', '".$_POST['kontrol_b_abs_1']."', '".$_POST['kontrol_b_abs_2']."', '".$_POST['kontrol_b_warna_1']."', '".$_POST['kontrol_b_warna_2']."', '".$_POST['kontrol_b_kesimpulan']."')";
}

