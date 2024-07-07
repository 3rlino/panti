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

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Ambil kode pembelian dari parameter GET
$kode_pembelian = $_GET["kode_pembelian"];

// Persiapkan statement SQL untuk mencari nama berdasarkan kode pembelian
$sql = "SELECT nama FROM pembelian WHERE kode_pembelian = ?";

// Persiapkan statement
$stmt = $conn->prepare($sql);

// Periksa apakah statement berhasil dipersiapkan
if ($stmt === false) {
    die("Error saat mempersiapkan statement: " . $conn->error);
}

// Bind parameter ke statement
$stmt->bind_param("s", $kode_pembelian);

// Eksekusi statement
if ($stmt->execute()) {
    // Ambil hasil query
    $result = $stmt->get_result();

    // Periksa apakah ada baris hasil
    if ($result->num_rows > 0) {
        // Ambil nama dari baris hasil pertama
        $row = $result->fetch_assoc();
        $nama = $row["nama"];

        // Kirim nama sebagai respons
        echo $nama;
    } else {
        // Jika tidak ada hasil, kirim pesan bahwa kode pembelian tidak ditemukan
        echo "Kode pembelian tidak ditemukan";
    }
} else {
    // Jika terjadi error saat eksekusi statement
    echo "Error: " . $stmt->error;
}

// Tutup statement
$stmt->close();

// Tutup koneksi ke database
$conn->close();
?>
