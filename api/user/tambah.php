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

    if (
        isset($input['user']) &&
        isset($input['nama']) &&
        isset($input['email']) &&
        isset($input['nohp']) &&
        isset($input['pass']) &&
        isset($input['lokasi']) &&
        isset($input['level']) &&
        isset($input['gambar'])
    ) {
        $user = $koneksi->real_escape_string($input['user']);
        $nama = $koneksi->real_escape_string($input['nama']);
        $email = $koneksi->real_escape_string($input['email']);
        $nohp = $koneksi->real_escape_string($input['nohp']);
        $pass = $koneksi->real_escape_string($input['pass']);
        $lokasi = $koneksi->real_escape_string($input['lokasi']);
        $level = $koneksi->real_escape_string($input['level']);
        $tanggal_create = date('Y-m-d H:i:s');
        $gambar = $koneksi->real_escape_string($input['gambar']);
        $imagePath = 'https://sipkopi.com/assets/datagambar/' . $gambar;

        $stmt = $koneksi->prepare("INSERT INTO `data_user` (`user`, `nama`, `email`, `nohp`, `pass`, `lokasi`, `level`, `tanggal_create`, `gambar`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $user, $nama, $email, $nohp, $pass, $lokasi, $level, $tanggal_create, $imagePath);
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
