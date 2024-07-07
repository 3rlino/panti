<?php
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
$kode_pembayaran = $_GET["kode_pembayaran"];

// Persiapkan statement SQL untuk mencari nama berdasarkan kode pembelian
$sql = "SELECT nama FROM pembayaran WHERE kode_pembayaran = ?";

// Persiapkan statement
$stmt = $conn->prepare($sql);

// Periksa apakah statement berhasil dipersiapkan
if ($stmt === false) {
    die("Error saat mempersiapkan statement: " . $conn->error);
}

// Bind parameter ke statement
$stmt->bind_param("s", $kode_pembayaran);

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
        echo "Kode pembayaran tidak ditemukan";
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
