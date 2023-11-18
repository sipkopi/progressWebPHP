<?php
$koneksi = mysqli_connect("localhost", "root", "", "sipkopi_test");

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

function query($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $tempat = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $tempat[] = $row;
    }
    return $tempat;
}

// C-R-U-D / DATA User
function hapususerr($user) {
    global $koneksi;

    // Dapatkan nama file gambar dari database
    $query = "SELECT gambar FROM data_user WHERE user='$user'";
    $result = $koneksi->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama_gambar = $row['gambar'];

        // Hapus data dari database
        mysqli_query($koneksi, "DELETE FROM data_user WHERE user='$user'");

        if (mysqli_affected_rows($koneksi) > 0) {
            // Hapus file gambar dari sistem file
            $lokasi_gambar = '../assets/datagambar/' . basename($nama_gambar); // Sesuaikan dengan lokasi folder gambar
            if (file_exists($lokasi_gambar)) {
                unlink($lokasi_gambar);
            }

            return true; // Data berhasil dihapus
        }
    }

    return false; // Data tidak ditemukan atau gagal dihapus
}

function tambahuserr($data) {
    global $koneksi;

    $user = htmlspecialchars($data["user"]);
    $user = htmlspecialchars($data["user"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $nohp = htmlspecialchars($data["nohp"]);
    $lokasi = htmlspecialchars($data["lokasi"]);
    $level = htmlspecialchars($data["level"]);
    $pass = hash('sha256', $data['pass']);
    $tgl = htmlspecialchars($data["tgl"]);

    // Proses upload gambar
    $upload_dir = "../assets/datagambar/"; // Ganti dengan direktori tempat Anda ingin menyimpan gambar
    $nama_gambar = '';

    if (isset($_FILES["upload"]) && $_FILES["upload"]["error"] === UPLOAD_ERR_OK) {
        $img_temp = $_FILES["upload"]["tmp_name"];
        $ekstensi_gambar = pathinfo($_FILES["upload"]["name"], PATHINFO_EXTENSION);
        $nama_gambar = uniqid() . '.' . $ekstensi_gambar;

        if (move_uploaded_file($img_temp, $upload_dir . $nama_gambar)) {
            $nama_gambar = 'http://localhost/v2/assets/datagambar/' . $nama_gambar;
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal mengupload gambar.'));
            exit();
        }
    }

    $tanggal_create = date('Y-m-d H:i:s');

    $query = "INSERT INTO `data_user` (`user`, `nama`, `email`, `nohp`, `pass`, `lokasi`, `level`, `tanggal_create`, `gambar`) VALUES 
    ('$user', '$nama', '$email', '$nohp', '$pass', '$lokasi', '$level', '$tanggal_create', '$nama_gambar')";


if (mysqli_query($koneksi, $query)) {
    header("Location: datauser.php?alert=success");
    return mysqli_affected_rows($koneksi);
   
} else {
    return -1; // Gagal menyimpan data
}


}



// C-R-U-D / DATA KOPI

require '../phpqrcode/qrlib.php';

function tambahkopi($data) {
    global $koneksi;

    $kdkopi = htmlspecialchars($data["kdkopi"]);
    $pere = htmlspecialchars($data["pere"]);
    $vari = htmlspecialchars($data["vari"]);
    $metode = htmlspecialchars($data["metode"]);
    $Exp = htmlspecialchars($data["tglexp"]);
    $tglroas = htmlspecialchars($data["tglroas"]);
    $tglpan = htmlspecialchars($data["tglpan"]);

    // $link = htmlspecialchars($data["link"]);
    $desk = htmlspecialchars($data["desk"]);
    $berat = htmlspecialchars($data["berat"]);


    // Siapkan array untuk menyimpan nama gambar
    $nama_gambar = array();

    // Loop untuk mengunggah tiga gambar
    for ($i = 1; $i <= 2; $i++) {
        $nama_field = "img" . $i;
        if (isset($_FILES[$nama_field]) && $_FILES[$nama_field]['error'] === UPLOAD_ERR_OK) {
            $lokasi_temp = $_FILES[$nama_field]['tmp_name'];
            $ekstensi_gambar = pathinfo($_FILES[$nama_field]['name'], PATHINFO_EXTENSION);
            $nama_gambar[$i] = uniqid() . '.' . $ekstensi_gambar;

            $folder_tujuan = "../assets/gambarkopi/"; // Sesuaikan dengan direktori yang Anda inginkan

            $qr_code_data = "http://localhost/v2/produk.php?kode_kopi=$kdkopi";
            $qr_code_filename = "../assets/gambarqr/$kdkopi.png"; // Nama file QR Code sesuai dengan kode kopi
            QRcode::png($qr_code_data, $qr_code_filename, 'H', 10);

            // Pindahkan gambar dari folder temporari ke folder img
            $pindahkan = move_uploaded_file($lokasi_temp, $folder_tujuan . $nama_gambar[$i]);

            if (!$pindahkan) {
                die("Gagal mengunggah gambar ke folder img.");
            }
        } else {
            die("Gagal mengunggah gambar: File gambar " . $i . " tidak diunggah atau terjadi kesalahan.");
        }
    }

    $query = "INSERT INTO `data_kopi` (`kode_kopi`, `kode_peremajaan`, `varietas_kopi`, `metode_pengolahan`, `tgl_roasting`, `tgl_panen`, `tgl_exp`, `berat`, `link`, `deskripsi`, `gambar1`, `gambar2`, `gambarqr`) 
    VALUES ('$kdkopi', '$pere', '$vari', '$metode', '$tglroas', '$tglpan', '$Exp', '$berat', '$qr_code_data', '$desk',
     'http://localhost/v2/assets/gambarkopi/$nama_gambar[1]',
    'http://localhost/v2/assets/gambarkopi/$nama_gambar[2]',
    'http://localhost/v2/assets/gambarqr/$kdkopi.png');";



    if (mysqli_query($koneksi, $query)) {
        header("Location: datakopi.php?alert=success");
        return mysqli_affected_rows($koneksi);
       
    } else {
        return -1; // Gagal menyimpan data
    }
}



function hapuskopi($id) {
    global $koneksi;

    // Dapatkan nama file gambar dari database
    $query = "SELECT gambar1, gambar2, gambarqr FROM data_kopi WHERE kode_kopi='$id'";
    $result = $koneksi->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama_gambar1 = $row['gambar1'];
        $nama_gambar2 = $row['gambar2'];
        $nama_gambarqr = $row['gambarqr'];

        // Hapus data dari database
        mysqli_query($koneksi, "DELETE FROM data_kopi WHERE kode_kopi='$id'");

        if (mysqli_affected_rows($koneksi) > 0) {
            // Hapus file gambar dari sistem file
            $lokasi_gambar1 = '../assets/gambarkopi/' . basename($nama_gambar1); // Sesuaikan dengan lokasi folder gambar
            $lokasi_gambar2 = '../assets/gambarkopi/' . basename($nama_gambar2); // Sesuaikan dengan lokasi folder gambar
            $lokasi_gambarqr = '../assets/gambarqr/' . basename($nama_gambarqr); // Sesuaikan dengan lokasi folder QR gambar

            if (file_exists($lokasi_gambar1)) {
                unlink($lokasi_gambar1);
            }

            if (file_exists($lokasi_gambar2)) {
                unlink($lokasi_gambar2);
            }

            if (file_exists($lokasi_gambarqr)) {
                unlink($lokasi_gambarqr);
            }

            return true; // Data berhasil dihapus
        }
    }

    return false; // Data tidak ditemukan atau gagal dihapus
}



// C-R-U-D / DATA Pemerajaan

function tambahlahan($data){
    global $koneksi;

    $lahan = htmlspecialchars($data["lahan"]);
    $user = htmlspecialchars($data["user"]);
    $vari = htmlspecialchars($data["vari"]);
    $tgl = htmlspecialchars($data["tgl"]);
    $bibit = htmlspecialchars($data["bibit"]);
    $luas = htmlspecialchars($data["luas"]);
    $tinggi = htmlspecialchars($data["tinggi"]);
    $longtitude = htmlspecialchars($data["longtitude"]);
    $latitude = htmlspecialchars($data["longtitude"]);

    $query = "INSERT INTO `data_lahan` (`kode_lahan`, `user`, `varietas_pohon`, `total_bibit`, `luas_lahan`, `tanggal`, `ketinggian_tanam`, `longtitude`, `latitude`) VALUES 
    ('$lahan', '$user', '$vari', '$bibit', '$luas', '$tgl', '$tinggi', '$longtitude', '$latitude')";


if (mysqli_query($koneksi, $query)) {
    header("Location: datalahan.php?alert=success");
    return mysqli_affected_rows($koneksi);
   
} else {
    return -1; // Gagal menyimpan data
}
}

function hapuslahan($id){
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM data_lahan WHERE kode_lahan='$id'");
    return mysqli_affected_rows($koneksi);
}


// C-R-U-D / DATA Pemerajaan

function tambahprj($data){
    global $koneksi;

    $kodeperemajaan = htmlspecialchars($data["kodeperemajaan"]);
    $kodelahan = htmlspecialchars($data["kodelahan"]);
    $tgl = htmlspecialchars($data["tgl"]);
    $kebutuhan = htmlspecialchars($data["kebutuhan"]);
    $pupuk = htmlspecialchars($data["pupuk"]);
    $perlakuan = htmlspecialchars($data["perlakuan"]);

    $query = "INSERT INTO `data_peremajaan` (`kode_peremajaan`, `kode_lahan`, `perlakuan`, `tanggal`, `kebutuhan`, `pupuk`) VALUES 
    ('$kodeperemajaan', '$kodelahan', '$perlakuan', '$tgl', '$kebutuhan', '$pupuk')";


if (mysqli_query($koneksi, $query)) {
    header("Location: data.php?alert=success");
    return mysqli_affected_rows($koneksi);
   
} else {
    return -1; // Gagal menyimpan data
}
}


function hapusKP($id){
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM data_peremajaan WHERE kode_peremajaan='$id'");
    return mysqli_affected_rows($koneksi);
}




// C-R-U-D / DATA POHON

// function tambahpohon($data){
//     global $koneksi;

//     $kode_pohon = htmlspecialchars($data["kode_pohon"]);
//     $priode = htmlspecialchars($data["priode"]);
//     $tinggi = htmlspecialchars($data["ketinggian"]);
//     $vari = htmlspecialchars($data["varietas"]);
//     $pupuk = htmlspecialchars($data["pupuk"]);

//         $query = "INSERT INTO data_pohon 
//                 VALUES
//                 ('$kode_pohon', '$priode', '$tinggi', '$vari', '$pupuk')

//     ";

//     mysqli_query($koneksi, $query);

//     return mysqli_affected_rows($koneksi);
// }

// function ubahpohon($data){
//     global $koneksi;

//     $kode_pohon = htmlspecialchars($data["kode_pohon"]);
//     $priode = htmlspecialchars($data["priode"]);
//     $tinggi = htmlspecialchars($data["ketinggian"]);
//     $vari = htmlspecialchars($data["varietas"]);
//     $pupuk = htmlspecialchars($data["pupuk"]);

    
//     $query = "UPDATE `data_pohon` SET `ketinggian_tanam` = '$tinggi', `priode_pemupukan` = '$priode', `kode_vari` = '$vari', `kode_pupuk` = '$pupuk' WHERE `data_pohon`.`kode_pohon` = '$kode_pohon';";
    

//     mysqli_query($koneksi, $query);

//     return mysqli_affected_rows($koneksi);
// }


// function hapuspohon($id){
//     global $koneksi;
//     mysqli_query($koneksi, "DELETE FROM data_pohon WHERE kode_pohon='$id'");
//     return mysqli_affected_rows($koneksi);
// }


// C-R-U-D / DATA VARIETAS
// function tambahvari($data){
//     global $koneksi;

//     $kode_pupuk = htmlspecialchars($data["kode_pupuk"]);
//     $nama_pupuk = htmlspecialchars($data["nama_pupuk"]);

//         $query = "INSERT INTO data_varietas 
//                 VALUES
//                 ('$kode_pupuk', '$nama_pupuk')

//     ";

//     mysqli_query($koneksi, $query);

//     return mysqli_affected_rows($koneksi);
// }

// function ubahvari($data){
//     global $koneksi;

//     $id = $data["kode_vari"];
//     $nama_vari = htmlspecialchars($data["nama_vari"]);

    
//     $query = "UPDATE `data_varietas` SET `nama_vari` = '$nama_vari' WHERE `data_varietas`.`kode_vari` = '$id';";
    

//     mysqli_query($koneksi, $query);

//     return mysqli_affected_rows($koneksi);
// }

// function hapusvari($id){
//     global $koneksi;
//     mysqli_query($koneksi, "DELETE FROM data_varietas WHERE kode_vari='$id'");
//     return mysqli_affected_rows($koneksi);
// }


?>




