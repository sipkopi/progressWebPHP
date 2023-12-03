<?php

// Konfigurasi database
$host = "localhost";
$database = "sipkopic_team2";
$username = "sipkopic_team";
$password = "sipkopiteam@2";

// Koneksi ke database
$koneksi = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}

// Query SQL untuk mendapatkan kode_peremajaan terbaru
$queryy = "SELECT kode_peremajaan FROM data_peremajaan ORDER BY kode_peremajaan DESC LIMIT 1";
$resultt = mysqli_query($koneksi, $queryy);

if ($resultt) {
    $row = mysqli_fetch_assoc($resultt);
    if ($row) {
        $lastCode = $row['kode_peremajaan'];

        // Extract nomor urut dari kode_peremajaan terakhir
        $lastNumber = (int)substr($lastCode, 3);

        // Tambahkan 1 ke nomor urut
        $newNumber = $lastNumber + 1;

        // Format nomor urut dengan nol di depan jika kurang dari 10
        if ($newNumber < 10) {
            $newCode = "KPR000" . $newNumber;
        } elseif ($newNumber < 100) {
            $newCode = "KPR00" . $newNumber;
        } else {
            $newCode = "KPR0" . $newNumber;
        }
    } else {
        // Kode awal jika tidak ada data
        $newCode = "KPR0001";
    }
} else {
    // Handle jika query tidak berhasil
    // Misalnya, Anda bisa mengatur kode awal di sini
    $newCode = "KPR0001";
}

// Tangkap data dari permintaan POST
$kode_lahan = $_POST['kode_lahan'];
$perlakuan = $_POST['perlakuan'];
$tanggal = $_POST['tanggal'];
$kebutuhan = $_POST['kebutuhan'];
$pupuk = $_POST['pupuk'];

// Query SQL untuk menyimpan data
$sql = "INSERT INTO `data_peremajaan` (`kode_peremajaan`, `kode_lahan`, `perlakuan`, `tanggal`, `kebutuhan`, `pupuk`) VALUES (?, ?, ?, ?, ?, ?)";

// Persiapkan pernyataan SQL dengan menggunakan parameter terikat
$pernyataan = $koneksi->prepare($sql);
$pernyataan->bind_param("ssssss", $newCode, $kode_lahan, $perlakuan, $tanggal, $kebutuhan, $pupuk);

// Eksekusi pernyataan SQL
if ($pernyataan->execute()) {
    $response = array('status' => 'success', 'message' => 'Data berhasil disimpan');
} else {
    $response = array('status' => 'error', 'message' => 'Gagal menyimpan data');
}

// Tutup koneksi
$pernyataan->close();
$koneksi->close();

// Mengembalikan respons dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
