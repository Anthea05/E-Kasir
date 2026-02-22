<?php
    include "../config/koneksi.php";
    
    $idPesanan = isset($_GET['idPesanan']) ? $_GET['idPesanan'] : '';
    
    if(empty($idPesanan)) {
        header('Location: ../index.php?p=pesan');
        exit(); 
    }

    $idPesanan = mysqli_real_escape_string($koneksi, $idPesanan);
    
    $sql = "UPDATE pesanan SET status='1' WHERE idPesanan='$idPesanan'";
    $query = mysqli_query($koneksi, $sql);

    if($query) {
        ?>
            <script type="text/javascript">
                window.location.href="../index.php?p=pesan";
            </script>
        <?php
    } else {
        ?>
            <script type="text/javascript">
                alert('GAGAL MENGUBAH STATUS');
                window.location.href="../index.php?p=pesan";
            </script>
        <?php
    }
?>
