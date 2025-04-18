<?php
include (".includes/header.php");
$title = "Home";
// menyertakan file untuk menampilkan notifikasi (jika  ada)
include '.includes/toast_notification.php';
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Card untuk menampilkan tabel postingan -->
     <div class="card">
        <!-- Tabel dengan baris yang dapat di hover -->
         <div class="card">
            <!-- Header tabel -->
             <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Semua Film</h4>
             </div>
             <div class="card-body">
                <!-- Tabel responsif -->
                 <div class="table-responsive text-nowrap">
                    <table id="datatable" class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th width="50px">Thumbnail</th>
                                <th>Judul film</th>
                                <th>Genre</th>
                                <th>Durasi</th>
                                <th width="150px">Pilihan</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        
                        <?php
                        $query = "SELECT * FROM film";
                        $exec = mysqli_query($conn, $query);
                        while ($film = mysqli_fetch_assoc($exec)) :
                        ?>
                        
                        <tr class="text-center">
                            <td>
                                <a href="detail_film.php?film_id=<?= $film['film_id']; ?>">
                                    <img src="<?= $film['image_path']; ?>" alt="Thumbnail" style="width: 150px; height: auto; border-radius: 5px;">
                                </a>
                            </td>
                            <td><?= $film['judul_film']; ?></td>
                            <td><?= $film['genre']; ?></td>
                            <td><?= $film['durasi']; ?></td>
                            <td> <a href="pesan.php?film_id=<?= $film['film_id']; ?>" class="btn btn-sm btn-primary">Pesan</a> </td>
                        </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                 </div>
             </div>
         </div>
         <!-- akhir tabel dengan baris yang dapat di hover -->
     </div>
</div>

<?php
include (".includes/footer.php");
?>