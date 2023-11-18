<?php
// Include file koneksi
include '../koneksi/koneksi.php';

if (isset($_POST['user'])) {
    $user = $_POST['user'];
    $password_lama = hash('sha256', $_POST['password_lama']);
    $password_baru = hash('sha256', $_POST['password_baru']);
    $konfirmasi_password = hash('sha256', $_POST['konfirmasi_password']);

    // Query untuk mengambil password saat ini dari database
    $query = "SELECT pass, user FROM data_user WHERE user='$user'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $password_db = $row['pass'];
        $user = $row['user'];

        // Verifikasi password lama dengan password yang ada di database
        if ($password_lama == $password_db) {
            // Verifikasi password baru dan konfirmasi password baru
            if ($password_baru == $konfirmasi_password) {
                // Update password baru ke dalam database
                $update_query = "UPDATE data_user SET pass='$password_baru' WHERE user='$user'";
                $update_result = mysqli_query($koneksi, $update_query);

                if ($update_result) {
                    echo json_encode(array('success' => true, 'message' => 'Password berhasil diubah!'));
                } else {
                    echo json_encode(array('success' => false, 'message' => 'Woops! Terjadi kesalahan.'));
                }
            } else {
                echo json_encode(array('success' => false, 'message' => 'Konfirmasi password baru tidak sesuai.'));
            }
        } else {
            echo json_encode(array('success' => false, 'message' => 'Password lama salah.'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Terjadi kesalahan dalam mengambil data.'));
    }
}
?>
