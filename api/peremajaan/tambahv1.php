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

header('Content-Type: application/json;charset=utf8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    // Menghasilkan kode_peremajaan secara otomatis
    $result = $koneksi->query("SELECT kode_peremajaan FROM data_peremajaan ORDER BY kode_peremajaan DESC LIMIT 1");
    $row = $result->fetch_assoc();

    if ($row) {
        $lastCode = $row['kode_peremajaan'];
        $lastNumber = (int)substr($lastCode, 3);
        $newNumber = $lastNumber + 1;
        $newCode = sprintf("KPR%04d", $newNumber);
    } else {
        // Kode awal jika tidak ada data
        $newCode = "KPR0001";
    }

    if (
        isset($newCode) &&
        isset($input['kode_lahan']) &&
        isset($input['perlakuan']) &&
        isset($input['tanggal']) &&
        isset($input['kebutuhan']) &&
        isset($input['pupuk'])
    ) {
        $newCode = $koneksi->real_escape_string($newCode);
        $kode_lahan = $koneksi->real_escape_string($input['kode_lahan']);
        $perlakuan = $koneksi->real_escape_string($input['perlakuan']);
        $tanggal = $koneksi->real_escape_string($input['tanggal']);
        $kebutuhan = $koneksi->real_escape_string($input['kebutuhan']);
        $pupuk = $koneksi->real_escape_string($input['pupuk']);

        $stmt = $koneksi->prepare("INSERT INTO `data_peremajaan` (`kode_peremajaan`, `kode_lahan`, `perlakuan`, `tanggal`, `kebutuhan`, `pupuk`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $newCode, $kode_lahan, $perlakuan, $tanggal, $kebutuhan, $pupuk);
        $queryResult = $stmt->execute();
        
        if ($queryResult) {
            $response = array('message' => 'Registrasi berhasil');
            echo json_encode($response);
        } else {
            $response = array('message' => 'Registrasi gagal');
            echo json_encode($response);
        }
    } else {
        $response = array('message' => 'Data tidak lengkap');
        echo json_encode($response);
    }
} else {
    $response = array('message' => 'Metode request tidak valid');
    echo json_encode($response);
}

$koneksi->close();
?>
