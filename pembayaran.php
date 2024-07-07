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
        .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .pagination {
        flex-grow: 1;
        display: flex;
        justify-content: flex-end; /* Pusatkan pagination ke kanan */
    }

    .pagination ul {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination li {
        margin-right: 5px; /* Beri jarak antara setiap item pagination */
    }

    .pagination a {
        display: inline-block;
        padding: 5px 10px;
        background-color: #007BFF;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
    }

    .pagination a:hover {
        background-color: #0056b3; /* Ubah warna latar saat hover */
    }

    .pagination .active a {
        background-color: #0056b3; /* Warna latar saat aktif */
    }
    .content-container {
        display: flex;
        align-items: flex-start; /* Atur agar konten dan pagination sejajar */
    }

    table {
        flex-grow: 1; /* Tabel mengisi sisa ruang yang tersedia */
    }
     .table-responsive {
                            
                                border: 1px solid #ddd;
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
            <li><a href="pembayaran.php" class="active">Pembayaran tiket</a></li>
            <li><a href="cetaktiket.php">Cetak tiket</a></li>
            <!-- <li><a id="whatsapp-link" href="https://wa.me/xxxxxxxxxx" target="_blank">WA Kami</a></li> -->
            <?php if ($loggedIn) : ?>
            <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
        <div id="menu-icon" class="bx bx-menu"></div>
    </header>
    <?php if ($loggedIn) : ?>
    <section>
    <div class="container">
        <div class="row">
            <br>
            <div class="col-lg-12">
                <br>
               <center><h1>Data Pembayaran Tiket</h1></center> 
                <br>
                <div class="btn-box">
                <a href="admin_tambah_pembayaran.php" class="btn float-right">Tambah Data</a>
                </div>
            </div>
            <br />
            <div class="content-container">
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
            
            <table class="table-responsive table-striped">
                <tr>
                    <th style="width: 14%; padding: 10px;">Id Pembayaran</th>
                    <th style="width: 14%; padding: 10px;">Id Pembelian</th>
                    <th style="width: 14%; padding: 10px;">Kode Pembelian</th>
                    <th style="width: 14%; padding: 10px;">Nama</th>
                    <th style="width: 14%; padding: 10px;">Tanggal</th>
                    <th style="width: 14%; padding: 10px;">Kode Pembayaran</th>
                    <th style="width: 7%; padding: 10px;">Edit</th>
                    <th style="width: 7%; padding: 10px;">Hapus</th>
                </tr>
                <?php
                $limit_startt = 0;
                $limitt = 6;
                $connect = mysqli_connect("localhost", "root", "", "fotografi");
                $limit_startt = ($pages - 1) * $limitt;
                $query = "SELECT * FROM pembayaran ORDER BY id_pembayaran DESC LIMIT $limit_startt, $limitt";
                $result = mysqli_query($connect, $query);
                while($row = mysqli_fetch_array($result))
                {
                    echo '<tr>
                            <td style="text-align: center; padding: 10px;">'.$row["id_pembayaran"].'</td>
                            <td style="text-align: center; padding: 10px;">'.$row["id_pembelian"].'</td>
                            <td style="text-align: center; padding: 10px;">'.$row["kode_pembelian"].'</td>
                            <td style="text-align: center; padding: 10px;">'.$row["nama"].'</td>
                            <td style="text-align: center; padding: 10px;">'.$row["tanggal"].'</td>
                            <td style="text-align: center; padding: 10px;">'.$row["kode_pembayaran"].'</td>
                            <td><center><a href="ubah_pembayaran.php?id_pembayaran='.$row["id_pembayaran"].'" class="btnn btn-warning btn-xs"><i class="fas fa-edit"></i></a></center></td>
                            <td><center><a href="delete_pembayaran.php?employee_id='.$row["id_pembayaran"].'" class="btnn btn-danger btn-xs"><i class="fas fa-trash-alt" onclick="return confirm(\'Anda yakin ingin menghapus data ini?\')"></i></a></center></td>
                        </tr>';
                }
                ?>
            </table>
            </div>
            <?php
            $query_jumlah = "SELECT count(*) AS jumlah FROM pembayaran";
            $dewan1 = $connect->prepare($query_jumlah);
            $dewan1->execute();
            $res1 = $dewan1->get_result();
            $row = $res1->fetch_assoc();
            $total_records = $row['jumlah'];
            ?>
            <br>
            <div class="pagination-container">
                <p>Total baris : <?php echo $total_records; ?></p>
                <nav class="pagination">
                    <ul>
                        <?php
                        $jumlah_page = ceil($total_records / $limitt);
                        $jumlah_number = 1;
                        $start_number = ($pages > $jumlah_number) ? $pages - $jumlah_number : 1;
                        $end_number = ($pages < ($jumlah_page - $jumlah_number)) ? $pages + $jumlah_number : $jumlah_page;

                        if ($pages == 1) {
                            echo '<li class="disabled"><a href="#">First</a></li>';
                            echo '<li class="disabled"><a href="#"><span aria-hidden="true">&laquo;</span></a></li>';
                        } else {
                            $link_prev = ($pages > 1) ? $pages - 1 : 1;
                            echo '<li><a href="?page=1">First</a></li>';
                            echo '<li><a href="?page=' . $link_prev . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
                        }

                        for ($i = $start_number; $i <= $end_number; $i++) {
                            $link_active = ($pages == $i) ? 'active' : '';
                            echo '<li class="' . $link_active . '"><a href="?page=' . $i . '">' . $i . '</a></li>';
                        }

                        if ($pages == $jumlah_page) {
                            echo '<li class="disabled"><a href="#"><span aria-hidden="true">&raquo;</span></a></li>';
                            echo '<li class="disabled"><a href="#">Last</a></li>';
                        } else {
                            $link_next = ($pages < $jumlah_page) ? $pages + 1 : $jumlah_page;
                            echo '<li><a href="?page=' . $link_next . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
                            echo '<li><a href="?page=' . $jumlah_page . '">Last</a></li>';
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    
    &nbsp;
    <div class="btn-box">
        <a href="index.php" class="btn float-right">Kembali</a>
    </div>
</div>
</section>
<?php else : ?>
    <section id="home" class="home">
        <div class="container">
        <div class="row"><br>
        <div class="col-md-6"><br>
            <h1>Bayar Tiket</h1>&nbsp;
            <form id="bayarForm" method="POST" action="proses_pembayaran.php" enctype="multipart/form-data">
               
                <input type="hidden" id="id_pembelian" name="id_pembelian" class="form-input">

                <label for="kode_pembelian" class="form-label">Silakan masukkan kode pembelian:</label>
                <input type="text" id="kode_pembelian" name="kode_pembelian" class="form-input" autofocus required>
                
                <label for="deskripsi" class="form-label">Nama:</label>
                <textarea type="text" id="nama" name="nama" class="form-textarea" rows="1" cols="70" required></textarea>
                
                <label for="tanggal" class="form-label">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" class="form-input" required>
                
                <input type="submit" name="bayar" value="Bayar" class="form-button">
            </form>
        </div>
        &nbsp;
        <div class="btn-box">
        <a href="index.php" class="btn float-right">Kembali</a>
        </div>
       </div>
    </div>
       
    </section>
    <?php endif; ?>            
    <footer>
        <p><a href="login.php" style="color: #bdbdbd;">Copyright &copy;</a> 2023 by Xgaming || All Right Reserved.</p>
    </footer>


    <script src="mixitup.min.js"></script>
    <script src="script.js"></script>
    <script src="scrypt.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.4/dist/sweetalert2.all.min.js"></script>
    <script>
    // Fungsi untuk mengisi nama berdasarkan kode pembelian
    function isiNama() {
        var kode_pembelian = document.getElementById("kode_pembelian").value;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("nama").value = xhr.responseText;
            }
        };
        xhr.open("GET", "get_nama.php?kode_pembelian=" + kode_pembelian, true);
        xhr.send();
    }
    
    // Panggil fungsi isiNama saat input kode pembelian berubah
    document.getElementById("kode_pembelian").addEventListener("input", isiNama);
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
