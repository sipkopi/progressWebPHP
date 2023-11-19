<?php
if (isset($_POST["kodeperemajaan"])) {
    $kodepr = $_POST["kodeperemajaan"];
    $kodelh = $_POST["kodelahan"];
    $tgl = $_POST["tgl"];
    $kebu = $_POST["kebutuhan"];
    $pupuk = $_POST["pupuk"];
    $perla = $_POST["perlakuan"];
    

    $connection = mysqli_connect("localhost", "root", "", "sipkopi_test");
    
    if (!$connection) {
        die("Koneksi ke database gagal: " . mysqli_connect_error());
    }

    $query = "UPDATE `data_peremajaan` SET 
    `kode_lahan` = '$kodelh', 
    `perlakuan` = '$perla', 
    `tanggal` = '$tgl', 
    `kebutuhan` = '$kebu', 
    `pupuk` = '$pupuk' 
    WHERE `data_peremajaan`.`kode_peremajaan` = '$kodepr'";


    if (mysqli_query($connection, $query)) {
        echo json_encode(array('success' => true, 'message' => 'Data updated successfully'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Kesalahan: ' . mysqli_error($connection)));
    }

    mysqli_close($connection);
}
?>
