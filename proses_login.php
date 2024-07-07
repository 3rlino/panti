<?php
session_start(); // Memulai sesi PHP

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Koneksi ke database
    $db = new mysqli('localhost', 'root', '', 'fotografi');

    if ($db->connect_error) {
        die("Koneksi database gagal: " . $db->connect_error);
    }

    // Prepared statement
    $query = "SELECT username, password FROM user WHERE username = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($dbUsername, $dbPassword);
    $stmt->fetch();

    if ($password === $dbPassword) {
        // Login berhasil, arahkan ke halaman setelah login
        $_SESSION['username'] = $username; // Simpan data pengguna di sesi
        header('Location: index.php');
        exit;
    } else {
        // Login gagal, arahkan kembali ke login.php
        header('Location: login.php?error=login_failed');
        exit;
    }

    $stmt->close();
    $db->close();
}
?>
