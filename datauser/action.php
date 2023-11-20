

<?php
if (isset($_POST["user"])) {
    $user = $_POST["user"];
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $nohp = $_POST["nohp"];
    $lokasi = $_POST["lokasi"];
    
    // Periksa apakah ada file gambar baru diupload
    $nama_gambar1 = '';
    if (isset($_FILES["upload"]) && $_FILES["upload"]["error"] === UPLOAD_ERR_OK) {
        $upload_dir = "../assets/datagambar/";
        $ekstensi_gambar = pathinfo($_FILES["upload"]["name"], PATHINFO_EXTENSION);
        $nama_gambar1 = uniqid() . '_1.' . $ekstensi_gambar;
        $lokasi_gambar1 = $upload_dir . $nama_gambar1;

        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $lokasi_gambar1)) {
            // Gambar 1 berhasil diupload
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal mengunggah gambar 1.'));
            exit;
        }
    }


    // Perbarui data kopi hanya jika ada perubahan
    $connection = mysqli_connect("localhost", "root", "", "sipkopi_test");

    if (!$connection) {
        die("Koneksi ke database gagal: " . mysqli_connect_error());
    }

    $query = "UPDATE `data_user` SET  
        `nama` = '$nama',
        `email` ='$email',  
        `nohp` = '$nohp',  
        `lokasi` = '$lokasi'";
        
    if (!empty($nama_gambar1)) {
        $query .= ", `gambar` = 'http://localhost/v2/assets/datagambar/$nama_gambar1'";
    }

    $query .= "  WHERE `user` = '$user'";

    if (mysqli_query($connection, $query)) {
        echo json_encode(array('success' => true, 'message' => 'Data updated successfully'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Kesalahan: ' . mysqli_error($connection)));
    }

    mysqli_close($connection);
}
?>

