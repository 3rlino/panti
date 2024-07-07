<?php
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus catatan dari database
    $connect = mysqli_connect("localhost", "root", "", "fotografi");

    $query_select = "SELECT foto FROM portfolio WHERE id_kapal = $id";
    $result_select = mysqli_query($connect, $query_select);
    if ($result_select && mysqli_num_rows($result_select) > 0) {
        $row = mysqli_fetch_array($result_select);
        $gambar = $row['foto'];

        // Hapus file gambar dari folder
        $file_path = 'uploads/portfolio' . $gambar; // Tambahkan garis miring setelah folder
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        $query = "DELETE FROM portfolio WHERE id_kapal = $id";
        $result = mysqli_query($connect, $query);

        if ($result) {
            $_SESSION['data_deleted'] = true;
            header("Location: portfolio.php?deleteSuccess=1");
            exit();
        } else {
            echo "Gagal menghapus catatan: " . mysqli_error($connect);
        }
    } else {
        echo "Data tidak ditemukan.";
    }
} else {
    echo "ID tidak ditemukan.";
}
?>