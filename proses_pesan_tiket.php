<?php

// menghubungkan ke file konfigurasi database
include("koneksi.php");

// memulai sesi untuk menyimpan notifikasi
session_start();

// proses pemesanan film
if (isset($_POST['pesan'])) {
    // mengambil data nama film dari form
    $penayanganID = $_POST['penayangan_id'];
    $nomorKursi = $_POST['nomor_kursi'];
    
    $harga = 30000;
    
    if (isset($_SESSION['id'])) {
        $userId = $_SESSION['id'];
    // query untuk menambahkan data pemesanan film ke dalam database
    $query = "INSERT INTO tiket (penayangan_id, user_id, nomor_kursi, harga)
    VALUES ('$penayanganID', '$userId', '$nomorKursi', '$harga')";
     $exec = mysqli_query($conn, $query);

    // menyimpan notifikasi berhasil atau gagal ke dalam session
    if ($exec){
        $_SESSION['notification'] = [
            'type' => 'primary', // "notifikasi berhasil"
            'message' => 'tiket berhasil dipesan!'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger', // "notifikasi gagal"  
            'message' => 'Gagal memesan tiket: ' . mysqli_error($conn)
        ];
    }

     // redirect kembalike halaman dashboard_user
    header('Location: dashboard_user.php');
    exit();
}
}