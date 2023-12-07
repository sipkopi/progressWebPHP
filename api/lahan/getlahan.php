<?php

// Ambil parameter kode_peremajaan dari request GET
$user = $_GET['user'];

// Persiapkan koneksi ke database
$koneksi = new mysqli("localhost", "sipkopic_team", "sipkopiteam@2", "sipkopic_team2");

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}

// Query SQL untuk mengambil data dengan kondisi WHERE kode_peremajaan
$sql = "SELECT * FROM `data_lahan` WHERE `user` = ?";

// Persiapkan pernyataan SQL dengan menggunakan parameter terikat
$pernyataan = $koneksi->prepare($sql);
$pernyataan->bind_param("s", $user);

// Eksekusi pernyataan SQL
$pernyataan->execute();

// Ambil hasil query
$result = $pernyataan->get_result();

// Inisialisasi array untuk menyimpan hasil
$data_peremajaan = array();

// Loop untuk mengambil setiap baris hasil query
while ($row = $result->fetch_assoc()) {
    $data_peremajaan[] = $row;
}

// Tutup pernyataan dan koneksi
$pernyataan->close();
$koneksi->close();

// Mengembalikan data dalam format JSON
echo json_encode($data_peremajaan);
?>
