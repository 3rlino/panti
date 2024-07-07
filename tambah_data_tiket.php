<?php
session_start();

// Fungsi untuk menambahkan data tiket
function addTicket($id_tiket, $nama, $tujuan, $umur, $kelas, $ekonomi, $harga, $id_kapal) {
    // Lakukan koneksi ke database
    $connect = mysqli_connect("localhost", "root", "", "fotografi");

    // Periksa koneksi
    if (!$connect) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    // Escape input untuk mencegah SQL Injection
    $id_tiket = mysqli_real_escape_string($connect, $id_tiket);
    $nama = mysqli_real_escape_string($connect, $nama);
    $tujuan = mysqli_real_escape_string($connect, $tujuan);
    $umur = mysqli_real_escape_string($connect, $umur);
    $kelas = mysqli_real_escape_string($connect, $kelas);
    $ekonomi = mysqli_real_escape_string($connect, $ekonomi);
    $harga = mysqli_real_escape_string($connect, $harga);
    $id_kapal = mysqli_real_escape_string($connect, $id_kapal);

    // Buat query untuk menambahkan data tiket
    $query = "INSERT INTO tiket (id_tiket, id_kapal, nama, tujuan, umur, kelas, ekonomi, harga) VALUES ('$id_tiket', '$id_kapal', '$nama', '$tujuan', '$umur', '$kelas', '$ekonomi', '$harga')";

    // Eksekusi query
    if (mysqli_query($connect, $query)) {
        // Set flag session untuk menandai bahwa data berhasil ditambahkan
         // Jika data berhasil ditambahkan, arahkan pengguna ke portfolio.php
         $_SESSION['data_added'] = true;
         header("Location: services.php?addSuccess=1");
         // Exit agar tidak menampilkan pesan "Data berhasil ditambahkan" dua kali
         exit();
    } else {
        // Jika terjadi error, tampilkan pesan error dan query yang bermasalah
        echo "Error: " . $query . "<br>" . mysqli_error($connect);
    }

    // Tutup koneksi
    mysqli_close($connect);
}

// Periksa apakah data tiket berhasil ditambahkan sebelumnya
if (isset($_SESSION['data_added']) && $_SESSION['data_added']) {
    unset($_SESSION['data_added']); // Hapus flag session
}

// Fungsi untuk mendapatkan id_kapal berdasarkan nama kapal
function getIdKapal($namaKapal) {
    // Lakukan koneksi ke database
    $connect = mysqli_connect("localhost", "root", "", "fotografi");

    // Periksa koneksi
    if (!$connect) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    // Escape input untuk mencegah SQL Injection
    $namaKapal = mysqli_real_escape_string($connect, $namaKapal);

    // Buat query untuk mendapatkan id_kapal berdasarkan nama kapal
    $query = "SELECT id_kapal FROM portfolio WHERE nama = '$namaKapal'";
    $result = mysqli_query($connect, $query);

    // Periksa apakah query berhasil dieksekusi
    if ($result) {
        // Periksa apakah data ditemukan
        if (mysqli_num_rows($result) > 0) {
            // Ambil hasil dari query
            $row = mysqli_fetch_assoc($result);
            $id_kapal = $row['id_kapal'];
        } else {
            // Jika tidak ada data yang cocok, kirimkan pesan error
            die("Error: Kapal tidak ditemukan");
        }
    } else {
        // Jika terjadi error pada query, tampilkan pesan error
        die("Error: " . mysqli_error($connect));
    }

    // Tutup koneksi
    mysqli_close($connect);

    // Kembalikan id_kapal
    return $id_kapal;
}

// Tangkap data dari form dan panggil fungsi addTicket
$id_tiket = $_POST['id_tiket'];
$nama = $_POST['nama'];
$tujuan = $_POST['tujuan'];
$umur = $_POST['umur'];
$kelas = $_POST['kelas'];
$ekonomi = $_POST['ekonomi'];
$harga = $_POST['harga'];

// Panggil fungsi untuk mendapatkan id_kapal berdasarkan nama
$namaKapal = $_POST['nama'];
$id_kapal = getIdKapal($namaKapal); // Fungsi getIdKapal() mengambil id_kapal berdasarkan nama kapal

// Panggil fungsi untuk menambahkan data tiket
addTicket($id_tiket, $nama, $tujuan, $umur, $kelas, $ekonomi, $harga, $id_kapal);
?>
