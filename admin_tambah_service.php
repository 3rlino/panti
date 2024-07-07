<?php
session_start();

// Periksa apakah pengguna sudah login
if (isset($_SESSION['username'])) {
    $loggedIn = true;
} else {
    $loggedIn = false;
}
// Inisialisasi variabel $pages
$pages = isset($_GET['page']) ? $_GET['page'] : 1;

if (isset($_SESSION['data_deleted']) && $_SESSION['data_deleted']) {
    $deleteSuccess = true;
}

if (isset($_SESSION['data_added']) && $_SESSION['data_added']) {
    $addSuccess = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASDP</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="img/asdp.png" type="image/x-icon">


    <style>
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 400px;
            text-align: center;
            justify-content: center;
            align-items: center;
        }

        .card h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-label {
            text-align: left;
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        .form-button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
        }
        .home {
        display: flex;
        justify-content: center;
        align-items: center;
        }
        @media (max-width: 768px) {
        table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        th,
        td {
            min-width: 100px;
        }
    }
    th {
            background-color: #292e66;
           color: white;
        }
    tr {
        background-color: gray;
           color: white;
    }
    .btnn {
            display: inline-block;
            font-size: 14px;
            line-height: 1.5;
            border: none;
            border-radius: 4px;
            padding: 6px 12px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
           
        }
    .btn-warning {
            background-color: #ffc107;
            color: #fff;
        
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn i {
            font-size: 20px;
        }
        .btnn span {
            display: inline-block;
            vertical-align: middle;
            margin-left: 5px; /* Margin between icon and text */
        }

    </style>
</head>
<body>

    <header>
        <div class="logo"><span>ASDP</span>_Kewapante.</div>
        <ul class="navlist">
            <li><a href="index.php"></a></li>
            <li><a href="about.php">Tentang</a></li>
            <li><a href="portfolio.php">Kapal</a></li>
            <li><a href="services.php" class="active">Tiket</a></li>
            <li><a href="pembelian.php">Pembelian tiket</a></li>
            <li><a href="pembayaran.php">Pembayaran tiket</a></li>
            <li><a href="cetaktiket.php">Cetak tiket</a></li>
            <!-- <li><a id="whatsapp-link" href="https://wa.me/xxxxxxxxxx" target="_blank">WA Kami</a></li> -->
            <?php if ($loggedIn) : ?>
            <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
        <div id="menu-icon" class="bx bx-menu"></div>
    </header>

<section id="home" class="home">
    <div class="container">
        <div class="row"><br>
            <div class="col-md-6"><br>
                <h1>Tambah Data Tiket</h1>&nbsp;
                <form method="POST" action="tambah_data_tiket.php">
                <input type="hidden" id="id_tiket" name="id_tiket" class="form-input">
                <input type="hidden" id="id_kapal" name="id_kapal" class="form-input">
                <?php
                    // Koneksi ke database (sesuaikan dengan informasi koneksi ke database Anda)
                    $host = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "fotografi";

                    $conn = new mysqli($host, $username, $password, $database);

                    if ($conn->connect_error) {
                        die("Koneksi ke database gagal: " . $conn->connect_error);
                    }

                    // Ambil data kapal dari database
                    $sql = "SELECT id_kapal, nama FROM portfolio";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Memulai elemen select
                        echo '<label for="nama" class="form-label">Silakan pilih kapal:</label>';
                        echo '<select id="nama" name="nama" class="form-input" onchange="getIdKapal()" autofocus required>';
                        // Menampilkan opsi untuk setiap baris hasil query
                        while($row_kapal = $result->fetch_assoc()) {
                            $selected = ($row_kapal["id_kapal"] == $row_old_data['id_kapal']) ? 'selected' : '';
                            echo '<option value="' . $row_kapal["nama"] . '" ' . $selected . '>' . $row_kapal["nama"] . '</option>';
                        }
                        echo '</select>';
                    } else {
                        echo "Tidak ada data kapal dalam database.";
                    }

                    // Tutup koneksi ke database
                    $conn->close();
                    ?>
                    <label for="tujuan" class="form-label">Tujuan:</label>
                    <textarea type="text" id="tujuan" name="tujuan" class="form-textarea" rows="1" cols="70" required></textarea>
                    
                    <label for="umur" class="form-label">Umur:</label>
                    <input type="text" id="umur" name="umur" class="form-input" required>

                    <label for="kelas" class="form-label">Kelas:</label>
                    <input type="text" id="kelas" name="kelas" class="form-input" required>

                    <label for="ekonomi" class="form-label">Ekonomi:</label>
                    <input type="text" id="ekonomi" name="ekonomi" class="form-input" required>

                    <label for="harga" class="form-label">Harga:</label>
                    <input type="text" id="harga" name="harga" class="form-input" required>
                    
                    <input type="submit" value="Tambah" class="form-button">
                </form>
            </div>
            &nbsp;
            <div class="btn-box">
                <a href="services.php" class="btn float-right">Kembali</a>
            </div>
        </div>
    </div>
</section>

<footer>
    <p><a href="login.php" style="color: #bdbdbd;">Copyright &copy;</a> 2023 by Xgaming || All Right Reserved.</p>
</footer>

<script src="mixitup.min.js"></script>
<script src="script.js"></script>
<script src="scrypt.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.4/dist/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function getIdKapal() {
    var namaKapal = document.getElementById("nama").value;
    $.ajax({
        type: "POST",
        url: "get_id_kapal.php",
        data: { nama_kapal: namaKapal },
        success: function(response) {
            document.getElementById("id_kapal").value = response;
        }
    });
}
</script>
</body>
</html>
