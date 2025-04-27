<?php

// menghubungkan ke file konfigurasi database
include("koneksi.php");

// memulai sesi untuk menyimpan notifikasi
session_start();

// proses penambahan film baru
if (isset($_POST['simpan'])) {
    // mengambil data nama film dari form
    $JudulFilm = $_POST['judul_film'];
    $Deskripsifilm = $_POST['deskripsi'];
    $Genre = $_POST['genre'];
    $durasi = $_POST['durasi'];

    $imageDir = "assets/img/uploads/";
    $imageName = $_FILES["image"]["name"]; // nama file gambar
    $imagePath = $imageDir . basename($imageName); // path lengkap gambar

    // query untuk menambahkan data film ke dalam database
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {

        $query = "INSERT INTO film (judul_film, image_path,deskripsi, genre, durasi) VALUES ('$JudulFilm', '$imagePath', '$Deskripsifilm', '$Genre', '$durasi')";
        $exec = mysqli_query($conn, $query);

    // menyimpan notifikasi berhasil atau gagal ke dalam session
    if ($exec){
        $_SESSION['notification'] = [
            'type' => 'primary', // jenis notifikasi (contoh: primary untuk keberhasilan)
            'message' => 'film berhasil ditamahkan!'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger', // jenis notifikasi (contoh: danger untuk kegagalan)
            'message' => 'Gagal menambahkan film: ' . mysqli_error($conn)
        ];
    }
} else {
    $error = error_get_last(); // Mendapatkan error terakhir dari PHP
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Gagal mengupload gambar. Error: ' . ($error ? $error['message'] : 'Tidak diketahui')
    ];

}

     // redirect kembalike halaman film
    header('Location: film.php');
    exit();
}

// Proses penghapusan film
if (isset($_POST['delete'])) {
    // Mengambil ID film dari parameter URL
    $filmID = $_POST['filmID'];

    // Query untuk menghapus film berdasarkan ID
    $exec = mysqli_query($conn, "DELETE FROM film WHERE film_id='$filmID'");

    // Menyimpan notifikasi keberhasilan atau kegagalan ke dalam session
    if ($exec) {
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'film berhasil dihapus!'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal menghapus film: ' . mysqli_error($conn)
        ];
    }

     // Redirect kembali ke halaman film
     header('Location: film.php');
     exit();
 }

 // Proses pembaruan film
if (isset($_POST['update'])) {
    // Mengambil data dari form pembaruan
    $filmID = $_POST['filmID'];
    $JudulFilm = $_POST['judul_film'];
    $Deskripsifilm = $_POST['deskripsi'];
    $Genre = $_POST['genre'];
    $durasi = $_POST['durasi'];
    $imageDir = "assets/img/uploads/";

    // periksa apakah file gambar baru diunggah
    if (!empty($_FILES["image_path"]["name"])) {
        $imageName = $_FILES["image_path"]["name"];
        $imagePath = $imageDir . $imageName;

        // pindahkan file baru ke direktori tujuan
        move_uploaded_file($_FILES["image_path"]["tmp_name"], $imagePath);

         // hapus gambar lama 
         $queryOldImage = "SELECT image_path FROM film WHERE film_id = $filmID";
         $resultOldImage = $conn->query($queryOldImage);
         if ($resultOldImage->num_rows > 0) {
             $oldImage = $resultOldImage->fetch_assoc()['image_path'];
             if (file_exists($oldImage)) {
                 unlink($oldImage); // menghapus file lama 
             }
         }
    
     } else {
        // jika tidak ada file baru, gunakan gambar lama 
        $imagePathQuery = "SELECT image_path FROM film WHERE film_id = $filmID";
        $result = $conn->query($imagePathQuery);
        $imagePath = ($result->num_rows > 0) ? $result->fetch_assoc()['image_path'] : null;
    }

    // update data postingan di database
    $queryUpdate = "UPDATE film SET judul_film = '$JudulFilm', deskripsi = '$Deskripsifilm', genre = '$Genre', durasi = '$durasi', image_path = '$imagePath' WHERE film_id = $filmID";
    $exec = mysqli_query($conn, $queryUpdate);

    // Menyimpan notifikasi keberhasilan atau kegagalan ke dalam session
    if ($exec) {
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'film berhasil diperbarui!'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal memperbarui film: ' . mysqli_error($conn)
        ];
    }

    // Redirect kembali ke halaman film
    header('Location: film.php');
    exit();
}