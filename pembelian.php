                        <?php
                        session_start();

                        // Periksa apakah pengguna sudah login
                        if (isset($_SESSION['username'])) {
                            $loggedIn = true;
                        } else {
                            $loggedIn = false;
                        }

                        // Inisialisasi variabel $page
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;

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
                                    .table-responsive{
                                        overflow: auto;
                                        overflow-x: auto;
                                        margin: auto;
                                        border-collapse: collapse;
                                        table-layout: auto;
                                    }
                                table {
                            
                                    overflow-x: auto;
                                    white-space: nowrap;
                                 
                                    width: 100%;
                                }

                                th,
                                td {
                                    min-width: 100%;
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
                            
                        
                            <?php if ($loggedIn) : ?>
                            <section>
                                        <div class="container">
                                                <div class="row">
                                                                    <br>
                                                                    <div class="col-lg-12">
                                                                        <br>
                                                                        <center><h1>Data Pembelian Tiket</h1></center>
                                                                        <br>
                                                                        <div class="btn-box">
                                                                        <a href="admin_tambah_tiket.php" class="btn float-right">Tambah Data</a>
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
                                                                    </div>
                                                                        
                                                                    <div class="table-responsive" style="overflow-x:auto;">
                                                                    <table style="width:100%;table-layout:auto;">
                                                                        <thead>
                                                                        <tr>
                                                                            <th style="width: 14%; padding: 10px;">Id Pembelian</th>
                                                                            <th style="width: 14%; padding: 10px;">Id Tiket</th>
                                                                            <th style="width: 14%; padding: 10px;">Nama</th>
                                                                            <th style="width: 14%; padding: 10px;">Umur</th>
                                                                            <th style="width: 14%; padding: 10px;">Tanggal</th>
                                                                            <th style="width: 14%; padding: 10px;">Kode Pembelian</th>
                                                                            <th style="width: 7%; padding: 10px;">Edit</th>
                                                                            <th style="width: 7%; padding: 10px;">Hapus</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <?php
                                                                        $limit_start = 0;
                                                                        $limit = 6;
                                                                        $connect = mysqli_connect("localhost", "root", "", "fotografi");
                                                                        $limit_start = ($page - 1) * $limit;
                                                                        $query = "SELECT * FROM pembelian ORDER BY id_pembelian DESC LIMIT $limit_start, $limit";
                                                                        $result = mysqli_query($connect, $query);
                                                                        while($row = mysqli_fetch_array($result))
                                                                        {
                                                                            echo '<tbody><tr>
                                                                                    <td style="text-align: center; padding: 10px;">'.$row["id_pembelian"].'</td>
                                                                                    <td style="text-align: center; padding: 10px;">'.$row["id_tiket"].'</td>
                                                                                    <td style="text-align: center; padding: 10px;">'.$row["nama"].'</td>
                                                                                    <td style="text-align: center; padding: 10px;">'.$row["umur"].'</td>
                                                                                    <td style="text-align: center; padding: 10px;">'.$row["tanggal"].'</td>
                                                                                    <td style="text-align: center; padding: 10px;">'.$row["kode_pembelian"].'</td>
                                                                                    <td><center><a href="ubah_pembelian.php?id_pembelian='.$row["id_pembelian"].'" class="btnn btn-warning btn-xs"><i class="fas fa-edit"></i></a></center></td>
                                                                                    <td><center><a href="delete_pembelian.php?employee_id='.$row["id_pembelian"].'" class="btnn btn-danger btn-xs"><i class="fas fa-trash-alt" onclick="return confirm(\'Anda yakin ingin menghapus data ini?\')"></i></a></center></td>
                                                                                </tr></tbody>';
                                                                        }
                                                                        ?>
                                                                    </table>
                                                                    </div>
                                                                    </div>
                                                                    <?php
                                                                    $query_jumlah = "SELECT count(*) AS jumlah FROM pembelian";
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
                                                                                $jumlah_page = ceil($total_records / $limit);
                                                                                $jumlah_number = 1;
                                                                                $start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1;
                                                                                $end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page;

                                                                                if ($page == 1) {
                                                                                    echo '<li class="disabled"><a href="#">First</a></li>';
                                                                                    echo '<li class="disabled"><a href="#"><span aria-hidden="true">&laquo;</span></a></li>';
                                                                                } else {
                                                                                    $link_prev = ($page > 1) ? $page - 1 : 1;
                                                                                    echo '<li><a href="?page=1">First</a></li>';
                                                                                    echo '<li><a href="?page=' . $link_prev . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
                                                                                }

                                                                                for ($i = $start_number; $i <= $end_number; $i++) {
                                                                                    $link_active = ($page == $i) ? 'active' : '';
                                                                                    echo '<li class="' . $link_active . '"><a href="?page=' . $i . '">' . $i . '</a></li>';
                                                                                }

                                                                                if ($page == $jumlah_page) {
                                                                                    echo '<li class="disabled"><a href="#"><span aria-hidden="true">&raquo;</span></a></li>';
                                                                                    echo '<li class="disabled"><a href="#">Last</a></li>';
                                                                                } else {
                                                                                    $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;
                                                                                    echo '<li><a href="?page=' . $link_next . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
                                                                                    echo '<li><a href="?page=' . $jumlah_page . '">Last</a></li>';
                                                                                }
                                                                                ?>
                                                                            </ul>
                                                                        </nav>
                                                                    </div>
                                                                   
                                                            &nbsp;
                                                            
                                                            <div class="btn-box">
                                                                <a href="index.php" class="btn float-right">Kembali</a>
                                                            </div>
                         
                                            </div>
                                    </div>
                            </section>
                        <?php else : ?>
                        <section id="home" class="home">
                            <div class="container">
                                <div class="row"><br>
                                    <div class="col-md-6"><br>
                                        <h1>Beli Tiket</h1>&nbsp;
                                        <form method="POST" action="tambah_tiket.php">
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
                                                echo '<select id="tiket" name="tiket" class="form-input" autofocus required>';
                                                
                                                // Menampilkan opsi untuk setiap baris hasil query
                                                while($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . $row["id_tiket"] . '">' . $row["ekonomi"] . '</option>';
                                                }
                                                
                                                // Menutup elemen select
                                                echo '</select>';
                                            } else {
                                                echo "Tidak ada data tiket dalam database.";
                                            }

                                            // Tutup koneksi ke database
                                            $conn->close();
                                            ?>
                                            <label for="deskripsi" class="form-label">Nama:</label>
                                            <textarea type="text" id="nama" name="nama" class="form-textarea" rows="1" cols="70" required></textarea>
                                            
                                            <label for="judul" class="form-label">Umur:</label>
                                            <input type="text" id="umur" name="umur" class="form-input" required>

                                            <label for="tanggal" class="form-label">Tanggal:</label>
                                            <input type="date" id="tanggal" name="tanggal" class="form-input" required>
                                            
                                            <input type="submit" value="Beli" class="form-button">
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
