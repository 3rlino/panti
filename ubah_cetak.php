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
  $id_cetak = $_POST["id_cetak"];
  $id_pembayaran = $_POST["id_pembayaran"];
  $kode_pembayaran = $_POST["kode_pembayaran"];
  $nama = $_POST["nama"];
  $tanggal = $_POST["tanggal"];

  // Ambil data lama dari database
  $conn = mysqli_connect("localhost", "root", "", "fotografi");
  $query_get_old_data = "SELECT * FROM cetak WHERE id_cetak='$id_cetak'";
  $result_old_data = mysqli_query($conn, $query_get_old_data);
  $row_old_data = mysqli_fetch_assoc($result_old_data);


    // Bandingkan data lama dengan data baru
    if (
        $kode_pembayaran != $row_old_data['kode_pembayaran'] ||
        $nama != $row_old_data['nama'] ||
        $tanggal != $row_old_data['tanggal'] 
        
    ) {
        // Ada perubahan, lakukan update
        $query = "UPDATE cetak SET kode_pembayaran='$kode_pembayaran', nama='$nama', tanggal='$tanggal' WHERE id_cetak='$id_cetak'";
        if (mysqli_query($conn, $query)) {
            $_SESSION['data_edit'] = true;
            header("Location: cetaktiket.php?editSuccess=1");
            exit();
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn); // Menggunakan $conn bukan $connect
        }
    } else {
        // Tidak ada perubahan, tidak perlu melakukan update
        header("Location: cetaktiket.php"); // Redirect tanpa pesan sukses
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
            <li><a href="pembelian.php">Pembelian tiket</a></li>
            <li><a href="pembayaran.php">Pembayaran tiket</a></li>
            <li><a href="cetaktiket.php" class="active">Cetak tiket</a></li>
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
                <h1>Ubah Data Cetak Tiket</h1>&nbsp;
                  <?php
        if (isset($_GET["id_cetak"])) {
            $id_cetak = $_GET["id_cetak"];
            $connect = mysqli_connect("localhost", "root", "", "fotografi");
            $query = "SELECT * FROM cetak WHERE id_cetak = '$id_cetak'";
            $result = mysqli_query($connect, $query);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <form method="POST">
                <input type="hidden" name="id_cetak" value="<?php echo $row['id_cetak']; ?>">
                <input type="hidden" name="id_pembayaran" value="<?php echo $row['id_pembayaran']; ?>">
                
                    <label for="kode_pembayaran" class="form-label">Kode Pembayaran:</label>
                    <textarea type="text" id="kode_pembayaran" name="kode_pembayaran" class="form-textarea" rows="1" cols="70" required><?php echo $row['kode_pembayaran']; ?></textarea>
                
                    <label for="nama" class="form-label">Nama:</label>
                    <input type="text" id="nama" name="nama" class="form-input" value="<?php echo $row['nama']; ?>" required>

                    <label for="tanggal" class="form-label">Tanggal:</label>
                    <input type="date" id="tanggal" name="tanggal" class="form-input" value="<?php echo $row['tanggal']; ?>" required>

                    <input type="submit" name="update" value="Update" class="form-button">
                </form>
            </div>
            &nbsp;
            <div class="btn-box">
                <a href="cetaktiket.php" class="btn float-right">Kembali</a>
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
