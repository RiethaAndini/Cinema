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
        <a href="pesan.php.php" class="btn btn-outline-secondary">Pesan sekarang</a> <br>

        <!-- Link untuk kembali ke halaman daftar film -->
        <a href="dashboard_user.php" class="btn btn-outline-secondary">Kembali</a>
      </div>
    </div>
  </div>
</div>

<?php include '.includes/footer.php'; ?>
