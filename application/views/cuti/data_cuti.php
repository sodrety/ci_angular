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


<!-- Main content -->

<section class="content">

	<?php if($this->uri->segment('2')==''){ ?>
		<div class="callout callout-success">
			<h4>Perhatian</h4>

			<p>Sisa Cuti yang anda miliki adalah <b><?php echo $total;?></b> </p>
		</div>
		<?php foreach ($data_cuti as $k) {
				if ($k->status==1) {?>
		<div class="callout callout-info">
			<h4>Perhatian</h4>

			<p>Hubungi Pihak Kepegawaian Untuk Mempercepat Proses</p>
		</div>
		<?php }elseif ($k->status==6) {?>
			<div class="callout callout-info">
			<h4>Perhatian</h4>

			<p>Hubungi Pihak Yang Diminta Rekomendasi Untuk Mempercepat Proses</p>
		</div>
	<?php } } }?>
        <div class="box">
            <?php if ($this->uri->segment('2')=='') { ?>
                <div class="box-header with-border">
                    <a href="<?php echo site_url('data_cuti/ajukanCuti');?>" class="btn btn-primary btn-lg" id="ajukanBtn" data-toggle="modal">Ajukan Cuti</a>
                </div>
            <?php }else{ ?>

            <?php } ?>
            <!-- silahkan print <a href='<?php echo site_url('data_cuti/doprint');?>'>print sekarang</a> -->
            <div class="box-body">
              <div style="overflow-x:auto;">
                <table class="table table-responsive table-stripped table-scrollable" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pemohon Cuti</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Cuti</th>
                            <th>Jenis Cuti</th>
                            <th>Jumlah Cuti</th>
                            <th>Atasan</th>
                            <th>Status</th>
                            <?php if ($this->uri->segment(2)=='') {?>
                            <th>Alasan Tolak</th>

                            <?php } ?>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($data_cuti as $k) { ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <!-- <td><?php echo $nama;?></td> -->
                            <td><?php echo $k->nama_karyawan;?></td>
                            <td><?php echo $k->created_date;?></td>
                            <td><?php echo $k->tanggal_mulai;?></td>
                            <td><?php echo $k->jenis_cuti;?></td>
                            <td class="text-center"><?php echo $k->jumlah_cuti;?>&nbsp<?php echo $k->nama_satuan;?></td>
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
                                <td>Menunggu Rekomendasi 2</td>
                            <?php } ?>
                            <?php if($k->status==7){?>
                                <td>Rekomendasi Diterima</td>
                            <?php } ?>
                            <?php if($k->status==8){?>
                                <td>Rekomendasi Ditolak</td>
                            <?php } ?>
                            <?php if($k->status==9){?>
                                <td>Menunggu Rekomendasi 1</td>
                            <?php } ?>
							<?php if($k->status==10){?>
                                <td>Menunggu Rekomendasi 3</td>
                            <?php } ?>
                            <?php if ($this->uri->segment(2)=='') { ?>
                                <td><?php echo $k->alasan_tolak;?> <?php echo $controller->alasanTolak($k->id_tolak);?></td>

                            <?php } ?>
                            <td class="text-center" width="150px">
                                <?php if ($k->status==6) {
                                    if ($this->session->userdata('user_id')==$k->id_rekom) { ?>
                                    <a class="btn btn-success" title="Setujui Rekomendasi 1" onclick="konfira(<?php echo $k->id_cuti;?>,<?php echo $k->status;?>,<?php echo $k->id_rekom3;?>);return false;"><i class="fa fa-check"></i></a>
                                <?php }  } ?>
                                <?php if ($k->status==9) {
                                    if ($this->session->userdata('user_id')==$k->id_rekom2) { ?>
                                    <a class="btn btn-success" title="Setujui Rekomendasi 2" onclick="konfira(<?php echo $k->id_cuti;?>,<?php echo $k->status;?>,<?php echo $k->id_rekom3;?>);return false;"><i class="fa fa-check"></i></a>
                                <?php }  } ?>
                                <?php if ($k->status==10) {
                                    if ($this->session->userdata('user_id')==$k->id_rekom3) { ?>
                                     <a class="btn btn-success" title="Setujui Rekomendasi 3" onclick="konfira(<?php echo $k->id_cuti;?>,<?php echo $k->status;?>,<?php echo $k->id_rekom3;?>);return false;"><i class="fa fa-check"></i></a>
                                <?php }  } ?>
                                <?php if ($k->id_atasan==$nama){?>
                                    <?php if ($k->status==2) { ?>
									<a href="<?php echo site_url('data_cuti');?>/approve/<?php echo $k->id_cuti;?>" class="btn btn-success" title="Terima Pengajuan"><i class="fa fa-check" ></i></a>
                                    <a href="" title="Tolak Pengajuan" class="btn btn-danger" onclick="tolak(<?php echo $k->id_cuti;?>);return false;"><i class="fa fa-times"></i></a>
                                <?php } } ?>
                                <?php if ($this->uri->segment('2')=='') {
                                    if ($k->status==1) { ?>
                                        <a class="btn btn-primary" href="<?php echo site_url('data_cuti');?>/edit/<?php echo $k->id_cuti;?>"><i class="fa fa-edit"></i></a>
                                    <?php } ?>
                                    <?php if ($k->status==6) { ?>
                                         <a class="btn btn-primary" href="<?php echo site_url('data_cuti');?>/edit/<?php echo $k->id_cuti;?>"><i class="fa fa-edit"></i></a>
                                    <?php } ?>
                                    <?php if ($k->status==9) { ?>
                                         <a class="btn btn-primary" href="<?php echo site_url('data_cuti');?>/edit/<?php echo $k->id_cuti;?>"><i class="fa fa-edit"></i></a>
                                    <?php } ?>
                                <?php  } ?>

							    <?php if ($k->id_pejabat==$nama){?>
                                <?php if ($k->status==3) { ?>
                                    <a href="" onclick="terimaCuti(<?php echo $k->id_cuti?>,<?php echo $k->jumlah_cuti?>,<?php echo $k->id_pegawai?>,<?php echo $k->id_jeniscuti?>);return false;" class="btn btn-success" title="Terima  "><i class="fa fa-check"></i></a>
                                    <a href="" class="btn btn-danger" title="Tolak Pengajuan" onclick="tolak(<?php echo $k->id_cuti;?>);return false;"><i class="fa fa-times"></i></a>
                                <?php } }?>
								<div id="terimaModal" class="modal fade" role="dialog"> </div>
								<div id="tolakModal" class="modal fade" role="dialog"> </div>
								<div id="rekomModal" class="modal fade" role="dialog"> </div>
                                <?php if ($k->status==5) { ?>
                                    <a class="btn btn-danger" title="Perbaiki Permohonan Cuti" href="<?php echo site_url('data_cuti');?>/edit/<?php echo $k->id_cuti;?>"><i class="fa fa-edit"></i></a>
                                <?php } ?>
                                <?php if ($k->status==8) {?>
                                     <a class="btn btn-danger" title="Perbaiki Permohonan Cuti" href="<?php echo site_url('data_cuti');?>/edit/<?php echo $k->id_cuti;?>"><i class="fa fa-edit"></i></a>
                                <?php } ?>
                				<a href="<?php echo site_url('data_cuti');?>/detail/<?php echo $k->id_cuti;?>" title="Detail" class="btn btn-info"><i class="fa fa-bars"></i></a>
                				<?php if($k->status==4){?>
                				<a href="<?php echo site_url('data_cuti');?>/printCuti/<?php echo $k->id_cuti;?>" target="_blank" title="Print" class="btn btn-danger"><i class="fa fa-print"></i></a>
                				<?php } ?>
                                <!--<a href="<?php echo site_url('data_cuti');?>/hapus/<?php echo $k->id_cuti;?>" title="Detail" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                <a data-toggle="modal" onclick="myFunction(<?php echo $k->id_cuti; ?>)">test</a> -->
                            </td>
                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>
              </div>
            </div>
        </div>
    </div>


