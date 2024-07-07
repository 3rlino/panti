<?php
session_start();

// Periksa apakah pengguna sudah login
if (isset($_SESSION['username'])) {
    $loggedIn = true;
} else {
    $loggedIn = false;
}

if (isset($_SESSION['data_deleted']) && $_SESSION['data_deleted']) {
    $deleteSuccess = true;
}

if (isset($_SESSION['data_edited']) && $_SESSION['data_edited']) {
    $editSuccess = true;
}

if (isset($_SESSION['data_added']) && $_SESSION['data_added']) {
    $addSuccess = true;
}
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "fotografi";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Ambil nama kapal dari permintaan AJAX
$namaKapal = $_POST['nama_kapal'];

// Cari id_kapal berdasarkan nama_kapal di tabel portfolio
$sql = "SELECT id_kapal FROM portfolio WHERE nama = '$namaKapal'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Jika data ditemukan, kirimkan id_kapal sebagai respons
    $row = $result->fetch_assoc();
    echo $row["id_kapal"];
} else {
    // Jika tidak ada data yang cocok, kirimkan pesan error
    echo "Error: Kapal tidak ditemukan";
}

// Tutup koneksi ke database
$conn->close();
?>
