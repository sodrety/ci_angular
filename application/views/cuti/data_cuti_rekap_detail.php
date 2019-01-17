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
                <a href='<?php echo site_url('data_cuti/toexcel')?>/<?php echo $tglmulai?>/<?php echo $tglakhir ?>' class="btn btn-primary">export</a>
            </div>
            <div class="box-body">
                <div class="text-center">
                    <h3>Rekap Cuti <h3>
                </div>
                <div style="overflow-x:auto;">
                <table class="table table-responsive table-stripped table-hover" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                            <th>Jenis Cuti</th>
                            <th>Jumlah Cuti</th>
                            <th>Status</th>
                            <th>Ket</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($data_cuti as $k) { ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $k->nama_karyawan;?></td>
                            <td><?php echo $k->tanggal_mulai;?></td>
                            <td><?php echo $k->tanggal_berakhir;?></td>
                            <td><?php echo $k->jenis_cuti;?></td>
                            <td class="text-center"><?php echo $k->jumlah_cuti;?>&nbsp<?php echo $k->nama_satuan;?></td>
                            <td>ptg cuti N-1 (<?php echo $k->ket_cuti_n1?>)&nbsp ptg cuti N (<?php echo $k->ket_cuti;?>)</td>
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
                            <?php if($k->status==11){?>
                                <td>Cuti Dihapus</td>
                            <?php } ?>
                            <td><a class="btn btn-primary" href="<?php echo site_url('data_cuti');?>/edit/<?php echo $k->id_cuti;?>"><i class="fa fa-edit"></i></a></td>
                            <td><a class="btn btn-danger" href="<?php echo site_url('data_cuti/hapusCuti');?>/<?php echo $k->id_cuti;?>"><i class="fa fa-edit"></i></a></td>
                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>
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


// $(function () {
//     $('#reservation').daterangepicker({
//         "linkedCalendars": false,
//         "showCustomRangeLabel": true,
//         "alwaysShowCalendars": true
//     }, function(start, end, label) {
//       console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ' '+jumlah+')');
//     });
// });

// function exportExcel(e){
//   var data = [];
//   data['tglmulai']  = '<?php echo $tglmulai ?>';
//   data['tglakhir'] = '<?php echo $tglakhir ?>';
// };

// function export(){
//     var tb = "";
//     origin_id="";
//     tb+="<div class=\"modal-dialog \" role=\"document\">";
//     tb+="<div class=\"modal-content modal-conten\" style=\"\">";

//     tb+="<div class=\"modal-header\">";
//     tb+="<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Tutup\"><span aria-hidden=\"true\"><strong>&times;</strong></span></button>";
//     tb+="<h4 class=\"modal-title\">Alasan Penolakan</h4>";
//     tb+="</div>";

//     tb+="<div class=\"modal-body\">";

//     tb+="<div class=\"modal-content\">";
//     tb+="<form class=\"form-horizontal\" action=\"<?php echo site_url('data_cuti/tolakCuti'); ?>\" method=\"post\">"

//     tb+="<div class=\"form-group\">";
//     tb+="<div class=\"col-md-12\">";
//     tb+="<input type=\"hidden\" name=\"id\" value=\""+id+"\">"
//     tb+="<input type=\"hidden\" name=\"jumlah\" value=\""+jumlah+"\">"
//     tb+="<input type=\"hidden\" name=\"id_pegawai\" value=\""+id_pegawai+"\">"
//     tb+="<textarea name=\"alasan\" class=\"form-control\" required></textarea>";
//     tb+="</div>";
//     tb+="</div>";

//     tb+="<div class=\"modal-footer\">";
//     tb+="<button type=\"submit\" class=\"btn btn-danger\">Tolak</button>";
// 	//tb+="<a href=\"<?php echo site_url('data_cuti/tolakCuti');?>/"+id+"/\" type=\"button\" class=\"btn btn-danger\">Tolak Rekomendasi</a>";
//     tb+="</div>";

//     tb+="</div>";
//     tb+="</div>";
//     tb+="</form>"
//     tb+="</div>";
//     document.getElementById("detailCuti").innerHTML = tb ;
//     $("#detailCuti").modal("show");

// }


</script>

<?php $this->load->view('template/js'); ?>
<?php $this->load->view('template/foot'); ?>
