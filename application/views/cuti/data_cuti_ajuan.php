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
        <div class="box-body">
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
                        <input type="number" class="form-control" name="jumlah" min="1" onchange="jumlahCuti(this.value)" oninput="this.value=this.value.replace(/[^0-5]/g,'');" id="jumlah_cuti" placeholder="Jumlah" required>
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
                    <label class="col-md-2">Rekomendasi 1</label>
                    <div class="col-md-4">
                        <select class="form-control select2" name="rekom2" style="width: 100%;" required>
                                <option value=""></option>
                            <?php foreach ($allKaryawan as $all) { ?>
                                <option value="<?php echo $all->id; ?>"><?php echo $all->nama; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <label><i>*Koordinator</i></label>
                </div>
                <div class="form-group" id="div_rekom">
                    <label class="col-md-2">Rekomendasi 2</label>
                    <div class="col-md-4">
                        <select class="form-control select2" name="rekom" style="width: 100%;" required>
                        <option value=""></option>
                            <?php foreach ($allKaryawan as $all) { ?>
                                <option value="<?php echo $all->id; ?>"><?php echo $all->nama; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <label><i>*Korfung</i></label>
                </div>
                <?php if ($k->status_kh==1) {?>
                <div class="form-group" id="div_rekom">
                    <label class="col-md-2">Rekomendasi 3</label>
                    <div class="col-md-4">
                        <select class="form-control select2" name="rekom3" style="width: 100%;" required>
                        <option value=""></option>
                            <?php foreach ($KaryawanLike as $al) { ?>
                                <option value="<?php echo $al->id; ?>"><?php echo $al->nama; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <label><i>*Kasie Yanop</i></label>
                </div>   
                <?php } ?>
                
          <?php } ?>
                <!-- <input type="checkbox" name="rek" onclick="showMe('div_rekom')"> -->
                <div class="form-group">
                    <label class="col-md-2">Atasan Yang Dituju</label>
                    <div class="col-md-4">
                        <select class="form-control select2" name="atasan" style="width: 100%;" required>
                            <option value=""></option>
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
                            <option value=""></option>
                            <?php foreach ($pejabat as $all) { ?>
                                <option value="<?php echo $all->id_pegawai; ?>"><?php echo $all->nama; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
          </div>
          <!-- <script></script> -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Ajukan</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        </form>
        </div>
    </div>
</section>
<script>
$(function () { $('.select2').select2()});
var serverDate = '<?= date('m-d-Y')?>';

var str = serverDate.toString();
var serverDates = str.split('-').join('/');
var dd = serverDates.substr(3,2)-5;
var year = serverDates.substr(6,10);
var mm = serverDates.substr(0,2);
// var bulan = bulan(mm);
var dateDiff = new Date - serverDate;
console.info('asd',serverDate);
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
console.info("tanggal",limits);



function jumlahCuti(jml){
    console.info(jml);
    if(jml==1){
        var limits = '<?php echo $limits;?>';
    }else{
        var limits = serverDate;
    }
    coba(jml,limits);
}

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

function coba(jml,limits) {
    var jumlah = Number(jml)-1;
    console.info(limits);
    document.getElementById("jumlah_cuti").readOnly = true;
    $('#reservation').daterangepicker({
	"minDate":limits,
	"startDate":serverDate,
        "linkedCalendars": false,
        "showCustomRangeLabel": false,
        "alwaysShowCalendars": true,
        locale: {
                format: 'YYYY-MM-DD'
            }
    },
     function(start, end, label) {
      console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ' '+jumlah+')');
    });
};
</script>

<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>
