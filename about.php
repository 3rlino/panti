<?php
session_start();

if (isset($_SESSION['username'])) {
    $loggedIn = true;
} else {
    $loggedIn = false;
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
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo"><span>ASDP</span>_Kewapante.</div>
        <ul class="navlist">
            <li><a href="index.php"></a></li>
            <li><a href="about.php" class="active">Tentang</a></li>
            <li><a href="portfolio.php">Kapal</a></li>
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
    
    <section id="about" class="about">
        <div class="img-about">
            <img src="img/7.png" alt="">
            <div class="info-about1">
                <span>10+</span>
                <p>Cruise</p>
            </div>
            <div class="info-about2">
                <span>150+</span>
                <p>Service</p>
            </div>
            <div class="info-about3">
                <span>200+</span>
                <p>Rewards</p>
            </div>
        </div>
        <div class="about-content">
            <span>Izinkan saya memperkenalkan ASDP</span>
            <h2>Tentang PT. ASDP</h2>
            <h3>Cerita yang baik</h3>
            <p id="intro-text">PT ASDP Indonesia Ferry ( Persero) atau ASDP adalah BUMN yang bergerak dalam bisnis jasa penyeberangan dan pelabuhan terintegrasi dan tujuan wisata waterfront . ASDP menjalankan armada ferry sebanyak lebih dari 226 unit kapal yang melayani 307 lintasan dan 36 pelabuhan di seluruh Indonesia dan mengembangkan bisnis lainnya terkait dengan pengembangan kawasan pelabuhan, seperti Bakauheni Harbour City  di Provinsi Lampung dan Kawasan Marina Labuan Bajo di Nusa Tenggara Timur.</p>
            <p id="extra-text" class="hidden">Perusahaan ini memulai sejarahnya pada tanggal 27 Maret 1973 dengan nama Proyek Angkutan Sungai, Danau, dan Ferry (PASDF) di bawah naungan Direktorat Lalu Lintas Angkutan Sungai Danau dan Ferry (DLLASDF), Direktorat Jenderal Perhubungan Darat, Departemen Perhubungan. Pada tahun 1980, nama PASDF diubah menjadi Proyek Angkutan Sungai Danau dan Penyeberangan (PASDP). PASDP bertugas menyediakan pelayanan angkutan penyeberangan antar pulau, menyediakan terminal umum penyeberangan angkutan sungai, danau, dan ferry, serta menjamin keselamatan pada sistem transportasi tersebut.</p>
            <div class="btn-box">
                <a href="javascript:void(0);" onclick="toggleText();" class="btn" id="read-more-btn">Detail</a> &nbsp; <a href="index.php" class="btn float-right">Kembali</a>
            </div>
        </div>        
    </section>
    <footer>
        <p><a href="login.php" style="color: #bdbdbd;">Copyright &copy;</a> 2023 by Xgaming || All Right Reserved.</p>
    </footer>
   <script>
    
let menuIcon = document.querySelector("#menu-icon");
let navlist = document.querySelector(".navlist");

menuIcon.onclick = ()=>{
    menuIcon.classList.toggle("bx-x");
    navlist.classList.toggle("open");
}
window.onscroll = ()=>{
    menuIcon.classList.remove("bx-x");
    navlist.classList.remove("open");
}
   </script>
    <script>
        function toggleText() {
            var introText = document.getElementById('intro-text');
            var extraText = document.getElementById('extra-text');
            var readMoreBtn = document.getElementById('read-more-btn');
    
            if (extraText.classList.contains('hidden')) {
                extraText.classList.remove('hidden');
                readMoreBtn.textContent = 'Tutup';
            } else {
                extraText.classList.add('hidden');
                readMoreBtn.textContent = 'Detail';
            }
        }
    </script>
     <script>
    document.addEventListener("DOMContentLoaded", function() {
    // Ganti karakter "xxxxxxxxxx" dengan nomor telepon yang sebenarnya
    var nomorTeleponAsli = "+6285239153735"; // Ganti dengan nomor telepon yang benar
    
    // Perbarui tautan WhatsApp dengan nomor telepon yang sebenarnya
    var whatsappLink = document.getElementById("whatsapp-link");
    whatsappLink.href = "https://wa.me/" + nomorTeleponAsli;
    whatsappLink.textContent = "WA Kami";
    });
    </script>
     <script src="scrypt.js"></script>
    </body>
    </html>