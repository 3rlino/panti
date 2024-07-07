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
function sendTelegramMessage($nama, $kode_pembelian) {
    $chat_id = 1744311372; // Ganti dengan chat_id Anda
    $message = "Pembelian tiket oleh $nama berhasil. Kode pembelian: $kode_pembelian";
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

// Periksa apakah data berhasil ditambahkan sebelumnya
if (isset($_SESSION['data_added']) && $_SESSION['data_added']) {
    unset($_SESSION['data_added']); // Hapus flag session
}

// Proses form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari form
    $id_tiket = $_POST["tiket"];
    $nama = $_POST["nama"];
    $umur = $_POST["umur"];
    $tanggal = $_POST["tanggal"];

    // Generate kode unik
    $kode_pembelian = generateUniqueCode();

    // Persiapkan statement SQL untuk memasukkan data ke dalam tabel pembeli
    $sql = "INSERT INTO pembelian (id_tiket, nama, umur, tanggal, kode_pembelian) VALUES (?, ?, ?, ?, ?)";
    
    // Persiapkan statement
    $stmt = $conn->prepare($sql);
    
    // Periksa apakah statement berhasil dipersiapkan
    if ($stmt === false) {
        die("Error saat mempersiapkan statement: " . $conn->error);
    }
    
    // Bind parameter ke statement
    $stmt->bind_param("issss", $id_tiket, $nama, $umur, $tanggal, $kode_pembelian);
    
    // Eksekusi statement
    if ($stmt->execute()) {
        // Tampilkan kode pembelian dalam alert
        echo "<script>alert('Kode pembelian Anda adalah: $kode_pembelian');";
        // Setelah pengguna menutup alert, tampilkan pesan sukses
        echo "window.location.href = 'pembelian.php?addSuccess=1';</script>";
        // Kirim pesan ke bot Telegram
        $telegram_result = sendTelegramMessage($nama, $kode_pembelian);
        if (!$telegram_result) {
            echo "<script>alert('Gagal mengirim pesan ke Telegram. Silakan coba lagi.');</script>";
            exit;
        }
        // Set flag session untuk menandai bahwa data berhasil ditambahkan
        $_SESSION['data_added'] = true;
        // Exit agar tidak menampilkan pesan "Data berhasil ditambahkan" dua kali
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Tutup statement
    $stmt->close();
}

// Tutup koneksi ke database
$conn->close();
?>
