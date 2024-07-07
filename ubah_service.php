<?php
session_start();

if (isset($_SESSION['username'])) {
    $loggedIn = true;
} else {
    $loggedIn = false;
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "fotografi";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil nilai id_tiket dari parameter URL
if (isset($_GET['id_tiket'])) {
    $id_tiket = $_GET['id_tiket'];

    // Lakukan sanitasi data
    $id_tiket = mysqli_real_escape_string($conn, $id_tiket);

    // Query untuk mendapatkan data tiket
    $sql = "SELECT * FROM tiket WHERE id_tiket = '$id_tiket'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_kapal = $row['id_kapal'];
        $nama_kapal = $row['nama'];
        $tujuan = $row['tujuan'];
        $umur = $row['umur'];
        $kelas = $row['kelas'];
        $ekonomi = $row['ekonomi'];
        $harga = $row['harga'];
    } else {
        echo "Data tidak ditemukan.";
        exit(); // Hentikan eksekusi jika data tidak ditemukan
    }
} else {
    echo "ID Tiket tidak ditemukan.";
    exit(); // Hentikan eksekusi jika ID Tiket tidak ditemukan di parameter URL
}

// Proses update data jika metode request adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_kapal_new = $_POST['id_kapal'];
    $nama_kapal_new = $_POST['nama_kapal'];
    $tujuan_new = $_POST['tujuan'];
    $umur_new = $_POST['umur'];
    $kelas_new = $_POST['kelas'];
    $ekonomi_new = $_POST['ekonomi'];
    $harga_new = $_POST['harga'];

    // Ambil data lama dari database
    $query_get_old_data = "SELECT * FROM tiket WHERE id_tiket='$id_tiket'";
    $result_old_data = $conn->query($query_get_old_data);
    $row_old_data = $result_old_data->fetch_assoc();

    // Bandingkan data lama dengan data baru
    if (
        $id_kapal_new != $row_old_data['id_kapal'] ||
        $nama_kapal_new != $row_old_data['nama'] ||
        $tujuan_new != $row_old_data['tujuan'] ||
        $umur_new != $row_old_data['umur'] ||
        $kelas_new != $row_old_data['kelas'] ||
        $ekonomi_new != $row_old_data['ekonomi'] ||
        $harga_new != $row_old_data['harga']
    ) {
        // Ada perubahan, lakukan update
        $query = "UPDATE tiket SET id_kapal='$id_kapal_new', nama='$nama_kapal_new', tujuan='$tujuan_new', umur='$umur_new', kelas='$kelas_new', ekonomi='$ekonomi_new', harga='$harga_new' WHERE id_tiket='$id_tiket'";

        if ($conn->query($query)) {
            $_SESSION['data_edit'] = true;
            header("Location: services.php?editSuccess=1");
            exit();
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    } else {
        // Tidak ada perubahan, tidak perlu melakukan update
        header("Location: services.php");
        exit();
    }
}

// Hapus sesi setelah melakukan edit
if (isset($_SESSION['data_edit']) && $_SESSION['data_edit']) {
    unset($_SESSION['data_edit']);
}

$conn->close();
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
                <h1>Ubah Data Tiket</h1>&nbsp;
                  <?php
        if (isset($_GET["id_tiket"])) {
            $id_tiket = $_GET["id_tiket"];
            $connect = mysqli_connect("localhost", "root", "", "fotografi");
            $query = "SELECT * FROM tiket WHERE id_tiket = '$id_tiket'";
            $result = mysqli_query($connect, $query);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <form method="POST">
                <input type="hidden" name="id_tiket" value="<?php echo $row['id_tiket']; ?>">
    <!-- Tambahkan input tersembunyi untuk id_kapal -->
    <input type="hidden" name="id_kapal" value="<?php echo $row['id_kapal']; ?>">
    
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
                        // Mulai elemen select
                        echo '<label for="nama" class="form-label">Silakan pilih kapal:</label>';
                        echo '<select id="nama" name="nama_kapal" class="form-input" autofocus required>';

                        // Loop melalui hasil query untuk menambahkan opsi untuk setiap nama kapal
                        while($row_kapal = $result->fetch_assoc()) {
                            // Periksa apakah nama kapal dari hasil query sama dengan nama kapal yang sudah ada dalam data
                            if ($row_kapal["nama"] == $nama_kapal) {
                                // Jika ya, tandai sebagai opsi yang dipilih
                                echo '<option value="' . $row_kapal["nama"] . '" selected>' . $row_kapal["nama"] . '</option>';
                            } else {
                                // Jika tidak, tambahkan opsi tanpa tanda
                                echo '<option value="' . $row_kapal["nama"] . '">' . $row_kapal["nama"] . '</option>';
                            }
                        }
                        echo '</select>';
                    } else {
                        echo "Tidak ada data kapal dalam database.";
                    }

                    // Tutup koneksi ke database
                    $conn->close();
                    ?>
                    <label for="tujuan" class="form-label">Tujuan:</label>
                    <textarea type="text" id="tujuan" name="tujuan" class="form-textarea" rows="1" cols="70" required><?php echo $row['tujuan']; ?></textarea>
                
                    <label for="judul" class="form-label">Umur:</label>
                    <input type="text" id="umur" name="umur" class="form-input" value="<?php echo $row['umur']; ?>" required>

                    <label for="kelas" class="form-label">Kelas:</label>
                    <input type="text" id="kelas" name="kelas" class="form-input" value="<?php echo $row['kelas']; ?>" required>
                    
                    <label for="ekonomi" class="form-label">Ekonomi:</label>
                    <input type="text" id="ekonomi" name="ekonomi" class="form-input" value="<?php echo $row['ekonomi']; ?>" required>

                    <label for="harga" class="form-label">Harga:</label>
                    <input type="text" id="harga" name="harga" class="form-input" value="<?php echo $row['harga']; ?>" required>

                    <input type="submit" name="update" value="Update" class="form-button">
                </form>
            </div>
            &nbsp;
            <div class="btn-box">
                <a href="services.php" class="btn float-right">Kembali</a>
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
</body>
</html>
