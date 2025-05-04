<?php

// menghubungkan ke file konfigurasi database
include("koneksi.php");

// memulai sesi untuk menyimpan notifikasi
session_start();

// proses penambahan jadwal baru
if (isset($_POST['simpan'])) {
    // mengambil data nama film dari form
    $film_id = $_POST['film_id'];
    $waktu = $_POST['waktu'];
    $tanggal = $_POST['tanggal'];

    // query untuk menambahkan data jadwal film ke dalam database
        $query = "INSERT INTO penayangan (film_id, waktu, tanggal) VALUES ('$film_id', '$waktu', '$tanggal')";
        $exec = mysqli_query($conn, $query);

    // menyimpan notifikasi berhasil atau gagal ke dalam session
    if ($exec){
        $_SESSION['notification'] = [
            'type' => 'primary', // "notifikasi berhasil"
            'message' => 'jadwal berhasil ditambahkan!'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger', // "notifikasi gagal"
            'message' => 'Gagal menambahkan jadwal: ' . mysqli_error($conn)
        ];
    }

     // redirect kembalike halaman jadwal
    header('Location: tambah_jadwal.php');
    exit();
}

// Proses penghapusan jadwal film
if (isset($_POST['delete'])) {
    // Mengambil ID dari parameter URL
    $penayangan = $_POST['catID'];

    // Query untuk menghapus jadwal film berdasarkan ID
    $exec = mysqli_query($conn, "DELETE FROM penayangan WHERE penayangan_id='$penayangan'");

    // Menyimpan notifikasi keberhasilan atau kegagalan ke dalam session
    if ($exec) {
        $_SESSION['notification'] = [
            'type' => 'primary', // "notifikasi berhasil"
            'message' => 'jadwal berhasil dihapus!'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',// "notifikasi gagal"
            'message' => 'Gagal menghapus jadwal film: ' . mysqli_error($conn)
        ];
    }

     // Redirect kembali ke halaman jadwal
     header('Location: tambah_jadwal.php');
     exit();
 }