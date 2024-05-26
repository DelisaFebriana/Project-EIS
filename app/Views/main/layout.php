<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Stock Barang Masuk dan Barang Keluar</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->

      <!-- Messages Dropdown Menu -->
      <!-- Notifications Dropdown Menu -->

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url() ?>/index3.html" class="brand-link">
      <img src="<?= base_url() ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">App Stock Barang</span>
    </a>


<!-- Sidebar -->
<div class="sidebar">

  <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3">
        <div class="d-flex">
            <div class="image">
                <img src="<?= base_url() ?>/dist/img/admin-icon.png" alt="User Image">
            </div>

              <?php if (!empty(session('name'))): ?>
                <div class="info">
                    <a href="#" class="d-block">Halo, <?= session('name') ?>!</a>
                </div>
              <?php else: ?>
                <div class="info">
                    <a href="#" class="d-block">Silakan masuk!</a>
                </div>
                  <script>
                    window.location.href = '/login';</script>
              <?php endif; ?>
            </div>
            



    </div>


    <!-- SidebarSearch Form -->


    <!-- Sidebar Menu -->
    <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                  with font-awesome or any other icon font library -->
              <li class="nav-item nav-header">Master</li>
              <li class="nav-item">
                  <a href="<?= site_url('kategori/index'); ?>" class="nav-link">
                      <i class="nav-icon fa fa-tasks text-primary"></i>
                      <p class="text">Kategori</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="<?= site_url('satuan/index'); ?>" class="nav-link">
                      <i class="nav-icon fa fa-angle-double-right text-warning"></i>
                      <p class="text">Satuan</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="<?= site_url('barang/index'); ?>" class="nav-link">
                      <i class="nav-icon fa fa-tasks text-success"></i>
                      <p class="text">Barang</p>
                  </a>
              </li>
          </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->

<!-- Logout Button -->
<div style="height: 50vh; position: relative;">
<div style="position: absolute; bottom: 0;" class="w-100 text-center hover-scale">
  
    <a href="#" data-toggle="modal" data-target="#logoutModal" data-backdrop="false" class="text-danger btn-block py-2">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>

  <!-- Modal -->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Apakah kamu yakin ingin keluar dari akun <?= session('name') ?>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal.</button>
          <a href="<?php echo base_url('/logout'); ?>" class="btn btn-danger">Ya, Keluar!</a>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- / Logout Button -->

  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
                <?= $this->renderSection('judul') ?>
            </h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
          <?= $this->renderSection('subjudul') ?>
          </h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
        <?= $this->renderSection('isi') ?>
        </div>
        <!-- /.card-body -->
       
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0
    </div>
    <strong>Copyright &copy; Stock Barang 2024 
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url() ?>/dist/js/demo.js"></script>
</body>
</html>
