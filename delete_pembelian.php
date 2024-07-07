<?php
session_start();

// Fungsi untuk menghapus pembelian berdasarkan ID
function deletePembelian($employee_id) {
    // Lakukan koneksi ke database
    $connect = mysqli_connect("localhost", "root", "", "fotografi");

    // Periksa koneksi
    if (!$connect) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    // Buat query untuk menghapus pembelian berdasarkan ID
    $query = "DELETE FROM pembelian WHERE id_pembelian = $employee_id";

    // Eksekusi query
    if (mysqli_query($connect, $query)) {
        $_SESSION['data_deleted'] = true;
            header("Location: pembelian.php?deleteSuccess=1");
            exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connect);
    }

    // Tutup koneksi
    mysqli_close($connect);
}

// Panggil fungsi deletePembelian jika parameter employee_id diterima
if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];
    deletePembelian($employee_id);
}

// Periksa apakah data berhasil ditambahkan sebelumnya
if (isset($_SESSION['data_delet']) && $_SESSION['data_deleted']) {
    unset($_SESSION['data_deleted']); // Hapus flag session
}
?>
