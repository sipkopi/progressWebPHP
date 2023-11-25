<?php

ob_start(); // Mulai output buffering

session_start();
if (!isset($_SESSION['nama'])) {
    header("Location: ../admin/indexlogin.php");
    exit(); // Terminate script execution after the redirect
}


require '../koneksi/koneksi.php';

$kode_kopi= $_GET["kode_kopi"];

$swa = query("SELECT * FROM data_kopi WHERE kode_kopi = '$kode_kopi'")[0];


?>

<script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <link rel="stylesheet" href="../assets/vendor/libs/flatpickr/flatpickr.css" />
 <script src="../assets/vendor/libs/flatpickr/flatpickr.js"></script>
 
<link rel="stylesheet" href="../assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <script src="../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <link rel="stylesheet" href="../assets/vendor/libs/animate-css/animate.css" />

    
<!-- /edit kopi -->

<div class="card mb-4">
                    <h3 class="card-header">Edit Data Lahan</h3>
                    <hr class="my-0" />
                    <!-- Account -->
                    <div class="card-body">
                    <form id="formAccountSettings" action="editdata.php" method="POST" onsubmit="return confirmEdit(event)" enctype="multipart/form-data">
                      <div class="d-flex align-items-start align-items-sm-center mb-2 gap-4">
                      </div>
                        <div class="row">

                          <div class="mb-3 ">
                            <label for="firstName" class="form-label">Kode Lahan</label>
                            <input
                              class="form-control"
                              type="text"
                              name="kdkopi" value="<?= $swa["kode_kopi"] ?>" required readonly
                              autofocus />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Kode Peremajaan</label>
                            <select name="pere" class="select2 form-select">
                            <option hidden value="<?= $swa["kode_peremajaan"] ?>"><?= $swa["kode_peremajaan"] ?></option>
                            <option value=""></option>
                                  <?php
                                 
                                  $kode_peremajaan = $swa["kode_peremajaan"];
                                  $vari_query = mysqli_query($koneksi, "SELECT kode_peremajaan FROM data_peremajaan WHERE NOT kode_peremajaan = '$kode_peremajaan'"); // Ganti 'nama_pengguna' dengan nama kolom yang sesuai
                                  
                                  if ($vari_query) {
                                      while ($getdataa = mysqli_fetch_assoc($vari_query)) {
                                          echo "<option value='" . $getdataa["kode_peremajaan"] . "'>" . $getdataa["kode_peremajaan"] . "</option>";
                                      }
                                  } else {
                                      echo "<option value=''>Data lahan tidak tersedia</option>";
                                  }
                                  ?>
                                </select>
                          </div>

                          <div class="mb-3 col-md-6">
                          <label for="emailLarge" class="form-label">Varietas Kopi</label>
                            <input class="form-control" type="text" name="vari" id="inputHuruf" oninput="validateInput(this)" value="<?= $swa["varietas_kopi"] ?>" required />
                          
                          </div>

                          <div class="mb-3 col-md-6">
                          <label for="emailLarge" class="form-label">Metode Pengolahan</label>
                          <select id="defaultSelect" name="metode" class="form-select">
                          <option required value="<?= $swa["metode_pengolahan"] ?>"><?= $swa["metode_pengolahan"] ?></option>
                          <option value="Basah">Basah</option>
                          <option value="Kering">Kering</option>
                                </select>
                          </div>

                          <div class="mb-3 col-md-6">
                          <label for="emailLarge" class="form-label">Berat</label>
                            <input class="form-control" type="number" name="berat" value="<?= $swa["berat"] ?>" required />
                            
                          </div>

                          <div class="row mb-3 mt-1">

                              <div class="col mb-0">
                              <label for="emailLarge" class="form-label">Tanggal Panen</label>
                                  <input type="text" name="tglpan" value="<?= $swa["tgl_panen"] ?>" required id="flatpickr-date" class="form-control" placeholder="" />
                                </div>
                                <div class="col mb-0">
                                <label for="emailLarge" class="form-label">Tanggal Roasting</label>
                                  <input type="text" name="tglroas" value="<?= $swa["tgl_roasting"] ?>" required id="flatpickr-datee" class="form-control" placeholder="" />
                                </div>

                                 <div class="col mb-0">
                                 <label for="emailLarge" class="form-label">Tgl Expired</label>
                                  <input type="text" name="tglexp" value="<?= $swa["tgl_exp"] ?>" required id="flatpickr-dateee" class="form-control" placeholder="" />
                                </div>

                                </div>

                          <div class="mb-3">
                          <label for="exampleFormControlTextarea1">Deskripsi</label>
                                <textarea type="text" name="desk" class="form-control mt-1 mb-4"  rows="4"><?= $swa["deskripsi"] ?></textarea>
                          </div>

                          <div class="mb-3 col-md-6 mt-3 mb-4">
  <h6 for="exampleFormControlTextarea1">Gambar 1</h6>
  <div class="d-flex align-items-start align-items-sm-center mb-4 gap-4">
    <img
      src="<?= $swa["gambar1"] ?>"
      alt="user-avatar"
      class="d-block w-px-200 h-px-200 rounded"
      name="upload1" 
      id="uploadedAvatar" />
    <div class="button-wrapper">
      <label for="upload1" class="btn btn-primary me-2 mb-3" tabindex="0"> <!-- Ganti "for" ke "upload1" -->
        <span class="d-none d-sm-block">Upload Foto Baru</span>
        <i class="ti ti-upload d-block d-sm-none"></i>
        <input
          type="file"
          id="upload1"
          name="upload11" 
          class="account-file-input"
          value="<?= $swa["gambar1"] ?>"
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
</div>

