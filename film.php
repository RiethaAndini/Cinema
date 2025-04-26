<?php
// Memamsukkan header halaman
include '.includes/header.php';
// Menyertakan filr untuk menampilkan notifikasi (jika ada)
include '.includes/toast_notification.php';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Tabel data film -->
     <div class="card">
        <div class="card-header d-flex justify-content-between aligin-items-center">
            <h4>Data Film</h4>
            <!-- Tombol untuk menambah film baru -->
             <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFilm">
                Tambah Film
             </button>
             </div>

             <div class="card-body">
                <div class="table-responsive text-nowrap">
                <table id="datatable" class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th width="50px">#</th>
                            <th>Judul Film</th>
                            <th>Genre</th>
                            <th>Durasi</th>
                            <th width="150px">Pilihan</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                       <!-- Mengambil data film dari database -->
                       <?php
                         $index = 1;
                         $query = "SELECT * FROM film";
                         $exec = mysqli_query($conn, $query);
                         while ($film = mysqli_fetch_assoc($exec)) :
                        ?>
                        <tr>
                            <!-- Menampilkan nomor, judul film, genre, durasi dan opsi -->
                            <td><?= $index++; ?></td>
                            <td><?= $film['judul_film']; ?></td>
                            <td><?= $film['genre']; ?></td>
                            <td><?= $film['durasi']; ?></td>
                            <td>
                            <!-- Dropdown untuk opsi Edit dan Delete -->
                            <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle 
                                    hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                    <a href="#" class="dropdown-item"data-bs-toggle="modal"
                                            data-bs-target="#editFilm_<?= $film['film_id']; ?>">
                                            <i class="bx bx-edit-alt me-2"></i>Edit</a>
                                            <a href="#"class="dropdown-item"data-bs-toggle="modal"
                                            data-bs-target="#deleteFilm_<?= $film['film_id']; ?>">
                                        <i class="bx bx-trash me-2"></i>Delete</a>
                                    </div>    
                                </div>
                            </td>
                        </tr>

                        <!-- Modal untuk edit data film -->
                        <div class="modal fade" id="editFilm_<?= $film['film_id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Data Film</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="proses_film.php" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="filmID" value="<?= $film['film_id']; ?>" />
                                        <div>
                                            <label for="judulFilm" class="form-label">Judul Film</label>
                                            <input type="text" class="form-control" name="judul_film" value="<?= $film['judul_film']; ?>" required />
                                        </div> <br>
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Ubah Thumbnail</label>
                                            <input class="form-control" type="file" name="image" accept="image/*" />
                                        </div> <br>
                                        <div>
                                            <label for="genre" class="form-label">Genre</label>
                                            <input type="text" class="form-control" name="genre" value="<?= $film['genre']; ?>" required />
                                        </div> <br>
                                        <div>
                                            <label for="durasi" class="form-label">Durasi</label>
                                            <input type="text" class="form-control" name="durasi" value="<?= $film['durasi']; ?>" required />
                                        </div> <br>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                        <!-- Modal  untuk Hapus Data film -->
                        <div class="modal fade" id="deleteFilm_<?= $film['film_id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus Film</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                    <div class="modal-body">
                                        <form action="proses_film.php" method="POST">
                                            <div>
                                                <p>Tindakan ini tidak bisa dibatalkan.</p>
                                                <input type="hidden" name="filmID" value="<?=$film['film_id']; ?>">
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

<!-- Modal untuk Tambah Data film -->
 <div class="modal fade" id="addFilm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Masukkan Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="proses_film.php" method="POST" enctype="multipart/form-data">
                    <div>
                        <label for="judulFilm" class="form-label">Judul Film</label>
                        <!-- Input untuk judul film baru -->
                         <input type="text" class="form-control" name="judul_film"required/>
                    </div> <br>
                    <div class="mb-3">
                        <!-- input untuk thumbnail -->
                            <label for="formFile" class="form-label">Unggah Thumbnail</label>
                            <input class="form-control" type="file" name="image" accept="image/*" />
                    </div> <br>
                    <div>
                        <label for="genre" class="form-label">Genre</label>
                        <!-- Input untuk genre baru -->
                         <input type="text" class="form-control" name="genre"required/>
                    </div> <br>
                    <div>
                        <label for="durasi" class="form-label">Durasi</label>
                        <!-- Input untuk durasi baru -->
                         <input type="text" class="form-control" name="durasi"required/>
                    </div> <br>
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