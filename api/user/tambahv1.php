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
    $user = $_POST['user'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $email = $_POST['email'] ?? '';
    $nohp = $_POST['nohp'] ?? '';
    $pass = $_POST['pass'] ?? '';
    $lokasi = $_POST['lokasi'] ?? '';
    $level = $_POST['level'] ?? '';

    // Handling image upload
    $upload_path = '../../assets/datagambar/';
    $fileExt = 'png'; // atau ekstensi lain yang diinginkan
    $gambar = uniqid() . '.' . $fileExt;  // Add unique identifier to the file name
    $tempPath = $_FILES['gambar']['tmp_name'];
    $imagePath = $upload_path . $gambar;
    $imageLink = 'https://sipkopi.com/assets/datagambar/' . $gambar;

    // Check if file already exists
    while (file_exists($imagePath)) {
        $gambar = uniqid() . '.' . $fileExt;
        $imagePath = $upload_path . $gambar;
        $imageLink = 'https://sipkopi.com/assets/datagambar/' . $gambar;
    }

    // Check if user exists
    $checkStmt = $koneksi->prepare("SELECT gambar FROM `data_user` WHERE `user` = ?");
    $checkStmt->bind_param("s", $user);
    $checkStmt->execute();
    $checkStmt->bind_result($gambarLama);
    $checkStmt->fetch();
    $checkStmt->close();

    $tanggal_create = date('Y-m-d H:i:s');

    // Delete old image if it exists
    if (!empty($gambarLama)) {
        $lokasi_gambar = '../../assets/datagambar/' . basename($gambarLama);
        if (file_exists($lokasi_gambar)) {
            unlink($lokasi_gambar);
        }
    }

    if (move_uploaded_file($tempPath, $imagePath)) {
        // File moved successfully
        // Check if user already exists
        $checkStmt = $koneksi->prepare("SELECT COUNT(*) FROM `data_user` WHERE `user` = ?");
        $checkStmt->bind_param("s", $user);
        $checkStmt->execute();
        $checkStmt->bind_result($userCount);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($userCount > 0) {
            // User exists, perform update
            $updateStmt = $koneksi->prepare("UPDATE `data_user` SET `nama`=?, `email`=?, `nohp`=?, `pass`=?, `lokasi`=?, `level`=?, `tanggal_create`=?, `gambar`=? WHERE `user`=?");
            $updateStmt->bind_param("sssssssss", $nama, $email, $nohp, $pass, $lokasi, $level, $tanggal_create, $imageLink, $user);
            $queryResult = $updateStmt->execute();
        } else {
            // User doesn't exist, perform insert
            $insertStmt = $koneksi->prepare("INSERT INTO `data_user` (`user`, `nama`, `email`, `nohp`, `pass`, `lokasi`, `level`, `tanggal_create`, `gambar`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insertStmt->bind_param("sssssssss", $user, $nama, $email, $nohp, $pass, $lokasi, $level, $tanggal_create, $imageLink);
            $queryResult = $insertStmt->execute();
        }

        if ($queryResult) {
            $response = array('message' => 'Registrasi berhasil');
            echo json_encode($response);
        } else {
            $response = array('message' => 'Registrasi gagal');
            echo json_encode($response);
        }
    } else {
        // File move failed
        $response = array('message' => 'Failed to move the uploaded file');
        echo json_encode($response);
        // Tambahkan pesan atau log untuk mengetahui penyebab kegagalan
        error_log("Failed to move the uploaded file: " . $tempPath . " to " . $imagePath);
    }
} else {
    $response = array('message' => 'Metode request tidak valid');
    echo json_encode($response);
}

$koneksi->close();
?>
