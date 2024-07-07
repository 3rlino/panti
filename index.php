<?php
session_start();
if (isset($_GET['success']) && $_GET['success'] === 'login_success') {
    echo "<script>alert('Login sukses. Selamat datang!');</script>";
}
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
</head>
<body>

    <header>
        <div class="logo"><span>ASDP</span>_Kewapante.</div>
        <ul class="navlist">
            <li><a href="index.php" class="active"></a></li>
            <li><a href="about.php">Tentang</a></li>
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
    <section id="home" class="home">
        <div class="home-content">
            <h1>Selamat Datang di ASDP</h1>
            <div class="change-text">
                <h3>Kewapante adalah</h3>
                <h3>
                    <span class="word">Perusahaan</span>
                    <span class="word">Transportasi</span>
                    <span class="word">Pelayaran</span>
                    <span class="word">Kapal laut</span>
                    <span class="word"></span>
                </h3>
            </div>
            <p>PT. ASDP Kewapante menawarkan layanan pembelian tiket secara online. Kami berlokasi di Kabupaten Sikka, Kecamatan Kewapante (Maumere). Terdepan dalam menghubungkan masyarakat dan pasar melalui jasa penyeberangan pelabuhan terintegrasi dan tujuan wisata waterfront.</p>
            <div class="info-box">
                <div class="email-info">
                    <h5>Email :</h5>
                    <span>bertholburce135@gmail.com </span>
                </div>
                <!-- <div class="behance-info">
                    <h5>Nomor HP :</h5>
                    <span>081353946885</span>
                </div> -->
            </div>
            <div class="btn-box">
                <a id="whatsapp" href="https://wa.me/xxxxxxxxxx" target="_blank" class="btn">Hubungi Kami</a>
                <!-- <a href="" class="btn">Hire Me Now!</a> -->
            </div>
            <div class="social-icons">
                <a href=""><i class="bx bxl-facebook"></i></a>
                <a href=""><i class="bx bxl-instagram"></i></a>
                <a href=""><i class="bx bxl-twitter"></i></a>
                <a href=""><i class="bx bxl-dribbble"></i></a>
            </div>
        </div>
        <div class="home-image">
            <div class="img-box">
                <img src="img/12.png" alt="">
            </div>
            <div class="liquid-shape">
                <svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" id="blobSvg">
                    <path fill="#12f7ff">
                        <animate attributeName="d"
                            dur="30000ms" repeatCount="indefinite"
                            values="M442.5,296Q409,342,380.5,384.5Q352,427,301,440Q250,453,209.5,421.5Q169,390,128.5,367Q88,344,67,297Q46,250,44.5,190.5Q43,131,100,110Q157,89,203.5,68.5Q250,48,306.5,51.5Q363,55,394.5,102Q426,149,451,199.5Q476,250,442.5,296Z;
                            
                            M444.5,310.5Q459,371,401.5,391.5Q344,412,297,420Q250,428,189.5,444Q129,460,101,406Q73,352,48.5,301Q24,250,36.5,192Q49,134,94,96Q139,58,194.5,49Q250,40,312,37.5Q374,35,408.5,87Q443,139,436.5,194.5Q430,250,444.5,310.5Z;
                            
                            M419.5,302.5Q432,355,392.5,392Q353,429,301.5,432Q250,435,201.5,426.5Q153,418,102,391.5Q51,365,33.5,307.5Q16,250,38.5,195.5Q61,141,94.5,89.5Q128,38,189,54.5Q250,71,294,84Q338,97,398,113.5Q458,130,432.5,190Q407,250,419.5,302.5Z;
                            
                            M472.5,312Q464,374,396.5,380Q329,386,289.5,409Q250,432,208.5,413Q167,394,122.5,371.5Q78,349,59.5,299.5Q41,250,74,208.5Q107,167,134,131.5Q161,96,205.5,81Q250,66,308.5,56.5Q367,47,394,99Q421,151,451,200.5Q481,250,472.5,312Z;
                            
                            M432,305.5Q442,361,395,390.5Q348,420,299,450Q250,480,202.5,447Q155,414,123,378Q91,342,56.5,296Q22,250,52.5,202Q83,154,124,128.5Q165,103,207.5,78Q250,53,308,51Q366,49,409,91Q452,133,437,191.5Q422,250,432,305.5Z;
                            
                            M421.5,288.5Q383,327,363,369.5Q343,412,296.5,432Q250,452,200.5,436.5Q151,421,115.5,384.5Q80,348,67,299Q54,250,49.5,191Q45,132,98.5,106Q152,80,201,89.5Q250,99,300,88Q350,77,396,108Q442,139,451,194.5Q460,250,421.5,288.5Z;
                            
                            M421,303Q434,356,404,410Q374,464,312,457.5Q250,451,190,454.5Q130,458,100.5,406Q71,354,40.5,302Q10,250,50,203.5Q90,157,121.5,119Q153,81,201.5,77.5Q250,74,288,96.5Q326,119,356,145Q386,171,397,210.5Q408,250,421,303Z;
                            
                            M466,308Q451,366,403.5,399.5Q356,433,303,458Q250,483,205,444.5Q160,406,123.5,375Q87,344,78,297Q69,250,55.5,190Q42,130,88,89.5Q134,49,192,31Q250,13,295.5,53Q341,93,401.5,110.5Q462,128,471.5,189Q481,250,466,308Z;">
                        </animate>
                    </path>
                  </svg>
            </div>

            <div class="liquid-shape">
                <svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" id="blobSvg">
                    <path fill="#12f7ff">
                        <animate attributeName="d"
                            dur="30000ms" repeatCount="indefinite"
                            values="M442.5,296Q409,342,380.5,384.5Q352,427,301,440Q250,453,209.5,421.5Q169,390,128.5,367Q88,344,67,297Q46,250,44.5,190.5Q43,131,100,110Q157,89,203.5,68.5Q250,48,306.5,51.5Q363,55,394.5,102Q426,149,451,199.5Q476,250,442.5,296Z;
                            
                            M444.5,310.5Q459,371,401.5,391.5Q344,412,297,420Q250,428,189.5,444Q129,460,101,406Q73,352,48.5,301Q24,250,36.5,192Q49,134,94,96Q139,58,194.5,49Q250,40,312,37.5Q374,35,408.5,87Q443,139,436.5,194.5Q430,250,444.5,310.5Z;
                            
                            M419.5,302.5Q432,355,392.5,392Q353,429,301.5,432Q250,435,201.5,426.5Q153,418,102,391.5Q51,365,33.5,307.5Q16,250,38.5,195.5Q61,141,94.5,89.5Q128,38,189,54.5Q250,71,294,84Q338,97,398,113.5Q458,130,432.5,190Q407,250,419.5,302.5Z;
                            
                            M472.5,312Q464,374,396.5,380Q329,386,289.5,409Q250,432,208.5,413Q167,394,122.5,371.5Q78,349,59.5,299.5Q41,250,74,208.5Q107,167,134,131.5Q161,96,205.5,81Q250,66,308.5,56.5Q367,47,394,99Q421,151,451,200.5Q481,250,472.5,312Z;
                            
                            M432,305.5Q442,361,395,390.5Q348,420,299,450Q250,480,202.5,447Q155,414,123,378Q91,342,56.5,296Q22,250,52.5,202Q83,154,124,128.5Q165,103,207.5,78Q250,53,308,51Q366,49,409,91Q452,133,437,191.5Q422,250,432,305.5Z;
                            
                            M421.5,288.5Q383,327,363,369.5Q343,412,296.5,432Q250,452,200.5,436.5Q151,421,115.5,384.5Q80,348,67,299Q54,250,49.5,191Q45,132,98.5,106Q152,80,201,89.5Q250,99,300,88Q350,77,396,108Q442,139,451,194.5Q460,250,421.5,288.5Z;
                            
                            M421,303Q434,356,404,410Q374,464,312,457.5Q250,451,190,454.5Q130,458,100.5,406Q71,354,40.5,302Q10,250,50,203.5Q90,157,121.5,119Q153,81,201.5,77.5Q250,74,288,96.5Q326,119,356,145Q386,171,397,210.5Q408,250,421,303Z;
                            
                            M466,308Q451,366,403.5,399.5Q356,433,303,458Q250,483,205,444.5Q160,406,123.5,375Q87,344,78,297Q69,250,55.5,190Q42,130,88,89.5Q134,49,192,31Q250,13,295.5,53Q341,93,401.5,110.5Q462,128,471.5,189Q481,250,466,308Z;">
                        </animate>
                    </path>
                  </svg>
            </div>
        </div>
    </section>

    <footer>
        <p><a href="login.php" style="color: #bdbdbd;">Copyright &copy;</a> 2023 by Xgaming || All Right Reserved.</p>
    </footer>


    <script src="mixitup.min.js"></script>
    <script src="script.js"></script>
    <script src="scrypt.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
    // Ganti karakter "xxxxxxxxxx" dengan nomor telepon yang sebenarnya
    var nomorTeleponAsli = "+6282235407352"; // Ganti dengan nomor telepon yang benar
    
    // Perbarui tautan WhatsApp dengan nomor telepon yang sebenarnya
    var whatsappLink = document.getElementById("whatsapp-link");
    whatsappLink.href = "https://wa.me/" + nomorTeleponAsli;
    whatsappLink.textContent = "WA Kami";
    });
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
    // Ganti karakter "xxxxxxxxxx" dengan nomor telepon yang sebenarnya
    var nomorTeleponAsli = "+6282235407352"; // Ganti dengan nomor telepon yang benar
    
    // Perbarui tautan WhatsApp dengan nomor telepon yang sebenarnya
    var whatsappLink = document.getElementById("whatsapp");
    whatsappLink.href = "https://wa.me/" + nomorTeleponAsli;
    whatsappLink.textContent = "Hubungi Kami";
    });
    </script>
</body>
</html>