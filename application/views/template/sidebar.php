<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
	<?php //$server = $_SERVER['SERVER_ADDR']; $ipss = explode('/',$server); $ips = $ipss[0];
$client=$_SERVER['REMOTE_ADDR'];
if(substr($client,0,4)=="192.") {$ips="192.168.1.58"; $ipo="192.168.1.56";} else {$ips="122.144.1.50"; $ipo="192.168.1.56"; }
?>

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar"
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="<?php echo ($this->uri->segment(1) == 'dashboard') ? 'active' : '';?>">
                <a href="<?php echo site_url('dashboard') ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span><!--  <i class="fa fa-angle-left pull-right"> --></i>
                </a>
            </li>
<?php $key=md5(date("Ymd")); $ids=$key.$this->session->userdata('user_id').$key;  ?>
		<li><a href="#">
		<i class="fa fa-book"></i> <span>Sistem Antrian</span>
                    </i>
		  <ul class="treeview-menu">
        <li><a href="//<?php echo $ips;?>/prioqnet/app_ext/dropbox/land.php?tab=list&usr=<?php echo $ids ?>"><i class="fa fa-angle-right"></i> Dropbox</a></li>
		  </ul>
		</a>
		</li>
		<li><a href="#">
		<i class="fa fa-book"></i> <span>Administrasi Perkantoran
			<?php if (!empty($notifApproveAtasan)) {?>
			<small class="label pull-right bg-green"><?php echo $notifApproveAtasan ?></small>
			<?php } ?></span>
			<?php if (!empty($notifApprovePejabat)) {?>
			<small class="label pull-right bg-green"><?php echo $notifApprovePejabat ?></small>
			<?php } ?></span>
			<?php if (!empty($notifApproveRekom)) {?>
			<small class="label pull-right bg-blue"><?php echo $notifApproveRekom ?></small>
			<?php } ?></span>
			<?php if (!empty($notifApproveRekom2)) {?>
			<small class="label pull-right bg-blue"><?php echo $notifApproveRekom2 ?></small>
			<?php } ?></span>
			<?php if (!empty($notifApproveRekom3)) {?>
			<small class="label pull-right bg-blue"><?php echo $notifApproveRekom3 ?></small>
			<?php } ?></span>
			<?php if (!empty($notifTolak)) {?>
			<small class="label pull-right bg-red"><?php echo $notifTolak ?></small>
			<?php } ?></span>
			<?php if($this->session->userdata('id_divisi')==1){ ?>
			<?php if (!empty($notifProses)) {?>
			<small class="label pull-right bg-yellow"><?php echo $notifProses ?></small>
			<?php } } ?>
		</i>
		<ul class="treeview-menu">
		  <li><a target="_blank" href="//<?php echo $ipo;?>/user_login/app/sm/?usr=<?php echo $ids ?>"><i class="fa fa-angle-right"></i> Surat Masuk</a></li>
		  <li><a target="_blank" href="//<?php echo $ipo;?>/user_login/app/sk/?usr=<?php echo $ids ?>"><i class="fa fa-angle-right"></i> Surat Keluar</a></li>
		  <li><a target="_blank" href="//192.168.1.56/user_login/app/tugas/?usr=<?php echo $ids ?>"><i class="fa fa-angle-right"></i> Penugasan</a></li>
			<?php if ($this->session->userdata('id_divisi')>=1) { ?>
    			<li><a href="<?php echo site_url('user') ?>"><i class="fa fa-angle-right"></i> User Management</a></li>
                <?php if($this->session->userdata('user_id')==137 && $this->session->userdata('user_id')==350)?>
                <li><a href="<?php echo site_url('user/akses') ?>"><i class="fa fa-angle-right"></i> Access Management</a></li>
			<?php } ?>
            <li class="<?php echo ($this->uri->segment(1) == 'data_cuti') ? 'active' : '';?>">
                <a href="#">
                    <i class="fa fa-angle-right"></i><span> <span>Cuti Pegawai</span>
							<?php if (!empty($notifApproveAtasan)) {?>
                            <small class="label pull-right bg-green"><?php echo $notifApproveAtasan ?></small>
                            <?php } ?></span>
							<?php if (!empty($notifApprovePejabat)) {?>
                            <small class="label pull-right bg-green"><?php echo $notifApprovePejabat ?></small>
                            <?php } ?></span>
							<?php if (!empty($notifApproveRekom2)) {?>
                            <small class="label pull-right bg-blue"><?php echo $notifApproveRekom2 ?></small>
                            <?php } ?></span>
                            <?php if (!empty($notifApproveRekom)) {?>
                            <small class="label pull-right bg-blue"><?php echo $notifApproveRekom ?></small>
                            <?php } ?></span>
							<?php if (!empty($notifApproveRekom3)) {?>
                            <small class="label pull-right bg-blue"><?php echo $notifApproveRekom3 ?></small>
                            <?php } ?></span>
							<?php if (!empty($notifTolak)) {?>
                            <small class="label pull-right bg-red"><?php echo $notifTolak ?></small>
              <?php } ?></span>
							<?php if($this->session->userdata('id_divisi')==1){ ?>
							<?php if (!empty($notifProses)) {?>
                            <small class="label pull-right bg-yellow"><?php echo $notifProses ?></small>
                            <?php } }?>
                    </i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == '') ? 'active' : '';?>">
                        <a href="<?php echo site_url('data_cuti') ?>"><i class="fa fa-angle-right"></i><span> Permohonan Cuti</span>
													<?php if (!empty($notifTolak)) {?>
                          	<small class="label pull-right bg-red"><?php echo $notifTolak ?></small>
                          <?php } ?></span>
                        </a>
                    </li>
                    <?php if ($this->session->userdata('id_divisi')==1) { ?>

                        <li class="<?php echo ($this->uri->segment(2) == 'proses') ? 'active' : '';?>">
                            <a href="<?php echo site_url('data_cuti/proses') ?>"><i class="fa fa-angle-right"></i> Proses Cuti
                            <?php if (!empty($notifProses)) {?>
                            <small class="label pull-right bg-yellow"><?php echo $notifProses ?></small>
                            <?php } ?>
                            </a>
                        </li>
                    <?php } ?>
                    <li class="<?php echo ($this->uri->segment(2) == 'approval') ? 'active' : '';?>">
                        <a href="<?php echo site_url('data_cuti/approval') ?>"><i class="fa fa-angle-right"></i><span> Approval Atasan</span>
                        <?php if (!empty($notifApproveAtasan)) {?>
                            <small class="label pull-right bg-green"><?php echo $notifApproveAtasan ?></small>
                           <?php } ?></span>
                        </a>
                    </li>
                    <li class="<?php echo ($this->uri->segment(2) == 'approvalPejabat') ? 'active' : '';?>">
                        <a href="<?php echo site_url('data_cuti/approvalPejabat') ?>"><i class="fa fa-angle-right"></i>&nbsp<span>Approval Pejabat</span>
                        <?php if (!empty($notifApprovePejabat)) {?>
                            <small class="label pull-right bg-green"><?php echo $notifApprovePejabat ?></small>
                            <?php } ?></span>
                        </a>
                    </li>
                    <li class="<?php echo ($this->uri->segment(2) == 'approvalRekom2') ? 'active' : '';?>">
                        <a href="<?php echo site_url('data_cuti/approvalRekom2') ?>"><i class="fa fa-angle-right"></i>&nbsp<span>Approval Rekomendasi</span>
                        <?php if (!empty($notifApproveRekom2)) {?>
                            <small class="label pull-right bg-blue"><?php echo $notifApproveRekom2 ?></small>
                           <?php } ?></span>
                        </a>
                    </li>
                    <li class="<?php echo ($this->uri->segment(2) == 'approvalRekom') ? 'active' : '';?>">
                        <a href="<?php echo site_url('data_cuti/approvalRekom') ?>"><i class="fa fa-angle-right"></i>&nbsp<span>Approval Rekomendasi 2</span>
                        <?php if (!empty($notifApproveRekom )) {?>
                            <small class="label pull-right bg-blue"><?php echo $notifApproveRekom ?></small>
                           <?php } ?></span>
                        </a>
                    </li>
                    <?php if ($this->session->userdata('status_kh')==1) {?>
                    <li class="<?php echo ($this->uri->segment(2) == 'approvalRekom3') ? 'active' : '';?>">
                        <a href="<?php echo site_url('data_cuti/approvalRekom3') ?>"><i class="fa fa-angle-right"></i>&nbsp<span>Approval Rekomendasi 3</span>
                        <?php if (!empty($notifApproveRekom3 )) {?>
                            <small class="label pull-right bg-blue"><?php echo $notifApproveRekom3 ?></small>
                           <?php } ?></span>
                        </a>
                    </li>
                    <?php } ?>
                        <?php if ($this->session->userdata('id_divisi')>0 or $this->session->userdata('jabatan')=="Kepala"){?>
                        <li class="<?php echo ($this->uri->segment(2) == 'rekap') ? 'active' : '';?>">
                            <a href="<?php echo site_url('data_cuti/rekap') ?>"><i class="fa fa-angle-right"></i>&nbsp Rekap Cuti
                            </a>
                        </li>
                        <?php } ?>
                        <?php if ($this->session->userdata('id_divisi')>0) { ?>
                        <li class="<?php echo ($this->uri->segment(2) == 'total') ? 'active' : '';?>">
                            <a href="<?php echo site_url('data_cuti/totalCuti') ?>"><i class="fa fa-angle-right"></i>&nbsp Rekap Total Cuti
                            </a>
                        </li>
                        <?php } ?> 
                </ul>
            </li>



		  </ul>
		</a>
		</li>
		<li><a href="#">
		<i class="fa fa-book"></i> <span>Monitoring & Evaluasi</span>
                    </i>
		  <ul class="treeview-menu">
		  <li><a href="<?php echo site_url('eksekutif/pilihanEksekutif'); ?>"><i class="fa fa-angle-right"></i> Data Update (Eksekutif)</a></li>
		  <li><a href="#">
		<i class="fa fa-angle-right"></i> <span>SI-LEA</span></a>
		 <ul class="treeview-menu">
         <li><a target="_blank" href="//<?php echo $ips;?>/prioqnet/app_ext/rq/land.php?usr=<?php echo $ids ?>"><i class="fa fa-angle-right"></i> 2018</a></li>
		 <li><a target="_blank" href="//<?php echo $ips;?>/prioqnet/app_ext/silea/2019/land.php?usr=<?php echo $ids ?>"><i class="fa fa-angle-right"></i> 2019</a></li>
		</ul>				
		</li>		
		  
		  <li><a target="_blank" href="//<?php echo $ips;?>/prioqnet/app_ext/sla_kt/land.php?usr=<?php echo $ids ?>"><i class="fa fa-angle-right"></i> SLA & Acak Petugas</a></li>
          <?php if ($this->session->userdata('status_kh')==1) {?>
            <li><a href="#"><i class="fa fa-angle-right"></i>Perencanaan KH</a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo site_url('perencanaan_kh'); ?>"><i class="fa fa-angle-right"></i>Distribusi</a></li>
                    <li><a href="<?php echo site_url('perencanaan_kh/penempatan'); ?>"><i class="fa fa-angle-right"></i>Penempatan</a></li>
					<li class="<?php echo ($this->uri->segment(2) == 'userKH') ? 'active' : '';?>"><a href="<?php echo site_url('monitoring_kh/userKH') ?>"><i class="fa fa-angle-right"></i><span> User KH</span></a></li>
					<li class="<?php echo ($this->uri->segment(2) == 'monitoring_kh') ? 'active' : '';?>">
						<a href="<?php echo site_url('monitoring_kh') ?>"><i class="fa fa-angle-right"></i><span>Tugas KH</span></a>
					</li>
					<li><a href="<?php echo site_url('perencanaan_kh/jadwal'); ?>"><i class="fa fa-angle-right"></i>Jadwal</a></li>
					<?php if($this->session->userdata('id_divisi')>=1){ ?>
					<li><a href="<?php echo site_url('perencanaan_kh/jadwalAdmin'); ?>"><i class="fa fa-angle-right"></i>Jadwal Admin</a></li>
					<?php } ?>
                </ul>
            </li>
			<li class="<?php echo ($this->uri->segment(2) == 'userKH') ? 'active' : '';?>">
				<a href="<?php echo site_url('monitoring_kh/admin') ?>"><i class="fa fa-angle-right"></i><span> Monitoring KH</span>
	
				</a>
			</li>
          <?php } ?>
          
		  <li><a target="_blank" href="//<?php echo $ips;?>/user_login/app/img/land.php?usr=<?php echo $ids ?>"><i class="fa fa-angle-right"></i> Dok Periksa</a></li>
		  </ul>
		</a>
		</li>


