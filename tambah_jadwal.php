<?php
// Memamsukkan header halaman
include '.includes/header.php';
// Menyertakan filr untuk menampilkan notifikasi (jika ada)
include '.includes/toast_notification.php';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Tabel data jadwal penayangan -->
     <div class="card">
        <div class="card-header d-flex justify-content-between aligin-items-center">
            <h4>Jadwal Penayangan</h4>
            <!-- Tombol untuk menambah jadwal baru -->
             <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addjadwal">
                Tambah Jadwal
             </button>
             </div>

             <div class="card-body">
                <div class="table-responsive text-nowrap">
                <table id="datatable" class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th width="50px">#</th>
                            <th>Judul Film</th>
                            <th>Waktu</th>
                            <th>Tanggal</th>
                            <th width="150px">Pilihan</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <?php
                    // Inisialisasi indeks nomor urut
                    $index = 1;
                    // Query untuk mengambil data penayangan dan judul film
                    $query = "SELECT penayangan.*, film.judul_film 
                              FROM penayangan 
                              JOIN film ON penayangan.film_id = film.film_id";
                    // Eksekusi query
                    $exec = mysqli_query($conn, $query);
                    // Looping untuk menampilkan semua data penayangan
                     while ($penayangan = mysqli_fetch_assoc($exec)) :
                    ?>
                        <tr>
                            <!-- Menampilkan nomor, judul film, waktu dan tanggal -->
                            <td><?= $index++; ?></td>
                            <td><?= $penayangan['judul_film']; ?></td>
                            <td><?= $penayangan['waktu']; ?></td>
                            <td><?= $penayangan['tanggal']; ?></td>
                            <td>
                            <!-- Dropdown untuk Delete -->
                            <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle 
                                    hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                            <a href="#"class="dropdown-item"data-bs-toggle="modal"
                                            data-bs-target="#deletePenayangan_<?= $penayangan['penayangan_id']; ?>">
                                        <i class="bx bx-trash me-2"></i>Delete</a>
                                    </div>    
                                </div>
                            </td>
                        </tr>
                        <!-- Modal  untuk Hapus Data jadwal -->
                        <div class="modal fade" id="deletePenayangan_<?= $penayangan['penayangan_id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-tittle">Hapus Jadwal</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                    <div class="modal-body">
                                        <form action="proses_jadwal.php" method="POST">
                                            <div>
                                                <p>Tindakan ini tidak bisa dibatalkan.</p>
                                                <input type="hidden" name="catID" value="<?=$penayangan['penayangan_id']; ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" name="delete" class="btn btn-primary">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <?php endwhile; ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include '.includes/footer.php'; ?>

<!-- Modal untuk Tambah Data jadwal -->
 <div class="modal fade" id="addjadwal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-tittle">Tambah Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="proses_jadwal.php" method="POST">
                    <div class="mb-3">
                            <label for="film_id" class="form-label">Judul Film</label>
                            <select class="form-select" name="film_id" required>
                                <!-- Mengambil data judul film dari database untuk mengisi opsi dropdown -->
                                 <option value="" selected disabled>Pilih salah satu</option>
                                 <?php
                                 $query = "SELECT * FROM film"; // Query untuk mengambil data film
                                 $result = $conn->query($query); // Menjalankan query
                                 if ($result->num_rows > 0) { // Jika terdapat data film
                                    while ($row = $result->fetch_assoc()) { // Iterasi setiap film
                                        echo "<option value='" . $row["film_id"] . "'>" . $row["judul_film"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                    </div>
                    <div class="mb-3">
                        <label for="waktu" class="form-label">Waktu</label>
                        <input type="time" class="form-control" name="waktu" required>
                    </div>
                    <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">Batal</button> 
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>