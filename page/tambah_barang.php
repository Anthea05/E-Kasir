<div class="row">
    <h2>Tambah Menu</h2>
    <div class="col-lg-12">
        <form action="" method="post" class="form">
            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" name="namaMenu" class="form-control" placeholder="Masukkan Nama Menu">
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" placeholder="Masukkan Harga">
            </div>

            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" placeholder="Masukkan Jumlah Stok">
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-md btn-primary" name="simpan" value="Simpan">
            </div>
        </form>
        
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

        <?php
            if(isset($_POST['simpan'])){
                $namaMenu = $_POST['namaMenu'];
                $harga = $_POST['harga'];
                $stok = $_POST['stok'];
                $sql = "INSERT INTO menu SET namaMenu='$namaMenu', harga= '$harga', stok= '$stok'";
                $query = mysqli_query($koneksi, $sql);
                if($query) {
                    ?>
                        <div class="alert alert-success">
                            Berhasil Menambah Menu
                        </div>
                    <?php
                }else {
                    ?>
                        <div class="alert alert-danger">
                            Gagal Menambah Menu
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