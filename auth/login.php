<?php
// Memanggil file header dari folder layouts
include(".layouts/header.php");
?>

<!-- Card utama untuk form login -->
<div class="card">
  <div class="card-body">
    <div class="app-brand justify-content-center">
      <a href="index.html" class="app-brand-link gap-2">
        <span class="app-brand-text demo text-uppercase fw-bolder">Cinema</span>
      </a>
    </div>
    <!-- /Logo -->

    <!-- Form login -->
    <form class="mb-3" action="proses_login.php" method="POST">
      <!-- Judul form -->
      <h5 class="mb-2 text-center">Selamat datang! 👋</h5>
      <!-- Input username -->
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" name="username"
          placeholder="Enter your username" autofocus required />
      </div>
      <!-- Input password -->
      <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
          <label class="form-label" for="password">Password</label>
        </div>
        <!-- Input dengan icon show/hide password -->
        <div class="input-group input-group-merge">
          <input type="password" class="form-control" name="password"
            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
            aria-describedby="password" />
          <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>
      </div>

      <!-- Tombol submit -->
      <div class="mb-3">
        <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
      </div>
    </form>

    <!-- Link untuk pengguna yang belum punya akun -->
    <p class="text-center">
      <span>Belum punya akun?</span><a href="register.php"><span> Daftar</span></a>
    </p>
  </div>
</div>
<!-- /Register -->

<?php
// Memanggil file footer dari folder layouts
include(".layouts/footer.php");
?>
