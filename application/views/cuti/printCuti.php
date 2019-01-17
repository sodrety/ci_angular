<?php $this->load->view('template/head'); ?>

<style type="text/css">

#printableArea{
}

</style>

<div id="printableArea">

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
	height:100px;
	vertical-align:bottom;
	text-align:center;
	padding:3px;
}
#hormat{
	height:100px;
	vertical-align:top;
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
                            <td>Keterangan</td>
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
                            <td width="10%">TELP/HP</td>
			    <?php foreach($detail as $k){?>
                            <td width="20%"><?php echo $k->hp;?></td>
			    <?php } ?>
                        </tr>
                        <tr>
                            <td><?php echo $p->alamat_cuti;?></td>
                            <td colspan="2" class="text-center" id="hormat">
				<p>Hormat Saya</p><br>
				<p><?php echo $p->nama_karyawan;?>
                                NIP.<?php echo $p->nip_karyawan;?></p>
                            </td>
                        </tr>
                    </table>
                    <table class="printerx" >
                        <tr>
                            <th colspan="2">VII. PERTIMBANGAN ATASAN LANGSUNG</th>
                        </tr>
                        <tr>
                            <td colspan="2">Disetujui</td>
                        </tr>
                        <tr>
                            <td style="border: none;width: 70%;"></td>
                            <td id="ttd">
							<?php if($p->id_pejabat!=368){?>
								<img src="<?php echo base_url('media/ttd');?>/<?php echo $p->id_atasan?>.png"><br>
                                <?php echo $p->nama_atasan;?>
                                <p>NIP.<?php echo $p->nip_atasan;?></p>
							</td>
							<?php }else{} ?>
                        </tr>
                    </table>
                    <table class="printerx" >
                        <tr>
                            <th colspan="2">VIII. KEPUTUSAN PEJABAT YANG BERWENANG</th>
                        </tr>
                        <tr>
                            <td colspan="2">Disetujui</td>
                        </tr>
                        <tr>
                            <td style="border: none;width: 70%;"></td>
                            <td id="ttd">
							<?php if($p->id_pejabat!=368){?>
							<img src="<?php echo base_url('media/ttd');?>/<?php echo $p->id_pejabat?>.png"><br>
							<?php echo $p->nama_pejabat;?>
											<p>NIP.<?php echo $p->nip_pejabat;?></p>
							<?php }else{
								
							} ?>
							</td>
                        </tr>
                    </table><br>
                    <img src="<?php echo site_url('barcode/ca_barcode');?>/<?php echo $bar; ?>" style="width:150px;">
                </div>
                <?php } ?>


            </div>
<script>
window.print();
</script>
