<?php
session_start();
 
if (!isset($_SESSION['nama'])) {
    header("Location: indexlogin.php");
    exit(); // Terminate script execution after the redirect
}


ob_start(); // Mulai output buffering
?>

<?php


require '../koneksi/koneksi.php';

$user= $_GET["user"];

$swa = query("SELECT * FROM data_user WHERE user = '$user'")[0];


?>

    <!-- Page CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/pages/page-account-settings.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/sweetalert2/sweetalert2.css" />



    <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-4">
                    <li class="nav-item">
                      <a class="nav-link" href="../admin/editadmin.php?user=<?=$swa["user"];?>"
                        ><i class="ti-xs ti ti-users me-1"></i> Account</a
                      >
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" href="../admin/ubahsandiadmin.php?user=<?=$swa["user"];?>"
                        ><i class="ti-xs ti ti-lock me-1"></i> Security</a
                      >
                    </li>

                  </ul>
                  <!-- Change Password -->
                  <div class="card mb-4">
                    <h3 class="card-header">Ubah Password Admin</h3>
                    <hr class="my-0" />
                    <div class="card-body">
                    <form id="formAccountSettings" action="actadminsandi.php" method="POST" onsubmit="return confirmEdit(event)" enctype="multipart/form-data">
                        <div class="row">
                          <div class="mb-3 col-md-6 form-password-toggle">
                            <label class="form-label" for="currentPassword">Sandi Lama</label>
                            <div class="input-group input-group-merge">
                              <input
                                class="form-control"
                                type="password"
                                name="password_lama" required
                               
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                              <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                          </div>
                        </div>
                        <input type="hidden" name="user" value="<?=$swa['user']?>" />
                        <div class="row">
                          <div class="mb-3 col-md-6 form-password-toggle">
                            <label class="form-label" for="newPassword">Sandi Baru</label>
                            <div class="input-group input-group-merge">
                              <input
                                class="form-control"
                                type="password"
                               
                                name="password_baru" required
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                              <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                          </div>

                          <div class="mb-3 col-md-6 form-password-toggle">
                            <label class="form-label" for="confirmPassword">Konfirmasi Sandi Baru</label>
                            <div class="input-group input-group-merge">
                              <input
                                class="form-control"
                                type="password"
                                name="konfirmasi_password" required
                               
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                              <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                          </div>
                          <div id="message-container"></div>
                          <div class="col-12 mt-3 mb-4">
                            <h6>Password Requirements:</h6>
                            <ul class="ps-3 mb-0">
                              <li class="mb-1">Panjang minimal 8 karakter, semakin banyak semakin baik</li>
                              <li class="mb-1">Setidaknya satu karakter besar</li>
                              <li>Setidaknya satu angka, simbol atau karakter spasi </li>
                            </ul>
                          </div>
                          <div>
                            <button type="submit" id="accountActivation" class="btn btn-primary me-2">Ubah Sandi</button>
                            <a href="../admin/detailadmin.php?user=<?=$swa["user"];?>" class="btn btn-label-danger">Kemabli</a>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  </div>
                  </div>

                  <!--/ Change Password -->


                  <script>
function confirmEdit(event) {
    event.preventDefault();

    Swal.fire({
        title: 'Apakah Ingin Mengubah Data?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'btn btn-primary me-2',
            cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData(document.getElementById('formAccountSettings'));

            fetch('actadminsandi.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                  Swal.fire({
  icon: 'success',
  title: 'Sandi Telah Diubah',
  showConfirmButton: false,
  timer: 1500
})
            setTimeout(() => {
              window.location.href = 'detailadmin.php?user=<?=$swa["user"];?>';
            }, 1500);
                } else {
                    // Tampilkan pesan kesalahan di dalam elemen #message-container
                    document.getElementById('message-container').innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
                }
            })
            .catch(error => {
                console.error('Terjadi kesalahan:', error);
                // Tampilkan pesan kesalahan di dalam elemen #message-container
                document.getElementById('message-container').innerHTML = '<div class="alert alert-danger">Terjadi kesalahan saat menyimpan data</div>';
            });
        }
    });
}
</script>


    <!-- Page JS -->
    <script src="../assets/js/pages-account-settings-security.js"></script>
    <script src="../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

<?php
$content = ob_get_clean(); // Ambil konten yang telah di-buffer

include_once '../admin/body.php';

?>