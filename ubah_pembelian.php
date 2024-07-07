<?php
// edit_data.php
session_start();

if (isset($_SESSION['username'])) {
  $loggedIn = true;
} else {
  $loggedIn = false;
}

// Cek apakah form telah disubmit
if (isset($_POST["update"])) {
  $id_pembelian = $_POST["id_pembelian"];
  $id_tiket = $_POST["id_tiket"];
  $nama = $_POST["nama"];
  $umur = $_POST["umur"];
  $tanggal = $_POST["tanggal"];
  $kode_pembelian = $_POST["kode_pembelian"];

  // Ambil data lama dari database
  $conn = mysqli_connect("localhost", "root", "", "fotografi");
  $query_get_old_data = "SELECT * FROM pembelian WHERE id_pembelian='$id_pembelian'";
  $result_old_data = mysqli_query($conn, $query_get_old_data);
  $row_old_data = mysqli_fetch_assoc($result_old_data);


    // Bandingkan data lama dengan data baru
    if (
        $id_tiket != $row_old_data['id_tiket'] ||
        $nama != $row_old_data['nama'] ||
        $umur != $row_old_data['umur'] ||
        $tanggal != $row_old_data['tanggal'] ||
        $kode_pembelian != $row_old_data['kode_pembelian'] 
        
    ) {
        // Ada perubahan, lakukan update
        $query = "UPDATE pembelian SET id_tiket='$id_tiket', nama='$nama', umur='$umur', tanggal='$tanggal', kode_pembelian='$kode_pembelian' WHERE id_pembelian='$id_pembelian'";
        if (mysqli_query($conn, $query)) {
            $_SESSION['data_edit'] = true;
            header("Location: pembelian.php?editSuccess=1");
            exit();
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn); // Menggunakan $conn bukan $connect
        }
    } else {
        // Tidak ada perubahan, tidak perlu melakukan update
        header("Location: pembelian.php"); // Redirect tanpa pesan sukses
        exit();
    }
    // Setelah blok kondisi form submit, lakukan penghapusan sesi di sini
if (isset($_SESSION['data_edit']) && $_SESSION['data_edit']) {
    unset($_SESSION['data_edit']);
}

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
            <li><a href="services.php">Tiket</a></li>
            <li><a href="pembelian.php" class="active">Pembelian tiket</a></li>
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
                <h1>Ubah Data Pembelian</h1>&nbsp;
                  <?php
       if (isset($_GET["id_pembelian"])) {
        $id_pembelian = $_GET["id_pembelian"];
        $connect = mysqli_connect("localhost", "root", "", "fotografi");
        $query = "SELECT * FROM pembelian WHERE id_pembelian = '$id_pembelian'";
        $result = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_array($result)) {
            // Inisialisasi $id_tiket dengan nilai dari database
            $id_tiket = $row['id_tiket'];
            ?>
            <form method="POST">
            <input type="hidden" name="id_pembelian" value="<?php echo $row['id_pembelian']; ?>">
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
    
                // Ambil data tiket dari database
                $sql = "SELECT id_tiket, ekonomi FROM tiket";
                $result = $conn->query($sql);
    
                if ($result->num_rows > 0) {
                    // Memulai elemen select
                    echo '<label for="tiket" class="form-label">Silakan pilih tiket:</label>';
                    echo '<select id="tiket" name="id_tiket" class="form-input" autofocus required>';
                    
                    // Menampilkan opsi untuk setiap baris hasil query
                    while($row_tiket = $result->fetch_assoc()) {
                        // Periksa apakah id_tiket dari hasil query sama dengan id_tiket yang sudah ada dalam data
                        if ($row_tiket["id_tiket"] == $id_tiket) {
                            // Jika ya, tandai sebagai opsi yang dipilih
                            echo '<option value="' . $row_tiket["id_tiket"] . '" selected>' . $row_tiket["ekonomi"] . '</option>';
                        } else {
                            // Jika tidak, tambahkan opsi tanpa tanda
                            echo '<option value="' . $row_tiket["id_tiket"] . '">' . $row_tiket["ekonomi"] . '</option>';
                        }
                    }
                    echo '</select>';
                } else {
                    echo "Tidak ada data tiket dalam database.";
                }
    
                // Tutup koneksi ke database
                $conn->close();
                ?>
                <label for="nama" class="form-label">Nama:</label>
                <textarea type="text" id="nama" name="nama" class="form-textarea" rows="1" cols="70" required><?php echo $row['nama']; ?></textarea>
            
                <label for="judul" class="form-label">Umur:</label>
                <input type="text" id="umur" name="umur" class="form-input" value="<?php echo $row['umur']; ?>" required>
    
                <label for="tanggal" class="form-label">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" class="form-input" value="<?php echo $row['tanggal']; ?>" required>
                
                <label for="kode_pembelian" class="form-label">kode Pembelian:</label>
                <input type="text" id="kode_pembelian" name="kode_pembelian" class="form-input" value="<?php echo $row['kode_pembelian']; ?>" required>
    
                <input type="submit" name="update" value="Update" class="form-button">
            </form>
            </div>
            &nbsp;
            <div class="btn-box">
                <a href="pembelian.php" class="btn float-right">Kembali</a>
            </div>
            <?php
            }}
            ?>
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
</body>
</html>
