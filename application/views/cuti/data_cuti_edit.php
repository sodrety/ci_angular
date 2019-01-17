<?php
$this->load->view('template/head'); ?>
<?php $this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Cuti
        <small>Permohonan Cuti</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Cuti</li>
        <li class="active">Edit CUti</li>
    </ol>
</section>
<section class="content">
	<div class="row">
            <div class="box">
                <div class="box-body">
                <?php foreach ($detail as $k) { ?>
                <?php if ($k->status==5) { ?>
                <form class="form-horizontal" action="<?php echo site_url('data_cuti/updateTolak'); ?>" method="post" enctype="multipart/form-data">
                <?php }elseif ($k->status==8) { ?>
                    <form class="form-horizontal" action="<?php echo site_url('data_cuti/updateTolak'); ?>" method="post" enctype="multipart/form-data">
                <?php }else{ ?>
            	<form class="form-horizontal" action="<?php echo site_url('data_cuti/update'); ?>" method="post" enctype="multipart/form-data">
                <?php } ?>
                        <div class="form-group">
                            <label class="col-md-1">Nama</label>
                            <div class="col-md-5">
                                <input type="hidden" name="status" value="<?php echo $k->status;?>">
                                <input type="hidden" name="id" value="<?php echo $k->id_cuti; ?>">
                                <input type="hidden" name="tgl_buat" id="tgl_buat" value="<?php echo $k->created_date; ?>">
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
                                <input type="text" class="form-control" name="masa" placeholder="" value="<?php echo $k->masa_kerja;?>" >
                            </div>
                        </div>
                        <br>
                        </hr>
                        <div class="form-group">
                            <label class="col-md-1">Jenis Cuti</label>
                            <div class="col-md-4">
                                <select class="form-control" name="jenis_cuti" ;?>">
                                    <option value=""></option>
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
                                <textarea class="form-control" name="alasan" value="<?php echo $k->alasan_cuti; ?>" ><?php echo $k->alasan_cuti; ?></textarea>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label class="col-md-1">Lama Cuti</label>
                            <div class="col-md-1">
                                <input type="text" class="form-control" name="jumlah" value="<?php echo $k->jumlah_cuti; ?>">
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="satuan">
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
                                <input type="text" class="form-control" name="tglmulai" data-date-format="yyyy/mm/dd" value="<?php echo $k->tanggal_mulai; ?>">
                            </div>
                            <label class="col-md-1">s/d</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="tglakhir" data-date-format="yyyy/mm/dd" value="<?php echo $k->tanggal_berakhir; ?>">
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label class="col-md-2">Alamat Selama Menjalankan Cuti</label>
                            <div class="col-md-5">
                                <textarea class="form-control" name="alamat_cuti" ><?php echo $k->alamat_cuti; ?></textarea>
                            </div>
                        </div>
                        <?php if ($k->id_rekom!=0) { ?>
                        <div class="form-group">
                            <label class="col-md-2">Rekomendasi 1</label>
                            <div class="col-md-4">
                                <select class="form-control select2" name="rekom2">
                                     <?php foreach ($allKaryawan as $all) {
                                        if ($all->id == $k->id_rekom2) {?>
                                            <option value="<?php echo $all->id; ?>" selected><?php echo $all->nama; ?></option>
                                        <?php }else{ ?>
                                            <option value="<?php echo $all->id; ?>"><?php echo $all->nama; ?></option>
                                     <?php } } ?>
                                </select>
                            </div>
                            <label><i>*Koordinator</i></label>
                        </div>
                        <div class="form-group" id="div_rekom">
                            <label class="col-md-2">Rekomendasi 2</label>
                            <div class="col-md-4">
                                <select class="form-control select2" name="rekom" style="width: 100%;" required>
                                  <option value=""></option>
                                  <?php foreach ($allKaryawan as $all) {

                                     if ($all->id == $k->id_rekom) {?>
                                         <option value="<?php echo $all->id; ?>" selected><?php echo $all->nama; ?></option>
                                     <?php }else{ ?>
                                         <option value="<?php echo $all->id; ?>"><?php echo $all->nama; ?></option>
                                  <?php } } ?>
                                </select>
                            </div>
                            <label><i>*Korfung</i></label>
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
							<label><i>*Kasie Yanop</i></label>
                        </div>
                       <?php } ?>
                        <?php } ?>
                        <div class="form-group">
                            <label class="col-md-2">Atasan Yang Dituju</label>
                            <div class="col-md-4">
                                <select class="form-control select2" name="atasan">
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
                                <select class="form-control select2" name="pejabat">
                                     <?php foreach ($allKaryawan as $all) {
                                        if ($all->id == $k->id_pejabat) {?>
                                            <option value="<?php echo $all->id; ?>" selected><?php echo $all->nama; ?></option>
                                        <?php }else{ ?>
                                            <option value="<?php echo $all->id; ?>"><?php echo $all->nama; ?></option>
                                     <?php } } ?>
                                </select>
                            </div>
                        </div>
						<?php if ($this->session->userdata('id_divisi')>=1){ ?>
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
						<?php }?>
                        <div class="form-group">
                            <div class="col-md-12 ">
                                <?php if ($k->status==5) { ?>
                                <button type="submit" class="btn btn-primary pull-right">Ajukan Ulang</button>
                                <?php }elseif ($k->status==8) {?>
                                    <button type="submit" class="btn btn-primary pull-right">Ajukan Ulang</button>
                                <?php }else{ ?>
                                <button type="submit" class="btn btn-primary pull-right">Edit</button>
                                <?php } ?>
                            </div>
                        </div>
						
                  </div>

                  </form>
                  <?php } ?>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
var tanggal = '<?php echo $tgl_buat;?>';
alert(tanggal);

$(function () {
	
    $('.select2').select2();
    //Date picker
    $('input[name="tglmulai"]').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
	  //startDate: '-5d'
    });

    $('input[name="tglakhir"]').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
	  //startDate: '-5d'
    });

});
</script>

<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>