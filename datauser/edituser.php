
<?php
ob_start(); // Mulai output buffering
?>

<?php
session_start();
 
if (!isset($_SESSION['nama'])) {
    header("Location: ../admin/indexlogin.php");
    exit(); // Terminate script execution after the redirect
}


require '../koneksi/koneksi.php';

$user= $_GET["user"];

$swa = query("SELECT * FROM data_user WHERE user = '$user'")[0];

?>

    <link rel="stylesheet" href="../assets/vendor/libs/sweetalert2/sweetalert2.css" />
   
    <script>
function confirmEdit(event) {
  event.preventDefault();

  Swal.fire({
    title: 'Apakah Ingin Mengubah Data?',
    // text: 'Apakah Anda yakin ingin menyimpan perubahan?',
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
      // Get user data from form
      const formData = new FormData(document.getElementById('formAccountSettings'));

      // Send user data to the server-side script
      fetch('action.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Swal.fire('Data Tersimpan', '', 'success');

            Swal.fire({
  icon: 'success',
  title: 'Data Tersimpan',
  showConfirmButton: false,
  timer: 1500
})

            setTimeout(() => {
              window.location.href = 'datauser.php';
            }, 1500);
          } else {
            Swal.fire('Kesalahan', data.message, 'error');
          }
        })
        .catch(error => {
          console.error('Terjadi kesalahan:', error);
          Swal.fire('Kesalahan', 'Terjadi kesalahan saat menyimpan data.', 'error');
        });
    }
  });
}

</script>


                    <div class="card mb-4">
                    <h3 class="card-header">Edit User</h3>
                    <hr class="my-0" />
                    <!-- Account -->
                    <div class="card-body">
                    <form id="formAccountSettings" action="action.php" method="POST" onsubmit="return confirmEdit(event)" enctype="multipart/form-data">
                      <div class="d-flex align-items-start align-items-sm-center mb-4 gap-4">
                        <img
                          src="<?= $swa["gambar"] ?>"
                          alt="user-avatar"
                          class="d-block w-px-100 h-px-100 rounded"
                          name="uploada"
                          id="uploadedAvatar" />
                        <div class="button-wrapper">
                          <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                            <span class="d-none d-sm-block">Upload Foto Baru</span>
                            <i class="ti ti-upload d-block d-sm-none"></i>
                            <input
                              type="file"
                              id="upload"
                              name="upload"
                              class="account-file-input"
                              hidden
                              accept="image/png, image/jpeg" />
                          </label>
                          <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
                            <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                          </button>

                          <div class="text-muted">Diperbolehkan bentuk JPG, GIF or PNG. Maximum 5MB</div>
                        </div>
                      </div>
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">Username</label>
                            <input
                              class="form-control"
                              type="text"
                              name="user"
                              value="<?= $swa["user"] ?>" readonly
                              placeholder="" required
                              autofocus />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Nama Lengkap</label>
                            <input class="form-control" id="inputHuruf" oninput="validateInput(this)" type="text" name="nama" value="<?= $swa["nama"] ?>" required />
                            <span id="error-message" style="color: cyan;"></span>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input
                              class="form-control"
                              type="email"
                              value="<?= $swa["email"] ?>" required
                              name="email"
                              placeholder="john.doe@example.com" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="phoneNumber">No HP</label>
                            <div class="input-group input-group-merge">
                              <span class="input-group-text">ID (+62)</span>
                              <input
                                type="number"
                                value="<?= $swa["nohp"] ?>" required
                                name="nohp"
                                class="form-control"
                                placeholder="" />
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Lokasi</label>
                            <input type="text" class="form-control"  value="<?= $swa["lokasi"] ?>" required name="lokasi" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="state" class="form-label">Level Akun</label>
                            <input class="form-control" type="text" value="<?= $swa["level"] ?>" readonly required name="level" placeholder="" />
                          </div>

                        </div>
                        <div class="mt-5 text-end">
                          
                          <button type="submit"  id="accountActivation" class="btn btn-primary me-3">Simpan Data</button>
                          <a class="btn btn-danger" href="datauser.php">Kembali </a>
                          
                        </div>
                        </form>
                    </div>
                    <!-- /Account -->
                  </div>

<script>

function validateInput(inputElement) {
      const inputValue = inputElement.value;
      const forbiddenCharacters = /[@1234567890!#^&*]/g; // Karakter yang tidak diinginkan

      if (forbiddenCharacters.test(inputValue)) {
        document.getElementById('error-message').textContent = 'Tidak boleh mengandung karakter tertentu, seperti @, angka, atau karakter lainnya.';
        inputElement.value = inputValue.replace(forbiddenCharacters, ''); // Menghapus karakter yang tidak diinginkan
      } else {
        document.getElementById('error-message').textContent = '';
      }
    }


document.addEventListener('DOMContentLoaded', function () {
  (function () {
    // Update/reset user image on the account page
    const accountUserImage = document.getElementById('uploadedAvatar');
    const fileInput = document.querySelector('.account-file-input');
    const resetFileInput = document.querySelector('.account-image-reset');

    if (accountUserImage) {
      const resetImage = accountUserImage.src;

      fileInput.onchange = () => {
        if (fileInput.files[0]) {
          accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
        }
      };

      resetFileInput.onclick = () => {
        fileInput.value = '';
        accountUserImage.src = resetImage;
      };
    }
  })();
});

</script>

<script src="../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>



<?php
$content = ob_get_clean(); // Ambil konten yang telah di-buffer

include '../admin/body.php';

?>