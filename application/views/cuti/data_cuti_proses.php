<?php
$this->load->view('template/head'); ?>
<?php $this->load->view('template/topbar');
$this->load->view('template/sidebar');

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Cuti
        <small>Proses Cuti</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('data_cuti');?>"> Home</a></li>
        <li class="active">Cuti</li>
    </ol>
</section>


<!-- Main content -->

<section class="content">
        <div class="box">
            <div class="box-body">
              <div style="overflow-x:auto;">
                <table class="table table-responsive table-stripped table-hover" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pemohon Cuti</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Cuti</th>
                            <th>Jenis Cuti</th>
                            <th>Jumlah Hari</th>
                            <th>Atasan</th>
                            <th>Status</th>
                            <th class="text-center" width="80px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($data_cuti_proses as $k) { ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <!-- <td><?php echo $nama;?></td> -->
                            <td><?php echo $k->nama_karyawan;?></td>
                            <td><?php echo $k->created_date;?></td>
                            <td><?php echo $k->tanggal_mulai;?></td>
                            <td><?php echo $k->jenis_cuti;?></td>
                            <td><?php echo $k->jumlah_cuti;?>&nbsp<?php echo $k->nama_satuan;?></td>
                            <td><?php echo $k->nama_atasan;?></td>
                            <?php if($k->status==1){?>
                                <td>Menunggu Konfirmasi Kepegawaian</td>
                            <?php } ?>
                            <?php if($k->status==2){?>
                                <td>Menunggu Konfirmasi Atasan Langsung</td>
                            <?php } ?>
                            <?php if($k->status==3){?>
                                <td>Menunggu Konfirmasi Pejabat Berwenang</td>
                            <?php } ?>
                            <?php if($k->status==4){?>
                                <td>Selesai</td>
                            <?php } ?>
                            <?php if($k->status==5){?>
                                <td>Ditolak</td>
                            <?php } ?>
                            <?php if($k->status==6){?>
                                <td>Menunggu Rekomendasi</td>
                            <?php } ?>
                            <?php if($k->status==7){?>
                                <td>Rekomendasi Diterima 2</td>
                            <?php } ?>
                            <?php if($k->status==8){?>
                                <td>Rekomendasi Ditolak</td>
                            <?php } ?>
                            <?php if($k->status==9){?>
                                <td>Menunggu Rekomendasi 1</td>
                            <?php } ?>
                            <td class="text-center">
                                <?php if ($k->id_atasan==$nama){?>
                                    <button class="btn btn-success" title="Terima Pengajuan"><i class="fa fa-check" ></i></button>
                                <?php  } ?>
                                <!-- <a href="<?php echo site_url('data_cuti');?>/hapus/<?php echo $k->id_cuti;?>" title="Detail" class="btn btn-danger"><i class="fa fa-trash"></i></a> -->
                                <a href="<?php echo site_url('data_cuti/lengkapi');?>/<?php echo $k->id_cuti;?>/<?php echo $k->id_pegawai;?>" title="Lengkapi" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                <a href="<?php echo site_url('data_cuti/hapusCuti');?>/<?php echo $k->id_cuti;?>" title="Batalkan" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>
              </div>
            </div>
        </div>


<!-- Modal -->
<div id="tambahCuti" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header with-border">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Form Pengajuan Cuti</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="<?php echo site_url('index.php/data_cuti/tambahCuti'); ?>" method="post" enctype="multipart/form-data">
            <?php foreach ($karyawan as $k ) { ?>
            <div class="form-group">
                <label class="col-md-1">Nama</label>
                <div class="col-md-5">
                    <input type="hidden" name="id_pegawai" value="<?php echo $k->id; ?>">
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
                    <input type="text" class="form-control" name="jabatan" value="<?php echo $k->jabatan;?>" readonly>
                </div>
                <label class="col-md-1">Golongan</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="golongan" value="<?php echo $k->golongan;?>" readonly>
                </div>
            </div>
            <?php } ?>
            <div class="form-group">
                <label class="col-md-1">Unit Kerja</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="unit" placeholder="" required>
                </div>
                <label class="col-md-1">Masa Kerja</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="masa" placeholder="" required>
                </div>
            </div>
            <br>
            </hr>
            <div class="form-group">
                <label class="col-md-1">Jenis Cuti</label>
                <div class="col-md-4">
                    <select class="form-control" name="jenis_cuti" required>
                        <option value=""></option>
                        <?php foreach ($jenis_cuti as $jenis) { ?>
                            <option value="<?php echo $jenis->id_jeniscuti; ?>"><?php echo $jenis->jenis_cuti ; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-1">Alasan</label>
                <div class="col-md-5">
                    <textarea class="form-control" name="alasan" required></textarea>
                </div>
            </div>
            <br>
            <br>
            <div class="form-group">
                <label class="col-md-1">Lama Cuti</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="jumlah" placeholder="Jumlah" required>
                </div>
                <div class="col-md-2">
                    <select class="form-control" name="satuan" required>
                        <!-- <option>-- Satuan --</option> -->
                        <option value="Hari">Hari</option>
                        <option value="Bulan">Bulan</option>
                        <option value="Tahun">Tahun</option>
                    </select>
                </div>
                <label class="col-md-1">Rentang</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="tglmulai" required>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="tglakhir" required>
                </div>
            </div>
            <br>
            <br>
            <div class="form-group">
                <label class="col-md-2">Alamat Selama Menjalankan Cuti</label>
                <div class="col-md-5">
                    <textarea class="form-control" name="alamat_cuti" required></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2">Atasan Yang Dituju</label>
                <div class="col-md-4">
                    <select class="form-control select2" name="atasan" required>
                        <?php foreach ($allKaryawan as $all) { ?>
                            <option value="<?php echo $all->id; ?>"><?php echo $all->nama; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Ajukan</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>
  </div>
</div>
<script>

$(document).ready(function(){
    $('#table1').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true
    });
});

// $(function() {
//     $('input[name="daterange"]').daterangepicker();
// });

$(function () {
    $('.select2').select2()
    //Date picker
    $('input[name="tglmulai"]').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    });
});
$(function () {
    //Date picker
    $('input[name="tglakhir"]').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    });
});
</script>
</section><!-- /.content -->


<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>
