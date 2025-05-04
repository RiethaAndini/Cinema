<?php
// Mengimpor file header halaman
include '.includes/header.php';

// Mengimpor file notifikasi toast (jika ada notifikasi yang ingin ditampilkan)
include '.includes/toast_notification.php';

// Mengambil ID film dari URL
$film_id = $_GET['id'];

// Query untuk mengambil detail film dan waktu penayangan (kalau ada)
$query = "SELECT film.*, penayangan.waktu 
          FROM film 
          LEFT JOIN penayangan 
          ON film.film_id = penayangan.film_id 
          WHERE film.film_id = $film_id";
// Eksekusi query
$exec = mysqli_query($conn, $query);
// Ambil data film sebagai array asosiatif
$film = mysqli_fetch_assoc($exec);
?>

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <h4>Detail Film</h4>
    </div>
    <div class="card-body">
      <!-- Menampilkan detail film -->
      <div class="row">
        <div class="col-md-4">
          <!-- Gambar thumbnail film -->
          <img src="<?= $film['image_path']; ?>" alt="Thumbnail Film" class="img-fluid">
        </div>
        <div class="col-md-8">
          <!-- Informasi judul, genre, durasi, dan deskripsi -->
          <h5>Judul Film: <?= $film['judul_film']; ?></h5>
          <p><strong>Genre:</strong> <?= $film['genre']; ?></p>
          <p><strong>Durasi:</strong> <?= $film['durasi']; ?> menit</p>
          <p><strong>Deskripsi:</strong> <?= $film['deskripsi']; ?></p>

          <?php
          // Query untuk ambil semua waktu penayangan berdasarkan film_id
          $query_waktu = "SELECT waktu FROM penayangan WHERE film_id = $film_id";
          $result_waktu = mysqli_query($conn, $query_waktu);
          ?>

          <p><strong>Waktu Tayang:</strong></p>

          <?php if (mysqli_num_rows($result_waktu) > 0): ?>
            <!-- Tampilkan semua jam penayangan -->
            <?php while ($row = mysqli_fetch_assoc($result_waktu)): ?>
              <span class="badge bg-primary" style="margin-right: 5px;">
                <?= substr($row['waktu'], 0, 5); ?>
              </span>
            <?php endwhile; ?>
          <?php else: ?>
            <!-- Jika tidak ada jadwal -->
            <p>Belum ada jadwal</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Tombol aksi -->
      <div class="modal-footer">
        <!-- Link untuk pesan tiket -->
        <a href="#" data-bs-toggle="modal" data-bs-target="#pesanfilm_<?= $film['film_id']; ?>">
        <i class="btn btn-outline-secondary">Pesan</i></a>

        <!-- Link untuk kembali ke halaman daftar film -->
        <a href="dashboard_user.php" class="btn btn-outline-secondary">Kembali</a>
      </div>
    </div>
  </div>
</div>

<!-- Modal untuk pesan tiket -->
<div class="modal fade" id="pesanfilm_<?= $film['film_id']; ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pesan Tiket</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- Form pesanan tiket -->
        <form action="proses_pesan_tiket.php" method="POST">
          <!-- Hidden input buat kirim ID film -->
          <input type="hidden" name="filmID" value="<?= $film['film_id']; ?>" />

          <!-- tampilin judul -->
          <div class="mb-3">
            <label class="form-label">Judul Film</label>
            <input type="text" class="form-control" name="judul_film" value="<?= $film['judul_film']; ?>" readonly />
          </div>

          <!-- Dropdown buat pilih jadwal -->
          <div class="mb-3">
            <label class="form-label">Pilih Penayangan</label>
            <select class="form-select" name="penayangan_id" id="penayangan_id" required>
              <option value="" disabled selected>Pilih Waktu & Tanggal</option>
              <?php
                $filmID = $film['film_id'];
                $queryPenayangan = mysqli_query($conn, "SELECT * FROM penayangan WHERE film_id = $filmID");
                while ($pen = mysqli_fetch_assoc($queryPenayangan)) {
                  $waktu = date("H:i", strtotime($pen['waktu']));
                  $tanggal = date("d-m-Y", strtotime($pen['tanggal']));
                  // Tampilkan pilihan kombinasi tanggal dan jam
                  echo "<option value='{$pen['penayangan_id']}'>Tanggal: $tanggal | Jam: $waktu</option>";
                }
              ?>
            </select>
          </div>

          <!-- Dropdown buat pilih kursi -->
          <div class="mb-3">
            <label class="form-label">Pilih Kursi</label>
            <select class="form-select" name="nomor_kursi" required>
              <option value="" disabled selected>Pilih Kursi</option>
              <!-- List kursi -->
              <option value="A1">A1</option>
              <option value="A2">A2</option>
              <option value="A3">A3</option>
              <option value="B1">B1</option>
              <option value="B2">B2</option>
              <option value="B3">B3</option>
              <option value="C1">C1</option>
              <option value="C2">C2</option>
              <option value="C3">C3</option>
            </select>
          </div>

          <!-- Tombol aksi modal -->
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" name="pesan" class="btn btn-primary">Pesan Tiket</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include '.includes/footer.php'; ?>
