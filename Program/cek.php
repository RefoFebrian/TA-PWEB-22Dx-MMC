<?php
session_start();

include ('koneksi/koneksi.php');
require 'HillCipher/enkripsi.php';

if (isset($_POST['username']) && isset($_POST['pass'])) {
    $username = enkripsiHillCipher($_POST['username'], $kunci);
    $password = enkripsiHillCipher($_POST['pass'], $kunci);
    
    // Hindari SQL Injection dengan menggunakan parameterized query
    $sql = "SELECT * FROM pengguna WHERE username = ? AND pass = ?";
    $stmt = $kdb->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Tambahkan pengecekan username dan password yang sesuai
        if ($row['username'] === $username && $row['pass'] === $password) {
			$_SESSION['logged_in'] = true;
    		$_SESSION['username'] = $username;
            echo "<script>alert('Login Berhasil')</script>";
            echo "<script>window.location='../klinik2/home/pasien.php'</script>";
        }
    } else {
        echo "<script>alert('Username/Password Salah!!! Silakan Hubungi Admin Untuk login')</script>";
        echo "<script>window.location='index.php'</script>";
    }
} else {
    echo "<script>alert('Username/Password tidak boleh kosong!')</script>";
    echo "<script>window.location='index.php'</script>";
}
?>
