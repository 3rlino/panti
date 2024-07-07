<?php
session_start();

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

// Fungsi untuk mengirim pesan ke bot Telegram
function sendTelegramMessage($nama, $kode_pembayaran) {
    $chat_id = 1744311372; // Ganti dengan chat_id Anda
    $message = "Pembayaran tiket oleh $nama berhasil. Kode pembayaran: $kode_pembayaran";
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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bayar'])) {
    // Ambil nilai dari form
    $kode_pembelian = $_POST["kode_pembelian"];
    $nama = $_POST["nama"];
    $tanggal = $_POST["tanggal"];

    // Generate kode unik
    $kode_pembayaran = generateUniqueCode();

    // Persiapkan statement SQL untuk mendapatkan id_pembelian berdasarkan kode_pembelian
    $sql_select_id = "SELECT id_pembelian FROM pembelian WHERE kode_pembelian = ?";
    $stmt_select_id = $conn->prepare($sql_select_id);

    // Periksa apakah statement berhasil dipersiapkan
    if ($stmt_select_id === false) {
        die("Error saat mempersiapkan statement: " . htmlspecialchars($conn->error));
    }

    // Bind parameter ke statement
    $stmt_select_id->bind_param("s", $kode_pembelian);

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
    $id_pembelian = $row_id["id_pembelian"];

    // Tutup statement
    $stmt_select_id->close();

    // Persiapkan statement SQL untuk memasukkan data ke dalam tabel pembayaran
    $sql_insert_pembayaran = "INSERT INTO pembayaran (id_pembelian, kode_pembelian, nama, tanggal, kode_pembayaran) VALUES (?, ?, ?, ?, ?)";
    
    // Persiapkan statement
    $stmt_insert_pembayaran = $conn->prepare($sql_insert_pembayaran);
    
    // Periksa apakah statement berhasil dipersiapkan
    if ($stmt_insert_pembayaran === false) {
        die("Error saat mempersiapkan statement: " . htmlspecialchars($conn->error));
    }
    
    // Bind parameter ke statement
    $stmt_insert_pembayaran->bind_param("issss", $id_pembelian, $kode_pembelian, $nama, $tanggal, $kode_pembayaran);
    
    // Eksekusi statement
    if ($stmt_insert_pembayaran->execute()) {
         // Tampilkan kode pembelian dalam alert
         echo "<script>alert('Kode pembayaran Anda adalah: $kode_pembayaran');";
         // Setelah pengguna menutup alert, tampilkan pesan sukses
         echo "window.location.href = 'pembayaran.php?addSuccess=1';</script>";
         // Kirim pesan ke bot Telegram
        // Kirim pesan ke bot Telegram
        $telegram_result = sendTelegramMessage($nama, $kode_pembayaran);
        
        if (!$telegram_result) {
            echo "
            <script>
            alert('Gagal mengirim pesan ke Telegram. Silakan coba lagi.');
            window.location.href = 'pembayaran.php';
            </script>
            ";
            exit;
        }
        
       // Set flag session untuk menandai bahwa data berhasil ditambahkan
       $_SESSION['data_added'] = true;
       // Exit agar tidak menampilkan pesan "Data berhasil ditambahkan" dua kali
       exit();
    } else {
        echo "Error saat melakukan pembayaran: " . htmlspecialchars($stmt_insert_pembayaran->error);
    }
    
    // Tutup statement
    $stmt_insert_pembayaran->close();
}

// Tutup koneksi ke database
$conn->close();
?>