<?php
$web="<li>
<a target='_blank' href='http://tanjungpriok.karantina.pertanian.go.id/inc/adm.php?u=".$this->session->userdata('user_id')."&l=Contributor&k=".md5(date("Ymd"))."&n=".$this->session->userdata('nama')."'><i class='fa fa-angle-right'></i> Contributor Website</a></li><li>
<a target='_blank' href='http://tanjungpriok.karantina.pertanian.go.id/inc/adm.php?u=".$this->session->userdata('user_id')."&l=Editor&k=".md5(date("Ymd"))."&n=".$this->session->userdata('nama')."'><i class='fa fa-angle-right'></i> Editor Website</a></li><li>
<a target='_blank' href='http://tanjungpriok.karantina.pertanian.go.id/adm/my/adm1.php'><i class='fa fa-angle-right'></i> My-Website</a></li>	";
?>
	<li><a href="#">
		<i class="fa fa-book"></i> <span>Manajemen Website</span>
                    </i>
		  <ul class="treeview-menu"><?php echo $web ?>
		  </ul>
		</a>
		</li>

		<li><a href="#">
		<i class="fa fa-book"></i> <span>Laboratorium</span>
                    </i>
		  <ul class="treeview-menu">
 <li><a target="_blank" href="//<?php echo $ips;?>/prioqnet/app_ext/lab_kt/land.php?usr=<?php echo $ids ?>"><i class="fa fa-angle-right"></i> Laboratorium KT</a></li>
		  <li><a target="_blank" href="//<?php echo $ips;?>/prioqnet/app_ext/koleksi/koleksi.php?usr=<?php echo $ids ?>"><i class="fa fa-angle-right"></i> Koleksi OPTK/HPHK</a></li>
		  </ul>
		</a>
		</li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
