<?php include(".layouts/header.php"); ?>
<!-- Register -->
<div class="card">
  <div class="card-body">
    <!-- Logo -->
    <div class="app-brand justify-content-center">
      <a href="index.html" class="app-brand-link gap-2">
        <span class="app-brand-text demo text-uppercase fw-bolder">Cinema</span>
      </a>
    </div>
    
    <!-- /Logo -->
    <form class="mb-3" action="proses_login.php" method="POST">
    <h5 class="mb-2 text-center">Selamat datang! 👋</h5>
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" name="username"
          placeholder="Enter your username" autofocus required />
      </div>

      <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
          <label class="form-label" for="password">Password</label>
        </div>

        <div class="input-group input-group-merge">
          <input type="password" class="form-control" name="password"
            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
            aria-describedby="password" />
          <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>
      </div>
      <div class="mb-3">
        <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
      </div>
    </form>
    <p class="text-center">
    <span>Belum punya akun?</span><a href="register.php"><span> Daftar</span></a>
    </p>
  </div>
</div>

<!-- /Register -->
<?php include(".layouts/footer.php"); ?>