<?php
if (isset($_POST["user"])) {
    $user = $_POST["user"];
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $nohp = $_POST["nohp"];
    $lokasi = $_POST["lokasi"];
    
    // Proses upload gambar
    if (isset($_FILES["upload"]) && $_FILES["upload"]["error"] === UPLOAD_ERR_OK) {
        // Hapus gambar lama terlebih dahulu
        $connection = mysqli_connect("localhost", "root", "", "sipkopi");
        
        if (!$connection) {
            die("Koneksi ke database gagal: " . mysqli_connect_error());
        }

        $query = "SELECT `gambar` FROM `data_user` WHERE `user` = '$user'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $gambar_lama = $row['gambar'];

            // Hapus gambar lama jika ada
            if ($gambar_lama) {
                $lokasi_gambar_lama = "../assets/datagambar/" . basename($gambar_lama);
                if (file_exists($lokasi_gambar_lama)) {
                    unlink($lokasi_gambar_lama);
                }
            }
        }

        // Upload gambar baru
        $img_temp = $_FILES["upload"]["tmp_name"];
        $upload_dir = "../assets/datagambar/";
        $ekstensi_gambar = pathinfo($_FILES["upload"]["name"], PATHINFO_EXTENSION);
        $nama_gambar = uniqid() . '.' . $ekstensi_gambar;

        move_uploaded_file($img_temp, $upload_dir . $nama_gambar);
    }

    // Perbarui data pengguna
    $connection = mysqli_connect("localhost", "root", "", "sipkopi");
    
    if (!$connection) {
        die("Koneksi ke database gagal: " . mysqli_connect_error());
    }

    $query = "UPDATE `data_user` SET  
        `nama` = '$nama', 
        `email` = '$email',  
        `nohp` = '$nohp',  
        `lokasi` = '$lokasi', 
        `gambar` = 'http://localhost/v2/assets/datagambar/$nama_gambar' 
        WHERE `user` = '$user'";

    if (mysqli_query($connection, $query)) {
        echo json_encode(array('success' => true, 'message' => 'Data updated successfully'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Kesalahan: ' . mysqli_error($connection)));
    }

    mysqli_close($connection);
}

?>
