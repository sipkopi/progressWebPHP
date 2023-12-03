<?php

// Ambil data dari request PUT
parse_str(file_get_contents("php://input"), $put_data);

// Ambil data yang diperlukan dari request
$kode_peremajaan = $put_data['kode_peremajaan'];
$kode_lahan = $put_data['kode_lahan'];
$perlakuan = $put_data['perlakuan'];
$tanggal = $put_data['tanggal'];
$kebutuhan = $put_data['kebutuhan'];
$pupuk = $put_data['pupuk'];

// Persiapkan koneksi ke database
$host = 'localhost';
$db = 'sipkopic_team2';
$user = 'sipkopic_team';
$pass = 'sipkopiteam@2';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
} catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
}

// Query SQL untuk update data
$sql = "UPDATE `data_peremajaan` SET `kode_lahan` = ?, `perlakuan` = ?, `tanggal` = ?, `kebutuhan` = ?, `pupuk` = ? WHERE `kode_peremajaan` = ?";

// Persiapkan pernyataan SQL dengan menggunakan parameter terikat
$stmt = $pdo->prepare($sql);
$stmt->execute([$kode_lahan, $perlakuan, $tanggal, $kebutuhan, $pupuk, $kode_peremajaan]);

// Tutup koneksi
$pdo = null;

// Beri respons
echo json_encode(['status' => 'success', 'message' => 'Data berhasil diupdate']);
?>
