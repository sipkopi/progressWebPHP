<?php
if (isset($_POST["kodelahan"])) {
    $kodelh = $_POST["kodelahan"];
    $tgl = $_POST["tgl"];
    $vari = $_POST["vari"];
    $user = $_POST["user"];
    $bibit = $_POST["bibit"];
    $luas = $_POST["luas"];
    $tinggi = $_POST["tinggi"];
    $longtitude = $_POST["longtitude"];
    $latitude = $_POST["latitude"];
    

    $connection = mysqli_connect("localhost", "root", "", "sipkopi");
    
    if (!$connection) {
        die("Koneksi ke database gagal: " . mysqli_connect_error());
    }
    $query = "UPDATE `data_lahan` SET 
    `user` = '$user', 
    `varietas_pohon` = '$vari', 
    `total_bibit` = '$bibit', 
    `luas_lahan` = '$luas', 
    `tanggal` = '$tgl', 
    `ketinggian_tanam` = '$tinggi', 
    `longtitude` = '$longtitude',
    `latitude` = '$latitude' 
    WHERE `data_lahan`.`kode_lahan` = '$kodelh'";


    if (mysqli_query($connection, $query)) {
        echo json_encode(array('success' => true, 'message' => 'Data updated successfully'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Kesalahan: ' . mysqli_error($connection)));
    }

    mysqli_close($connection);
}
?>
