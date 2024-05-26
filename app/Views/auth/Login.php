<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    
    <!-- Style -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/auth.style.css">

      <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">

    <title>Stock Barang Masuk dan Barang Keluar</title>
</head>
<body>
  

  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('<?= base_url('dist/img/bg_1.jpg') ?>');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <h3>Masuk ke <strong>Stock Barang</strong></h3>
            <p class="mb-4">Silakan masuk untuk mendapatkan akses.</p>
            <?php if(session()->getFlashData('success')) { ?>
                <div class="alert alert-success">
                    <?= session()->get('success') ?>
                </div>
            <?php } ?>

            <?php if(session()->getFlashdata('errors')) { ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('errors') ?>
                </div>
            <?php } ?>

            <form action="/login" method="post">
              <div class="form-group first">
                <label for="email">E-mail</label>
                <input type="text" class="form-control" placeholder="your-email@gmail.com" id="email" name="email" value="<?= old('email') ?>">
              </div>
              <div class="form-group last mb-3">
                <label for="password">Kata Sandi</label>
                <input type="password" class="form-control" placeholder="Your Password" id="password" name="password">
              </div>
              
              <input type="submit" value="Log In" class="btn mt-5 mb-2 btn-block btn-primary bg-dark text-white">
              
              <div class="d-flex align-items-center">

                <span class="ml-auto">Belum punya akun? <a href="/register" class="">Daftar di sini.</a></span> 
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

    
  </div>
    
    
  </body>
</html>