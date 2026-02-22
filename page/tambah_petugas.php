<div class="row">
    <h2>Tambah Petugas</h2>
    <div class="col-lg-12">
        <form action="" method="post" class="form">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan Username">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="text" name="password" class="form-control" placeholder="Masukkan Password">
            </div>

            <div class="form-group">
                <label>Level</label>
            </div>
            <select name="level" class="form-control">
                    <option value="level">masukkan level</option>
                    <option value="admin">admin</option>
                    <option value="kasir">kasir</option>
                    <option value="waiter">waiter</option>
                    <option value="pemilik">pemilik</option>
                    </select>

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
                $username = $_POST['username'];
                $password = md5($_POST['password']);
                $level = $_POST['level'];

                $sql = "INSERT INTO user SET username='$username', password= '$password', level='$level'";
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
    <a href="?p=list_petugas" class="btn btn-md btn-default" style="margin-left: 530px">Kembali</a>
</div>