<!-- Modal -->
<div id="tambahCuti" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header with-border">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Form Pengajuan Cuti</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="<?php echo site_url('data_cuti/tambahCuti'); ?>" method="post" enctype="multipart/form-data">
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
                    <input type="text" class="form-control" name="unit" value="BBKP Tanjung Priok" readonly>
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
                    <input type="number" class="form-control" name="jumlah" onchange="jumlahCuti(this.value)" id="jumlah_cuti" placeholder="Jumlah" required>
                </div>
                <div class="col-md-2">
                    <select class="form-control" name="satuan" required>
                        <?php foreach ($satuan_cuti as $satuan) { ?>
                            <option value="<?php echo $satuan->id_cutisatuan; ?>"><?php echo $satuan->nama_satuan; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <label class="col-md-1">Rentang</label>
                <!-- <div class="col-md-3">
                    <input type="text" class="form-control" name="tglmulai" required>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="tglakhir" required>
                </div> -->

                <div class="col-md-6">
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right reservation" id="reservation" name="rentang">
                    </div>
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
            <?php if($k->kode_jab=='fk'){ ?>
            <div class="form-group" id="div_rekom">
                <label class="col-md-2">Rekomendasi</label>
                <div class="col-md-4">
                    <select class="form-control select2" name="rekom" style="width: 100%;" required>
                        <?php foreach ($allKaryawan as $all) { ?>
                            <option value=""></option>
                            <option value="<?php echo $all->id; ?>"><?php echo $all->nama; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
			<?php } ?>
            <!-- <input type="checkbox" name="rek" onclick="showMe('div_rekom')"> -->
            <div class="form-group">
                <label class="col-md-2">Atasan Yang Dituju</label>
                <div class="col-md-4">
                    <select class="form-control select2" name="atasan" style="width: 100%;" required>
                        <?php foreach ($KaryawanLike as $al) { ?>
                            <option value="<?php echo $al->id; ?>"><?php echo $al->nama; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2">Pejabat Yang Berwenang</label>
                <div class="col-md-4">
                    <select class="form-control select2" name="pejabat" style="width: 100%;" required>
                        <?php foreach ($pejabat as $all) { ?>
                            <option value="<?php echo $all->id_pegawai; ?>"><?php echo $all->nama; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-1">Alasan</label>
                <div class="col-md-5">
                    <input type="text" id="datepicker2" class="form-control">
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
<script >
var serverDate = '<?= date('m-d-Y')?>';

var str = serverDate.toString();
var serverDates = str.split('-').join('/');
var dd = serverDates.substr(3,2)-5;
var year = serverDates.substr(6,10);
var mm = serverDates.substr(0,2);
var dateDiff = new Date - serverDate;
console.log('asd',dd);
// var tanggal = new Date();
// var dd = tanggal.getDate();
// var dds = tanggal.getDate()-5;
// var mm = tanggal.getMonth()+1; //January is 0!
// var yyyy = tanggal.getFullYear();
// if(dd<10) {
//     dd = '0'+dd
// }
//
// if(mm<10) {
//     mm = '0'+mm
// }
var today = serverDates;
var limitDate = mm + '/' + dd + '/' + year;
// var diff = today-limitDate;
console.info("tanggal",dd);


$(function(){
    $('#table1').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true
    });
});

$(function () {
    $("#datepicker").datepicker( {
		autoclose: true,
		format: "mm-yyyy",
		startView: "months",
		minViewMode: "months"
	});
    $("#datepicker2").datepicker( {
		autoclose: true,
		format: "mm-yyyy",
		startView: "months",
		minViewMode: "months"
	});
});

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

function jumlahCuti(jml){
    console.info(jml);
    coba(jml);
};

// function limitTanggal(limit){
//     console.log(limit);
//     var lama = document.getElementById('jumlah_cuti').value;
//     console.info(lama);
//     $('#reservation').daterangepicker({
//         "dateLimit": {
//             "days": 7
//         },
//         "linkedCalendars": false,
//         "autoUpdateInput": false,
//         "showCustomRangeLabel": false
//     }, function(start, end, label) {
//       console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
//     });
// }

function coba(jml) {
    var lama = document.getElementById('jumlah_cuti').value;
    // console.info("lama"+jml);
    var jumlah = Number(jml)-1;
    var dateMin = today-2;
    console.info(jumlah);
    $('#reservation').daterangepicker({
	"minDate":limitDate,
  "startDate":today,
        "linkedCalendars": false,
        "showCustomRangeLabel": false,
        "container": '#tambahCuti',
        "alwaysShowCalendars": true,
        locale: {
                format: 'YYYY-MM-DD'
            }
    },
     function(start, end, label) {
      console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ' '+jumlah+')');
    });
};


function tolak(id){
    //alert('gabus');
    var tb = "";
    tb+="<div class=\"modal-dialog \" role=\"document\">";
    tb+="<div class=\"modal-content modal-conten\" style=\"\">";

    tb+="<div class=\"modal-header\">";
    tb+="<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Tutup\"><span aria-hidden=\"true\"><strong>&times;</strong></span></button>";
    tb+="<h4 class=\"modal-title\">Alasan Penolakan</h4>";
    tb+="</div>";

    tb+="<div class=\"modal-body\">";

    tb+="<div class=\"modal-content\">";
    tb+="<form class=\"form-horizontal\" action=\"<?php echo site_url('data_cuti/tolakCuti'); ?>\" method=\"post\">";

    tb+="<div class=\"form-group\">";
    tb+="<div class=\"col-md-12\">";
    tb+="<input type=\"hidden\" name=\"id\" value=\""+id+"\">";
    tb+="<textarea name=\"alasan\" class=\"form-control\" required></textarea>";
    tb+="</div>";
    tb+="</div>";

    tb+="<div class=\"modal-footer\">";
    tb+="<button type=\"submit\" class=\"btn btn-danger\">Tolak</button>";
	//tb+="<a href=\"<?php echo site_url('data_cuti/tolakCuti');?>/"+id+"/\" type=\"button\" class=\"btn btn-danger\">Tolak Rekomendasi</a>";
    tb+="</div>";

    tb+="</div>";
    tb+="</div>";
    tb+="</form>";
    tb+="</div>";
    document.getElementById("tolakModal").innerHTML = tb ;
	//alert(tb);
    $("#tolakModal").modal("show");

};

function terimaCuti(id,jumlah,id_pegawai,id_jenis){
    //alert('coba ath bray');
    var tb = "";
    origin_id="";
    tb+="<div class=\"modal-dialog \" role=\"document\">";
    tb+="<div class=\"modal-content modal-conten\" style=\"\">";

    tb+="<div class=\"modal-header\">";
    tb+="<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Tutup\"><span aria-hidden=\"true\"><strong>&times;</strong></span></button>";
    tb+="<h4 class=\"modal-title\">Terima Pengajuan ?</h4>";
    tb+="</div>";

    tb+="<div class=\"modal-body\">";

    tb+="<div class=\"modal-content\">";
    tb+="<form class=\"form-horizontal\" action=\"<?php echo site_url('data_cuti/approvePejabatBaru'); ?>\" method=\"post\">"

    tb+="<div class=\"form-group\">";
    tb+="<div class=\"col-md-12\">";
    tb+="<input type=\"hidden\" name=\"id\" value=\""+id+"\">";
    tb+="<input type=\"hidden\" name=\"jumlah\" value=\""+jumlah+"\">";
    tb+="<input type=\"hidden\" name=\"id_pegawai\" value=\""+id_pegawai+"\">";
    tb+="<input type=\"hidden\" name=\"id_jenis\" value=\""+id_jenis+"\">";
    tb+="</div>";
    tb+="</div>";

    tb+="<div class=\"modal-footer\">";
    tb+="<button type=\"submit\" class=\"btn btn-success\">Setuju</button>";
	//tb+="<a href=\"<?php echo site_url('data_cuti/tolakCuti');?>/"+id+"/\" type=\"button\" class=\"btn btn-danger\">Tolak Rekomendasi</a>";
    tb+="</div>";

    tb+="</div>";
    tb+="</div>";
    tb+="</form>";

    tb+="</div>";

    document.getElementById("terimaModal").innerHTML = tb ;
	//alert(tb);

    $("#terimaModal").modal("show");

};
function konfira(id,status,kh){
    // alert(kh);
    var tb = "";
    tb+="<div class=\"modal-dialog \" role=\"document\">";
    tb+="<div class=\"modal-content modal-conten\" style=\"\">";

    tb+="<div class=\"modal-header\">";
    tb+="<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Tutup\"><span aria-hidden=\"true\"><strong>&times;</strong></span></button>";
    tb+="<h4 class=\"modal-title\">Proses Rekomendasi </h4>";
    tb+="</div>";

    tb+="<div class=\"modal-body\">";

    tb+="<div class=\"modal-content\">";
    tb+="<form class=\"form-horizontal\" action=\"<?php echo site_url('data_cuti/terimaRekom'); ?>\" method=\"post\">";

    tb+="<div class=\"form-group\">";
    tb+="<div class=\"col-md-12\">";
    tb+="<input type=\"hidden\" name=\"id\" value=\""+id+"\">";
    tb+="<input type=\"hidden\" name=\"status\" value=\""+status+"\">";
    tb+="<input type=\"hidden\" name=\"kh\" value=\""+kh+"\">";
    tb+="</div>";
    tb+="</div>";

    tb+="<div class=\"modal-footer text-center\">";
    tb+="<a href=\"<?php echo site_url('data_cuti/tolakRekom');?>/"+id+"/\" type=\"button\" class=\"btn btn-danger\">Tolak Rekomendasi</a>";
    tb+="<button type=\"submit\" class=\"btn btn-success\">Terima Rekomendasi</button>";
    tb+="</div>";

    tb+="</div>";
    tb+="</div>";
    tb+="</form>";
    tb+="</div>";
    document.getElementById("rekomModal").innerHTML = tb ;
    $("#rekomModal").modal("show");
};

</script>
</section><!-- /.content -->


<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>
