<?php

//use http://contoh.com/delete_peremajaan.php?kode_peremajaan=123

// Konfigurasi database

$host = "localhost";
$database = "sipkopic_team2";
$username = "sipkopic_team";
$password = "sipkopiteam@2";

$conn = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Mendapatkan nilai kode_peremajaan dari permintaan DELETE
$kode_peremajaan = $_GET['kode_peremajaan'];

// Membuat query DELETE dengan parameter terikat
$sql = "DELETE FROM `data_peremajaan` WHERE `kode_peremajaan` = ?";

// Mempersiapkan statement dengan parameter
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $kode_peremajaan);

// Menjalankan query DELETE
if ($stmt->execute()) {
    echo "Data berhasil dihapus";
} else {
    echo "Error: " . $sql . "<br>" . $stmt->error;
}

// Menutup statement dan koneksi ke database
$stmt->close();
$conn->close();
?>


