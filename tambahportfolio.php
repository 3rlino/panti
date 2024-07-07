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
            <h1>Tambah Kapal</h1>&nbsp;
            <form method="POST" action="proses_tambah_portfolio.php" enctype="multipart/form-data">
                <label for="nama" class="form-label">Nama Kapal:</label>
                <input type="text" id="nama" name="nama" class="form-input" autofocus required>
                
                <label for="jenis" class="form-label">Jenis:</label>
                <input type="text" id="jenis" name="jenis" class="form-input" required>

                <label for="rute" class="form-label">Rute:</label>
                <textarea id="rute" name="rute" class="form-textarea" rows="4" cols="50" required></textarea>

                <label for="nahkoda" class="form-label">nahkoda:</label>
                <input type="text" id="nahkoda" name="nahkoda" class="form-input" autofocus required>
                
                <label for="gambar" class="form-label">Gambar:</label>
                <input type="file" id="gambar" name="gambar" accept="image/*" class="form-input" required>
                
                <input type="submit" value="Tambah" class="form-button">
            </form>
        </div>
        &nbsp;
        <div class="btn-box">
        <a href="portfolio.php" class="btn float-right">Kembali</a>
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
</body>
</html>