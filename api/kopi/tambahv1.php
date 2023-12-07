<?php

require '../../phpqrcode/qrlib.php';

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
    // Generate kode_kopi
    $result = $koneksi->query("SELECT kode_kopi FROM data_kopi ORDER BY kode_kopi DESC LIMIT 1");
    $row = $result->fetch_assoc();

    if ($row) {
        $lastCode = $row['kode_kopi'];
        $lastNumber = (int) substr($lastCode, 2);
        $newNumber = $lastNumber + 1;
        $newCode = sprintf("KP%04d", $newNumber);
    } else {
        // Initial code if no data is present
        $newCode = "KP0001";
    }

    // Data POST
    $kode_peremajaan = $_POST['kode_peremajaan'] ?? '';
    $varietas_kopi = $_POST['varietas_kopi'] ?? '';
    $metode_pengolahan = $_POST['metode_pengolahan'] ?? '';
    $tgl_roasting = $_POST['tgl_roasting'] ?? '';
    $tgl_panen = $_POST['tgl_panen'] ?? '';
    $tgl_exp = $_POST['tgl_exp'] ?? '';
    $berat = $_POST['berat'] ?? '';
    $deskripsi = $_POST['deskripsi'] ?? '';

    // URL dan path gambar
    $gambarlinkqr = 'https://sipkopi.com/assets/gambarqr/' . $newCode .'.png';
    $link = 'https://sipkopi.com/produk.php?kode_kopi=' . $newCode;
    $gambarqr = '../../assets/gambarqr/' . $newCode . '.png';
    // Generate QR Code
    QRcode::png($link, $gambarqr, 'H', 10);

    // Handling image upload
    $upload_path = '../../assets/gambarkopi/';
    $fileExt = strtolower(pathinfo($_FILES['gambar1']['name'], PATHINFO_EXTENSION));
    $gambar = uniqid() . '.' . $fileExt;
    $tempPath = $_FILES['gambar1']['tmp_name'];
    $imagePath = $upload_path . $gambar;
    $imageLink = 'https://sipkopi.com/assets/gambarkopi/' . $gambar;



    if (move_uploaded_file($tempPath, $imagePath)) {
        $stmt = $koneksi->prepare("INSERT INTO `data_kopi` (`kode_kopi`, `kode_peremajaan`, `varietas_kopi`, `metode_pengolahan`, `tgl_roasting`, `tgl_panen`, `tgl_exp`, `berat`, `link`, `deskripsi`, `gambar1`, `gambarqr`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss", $newCode, $kode_peremajaan, $varietas_kopi, $metode_pengolahan, $tgl_roasting, $tgl_panen, $tgl_exp, $berat, $link, $deskripsi, $imageLink, $gambarlinkqr);

        try {
            $queryResult = $stmt->execute();

            if ($queryResult) {
                $response = array('message' => 'Registrasi berhasil');
                echo json_encode($response);
            } else {
                $response = array('message' => 'Registrasi gagal');
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $response = array('message' => 'Terjadi kesalahan: ' . $e->getMessage());
            echo json_encode($response);
        }

        $stmt->close();
    } else {
        // File move failed
        $response = array('message' => 'Failed to move the uploaded file');
        echo json_encode($response);
    }

    $koneksi->close();
} else {
    $response = array('message' => 'Metode request tidak valid');
    echo json_encode($response);
}
?>
