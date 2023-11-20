<?php

require '../koneksi/koneksi.php';

    $kode_kopi = $_GET['kode_kopi'];

    if (hapuskopi($kode_kopi) > 0) {
        echo "
       <script>
            
               document.location.href = 'datakopi.php';
       </script>
       ";
} else{
        echo "
       <script>
               document.location.href = 'datakopi.php';
       </script>
       ";
}


?>