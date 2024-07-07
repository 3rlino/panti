<?php
session_start();

// Koneksi ke database (gantilah dengan informasi koneksi sesuai database Anda)
$host = "localhost";
$username = "root";
$password = "";
$database = "fotografi";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Proses data yang dikirimkan melalui form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $jenis = $_POST["jenis"];
    $rute = $_POST["rute"];
    $nahkoda = $_POST["nahkoda"];

    // Upload gambar
    $gambar = generateRandomName(10) . '.' . pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION); // Menghasilkan nama file acak
    $temp = $_FILES["gambar"]["tmp_name"];
    $folder = "uploads/portfolio/"; // Lokasi penyimpanan gambar, pastikan folder ini ada

    if (move_uploaded_file($temp, $folder . $gambar)) {
        // Insert data ke database
        $sql = "INSERT INTO portfolio (nama, jenis, rute, nahkoda, foto) VALUES ('$nama', '$jenis', '$rute', '$nahkoda', '$gambar')";
        
        if ($conn->query($sql)) {
            // Jika data berhasil ditambahkan, arahkan pengguna ke portfolio.php
            $_SESSION['data_added'] = true;
            header("Location: portfolio.php?addSuccess=1");
            // Exit agar tidak menampilkan pesan "Data berhasil ditambahkan" dua kali
            exit();
        }
    } else {
        echo "Upload gambar gagal.";
    }

    // Tutup koneksi ke database
    $conn->close();
}

// Hapus flag session jika ada dan bernilai true
if (isset($_SESSION['data_added']) && $_SESSION['data_added']) {
    unset($_SESSION['data_added']); // Hapus flag session
}

// Fungsi untuk menghasilkan nama file acak
function generateRandomName($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>
