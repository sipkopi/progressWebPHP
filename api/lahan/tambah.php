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
    $result = $koneksi->query("SELECT kode_lahan FROM data_lahan ORDER BY kode_lahan DESC LIMIT 1");
    $row = $result->fetch_assoc();

    if ($row) {
        $lastCode = $row['kode_lahan'];
        $lastNumber = (int)substr($lastCode, 2);
        $newNumber = $lastNumber + 1;
        $newCode = sprintf("KL%04d", $newNumber);
    } else {
        // Kode awal jika tidak ada data
        $newCode = "KL0001";
    }

    if (
        isset($newCode) &&
        isset($input['user']) &&
        isset($input['varietas_pohon']) &&
        isset($input['total_bibit']) &&
        isset($input['luas_lahan']) &&
        isset($input['tanggal']) &&
        isset($input['ketinggian_tanam']) &&
        isset($input['lokasi_lahan']) &&
        isset($input['longtitude']) &&  // Missing comma here
        isset($input['latitude'])
    ) {
        $newCode = $koneksi->real_escape_string($newCode);
        $user = $koneksi->real_escape_string($input['user']);
        $varietas_pohon = $koneksi->real_escape_string($input['varietas_pohon']);
        $total_bibit = $koneksi->real_escape_string($input['total_bibit']);
        $luas_lahan = $koneksi->real_escape_string($input['luas_lahan']);
        $tanggal = $koneksi->real_escape_string($input['tanggal']);
        $ketinggian_tanam = $koneksi->real_escape_string($input['ketinggian_tanam']);
        $lokasi_lahan = $koneksi->real_escape_string($input['lokasi_lahan']);
        $longtitude = $koneksi->real_escape_string($input['longtitude']);
        $latitude = $koneksi->real_escape_string($input['latitude']);

        $stmt = $koneksi->prepare("INSERT INTO `data_lahan` (`kode_lahan`, `user`, `varietas_pohon`, `total_bibit`, `luas_lahan`, `tanggal`, `ketinggian_tanam`, `lokasi_lahan`, `longtitude`, `latitude`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $newCode, $user, $varietas_pohon, $total_bibit, $luas_lahan, $tanggal, $ketinggian_tanam, $lokasi_lahan, $longtitude, $latitude);
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
