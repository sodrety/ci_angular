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
        <li class="active">Cuti</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header">
            <form class="form-horizontal" action="<?php echo site_url('user/editAkses'); ?>" method="post">
                <div class="form-group">
                    <label class="col-sm-2">Tambah/Update</label>
                    <div class="col-sm-3">
                        <select class="form-control select2" name="id" required>
                            <option value=""></option>
                            <?php foreach($allKaryawan as $k){?>
                            <option value="<?php echo $k->id?>"><?php echo $k->nama;?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select class="form-control" name="aplikasi">
                            <option value="PHYTO">Phyto</option>
                            <option value="PENUGASAN">Penugasan</option>
                            <option value="ANGGARAN">Anggaran</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select class="form-control" name="akses">
                            <option value="NONE">None</option>
                            <option value="BACA">Baca</option>
                            <option value="TULIS">Tulis</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="box-body">
            <table class="table table-responsive table-stripped" id="table1">
                <thead>
                    <tr>
                        <th witdh="10px">No</th>
                        <th>Nama</th>
                        <th>Aplikasi</th>
                        <th>Akses</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($akses as $k){ ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $k->nama;?></td>
                        <td><?php echo $k->aplikasi;?></td>
                        <td><?php echo $k->hak_akses;?></td>
                    </tr>
                    <?php $no++; } ?>
                </tbody>
            </table>
        </div>
	</div>
</section>

<script>
$(function(){
    $('.select2').select2()
    $('#table1').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true
    });
});
</script>
<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>
