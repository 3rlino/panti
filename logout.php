<?php
session_start(); // Memulai sesi PHP

// Periksa apakah pengguna sudah login
if (isset($_SESSION['username'])) {
    // Jika pengguna sudah login, hapus semua data sesi
    session_unset();
    session_destroy();
}

// Arahkan pengguna ke halaman utama (index.php)
header('Location: index.php');
exit;
?>
