<?php
        include "../config/koneksi.php";

        $idUser = $_GET['idUser'];
        $sql = "DELETE FROM user WHERE idUser='$idUser'";
        $query = mysqli_query($koneksi, $sql);
        

        if($query){
            ?>
                <script type="text/javascript">
                    window.location.href="../index.php?p=list_petugas";
                </script>
            <?php
        }else{
            ?>
                <script type="text/javascript">
                    alert('Terjadi Kesalahan');
                    window.location.href="../index.php?p=list_petugas";
                </script>
            <?php
        }

    ?>  