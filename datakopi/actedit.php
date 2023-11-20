<?php
if (isset($_POST["kdkopi"])) {
    $kdkopi = $_POST["kdkopi"];
    $pere = $_POST["pere"];
    $vari = $_POST["vari"];
    $metode = $_POST["metode"];
    $tglexp = $_POST["tglexp"];
    $tglroas = $_POST["tglroas"];
    $tglpan = $_POST["tglpan"];
    $desk = $_POST["desk"];
    $berat = $_POST["berat"];
    
    // Periksa apakah ada file gambar baru diupload
    $nama_gambar1 = '';
    if (isset($_FILES["upload11"]) && $_FILES["upload11"]["error"] === UPLOAD_ERR_OK) {
        $upload_dir = "../assets/gambarkopi/";
        $ekstensi_gambar = pathinfo($_FILES["upload11"]["name"], PATHINFO_EXTENSION);
        $nama_gambar1 = uniqid() . '_1.' . $ekstensi_gambar;
        $lokasi_gambar1 = $upload_dir . $nama_gambar1;

        if (move_uploaded_file($_FILES["upload11"]["tmp_name"], $lokasi_gambar1)) {
            // Gambar 1 berhasil diupload
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal mengunggah gambar 1.'));
            exit;
        }
    }

    $nama_gambar2 = '';
    if (isset($_FILES["upload22"]) && $_FILES["upload22"]["error"] === UPLOAD_ERR_OK) {
        $upload_dir = "../assets/gambarkopi/";
        $ekstensi_gambar = pathinfo($_FILES["upload22"]["name"], PATHINFO_EXTENSION);
        $nama_gambar2 = uniqid() . '_2.' . $ekstensi_gambar;
        $lokasi_gambar2 = $upload_dir . $nama_gambar2;

        if (move_uploaded_file($_FILES["upload22"]["tmp_name"], $lokasi_gambar2)) {
            // Gambar 2 berhasil diupload
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal mengunggah gambar 2.'));
            exit;
        }
    }

    // Perbarui data kopi hanya jika ada perubahan
    $connection = mysqli_connect("localhost", "root", "", "sipkopi_test");

    if (!$connection) {
        die("Koneksi ke database gagal: " . mysqli_connect_error());
    }

    $query = "UPDATE `data_kopi` SET  
        `kode_peremajaan` = '$pere',
        `varietas_kopi` = '$vari',
        `metode_pengolahan` = '$metode',
        `tgl_roasting` = '$tglroas',
        `tgl_panen` = '$tglpan',
        `tgl_exp` = '$tglexp',
        `berat` = '$berat',
        `deskripsi` = '$desk'";
        
    if (!empty($nama_gambar1)) {
        $query .= ", `gambar1` = 'http://localhost/v2/assets/gambarkopi/$nama_gambar1'";
    }

    if (!empty($nama_gambar2)) {
        $query .= ", `gambar2` = 'http://localhost/v2/assets/gambarkopi/$nama_gambar2'";
    }

    $query .= " WHERE `kode_kopi` = '$kdkopi'";

    if (mysqli_query($connection, $query)) {
        echo json_encode(array('success' => true, 'message' => 'Data updated successfully'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Kesalahan: ' . mysqli_error($connection)));
    }

    mysqli_close($connection);
}
?>
