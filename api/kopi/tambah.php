<?php
// Database Configuration
$host = "localhost";
$database = "sipkopic_team2";
$username = "sipkopic_team";
$password = "sipkopiteam@2";

// Database Connection
$koneksi = new mysqli($host, $username, $password, $database);

// Check Connection
if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}

header('Content-Type: application/json;charset=utf8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    // Generate kode_kopi
    $result = $koneksi->query("SELECT kode_kopi FROM data_kopi ORDER BY kode_kopi DESC LIMIT 1");
    $row = $result->fetch_assoc();

    if ($row) {
        $lastCode = $row['kode_kopi'];
        $lastNumber = (int)substr($lastCode, 2);
        $newNumber = $lastNumber + 1;
        $newCode = sprintf("KP%04d", $newNumber);
    } else {
        // Initial code if no data is present
        $newCode = "KP0001";
    }

    // Check for existing code to avoid conflicts

    if (
        isset($newCode) &&
        isset($input['kode_peremajaan']) &&
        isset($input['varietas_kopi']) &&
        isset($input['metode_pengolahan']) &&
        isset($input['tgl_roasting']) &&
        isset($input['tgl_panen']) &&
        isset($input['tgl_exp']) &&
        isset($input['berat']) &&
        isset($input['link']) &&
        isset($input['deskripsi']) &&
        isset($input['gambar1']) &&
        isset($input['gambar2']) &&
        isset($input['gambarqr'])
    ) {
        // Escape and validate input
        $newCode = $koneksi->real_escape_string($newCode);
        $kode_peremajaan = $koneksi->real_escape_string($input['kode_peremajaan']);
        $varietas_kopi = $koneksi->real_escape_string($input['varietas_kopi']);
        $metode_pengolahan = $koneksi->real_escape_string($input['metode_pengolahan']);
        $tgl_roasting = $koneksi->real_escape_string($input['tgl_roasting']);
        $tgl_panen = $koneksi->real_escape_string($input['tgl_panen']);
        $tgl_exp = $koneksi->real_escape_string($input['tgl_exp']);
        $berat = $koneksi->real_escape_string($input['berat']);
        $link = $koneksi->real_escape_string($input['link']);
        $deskripsi = $koneksi->real_escape_string($input['deskripsi']);
        $gambar1 = $koneksi->real_escape_string($input['gambar1']);
        $gambar2 = $koneksi->real_escape_string($input['gambar2']);
        $gambarqr = $koneksi->real_escape_string($input['gambarqr']);

        // Construct image URLs
        $baseURL = 'https://sipkopi.com/assets/datagambar/';
        $baseURL1 = 'https://sipkopi.com/assets/gambarqr/';
        $imagePath1 = $baseURL . $gambar1;
        $imagePath2 = $baseURL . $gambar2;
        $imageqr = $baseURL1 . $gambarqr;

        // Use prepared statement to prevent SQL injection
        $stmt = $koneksi->prepare("INSERT INTO `data_kopi` (`kode_kopi`, `kode_peremajaan`, `varietas_kopi`, `metode_pengolahan`, `tgl_roasting`, `tgl_panen`, `tgl_exp`, `berat`, `link`, `deskripsi`, `gambar1`, `gambar2`, `gambarqr`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssss", $newCode, $kode_peremajaan, $varietas_kopi, $metode_pengolahan, $tgl_roasting, $tgl_panen, $tgl_exp, $berat, $link, $deskripsi, $imagePath1, $imagePath2, $imageqr);
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
