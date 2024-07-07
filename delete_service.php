<?php
session_start();

// Fungsi untuk menghapus pembelian berdasarkan ID
function deleteService($id_tiket) {
    // Lakukan koneksi ke database
    $connect = mysqli_connect("localhost", "root", "", "fotografi");

    // Periksa koneksi
    if (!$connect) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    // Escape variabel untuk mencegah serangan SQL Injection
    $id_tiket = mysqli_real_escape_string($connect, $id_tiket);

    // Buat query untuk menghapus pembelian berdasarkan ID
    $query = "DELETE FROM tiket WHERE id_tiket = $id_tiket";

    // Eksekusi query
    if (mysqli_query($connect, $query)) {
        $_SESSION['data_deleted'] = true;
        header("Location: services.php?deleteSuccess=1");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connect);
    }

    // Tutup koneksi
    mysqli_close($connect);
}

// Panggil fungsi deleteService jika parameter id_tiket diterima
if (isset($_GET['id_tiket'])) {
    $id_tiket = $_GET['id_tiket'];
    deleteService($id_tiket);
}

// Periksa apakah data berhasil dihapus sebelumnya
if (isset($_SESSION['data_deleted']) && $_SESSION['data_deleted']) {
    unset($_SESSION['data_deleted']); // Hapus flag session
}
?>
