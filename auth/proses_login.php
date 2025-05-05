<?php
// Memulai sesi untuk menyimpan data login pengguna
session_start();

// Menyertakan file koneksi ke database
require_once("../koneksi.php");

// Mengecek apakah form login dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Menyimpan data username dan password dari input pengguna
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Query untuk mencari pengguna berdasarkan username
  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = $conn->query($sql);

  // Mengecek apakah pengguna ditemukan
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Memverifikasi password yang dimasukkan dengan yang ada di database
    if (password_verify($password, $row["password"])) {
      // Jika password cocok, simpan data pengguna ke dalam session
      $_SESSION["username"] = $username;
      $_SESSION["name"] = $row["name"];
      $_SESSION["role"] = $row["role"];
      $_SESSION["id"] = $row["id"];

      // Menampilkan notifikasi berdasarkan peran pengguna
      if ($row["role"] === "admin") {
        $_SESSION['notification'] = [
          'type' => 'primary',
          'message' => 'Selamat Datang Sebagai Admin!'
        ];
      } else {
        $_SESSION['notification'] = [
          'type' => 'primary',
          'message' => 'Terimakasih telah login!!'
        ];
      }

      // Redirect ke halaman dashboard sesuai dengan peran pengguna
      if ($row["role"] === "admin") {
        header('Location: ../dashboard.php');
      } else {
        header('Location: ../dashboard_user.php');
      }
      exit();
    } else {
      // Jika password salah, tampilkan notifikasi kesalahan
      $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Username atau Password salah'
      ];
    }
  } else {
    // Jika username tidak ditemukan di database
    $_SESSION['notification'] = [
      'type' => 'danger',
      'message' => 'Username atau Password salah'
    ];
  }

  // Kembali ke halaman login jika gagal
  header('Location: login.php');
  exit();
}

// Menutup koneksi ke database
$conn->close();
?>
