<?php
session_start();

if (isset($_SESSION['username'])) {
  $loggedIn = true;
} else {
  $loggedIn = false;
}

$servername = "localhost"; // Ganti dengan server database Anda
$username = "root"; // Ganti dengan nama pengguna database Anda
$password = ""; // Ganti dengan kata sandi database Anda
$database = "fotografi"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id_kapal = $_GET['id_kapal'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_kapal = $_POST['id_kapal'];
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $rute = $_POST['rute'];
    $nahkoda = $_POST['nahkoda'];

    // Ambil data lama dari database
    $query_get_old_data = "SELECT * FROM portfolio WHERE id_kapal='$id_kapal'";
    $result_old_data = $conn->query($query_get_old_data);
    $row_old_data = $result_old_data->fetch_assoc();

    // Bandingkan data lama dengan data baru
    if (
        $nama != $row_old_data['nama'] ||
        $jenis != $row_old_data['jenis'] ||
        $rute != $row_old_data['rute'] ||
        $nahkoda != $row_old_data['nahkoda'] ||
        ($_FILES['foto']['error'] === 0) // Jika ada gambar baru diunggah
    ) {
        // Ada perubahan, lakukan update

        // Cek apakah gambar baru diunggah
        if ($_FILES['foto']['error'] === 0) {
            // Hapus gambar lama
            $gambarLama = 'uploads/portfolio/' . $row_old_data['foto'];
            if (file_exists($gambarLama)) {
                unlink($gambarLama);
            }

            // Generate nama file foto baru secara acak
            $randomName = generateRandomName(10) . '.' . pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $gambarBaru = $randomName;
            $gambarTmp = $_FILES['foto']['tmp_name'];
            move_uploaded_file($gambarTmp, 'uploads/portfolio/' . $randomName);

            // Update database dengan nama gambar baru
            $sql = "UPDATE portfolio SET nama = '$nama', jenis = '$jenis', rute = '$rute', nahkoda = '$nahkoda', foto = '$gambarBaru' WHERE id_kapal = $id_kapal";
        } else {
            // Jika tidak ada gambar baru diunggah, lakukan update data tanpa gambar
            $sql = "UPDATE portfolio SET nama = '$nama', jenis = '$jenis', rute = '$rute', nahkoda = '$nahkoda' WHERE id_kapal = $id_kapal";
        }

        if ($conn->query($sql)) {
            $_SESSION['data_edit'] = true;
            header("Location: portfolio.php?editSuccess=1");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Tidak ada perubahan, tidak perlu melakukan update
        // Jangan lakukan redirect atau tampilkan pesan di sini
        header("Location: portfolio.php");
        exit();
    }
}

$sql = "SELECT * FROM portfolio WHERE id_kapal = '$id_kapal'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_kapal = $row['id_kapal'];
    $nama = $row['nama'];
    $jenis = $row['jenis'];
    $rute = $row['rute'];
    $nahkoda = $row['nahkoda'];
    $foto = 'uploads/portfolio/' . $row['foto'];
} else {
    echo "Data tidak ditemukan.";
}

// Hapus sesi setelah melakukan edit
if (isset($_SESSION['data_edit']) && $_SESSION['data_edit']) {
    unset($_SESSION['data_edit']);
}

$conn->close();

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



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Portfolio</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
    </style>
</head>
<body>

<header>
        <div class="logo"><span>ASDP</span>_Kewapante.</div>
        <ul class="navlist">
            <li><a href="index.php"></a></li>
            <li><a href="about.php">Tentang</a></li>
            <li><a href="portfolio.php" class="active">Kapal</a></li>
            <li><a href="services.php">Tiket</a></li>
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
                    <h1>Edit Data Kapal</h1>&nbsp;
                    <?php
        if (isset($_GET["id_kapal"])) {
            $id_kapal = $_GET["id_kapal"];
            $connect = mysqli_connect("localhost", "root", "", "fotografi");
            $query = "SELECT * FROM portfolio WHERE id_kapal = '$id_kapal'";
            $result = mysqli_query($connect, $query);
            while($row = mysqli_fetch_array($result)) {
                ?>
                    <form method="POST" action="editportfolio.php?id=<?php echo $id_kapal; ?>" enctype="multipart/form-data">
                    
                    <input type="hidden" name="id_kapal" value="<?php echo $row['id_kapal']; ?>">
                        <label for="nama" class="form-label">Nama:</label>
                        <input type="text" id="nama" name="nama" class="form-input" value="<?php echo $nama; ?>" autofocus required>
                        <label for="jenis" class="form-label">Jenis:</label>
                        <textarea id="jenis" name="jenis" class="form-textarea" rows="1" cols="50" required><?php echo $jenis; ?></textarea>
                        <label for="rute" class="form-label">Rute:</label>
                        <input id="rute" name="rute" class="form-input" value="<?php echo $rute; ?>" required>
                        <label for="nahkoda" class="form-label">Nahkoda:</label>
                        <input id="nahkoda" name="nahkoda" class="form-input" value="<?php echo $nahkoda; ?>" required>
                        <label for="foto" class="form-label">Foto:</label>
                        <input type="file" id="foto" name="foto" accept="image/*" class="form-input">
                        <img src="<?php echo $foto; ?>" alt="foto Lama" style="max-width: 100px; margin: 10px 0;">
                        
                        <input type="submit" name="update" value="Update" class="form-button">
                    </form>&nbsp;
                    <div class="btn-box">
                    <a href="portfolio.php" class="btn" class="float-right">Kembali</a>
                    </div>
                    <?php
            }}
            ?>
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
</body>
</html>
