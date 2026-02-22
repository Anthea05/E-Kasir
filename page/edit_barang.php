<?php
    @$idMenu = $_GET['idMenu'];
    if(empty($idMenu)){
        ?>
            <script type="text/javascript">
                window.location.href="?p=list_barang";
            </script>
        <?php
    }

    $sql = "SELECT * FROM menu WHERE idMenu = '$idMenu'";
    $query = mysqli_query($koneksi, $sql);
    $cek = mysqli_num_rows($query);
    if($cek > 0){
        $data = mysqli_fetch_array($query);
    }else {
        $data = NULL;
    }
?>
    <style type="text/css">
        .row {
        background-color: white;
        width: 50%;
        margin: 50px auto;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        }
        
            h2 {
        padding-top: 5px;
        text-align: center;
        color: #333;
        }

        form {
        display: flex;
        flex-direction: column;
        }
        label {
            margin-top: 10px;
        }
        input[type="text"] {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        </style> 
<div class="row">
    <h2>Edit Menu</h2>
    <div class="col-lg-12">
        <form action="" method="post" class="form">
            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" name="namaMenu" class="form-control" value="<?= $data['namaMenu'] ?>">
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>">
            </div>

            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" value="<?= $data['stok'] ?>">
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-md btn-primary" name="simpan" value="Simpan">
            </div>
        </form>

        <?php

            if(isset($_POST['simpan'])){
                $namaMenu = $_POST['namaMenu'];
                $harga = $_POST['harga'];
                $stok = $_POST['stok'];
                $sql_update = "UPDATE menu SET namaMenu = '$namaMenu', harga = '$harga', stok = '$stok' WHERE idMenu='$idMenu'";
                $q = mysqli_query($koneksi, $sql_update);

                if($q) {
                    ?>
                        <script type="text/javascript">
                            window.location.href="?p=list_barang";
                        </script>
                    <?php
                }else {
                    ?>
                        <div class="alert alert-danger">
                            Gagal Menyimpan.
                        </div>
                    <?php
                }
            }

        ?>
    </div>
</div>
<div class="kembali">
    <a href="?p=list_barang" class="btn btn-md btn-default" style="margin-left: 530px">Kembali</a>
</div>