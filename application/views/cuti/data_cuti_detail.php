<?php
$this->load->view('template/head'); ?>
<?php $this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<style type="text/css">

#printableArea *{
    font-size: 5px;
}

#print tr td {
    height: 3px;
    border: 5x solid red;
    padding: 0;
    margin: 0;
}

</style>
<section class="content-header">
    <h1>
        Cuti
        <small>Permohonan Cuti</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cuti</li>
    </ol>
</section>
<section class="content">
        <div class="box">
            <?php if ($this->uri->segment(2)=='detail'){ ?>
            <div class="box-header hide">
                <?php foreach ($detail as $k) { ?>
                    <a href="<?php echo site_url('data_cuti');?>/edit/<?php echo $k->id_cuti;?>" class="btn btn-primary">Edit</a>
                <?php } ?>
            </div>
            <?php } ?>
	<?php foreach ($detail as $k) {
		if($k->status==4){?>
            <!-- <a href="<?php echo site_url('data_cuti/printCuti');?>" class="btn btn-danger">print</a> -->
            <!--<input type="button" onclick="printDiv('printableArea')"  value="Print Cuti" />-->
        <?php } } ?>
	<div class="box-body" >
            	<?php foreach ($detail as $k) { ?>
            	<form class="form-horizontal" action="<?php echo site_url('data_cuti/lengkapiCuti'); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-md-1">Nama</label>
                            <div class="col-md-5">

                                <!-- <input type="hidden" name="id_pegawai" value="<?php echo $k->id; ?>"> -->
                                <input type="text" class="form-control" name="nama"  value="<?php echo $k->nama;?>" readonly>
                            </div>
                            <label class="col-md-1">NIP</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="nip" value="<?php echo $k->nip;?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-1">Jabatan</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="jabatan" value="<?php echo $k->jabatan_cuti;?>" readonly>
                            </div>
                            <label class="col-md-1">Golongan</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="golongan" value="<?php echo $k->golongan_cuti;?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-1">Unit Kerja</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="unit" placeholder="" value="<?php echo $k->unit_kerja;?>" readonly>
                            </div>
                            <label class="col-md-1">Masa Kerja</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="masa" placeholder="" value="<?php echo $k->masa_kerja;?>" readonly>
                            </div>
                        </div>
                        <br>
                        </hr>
                        <div class="form-group">
                            <label class="col-md-1">Jenis Cuti</label>
                            <div class="col-md-4">
                                <select class="form-control" name="jenis_cuti" readonly>
                                    <?php foreach ($jenis_cuti as $jenis) {
                                        if ($jenis->id_jeniscuti == $k->id_jeniscuti) { ?>
                                            <option value="<?php echo $jenis->id_jeniscuti; ?>" selected><?php echo $jenis->jenis_cuti ; ?></option>
                                        <?php }else{ ?>
                                         <option value="<?php echo $jenis->id_jeniscuti; ?>"><?php echo $jenis->jenis_cuti ; ?></option>
                                     <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-1">Alasan</label>
                            <div class="col-md-5">
                                <textarea class="form-control" name="alasan" value="<?php echo $k->alasan_cuti; ?>" readonly><?php echo $k->alasan_cuti; ?></textarea>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label class="col-md-1">Lama Cuti</label>
                            <div class="col-md-1">
                                <input type="text" class="form-control" name="jumlah" value="<?php echo $k->jumlah_cuti; ?>" readonly>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="satuan" readonly>
                                    <?php foreach ($satuan_cuti as $sa ) {
                                          if ($sa->id_cutisatuan == $k->id_cutisatuan) { ?>
                                                <option value="<?php echo $sa->id_cutisatuan?>" selected><?php echo $sa->nama_satuan;?></option>
                                         <?php }else{ ?>
                                                <option value="<?php echo $sa->id_cutisatuan?>"><?php echo $sa->nama_satuan;?></option>
                                    <?php } }?>

                                </select>
                            </div>
                            <label class="col-md-1">Rentang</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="tglmulai" id="tglmulai" data-date-format="yyyy/mm/dd" value="<?php echo $k->tanggal_mulai;?>" readonly>
                            </div>
                            <label class="col-md-1">s/d</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="tglakhir" id="tglakhir" data-date-format="yyyy/mm/dd" value="<?php echo $k->tanggal_berakhir;?>" readonly>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label class="col-md-2">Alamat Selama Menjalankan Cuti</label>
                            <div class="col-md-5">
                                <textarea class="form-control" name="alamat_cuti"  readonly><?php echo $k->alamat_cuti;?></textarea>
                            </div>
                        </div>
                        <?php if ($k->id_rekom!=0) {?>
                        <div class="form-group" id="div_rekom">
                            <label class="col-md-2">Rekomendasi 1</label>
                            <div class="col-md-4">
                                <select class="form-control select2" name="rekom" style="width: 100%;" required>
                                  <option value=""></option>
                                  <?php foreach ($allKaryawan as $all) {

                                     if ($all->id == $k->id_rekom2) {?>
                                         <option value="<?php echo $all->id; ?>" selected><?php echo $all->nama; ?></option>
                                     <?php }else{ ?>
                                         <option value="<?php echo $all->id; ?>"><?php echo $all->nama; ?></option>
                                  <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="div_rekom">
                            <label class="col-md-2">Rekomendasi 2</label>
                            <div class="col-md-4">
                                <select class="form-control select2" name="rekom" style="width: 100%;" required>
                                  <?php foreach ($allKaryawan as $all) {
                                     if ($all->id == $k->id_rekom) {?>
                                         <option value="<?php echo $all->id; ?>" selected><?php echo $all->nama; ?></option>
                                     <?php }else{ ?>
                                         <option value="<?php echo $all->id; ?>"><?php echo $all->nama; ?></option>
                                  <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <?php if ($k->status_kh==1) { ?>
                          <div class="form-group" id="div_rekom">
                            <label class="col-md-2">Rekomendasi 3</label>
                            <div class="col-md-4">
                                <select class="form-control select2" name="rekom3" style="width: 100%;" required>
                                  <?php foreach ($allKaryawan as $all) {
                                     if ($all->id == $k->id_rekom3) {?>
                                         <option value="<?php echo $all->id; ?>" selected><?php echo $all->nama; ?></option>
                                     <?php }else{ ?>
                                         <option value="<?php echo $all->id; ?>"><?php echo $all->nama; ?></option>
                                  <?php } } ?>
                                </select>
                            </div>
                        </div>
                       <?php } ?>
                        
                        <?php } ?>
                        <div class="form-group">
                            <label class="col-md-2">Atasan Yang Dituju</label>
                            <div class="col-md-4">
                                <select class="form-control select2" name="atasan" readonly>
                                    <?php foreach ($allKaryawan as $all) {
                                        if ($all->id == $k->id_atasan) {?>
                                            <option value="<?php echo $all->id; ?>" selected><?php echo $all->nama; ?></option>
                                        <?php }else{ ?>
                                            <option value="<?php echo $all->id; ?>"><?php echo $all->nama; ?></option>
                                     <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2">Pejabat Yang Berwenang</label>
                            <div class="col-md-4">
                                <select class="form-control select2" name="pejabat" readonly>
                                     <?php foreach ($allKaryawan as $all) {
                                        if ($all->id == $k->id_pejabat) {?>
                                            <option value="<?php echo $all->id; ?>" selected><?php echo $all->nama; ?></option>
                                        <?php }else{ ?>
                                            <option value="<?php echo $all->id; ?>"><?php echo $all->nama; ?></option>
                                     <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <?php if ($this->uri->segment('2')=='detail') { ?>
                            <div class="form-group">
                            <label class="col-md-2">Catatan Cuti</label>
                            <div class="col-md-4">
                                <input type="hidden" name="id" value="<?php echo $k->id_cuti; ?>">
                                <textarea class="form-control" name="catatan_cuti" readonly><?php echo $k->catatan_cuti ;?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <th>Tahun</th>
                                        <th>Sisa</th>
                                        <th>Keterangan</th>
                                    </tr>
                                    <tr>
                                        <td>N1</td>
                                        <td><input type="text" class="form-control" name="sisa_n1" value="<?php echo $k->sisa_cuti_n1;?>" readonly></td>
                                        <td><input type="text" class="form-control" name="ket_n1" value="<?php echo $k->ket_cuti_n1;?>" readonly></td>
                                    </tr>
                                    <tr>
                                        <td>N</td>
                                        <td><input type="text" class="form-control" name="sisa_n" value="<?php echo $k->sisa_cuti;?>" readonly></td>
                                        <td><input type="text" class="form-control" name="ket_n" value="<?php echo $k->ket_cuti;?>" readonly></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-group hide">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success pull-right">Ajukan Ke Atasan</button>
                            </div>
                        </div>
                        <?php } ?>


                        <?php if ($this->uri->segment(2)=='lengkapi') { ?>

                        <div class="form-group">
                            <label class="col-md-2">Catatan Cuti</label>
                            <div class="col-md-4">
                                <input type="hidden" name="id" value="<?php echo $k->id_cuti; ?>">
                                <textarea class="form-control" name="catatan_cuti"><?php echo $k->catatan_cuti ;?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <th>Tahun</th>
                                        <th>Sisa</th>
                                        <th>Keterangan</th>
                                    </tr>
                                    <tr>
                                        <td>N1</td>
                                        <td><input type="text" class="form-control" name="sisa_n1" value="<?php echo $sisa_n1;?>" readonly></td>
                                        <td><input type="text" class="form-control" name="ket_n1" value="<?php echo $k->ket_cuti_n1;?>" required></td>
                                    </tr>
                                    <tr>
                                        <td>N</td>
                                        <td><input type="text" class="form-control" name="sisa_n" value="<?php echo $sisa_n;?>" readonly></td>
                                        <td><input type="text" class="form-control" name="ket_n" value="<?php echo $k->ket_cuti;?>" required></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label class="col-md-2">Atasan Yang Dituju</label>
                            <div class="col-md-4">
                                <select class="form-control select2" name="atasan" required>
                                     <?php foreach ($allKaryawan as $all) {
                                        if ($all->id == $k->id_atasan) {?>
                                            <option value="<?php echo $all->id; ?>" selected><?php echo $all->nama; ?></option>
                                        <?php }else{ ?>
                                            <option value="<?php echo $all->id; ?>"><?php echo $all->nama; ?></option>
                                     <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2">Pejabat Yang Berwenang</label>
                            <div class="col-md-4">
                                <select class="form-control select2" name="pejabat" required>
                                     <?php foreach ($allKaryawan as $all) {
                                        if ($all->id == $k->id_pejabat) {?>
                                            <option value="<?php echo $all->id; ?>" selected><?php echo $all->nama; ?></option>
                                        <?php }else{ ?>
                                            <option value="<?php echo $all->id; ?>"><?php echo $all->nama; ?></option>
                                     <?php } } ?>
                                </select>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success pull-right">Ajukan Ke Atasan</button>
				<a href="" class="btn btn-danger pull-right" title="Tolak Pengajuan" onclick="tolak(<?php echo $k->id_cuti?>);return false;">Tolak Pengajuan</a>
                            </div>
                        </div>

                        <?php } ?>
                  </div>
                  </form>
                  <?php } ?>
            </div>



            <div class="box-body hide" id="printableArea">

                                <?php foreach ($detail_print as $p ) { ?>


                <div class="col-md-8" id="print">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="50%"></td>
                            <td width="50%">
                                <p class="text-center">Jakarta, &nbsp<?php echo date("Y/m/d"); ?><br>
                               Kepada<br>
                                Yth. Kepala Balai Besar Karantina Pertanian Tanjung Priok</p>
                            </td>
                        </tr>
                    </table>
                    <center>FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</center>

<style type="text/css">

.printerx{
    padding: 0;
    margin: 10px 0 0 0 ;
    border-top: 1px solid #555;
    border-right: 1px solid #555;
    width: 100%;
    border-spacing: 0;
    border-collapse: separate;
}
.printerx tr th, .printerx tr td{
    padding: 1px;
    border-left: 1px solid #555;
    border-bottom: 1px solid #555;
}
center{
    font-size: 12pt;
}
#ttd{
	height:120px;
	vertical-align:bottom;
	text-align:center;
	padding:0;
}
</style>                    <table class="printerx"  cellpadding="0" cellspacing="0">
                        <tr>
                            <th colspan="4">I. DATA PEGAWAI</th>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td><?php echo $p->nama_karyawan;?></td>
                            <td>NIP</td>
                            <td><?php echo $p->nip_karyawan;?></td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td><?php echo $p->jabatan_cuti;?></td>
                            <td>Golongan</td>
                            <td><?php echo $p->golongan_cuti;?></td>
                        </tr>
                        <tr>
                            <td>Unit Kerja</td>
                            <td><?php echo $p->unit_kerja;?></td>
                            <td>Masa Kerja</td>
                            <td><?php echo $p->masa_kerja;?></td>
                        </tr>
                    </table>
                    <table class="printerx" >
                        <tr>
                            <th>II. JENIS CUTI YANG DIAMBIL</th>
                        </tr>
                        <tr>
                            <td><?php echo $p->jenis_cuti;?></td>
                        </tr>
                    </table>
                    <table class="printerx" >
                        <tr>
                            <th>III. ALASAN CUTI</th>
                        </tr>
                        <tr>
                            <td><?php echo $p->alasan_cuti;?></td>
                        </tr>
                    </table>
                    <table class="printerx" >
                        <tr>
                            <th colspan="6">IV. LAMANYA CUTI</th>
                        </tr>
                        <tr>
                            <td width="10%">Selama</td>
                            <td width="10%"><?php echo $p->jumlah_cuti;?>&nbsp<?php echo $p->nama_satuan;?></td>
                            <td width="20%">Mulai Tanggal</td>
                            <td width="25%"><?php echo $p->tanggal_mulai;?></td>
                            <td width="10%">s/d</td>
                            <td width="25%"><?php echo $p->tanggal_berakhir;?></td>
                        </tr>
                    </table>
                    <table class="printerx" >
                        <tr>
                            <th colspan="4">V. CATATAN CUTI</th>
                        </tr>
                        <tr>
                            <td colspan="4"><?php echo $p->catatan_cuti;?></td>
                        </tr>
                        <tr>
                            <td>Tahun</td>
                            <td>Sisa</td>
                            <td>Keterangann</td>
                            <td rowspan="4"><?php echo $p->jenis_cuti;?></td>
                        </tr>
                        <tr>
                            <td>N-1</td>
                            <td><?php echo $p->sisa_cuti_n1;?></td>
                            <td><?php echo $p->ket_cuti_n1;?></td>
                        </tr>
                        <tr>
                            <td>N</td>
                            <td><?php echo $p->sisa_cuti;?></td>
                            <td><?php echo $p->ket_cuti;?></td>
                        </tr>
                        <tr>
                            <td colspan="3">Disetujui</td>
                        </tr>
                    </table>
                    <table class="printerx" >
                        <tr>
                            <th colspan="3">VI. ALAMAT SELAMA MENJALANKAN CUTI</th>
                        </tr>
                        <tr>
                            <td width="70%"></td>
                            <td>TELP/HP</td>
                            <td><?php echo $k->hp;?></td>
                        </tr>
                        <tr>
                            <td><?php echo $p->alamat_cuti;?></td>
                            <td colspan="2" class="text-center">
                                <p>Hormat Saya</p><br>
                                <p>NIP.<?php echo $p->nip_karyawan;?></p>
                            </td>
                        </tr>
                    </table>
                    <table class="printerx" >
                        <tr>
                            <th colspan="2">VII. PERTIMBANGAN ATASAN LANGSUNG</th>
                        </tr>
                        <tr>
                            <td colspan="2">Nama</td>
                        </tr>
                        <tr>
                            <td style="border: none;width: 70%;"></td>
                            <td id="ttd"><p>
				<img src="<?php echo base_url('media/ttd');?>/<?php echo $p->id_atasan?>.png">
                                <?php echo $p->nama_atasan;?>
                                NIP.<?php echo $p->nip_atasan;?></p></td>
                        </tr>
                    </table>
                    <table class="printerx" >
                        <tr>
                            <th colspan="2">VIII. KEPUTUSAN PEJABAT YANG BERWENANG</th>
                        </tr>
                        <tr>
                            <td colspan="2">Nama</td>
                        </tr>
                        <tr>
                            <td style="border: none;width: 70%;"></td>
                            <td id="ttd">
				<img src="<?php echo base_url('media/ttd');?>/<?php echo $p->id_pejabat?>.png">
				<?php echo $p->nama_pejabat;?>
                                <p>NIP.<?php echo $p->nip_pejabat;?>

                            </p></td>
                        </tr>
                    </table>
                </div>
                <?php } ?>


            </div>
        </div>
<div id="detailCuti" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">



  </div>
</div>

<div class="modal hide" id="addBookDialog">
 <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>Modal header</h3>
  </div>
    <div class="modal-body">
        <p>some content</p>
        <input type="text" name="bookId" id="bookId" value=""/>
    </div>
</div>
</section>


<script type="text/javascript">
$(function () {
    $('.select2').select2();
    //Date picker
    $('#tglmulai').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    });

});

$(function(){
    $('#tglakhir').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    });
})

function tolak(id,jumlah,id_pegawai){
    var tb = "";
    origin_id="";
    tb+="<div class=\"modal-dialog \" role=\"document\">";
    tb+="<div class=\"modal-content modal-conten\" style=\"\">";

    tb+="<div class=\"modal-header\">";
    tb+="<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Tutup\"><span aria-hidden=\"true\"><strong>&times;</strong></span></button>";
    tb+="<h4 class=\"modal-title\">Alasan Penolakan</h4>";
    tb+="</div>";

    tb+="<div class=\"modal-body\">";

    tb+="<div class=\"modal-content\">";
    tb+="<form class=\"form-horizontal\" action=\"<?php echo site_url('data_cuti/tolakCuti'); ?>\" method=\"post\">"

    tb+="<div class=\"form-group\">";
    tb+="<div class=\"col-md-12\">";
    tb+="<input type=\"hidden\" name=\"id\" value=\""+id+"\">"
    tb+="<input type=\"hidden\" name=\"jumlah\" value=\""+jumlah+"\">"
    tb+="<input type=\"hidden\" name=\"id_pegawai\" value=\""+id_pegawai+"\">"
    tb+="<textarea name=\"alasan\" class=\"form-control\" required></textarea>";
    tb+="</div>";
    tb+="</div>";

    tb+="<div class=\"modal-footer\">";
    tb+="<button type=\"submit\" class=\"btn btn-danger\">Tolak</button>";
	//tb+="<a href=\"<?php echo site_url('data_cuti/tolakCuti');?>/"+id+"/\" type=\"button\" class=\"btn btn-danger\">Tolak Rekomendasi</a>";
    tb+="</div>";

    tb+="</div>";
    tb+="</div>";
    tb+="</form>"
    tb+="</div>";
    document.getElementById("detailCuti").innerHTML = tb ;
    $("#detailCuti").modal("show");

}

</script>

<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>
