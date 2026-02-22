<?php
    @$idUser = $_GET['idUser'];
    if(empty($idUser)){
        ?>
            <script type="text/javascript">
                window.location.href="?p=list_petugas";
            </script>
        <?php
    }

    $sql = "SELECT * FROM user WHERE idUser = '$idUser'";
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
    <h2>Edit Petugas</h2>
    <div class="col-lg-12">
        <form action="" method="post" class="form">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?= $data['username'] ?>">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="text" name="password" class="form-control" value="<?= $data['password'] ?>">
            </div>

            <div class="form-group">
                <label>Level</label>
                <input type="text" name="level" class="form-control" value="<?= $data['level'] ?>">
            </div>
            <h5>Level yang tersedia: Admin, Kasir, Waiter, Pemilik</h5>

            <div class="form-group">
                <input type="submit" class="btn btn-md btn-primary" name="simpan" value="Simpan">
            </div>
        </form>

        <?php
    if(isset($_POST['simpan'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $level = $_POST['level'];
        
        // Cek apakah kolom password diisi atau tidak
        if (!empty($password)) {
            // Jika DIISI, hash password baru dengan metode yang aman
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql_update = "UPDATE user SET username = '$username', password = '$hashed_password', level = '$level' WHERE idUser='$idUser'";
        } else {
            // Jika KOSONG, JANGAN perbarui kolom password
            $sql_update = "UPDATE user SET username = '$username', level = '$level' WHERE idUser='$idUser'";
        }
        
        // PENTING: Gunakan prepared statement untuk keamanan
        $stmt = mysqli_prepare($koneksi, $sql_update);
        
        if(mysqli_stmt_execute($stmt)) {
            ?>
                <script>
                    window.location.href="?p=list_petugas";
                </script>
            <?php
        } else {
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
    <a href="?p=list_petugas" class="btn btn-md btn-default" style="margin-left: 530px">Kembali</a>
</div>