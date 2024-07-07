<?php
session_start();

// Periksa apakah pengguna sudah login
if (isset($_SESSION['username'])) {
    $loggedIn = true;
} else {
    $loggedIn = false;
}

// Inisialisasi variabel $page
$pages = isset($_GET['page']) ? $_GET['page'] : 1;

// Jika operasi penghapusan berhasil
if (isset($_SESSION['data_deleted']) && $_SESSION['data_deleted']) {
    $deleteSuccess = true;
    unset($_SESSION['data_deleted']); // Hapus sesi setelah pesan ditampilkan
}

// Jika operasi penambahan berhasil
if (isset($_SESSION['data_added']) && $_SESSION['data_added']) {
    $addSuccess = true;
    unset($_SESSION['data_added']); // Hapus sesi setelah pesan ditampilkan
}

// Jika operasi pembaruan berhasil
if (isset($_SESSION['data_edited']) && $_SESSION['data_edited']) {
    $editSuccess = true;
    unset($_SESSION['data_edited']); // Hapus sesi setelah pesan ditampilkan
}
$deleteSuccess = isset($_GET['deleteSuccess']) && $_GET['deleteSuccess'] === '1';
$addSuccess = isset($_GET['addSuccess']) && $_GET['addSuccess'] === '1';
$editSuccess = isset($_GET['editSuccess']) && $_GET['editSuccess'] === '1'; // Menambahkan inisialisasi variabel $editSuccess
?>

<!DOCTYPE html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASDP</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="img/asdp.png" type="image/x-icon">

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
    
    <section id="portfolio" class="portfolio">
        <div class="main-text">
            <span>Apa yang akan saya lakukan untuk Anda</span>
            <h2>Kapal Kami</h2>
        </div>
       
        <div class="btn-box">
            <?php if ($loggedIn) : ?>
                <a href="tambahportfolio.php" class="btn">Tambah</a>
            <?php endif; ?>
            <!-- <a href="" class="btn">Hire Me Now!</a> -->
        </div><br>
        <div class="container" style="margin-bottom: 20px;">
        <?php if (isset($editSuccess) && $editSuccess) : ?>
            <?php if (isset($_SESSION['data_edited']) && $_SESSION['data_edited']) { ?>
                <div id="editSuccessModal" class="alert alert-success modal">
                    <i class="bx bx-check"></i> Data berhasil diperbaharui.
                </div>
                <?php unset($_SESSION['data_edited']); // Hapus sesi setelah pesan ditampilkan
            } ?>
            <script>
                if (typeof window.history.replaceState == 'function') {
                    history.replaceState({}, null, window.location.pathname);
                }
            </script>
            <?php endif; ?>
            <?php if (isset($addSuccess) && $addSuccess) : ?>
            <?php if (isset($_SESSION['data_added']) && $_SESSION['data_added']) { ?>
                <div id="addSuccessModal" class="alert alert-success modal">
                    <i class="bx bx-check"></i> Data berhasil ditambahkan.
                </div>
                <?php unset($_SESSION['data_added']); // Hapus sesi setelah pesan ditampilkan
            } ?>
            <script>
                if (typeof window.history.replaceState == 'function') {
                    history.replaceState({}, null, window.location.pathname);
                }
            </script>
            <?php endif; ?>
            <?php if (isset($deleteSuccess) && $deleteSuccess) : ?>
            <?php if (isset($_SESSION['data_deleted']) && $_SESSION['data_deleted']) { ?>
                <div id="deleteSuccessModal" class="alert alert-success modal">
                    <i class="bx bx-check"></i> Data berhasil dihapus.
                </div>
                <?php unset($_SESSION['data_deleted']); // Hapus sesi setelah pesan ditampilkan
            } ?>
            <script>
                if (typeof window.history.replaceState == 'function') {
                    history.replaceState({}, null, window.location.pathname);
                }
            </script>
            <?php endif; ?>
            <div class="portfolio-gallery">
                <?php
                $connect = mysqli_connect("localhost", "root", "", "fotografi");
                $query = "SELECT id_kapal, foto, nama, jenis, rute, nahkoda FROM portfolio";
                $result = mysqli_query($connect, $query);
                while ($row = mysqli_fetch_array($result)) {
                ?>
                <div class="port-box">
                    <div class="port-image">
                        <img src="uploads/portfolio/<?php echo $row["foto"]; ?>" alt="">
                    </div>
                    <div class="port-content">
                    <h6 style="margin-bottom: 10px;">Nama Kapal : <?php echo $row["nama"]; ?></h6>
                    <p>Jenis Kapal : <?php echo $row["jenis"]; ?></p>
                    <p>Rute : <?php echo $row["rute"]; ?></p>
                    <p>Nahkoda : <?php echo $row["nahkoda"]; ?></p>
                        <?php if ($loggedIn) : ?>
                            <a href="editportfolio.php?id_kapal=<?php echo $row["id_kapal"]; ?>" class="edit-button"><i class="bx bx-edit"></i></a>&nbsp;
                            <a onclick="return confirm('yakin menghapus?');" href="hapusportfolio.php?id=<?php echo $row["id_kapal"]; ?>" class="delete-button"><i class="bx bx-trash"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            &nbsp;&nbsp;
        <div class="btn-box">
        <a href="index.php" class="btn float-right">Kembali</a>
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
    <script>
    <?php if (isset($deleteSuccess) && $deleteSuccess) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Data berhasil dihapus',
            showConfirmButton: false,
            timer: 1500
        });
        <?php unset($_SESSION['data_deleted']); // Hapus sesi setelah pesan ditampilkan ?>
    <?php endif; ?>
    <?php if (isset($addSuccess) && $addSuccess) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Data berhasil ditambahkan',
            showConfirmButton: false,
            timer: 1500
        });
        <?php unset($_SESSION['data_added']); // Hapus sesi setelah pesan ditampilkan ?>
    <?php endif; ?>
    <?php if (isset($editSuccess) && $editSuccess) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Data berhasil diperbaharui',
            showConfirmButton: false,
            timer: 1500
        });
        <?php unset($_SESSION['data_edited']); // Hapus sesi setelah pesan ditampilkan ?>
    <?php endif; ?>
</script>

</body>
</html>
