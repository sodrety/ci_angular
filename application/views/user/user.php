<?php
$this->load->view('template/head'); ?>
<?php $this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        User Management
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cuti</li>
    </ol>
</section>

<section class="content">
		<div class="box">
      <div class="box-header">
        <button class="btn btn-success pull-right" placeholder="Tambah Karyawan" data-toggle="modal" data-target="#myModal">Tambah Pegawai </button>
      </div>
			<div class="box-body">
				<table class="table table-responsive table-stripped" id="table1">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>NIP</th>
							<th>Jabatan</th>
							<th>Golongan</th>
              <th>Username</th>
							<th width="10%">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; foreach($karyawan as $k){ ?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo $k->nama;?></td>
							<td><?php echo $k->nip;?></td>
							<td><?php echo $k->jabatan;?></td>
							<td><?php echo $k->golongan;?></td>
							<td><?php echo $k->username;?></td>
							<td>
								<a href="<?php echo site_url('user') ?>/edit/<?php echo $k->id?>" type="button" class="btn btn-md btn-primary"><i class="fa fa-edit"></i></a>
								<a href="<?php echo site_url('user') ?>/hapus/<?php echo $k->id?>" type="button" class="btn btn-md btn-danger"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
						<?php $no++; } ?>
					</tbody>
				</table>
			</div>
		</div>


    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modal Header</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" action="<?php echo site_url('user/tambahPegawai'); ?>" method="post" enctype="multipart/form-data">

                <div class="form-group">
                <label class="col-md-3">NIP</label>
                  <div class="col-md-9">
                    <input type="hidden" class="form-control" name="id" >
                    <input type="text" class="form-control" name="nip">
                  </div>
                </div>
                <div class="form-group">
                <label class="col-md-3">Nama</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="nama" required>
                  </div>
                </div>
                <div class="form-group">
                <label class="col-md-3">Pangkat</label>
                  <div class="col-md-9">
                    <select class="form-control" name="pangkat">
                      <option value=""></option>
                      <?php foreach ($gol as $g){ ?>
                      <option value="<?php echo $g->gol;?>"><?php echo $g->gol;?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                <label class="col-md-3">Jabatan</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="jabatan" >
                  </div>
                </div>
                <div class="form-group">
                <label class="col-md-3">HP</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="hp" required>
                  </div>
                </div>
                <div class="form-group">
                <label class="col-md-3">Email</label>
                  <div class="col-md-9">
                    <input type="email" class="form-control" name="email">
                  </div>
                </div>
                <div class="form-group">
                <label class="col-md-3">WhatsApp</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="wa">
                  </div>
                </div>
                <div class="form-group">
                <label class="col-md-3">Username </label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="username" required>
                  </div>
                </div>
                <div class="form-group">
                <label class="col-md-3">Password</label>
                  <div class="col-md-9">
                    <input type="password" class="form-control" name="password" required>
                  </div>
                </div>
                <div class="form-group">
                <label class="col-md-3">Ulangi Password</label>
                  <div class="col-md-9">
                    <input type="password" class="form-control" name="ul_password" required>
                  </div>
                </div>
                <div class="form-group">
                <label class="col-md-3">Bidang</label>
                  <div class="col-md-9">
                    <input type="radio" name="bid" value="0">Tumbuhan
                    <input type="radio" name="bid" value="1">Hewan
                  </div>
                </div>
                <div class="form-group">
                <label class="col-md-3">Bagian</label>
                  <div class="col-md-9">
                    <input type="radio" name="bag" value="st">Umum
                    <input type="radio" name="bag" value="fk">Fungsional
                  </div>
                </div>
              </div>
              <div class="modal-footer">
              <button type="submit" class="btn btn-success">Simpan</button>
              </div>
            </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>


</section>
<script>
$(function(){
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
