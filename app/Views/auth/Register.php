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
            <h3>Daftar ke <strong>Stock Barang</strong></h3>
            <p class="mb-4">Buat akun baru untuk memulai.</p>
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

            <form action="/register" method="post">
              <div class="form-group first">
                <label for="name">Nama</label>
                <input type="text" class="form-control" placeholder="Enter name" id="name" name="name" required>
              </div>
              <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" placeholder="Enter email" id="email" name="email" required>
              </div>
              <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" class="form-control" placeholder="Enter password" id="password" name="password" required>
                <small id="passwordHelpBlock" class="form-text text-muted">
                Demi keamanan akun Anda, mohon gunakan kata sandi yang kuat dan tidak mudah ditebak.
                </small>    
              </div>
              <div class="form-group last mb-3">
                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                <input type="password" class="form-control" placeholder="Enter password" id="password_confirmation" name="password_confirmation" required>
                <small id="passwordHelpBlock" class="form-text text-muted">
                    Pastikan bagian ini sama dengan yang sebelumnya.
                </small>    
            </div>

              <input type="submit" value="Daftar" class="btn mt-5 mb-2 btn-block btn-primary bg-dark text-white" id="submit-btn" disabled>
              
              <div class="d-flex align-items-center">

                <span class="ml-auto">Sudah punya akun? <a href="/login" class="">Masuk di sini.</a></span> 
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

    
  </div>
    
    
  </body>
  <script>
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordConfirmationInput = document.getElementById('password_confirmation');
    const submitBtn = document.getElementById('submit-btn');

    function validateForm() {
      if (nameInput.value.trim() === '' || emailInput.value.trim() === '' || passwordInput.value.trim() === '' || passwordConfirmationInput.value.trim() === '') {
        submitBtn.disabled = true;
      } else if (!emailInput.value.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/)) {
        submitBtn.disabled = true;
      } else if (passwordInput.value !== passwordConfirmationInput.value) {
        submitBtn.disabled = true;
      } else {
        submitBtn.disabled = false;
      }
    }

    nameInput.addEventListener('input', validateForm);
    emailInput.addEventListener('input', validateForm);
    passwordInput.addEventListener('input', validateForm);
    passwordConfirmationInput.addEventListener('input', validateForm);
  </script>
</html>