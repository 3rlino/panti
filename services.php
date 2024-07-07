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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASDP</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="img/asdp.png" type="image/x-icon">
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
    
    <section id="services" class="services">
        <div class="main-text">
            <span>Apa yang akan saya lakukan untuk Anda</span>
            <h2>Tiket Kami</h2>
        </div>  
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
        <div class="btn-box">
                <?php if ($loggedIn) : ?>
                <a href="admin_tambah_service.php" class="btn float-right">Tambah Data</a>
                <?php endif; ?>
                </div>
                <br>
  
        <div class="section-services">
        <?php
    $connect = mysqli_connect("localhost", "root", "", "fotografi");
    $query = "SELECT id_tiket, id_kapal, nama, tujuan, umur, kelas, ekonomi, harga FROM tiket";
    $result = mysqli_query($connect, $query);
    $index = 0; // Menambahkan variabel index untuk menambahkan angka unik pada ID
    while ($row = mysqli_fetch_array($result)) {
        $index++; // Menambahkan nilai index setiap kali loop
?>

<div class="service-box">
<img src="img/asdp.png" alt="Ikon Kamera" class="bx bxs-camera service-icon"  style="width: 116px; height: 116px;"> <br><br>
    
    <h4><b>Nama Kapal</b> :<?php echo $row["nama"]; ?></h4>&nbsp;
    <p id="service-text-<?php echo $index; ?>"><b>Tujuan</b> :<?php echo $row["tujuan"]; ?></p>
    <p id="service-text-<?php echo $index; ?>"><b>Umur</b> :<?php echo $row["umur"]; ?></p>
    <p id="service-text-<?php echo $index; ?>"><b>Kelas</b> :<?php echo $row["kelas"]; ?></p>
    <p id="service-text-<?php echo $index; ?>"><b>Ekonomi</b> :<?php echo $row["ekonomi"]; ?></p>
    <p id="service-text-<?php echo $index; ?>"><b>Harga</b> :<?php echo $row["harga"]; ?></p>
    
    <div class="btn-box service-btn">
        <a href="#" class="btn" data-target="service-text-<?php echo $index; ?>" id="button-<?php echo $index; ?>">Detail</a>
    </div><br>
    <?php if ($loggedIn) : ?>
        
        <a href="ubah_service.php?id_tiket=<?php echo $row["id_tiket"]; ?>" class="edit-button"><i class="bx bx-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="delete_service.php?id_tiket=<?php echo $row['id_tiket']; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')"  class="delete-button"><i class="bx bx-trash"></i></a>

    <?php endif; ?>
</div>
<?php
    }
?>

        </div>
        &nbsp;
        <div class="btn-box">
        <a href="index.php" class="btn float-right">Kembali</a>
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
    function toggleText(elementId, buttonId) {
    var paragraph = document.getElementById(elementId);
    var button = document.getElementById(buttonId);

    if (paragraph.getAttribute('data-full-text') === 'true') {
        // Menampilkan hanya 3 paragraf dalam service-box
        var paragraphs = paragraph.parentNode.querySelectorAll('p');
        for (var i = 0; i < paragraphs.length; i++) {
            if (i >= 3) {
                paragraphs[i].style.display = 'none';
            }
        }
        paragraph.setAttribute('data-full-text', 'false');
        button.textContent = "Detail";
    } else {
        // Menampilkan semua paragraf dalam service-box
        var paragraphs = paragraph.parentNode.querySelectorAll('p');
        for (var i = 0; i < paragraphs.length; i++) {
            paragraphs[i].style.display = 'block';
        }
        paragraph.setAttribute('data-full-text', 'true');
        button.textContent = "Tutup";
    }
}

    // Inisialisasi
    var serviceBoxes = document.querySelectorAll('.service-box');
    for (var i = 0; i < serviceBoxes.length; i++) {
        var paragraphs = serviceBoxes[i].querySelectorAll('p');
        for (var j = 0; j < paragraphs.length; j++) {
            if (j >= 3) {
                paragraphs[j].style.display = 'none';
            }
        }
    }

    // Menambahkan event listener untuk setiap tombol "Detail"
    var buttons = document.querySelectorAll('.service-box .btn');
    buttons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            var elementId = button.getAttribute('data-target');
            toggleText(elementId, button.id);
        });
    });
</script>


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