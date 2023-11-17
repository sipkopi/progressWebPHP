<?php
session_start();
if (!isset($_SESSION['nama'])) {
    header("Location: indexlogin.php");
    exit(); // Terminate script execution after the redirect
}
ob_start(); // Mulai output buffering
?>

<?php


include_once '../koneksi/koneksi.php';

$user= $_GET["user"];

$swa = query("SELECT * FROM data_user WHERE user = '$user'")[0];


?>
    <link rel="stylesheet" href="../assets/vendor/css/pages/page-profile.css" />
              <!-- Header -->
              <div class="row">
                <div class="col-12">
                  <div class="card mb-4">
                    <div class="user-profile-header-banner">
                      <img src="../assets/img/pages/profile-banner.png" alt="Banner image" class="rounded-top" />
                    </div>
                    <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                      <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img
                          src="<?= $swa["gambar"] ?>"
                          alt="user image"
                          class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" />
                      </div>
                      <div class="flex-grow-1 mt-3 mt-sm-5">
                        <div
                          class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                          <div class="user-profile-info">
                            <h4><?= $swa["nama"] ?></h4>
                            <ul
                              class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                              <li class="list-inline-item"><i class="ti ti-color-swatch"></i> <?= $swa["level"] ?></li>
                              <li class="list-inline-item"><i class="ti ti-map-pin"></i> <?= $swa["lokasi"] ?></li>
                              <li class="list-inline-item"><i class="ti ti-calendar"></i> Joined <?= $swa["tanggal_create"] ?></li>
                            </ul>
                          </div>
                          <a href="editadmin.php?user=<?=$swa["user"];?>" class="btn btn-primary">
                            <i class="ti ti-user-check me-1"></i>Setting Akun
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Header -->

<div class="card mb-4">
                    <h3 class="card-header">Detail Tambahan</h3>
                    <!-- Account -->

                    <hr class="my-0" />
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST" onsubmit="return false">
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
                            <label for="email" class="form-label">E-mail</label>
                            <input
                              class="form-control"
                              type="email"
                              value="<?= $swa["email"] ?>" readonly
                              name="email"
                              placeholder="john.doe@example.com" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="phoneNumber">No HP</label>
                            <div class="input-group input-group-merge">
                              <span class="input-group-text">ID (+62)</span>
                              <input
                                type="number"
                                value="<?= $swa["nohp"] ?>" readonly
                                name="nohp"
                                class="form-control"
                                placeholder="" />
                            </div>
                          </div>
                        </div>
                        <div class="mt-2">
                          <!-- <button type="submit" class="btn btn-primary me-2">Save changes</button>
                          <button type="reset" class="btn btn-label-secondary">Cancel</button> -->
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>



<?php
$content = ob_get_clean(); // Ambil konten yang telah di-buffer

include '../admin/body.php';

?>