if($this->input->post('rentang')){
			$data['eksekutif'] = $this->eksekutif_model->getDataQuery("SELECT komoditas_tumbuhan.nama as nama_tum,master_negara.nama,alamat_pengirim,nama_pengirim,no_aju,tanggal,nomor,ppk_komoditas_tumbuhan.ppk_id,ppk_komoditas_tumbuhan_id,komoditas_tumbuhan.nama_en FROM 
			komoditas_tumbuhan 
			JOIN ppk_komoditas_tumbuhan_detail ON komoditas_tumbuhan.id=ppk_komoditas_tumbuhan_detail.komoditas_tumbuhan_id
			JOIN ppk_komoditas_tumbuhan ON ppk_komoditas_tumbuhan_detail.ppk_komoditas_tumbuhan_id=ppk_komoditas_tumbuhan.id
			JOIN ".$tbl." ON ppk_komoditas_tumbuhan.ppk_id=".$tbl.".ppk_id
			JOIN ppk ON ppk_komoditas_tumbuhan.ppk_id=ppk.id
			JOIN master_negara ON master_negara.id=ppk.negara_tujuan
			WHERE (komoditas_tumbuhan.nama_en LIKE '%".$kom."%' or komoditas_tumbuhan.nama LIKE '%".$kom."%') and nomor LIKE '".$tb."' order by tanggal desc");
			
		}else{
			$data['eksekutif'] = $this->eksekutif_model->getDataQuery("SELECT ".$tbl.".tanggal,komoditas_tumbuhan.nama as nama_tum,master_negara.nama,alamat_pengirim,nama_pengirim,no_aju,tanggal,nomor,ppk_komoditas_tumbuhan.ppk_id,ppk_komoditas_tumbuhan_id,komoditas_tumbuhan.nama_en FROM 
			komoditas_tumbuhan 
			JOIN ppk_komoditas_tumbuhan_detail ON komoditas_tumbuhan.id=ppk_komoditas_tumbuhan_detail.komoditas_tumbuhan_id
			JOIN ppk_komoditas_tumbuhan ON ppk_komoditas_tumbuhan_detail.ppk_komoditas_tumbuhan_id=ppk_komoditas_tumbuhan.id
			JOIN ".$tbl." ON ppk_komoditas_tumbuhan.ppk_id=".$tbl.".ppk_id
			JOIN ppk ON ppk_komoditas_tumbuhan.ppk_id=ppk.id
			JOIN master_negara ON master_negara.id=ppk.negara_tujuan
			WHERE (komoditas_tumbuhan.nama_en LIKE '%".$kom."%' or komoditas_tumbuhan.nama LIKE '%".$kom."%') and nomor LIKE '".$tb."' and ".$tbl.".tanggal>='".$tglmulaifinal."' and ".$tbl.".tanggal<='".$tglakhirfinal."' order by tanggal desc");
			
		}
		
		<div class="box box-default collapsed-box" style="width:70%;">
						<div class="box-header">
						  <!-- tools box -->
						  <div class="pull-right box-tools">
							<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
									data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
								<i class="fa fa-plus"></i></button>
							</div>
							<h3 class="box-title">
							By Komoditas
							</h3>
						</div>
						<div class="box-body">
							<div style="height: 250px; width: 100%;">
								<form class="form-horizontal" action="<?php echo site_url('eksekutif') ?>" method="post">
									<div class="form-group">
										<div class="col-md-10">
											<input type="text" class="form-control" name="kom">
											<input type="hidden" class="form-control" name="bid" value="kh">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-2">
											<input type="submit" class="btn btn-primary" value="Tampilkan">
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- /.box-body-->
						<div class="box-footer no-border">
							<div class="row">
							</div>
						  <!-- /.row -->
						</div>
					</div>