<div class="mb-3 col-md-6 mt-3 mb-4">
  <h6 for="exampleFormControlTextarea1">Gambar 2</h6>
  <div class="d-flex align-items-start align-items-sm-center mb-4 gap-4">
    <img
      src="<?= $swa["gambar2"] ?>"
      alt="user-avatar"
      class="d-block w-px-200 h-px-200 rounded"
      name="upload2" 
      id="uploadedAvatarsatu" />
    <div class="button-wrapper">
      <label for="upload2" class="btn btn-primary me-2 mb-3" tabindex="0"> <!-- Ganti "for" ke "upload2" -->
        <span class "d-none d-sm-block">Upload Foto Baru</span>
        <i class="ti ti-upload d-block d-sm-none"></i>
        <input
          type="file"
          id="upload2" 
          name="upload22"
          class="account-file-inputsatu"
          hidden
          value="<?= $swa["gambar2"] ?>"
          accept="image/png, image/jpeg" />
      </label>
      <button type="button" class="btn btn-label-secondary account-image-resetsatu mb-3">
        <i class="ti ti-refresh-dot d-block d-sm-none"></i>
        <span class="d-none d-sm-block">Reset</span>
      </button>
      <div class="text-muted">Diperbolehkan bentuk JPG, GIF or PNG. Maximum 5MB</div>
    </div>
  </div>
</div>



                        </div>
                        <div class="mt-5 text-end mb-2">
                          
                          <button type="submit" id="accountActivation" class="btn btn-primary me-3">Simpan Data</button>
                          <a class="btn btn-danger" href="datakopi.php">Kembali </a>
                        </div>
                        </form>
                    </div>
                
                  </div>
<!-- /edit kopi -->

<!-- ALERT  EDIT -->
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
      fetch('actedit.php', {
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
              window.location.href = 'datakopi.php';
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
<!-- ALERT  EDIT -->



<!-- CUSTOM TANGGAL -->
<script>
  'use strict';
(function () {

  const flatpickrDate = document.querySelector('#flatpickr-date'),
   flatpickrDatepanen = document.querySelector('#flatpickr-datee'),
   flatpickrDateexp = document.querySelector('#flatpickr-dateee');

  if (flatpickrDate) {
    flatpickrDate.flatpickr({
      monthSelectorType: 'static'
    });
  }

  if (flatpickrDatepanen) {
    flatpickrDatepanen.flatpickr({
      monthSelectorType: 'static'
    });
  }

  if (flatpickrDateexp) {
    flatpickrDateexp.flatpickr({
      monthSelectorType: 'static'
    });
  }
})();
</script>
<!-- CUSTOM TANGGAL -->



<script>

// TIDAK BOLEH INPUT ANGKA
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


// UPDATE GAMBAR 1
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

// UPDATE GAMBAR 2
document.addEventListener('DOMContentLoaded', function () {
  (function () {
    // Update/reset user image on the account page
    const Image = document.getElementById('uploadedAvatarsatu');
    const file = document.querySelector('.account-file-inputsatu');
    const resetFileInput = document.querySelector('.account-image-resetsatu');

    if (Image) {
      const resetImage = Image.src;

      file.onchange = () => {
        if (file.files[0]) {
          Image.src = window.URL.createObjectURL(file.files[0]);
        }
      };

      resetFileInput.onclick = () => {
        file.value = '';
        Image.src = resetImage;
      };
    }
  })();
});


</script>





<?php
$content = ob_get_clean(); // Ambil konten yang telah di-buffer

include '../admin/body.php';

?>