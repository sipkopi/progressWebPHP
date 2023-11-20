<?php

ob_start(); // Mulai output buffering

session_start();
if (!isset($_SESSION['nama'])) {
    header("Location: ../admin/indexlogin.php");
    exit(); // Terminate script execution after the redirect
}


// memanggil data berdasarkan kode peremajaan
require '../koneksi/koneksi.php';
$kode_peremajaan = $_GET["kode_peremajaan"];

$swa = query("SELECT * FROM data_peremajaan WHERE kode_peremajaan = '$kode_peremajaan'")[0];

?>


    <link rel="stylesheet" href="../assets/vendor/libs/flatpickr/flatpickr.css" />
 <script src="../assets/vendor/libs/flatpickr/flatpickr.js"></script>
 <link rel="stylesheet" href="../assets/vendor/libs/sweetalert2/sweetalert2.css" />
 <script src="../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>



<div class="card mb-4">
                    <h3 class="card-header">Edit Data Peremajaan</h3>
                    <hr class="my-0" />
                    <!-- Account -->
                    <div class="card-body">
                    <form id="formAccountSettings" action="editdata.php" method="POST" onsubmit="return confirmEdit(event)" enctype="multipart/form-data">
                      <div class="d-flex align-items-start align-items-sm-center mb-2 gap-4">
                      </div>
                        <div class="row">

                          <div class="mb-3 ">
                            <label for="firstName" class="form-label">Kode Peremajaan</label>
                            <input
                              class="form-control"
                              type="text"
                              name="kodeperemajaan" value="<?= $swa["kode_peremajaan"] ?>" required readonly
                              autofocus />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Kode Lahan</label>
                            <select name="kodelahan" class="select2 form-select">
                                  <?php
                                  $nama_pengguna = $_SESSION['user'];
                                  $vari_query = mysqli_query($koneksi, "SELECT kode_lahan, user, varietas_pohon FROM data_lahan WHERE user = '$nama_pengguna'"); // Ganti 'nama_pengguna' dengan nama kolom yang sesuai
                                  
                                  if ($vari_query) {
                                      while ($getdataa = mysqli_fetch_assoc($vari_query)) {
                                          echo "<option value='" . $getdataa["kode_lahan"] . "'>" . $getdataa["kode_lahan"] ." ". $getdataa["varietas_pohon"] . "</option>";
                                      }
                                  } else {
                                      echo "<option value=''>Data lahan tidak tersedia</option>";
                                  }
                                  ?>
                                </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="flatpickr-datetime" class="form-label">Tanggal</label>
                            <input
                              class="form-control"
                              type="text"
                              value="<?= $swa["tanggal"] ?>" required
                              placeholder="YYYY-MM-DD HH:MM" 
                              name="tgl" 
                              id="flatpickr-date"
                               />
                          </div>

                          <div class="mb-3 col-md-6">
                          <label for="lastName" class="form-label">Kebutuhan ( Liter )</label>
                            <input class="form-control" type="number" name="kebutuhan" value="<?= $swa["kebutuhan"] ?>" required />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Pupuk</label>
                            <input type="text" class="form-control"  value="<?= $swa["pupuk"] ?>" required name="pupuk" />
                          </div>

                          <div class="mb-3 ">
                            <label for="state" class="form-label">Perlakuan</label>
                            <input class="form-control" type="text" value="<?= $swa["perlakuan"] ?>" required name="perlakuan" placeholder="" />
                          </div>

                        </div>
                        <div class="mt-5 text-end">
                          
                          <button type="submit" id="accountActivation" class="btn btn-primary me-3">Simpan Data</button>
                          <a class="btn btn-danger" href="data.php">Kembali </a>
                          
                          
                        </div>
                        </form>
                    </div>
                    <!-- /Account -->
                  </div>



<!-- CUSTOM TANGGAL -->
<script>
  'use strict';

(function () {

  const flatpickrDate = document.querySelector('#flatpickr-date');

  if (flatpickrDate) {
    flatpickrDate.flatpickr({
      monthSelectorType: 'static'
    });
  }

})();
</script>
<!-- CUSTOM TANGGAL -->

<!-- CUSTOM SIMPAN -->
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
      fetch('editdata.php', {
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
              window.location.href = 'data.php';
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
<!-- CUSTOM SIMPAN -->


<?php
$content = ob_get_clean(); // Ambil konten yang telah di-buffer

include '../admin/body.php';

?>