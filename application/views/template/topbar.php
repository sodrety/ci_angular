</head>
<body class="skin-blue hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <!-- <body class="hold-transition skin-blue sidebar-mini"> -->
    <div class="wrapper">

        <header class="main-header">
            <a href="#" class="logo"><b>Prioq</b>Net</a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="fa fa-bars"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- <img src="<?php echo base_url('assets/AdminLTE-2.0.5/dist/img/user2-160x160.jpg') ?>" class="user-image" alt="User Image"/> -->
                                <span class="hidden-xs"><?php echo $this->session->userdata('nama'); ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                <?php if ($this->uri->segment(1)=='dashboard') { ?>
              									<div class="pull-left">
              										<button type="button" data-toggle="modal" data-target="#modal1" class="btn btn-default btn-flat">Profile</button>
              									</div>
                                <?php }?>
                                    <div class="pull-right">
                                        <a href="<?php echo site_url('login/logout') ?>" class="btn btn-default btn-flat">Log out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
			<div id="modal1" class="modal fade" role="dialog">
			  <div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-center">Data Diri</h4>
				  </div>
				  <div class="modal-body">
					<form class="form-horizontal" action="<?php echo site_url('data_cuti/updateProfil'); ?>" method="post" enctype="multipart/form-data">
					<?php foreach ($profil as $p){ ?>
						<div class="form-group">
						<label class="col-md-3">NIP</label>
							<div class="col-md-9">
								<input type="hidden" class="form-control" name="id" value="<?php echo $p->id;?>">
								<input type="text" class="form-control" name="nip" value="<?php echo $p->nip;?>">
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">Nama</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="nama" value="<?php echo $p->nama;?>">
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">Pangkat</label>
							<div class="col-md-9">
								<select class="form-control" name="pangkat"><option value="<?php echo $p->golongan;?>"><?php echo $p->golongan;?></option>
									<?php foreach ($gol as $g){ ?>
									<option value="<?php echo $g->gol;?>"><?php echo $g->gol;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">Jabatan</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="jabatan" value="<?php echo $p->jabatan;?>">
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">HP</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="hp" value="<?php echo $p->hp;?>">
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">Email</label>
							<div class="col-md-9">
								<input type="email" class="form-control" name="email" value="<?php echo $p->email;?>">
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">WhatsApp</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="wa" value="<?php echo $p->wa;?>">
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">Username </label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="username" value="<?php echo $p->username;?>">
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">Password</label>
							<div class="col-md-9">
								<input type="password" class="form-control" name="password">
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3">Ulangi Password</label>
							<div class="col-md-9">
								<input type="password" class="form-control" name="ul_password">
							</div>
						</div>
				  </div>
				  <div class="modal-footer">
					<button type="submit" class="btn btn-success">Update</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  </div>
				</div>
				<?php } ?>
				</form>
			  </div>
			</div>
        </header>


        <!-- =============================================== -->
