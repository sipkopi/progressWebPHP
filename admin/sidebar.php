<?php

// Mendapatkan nama file halaman saat ini (misal: "dashboard.php" dari "/admin/dashboard.php")
$current_page = basename($_SERVER['REQUEST_URI']);

?>

<ul class="menu-inner py-1">
    <!-- Dashboards -->
    <br>
    <li class="menu-item <?php echo ($current_page === 'dashboard.php') ? 'active' : ''; ?>">
        <a href="../admin/dashboard.php" class="menu-link ">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Dashboards">Dashboards</div>
            <div class="badge bg-label-primary rounded-pill ms-auto">3</div>
        </a>
    </li>
    <br>
    <!-- Apps & Pages -->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Data User &amp; Kopi</span>
    </li>

    <li class="mb-2 menu-item <?php echo ($current_page === 'datauser.php') ? 'active open' : ''; ?>">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-users"></i>
            <div data-i18n="Data User">Data User</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item <?php echo ($current_page === 'datauser.php') ? 'active' : ''; ?>">
                <a href="../datauser/datauser.php" class="menu-link">
                    <div data-i18n="Data User">Data User</div>
                </a>
            </li>
        </ul>
    </li>

    <li class="menu-item <?php echo (in_array($current_page, array( 'datakopi.php', 'datalahan.php', 'data.php'))) ? 'active open' : ''; ?>">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon ti ti-box"></i>
        <div data-i18n="Data Produk">Data Produk</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item <?php echo ($current_page === 'datakopi.php') ? 'active' : ''; ?>">
            <a href="../datakopi/datakopi.php" class="menu-link">
                <div data-i18n="Data Kopi">Data Kopi</div>
            </a>
        </li>
        <li class="menu-item <?php echo ($current_page === 'datalahan.php') ? 'active' : ''; ?>">
            <a href="../datalahan/datalahan.php" class="menu-link">
                <div data-i18n="Data Lahan">Data Lahan</div>
            </a>
        </li>
        <li class="menu-item <?php echo ($current_page === 'data.php') ? 'active' : ''; ?>">
            <a href="../dataperemajaan/data.php" class="menu-link">
                <div data-i18n="Data Peremajaan">Data Peremajaan</div>
            </a>
        </li>
        <!-- <li class="menu-item <?php echo ($current_page === 'app-user-list.html') ? 'active' : ''; ?>">
            <a href="app-user-list.html" class="menu-link">
                <div data-i18n="Data Varietas">Data Varietas</div>
            </a>
        </li> -->
    </ul>
</li>

</ul>

