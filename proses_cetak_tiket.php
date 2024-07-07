
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASDP</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="img/asdp.png" type="image/x-icon" style="display:important!">
</head>
<body>
    <?php
     $icon_link_html = '<link rel="icon" href="img/asdp.png" type="image/x-icon">';
    ?>
<?php
   
    require_once __DIR__ . '/vendor/autoload.php';

// Fungsi untuk menghasilkan kode unik secara acak
function generateUniqueCode($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';
    $max = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, $max)];
    }
    return $code;
}

// Mengatur header untuk membuat browser mengenali konten sebagai file yang akan diunduh

// Header Content-Type dan Content-Disposition
header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=tiket.pdf");

// Membuat instance MPDF
$mpdf = new \Mpdf\Mpdf();

// Set watermark gambar
$mpdf->SetWatermarkImage('img/asdp.png');
// Atur opacity gambar watermark
$mpdf->showWatermarkImage = true;

// Tambahkan halaman baru
$mpdf->AddPage();
// Tambahkan kode HTML untuk ikon ke dalam dokumen PDF

// Tambahkan konten ke dokumen
$mpdf->WriteHTML('<table width="100%" style="background-color:	#B0E0E6;margin-top:0px;">
<tr>
<td width="15" align="left"><img src="img/asdp.png" width="15%"></td>
<td width="100" align="center"><h3>PT. ASDP Indonesia Ferry (Persero)</h3><br><h4>Kewapante - Maumere</h4></td>
<td width="15" align="right"><img src="img/bumn.png" width="15%"></td>
</tr>
</table>
<hr>');
$mpdf->WriteHTML('<h3 style="font-style:italic;text-align:center;color:grey;">E-TIKET (e-ticket)</h3>');
$mpdf->WriteHTML('<h4>DATA PEMESANAN</h4>');
$mpdf->WriteHTML('<pre style="color:#696969;">Nama             : ' . $_POST['nama'] . '</pre>');
$mpdf->WriteHTML('<pre style="color:#696969;">Kode Pembayaran  : ' . $_POST['kode_pembayaran'] . '</pre>');
$mpdf->WriteHTML('<pre style="color:#696969;">Tanggal          : ' . $_POST['tanggal'] . '</pre>');


// Output dokumen PDF
$mpdf->Output();

// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "fotografi";

$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}
function sendTelegramMessage($nama, $kode_pembayaran) {
    $chat_id = 1744311372; // Ganti dengan chat_id Anda
    $message = "Proses cetak tiket oleh $nama berhasil. Kode pembayaran: $kode_pembayaran";
    $token = "7156202756:AAEH79Mf1Ei-4NSwFXG_MVagKuJA1DjOwEs";
    $url = "https://api.telegram.org/bot$token/sendMessage";
    
    $postData = [
        'chat_id' => $chat_id,
        'text' => $message
    ];

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    $response_array = json_decode($response, true); // Decode response to associative array

    if ($httpCode != 200 || $response_array['ok'] != true) {
        return false; // Gagal mengirim pesan ke Telegram
    }
    return true; // Berhasil mengirim pesan ke Telegram
}
if (isset($_SESSION['data_added']) && $_SESSION['data_added']) {
    unset($_SESSION['data_added']); // Hapus flag session
}
// Proses form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cetak'])) {
    // Ambil nilai dari form
    $kode_pembayaran = $_POST["kode_pembayaran"];
    $nama = $_POST["nama"];
    $tanggal = $_POST["tanggal"];

    // Validasi input kode_pembelian
    if (empty($kode_pembayaran)) {
        die("Error: Kode pembayaran tidak boleh kosong.");
    }

    // Persiapkan statement SQL untuk mendapatkan id_pembelian berdasarkan kode_pembelian
    $sql_select_id = "SELECT id_pembayaran FROM pembayaran WHERE kode_pembayaran = ?";
    $stmt_select_id = $conn->prepare($sql_select_id);

    // Periksa apakah statement berhasil dipersiapkan
    if ($stmt_select_id === false) {
        die("Error saat mempersiapkan statement: " . htmlspecialchars($conn->error));
    }

    // Bind parameter ke statement
    $stmt_select_id->bind_param("s", $kode_pembayaran);

    // Eksekusi statement
    $stmt_select_id->execute();

    // Ambil hasil query
    $result_id = $stmt_select_id->get_result();

    // Periksa apakah kode_pembelian valid
    if ($result_id->num_rows === 0) {
        die("Error: Kode pembelian tidak valid.");
    }

    // Ambil id_pembelian dari hasil query
    $row_id = $result_id->fetch_assoc();
    $id_pembayaran = $row_id["id_pembayaran"];

    // Tutup statement
    $stmt_select_id->close();

    // Persiapkan statement SQL untuk memasukkan data ke dalam tabel pembayaran
    $sql_insert_pembayaran = "INSERT INTO cetak (id_pembayaran, kode_pembayaran, nama, tanggal) VALUES (?, ?, ?, ?)";
    
    // Persiapkan statement
    $stmt_insert_pembayaran = $conn->prepare($sql_insert_pembayaran);
    
    // Periksa apakah statement berhasil dipersiapkan
    if ($stmt_insert_pembayaran === false) {
        die("Error saat mempersiapkan statement: " . htmlspecialchars($conn->error));
    }
    
    // Bind parameter ke statement
    $stmt_insert_pembayaran->bind_param("isss", $id_pembayaran, $kode_pembayaran, $nama, $tanggal);
    
    // Eksekusi statement
    if ($stmt_insert_pembayaran->execute()) {
        // Set flag session untuk menandai bahwa data berhasil ditambahkan
        $_SESSION['data_added'] = true;
        // echo "<script>alert('Terima kasih sudah melakukan cetak tiket: $nama'); window.location.href = 'cetaktiket.php';</script>";
        // exit;
    } else {
        echo "Error saat melakukan cetak tiket: " . htmlspecialchars($stmt_insert_pembayaran->error);
    }
    
    // Tutup statement
    $stmt_insert_pembayaran->close();
}

// Tutup koneksi ke database
$conn->close();
    
    ?>
<script src="mixitup.min.js"></script>
    <script src="script.js"></script>
    <script src="scrypt.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.4/dist/sweetalert2.all.min.js"></script>
</body>
</html>