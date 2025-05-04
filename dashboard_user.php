<?php
// Menghubungkan file header
include (".includes/header.php");

// Menyertakan file notifikasi jika ada pesan toast
include '.includes/toast_notification.php';

// Query default untuk mengambil semua data film
$query = "SELECT * FROM film";

// Jika parameter genre dikirim melalui URL dan tidak kosong, tambahkan kondisi ke query
if (isset($_GET['genre']) && $_GET['genre'] != '') {
  $genre = $_GET['genre'];
  $query .= " WHERE genre = '$genre'";
}

// Eksekusi query dan simpan hasilnya ke variabel $result
$result = mysqli_query($conn, $query);
?>

<div class="container-xxl flex-grow-1 container-p-y">

  <!-- Form untuk memilih genre film -->
  <form method="GET" class="mb-4">
    <label for="genre" class="form-label">Pilih Genre:</label>
    <!-- Dropdown genre, akan submit otomatis saat dipilih -->
    <select name="genre" id="genre" class="form-select w-25" onchange="this.form.submit()">
      <option value="">Semua Genre</option>
      <option value="Action" <?= isset($_GET['genre']) && $_GET['genre'] == 'Action' ? 'selected' : ''; ?>>Action</option>
      <option value="Comedy" <?= isset($_GET['genre']) && $_GET['genre'] == 'Comedy' ? 'selected' : ''; ?>>Comedy</option>
      <option value="Drama" <?= isset($_GET['genre']) && $_GET['genre'] == 'Drama' ? 'selected' : ''; ?>>Drama</option>
      <option value="Horror" <?= isset($_GET['genre']) && $_GET['genre'] == 'Horror' ? 'selected' : ''; ?>>Horror</option>
    </select>
  </form>

  <!-- Menampilkan daftar film dalam bentuk kartu -->
  <div class="row">
    <?php while ($film = mysqli_fetch_assoc($result)) : ?>
      <div class="col-md-3 mb-4">
        <div class="card h-100">
          <!-- Klik gambar akan menuju halaman detail film -->
          <a href="detail_film.php?id=<?= $film['film_id']; ?>">
            <img src="<?= $film['image_path']; ?>" class="card-img-top" style="height: 300px; object-fit: cover; border-radius: 5px; border: 3px solid #ccc;">
          </a>
          <div class="card-body text-center">
            <!-- Menampilkan judul film -->
            <h6 class="card-title"><?= $film['judul_film']; ?></h6>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php
// Menutup halaman dengan menyertakan file footer
include (".includes/footer.php");
?>