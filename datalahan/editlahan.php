
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

$kode_lahan= $_GET["kode_lahan"];

$swa = query("SELECT * FROM data_lahan WHERE kode_lahan = '$kode_lahan'")[0];
?>


<link rel="stylesheet" href="../assets/vendor/libs/flatpickr/flatpickr.css" />
 <script src="../assets/vendor/libs/flatpickr/flatpickr.js"></script>
 <link rel="stylesheet" href="../assets/vendor/libs/sweetalert2/sweetalert2.css" />
 <script src="../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>



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
                              name="kodelahan" value="<?= $swa["kode_lahan"] ?>" required readonly
                              autofocus />
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">User</label>
                            <select name="user" value="<?= $swa["user"] ?>" class="select2 form-select">
                            
                                  <?php
                                  $nama_pengguna = $_SESSION['user'];
                                  $vari_query = mysqli_query($koneksi, "SELECT user FROM data_user WHERE user = '$nama_pengguna'"); // Ganti 'nama_pengguna' dengan nama kolom yang sesuai
                                  
                                  if ($vari_query) {
                                      while ($getdataa = mysqli_fetch_assoc($vari_query)) {
                                          echo "<option value='" . $getdataa["user"] . "'>" . $getdataa["user"] . "</option>";
                                      }
                                  } else {
                                      echo "<option value=''>Data lahan tidak tersedia</option>";
                                  }
                                  ?>
                                </select>
                          </div>

                          <div class="mb-3 col-md-6">
                          <label for="emailLarge" class="form-label">Varietas Pohon</label>
                            <input class="form-control" type="text" name="vari" id="inputHuruf" oninput="validateInput(this)" value="<?= $swa["varietas_pohon"] ?>" required />
                            <span id="error-message" style="color: cyan;"></span>
                          </div>

                          <div class="row mb-3 mt-1">

                              <div class="col mb-0">
                              <label for="emailLarge" class="form-label">Total Bibit ( Pohon )</label>
                              <input type="number" name="bibit" value="<?= $swa["total_bibit"] ?>" required class="form-control" />
                                </div>
                                <div class="col mb-0">
                                <label for="emailLarge" class="form-label">Luas Lahan ( M ² )</label>
                                  <input type="number" name="luas" value="<?= $swa["luas_lahan"] ?>" required class="form-control" />
                                </div>

                                 <div class="col mb-0">
                                <label for="emailLarge" class="form-label">Ketinggian Tanam ( Meter )</label>
                                  <input type="number" name="tinggi" value="<?= $swa["ketinggian_tanam"] ?>" required class="form-control" />
                                </div>

                                </div>

                          <div class="mb-3 ">
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
                            <label for="state" class="form-label">Longtitude</label>
                            <input class="form-control" type="text" value="<?= $swa["longtitude"] ?>" required name="longtitude" placeholder="" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="state" class="form-label">Latitude</label>
                            <input class="form-control" type="text" value="<?= $swa["latitude"] ?>" required name="latitude" placeholder="" />
                          </div>

                        </div>
                        <div class="mt-4">
                          
                          <button type="submit" id="accountActivation" class="btn btn-primary me-2">Simpan Data</button>
                          
                          <a class="btn btn-label-danger" href="datalahan.php">Kembali </a>
                          
                        </div>
                        </form>
                    </div>
                    <!-- /Account -->
                  </div>


<!-- CUSTOM hanya Huruf -->
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
</script>
<!-- CUSTOM hanya Huruf -->

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
              window.location.href = 'datalahan.php';
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