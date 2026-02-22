<?php
    $sql = "SELECT max(idPelanggan) as maxKode FROM pelanggan";
    $query = mysqli_query($koneksi, $sql);

    $data = mysqli_fetch_array($query);
    $idPelanggan = $data['maxKode'];

    if ($idPelanggan !== null) {
        $noUrut = (int) substr($idPelanggan, 3, 3) + 1;
    } else {
        $noUrut = 1;
    }

    $char = "PLG";
    $kodePelanggan = $char . sprintf("%03s", $noUrut);
?>



<div class="row">
    <center>
    <h2>Pesanan</h2>
    </center>
    <div class="col-lg-5">
        <div class="panel panel-primary">
            <div class="panel-heading">Form Pesanan</div>
            <div class="panel-body">
                <form action="" method="post">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ID Pelanggan</label>
                            <input type="text" name="idPelanggan" class="form-control" readonly="readonly" value="<?= $kodePelanggan ?>">
                        </div>

                        <div class="form-group">
                            <label>Nama Pelanggan</label>
                            <input type="text" name="namaPelanggan" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenisKelamin" class="form-control">
                                <option value="jenisKelamin">- Jenis Kelamin -</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>No Telepon</label>
                            <input type="number" name="noHp" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Menu</label>
                            <select name="idMenu" class="form-control">
                                <option value="">- Pilih Menu -</option>
                                <?php
                                    $sql_menu = "SELECT * FROM menu";
                                    $query_menu = mysqli_query($koneksi, $sql_menu);
                                    while ($menu = mysqli_fetch_array($query_menu)) {
                                ?>
                                <option value="<?= $menu['idMenu'] ?>"><?= $menu['namaMenu'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" class="form-control">
                        </div>

                        <div class="form-group">
                        <input type="submit" name="simpan" class="btn btn-md btn-primary" value="Simpan">
                        </div>
                    </div>              
                </form>
            </div>
            <?php
                    if(isset($_POST['simpan'])){ 

                        $idPelanggan =$_POST['idPelanggan'];
                        $namaPelanggan =$_POST['namaPelanggan'];
                        $jenisKelamin =$_POST['jenisKelamin'];
                        $noHp =$_POST['noHp'];
                        $alamat = $_POST['alamat'];
                        $idMenu =$_POST['idMenu'];
                        $jumlah = $_POST['jumlah'];
                        $sql_get_stock = "SELECT stok FROM menu WHERE idMenu = '$idMenu'";
                        $query_get_stock = mysqli_query($koneksi, $sql_get_stock);
                        $data_stock = mysqli_fetch_array($query_get_stock);
                        $current_stock = $data_stock['stok'];
                        if ($jumlah > $current_stock){
                            ?>
                                <div class="alert alert-danger">
                                    STOK HABIS!
                                </div>
                            <?php
                        }else{
                            $sql_pelanggan = "INSERT INTO pelanggan (idPelanggan, namaPelanggan, jenisKelamin, noHp, alamat) VALUES ('$idPelanggan', '$namaPelanggan', '$jenisKelamin', '$noHp', '$alamat')";

                        $query_input = mysqli_query($koneksi, $sql_pelanggan);

                        if($query_input){
                                $sql_pesanan ="INSERT INTO pesanan SET idMenu='$idMenu', idPelanggan= '$idPelanggan', jumlah = '$jumlah', idUser = '$idUser', status = '0'";
                                $query_pesan = mysqli_query($koneksi, $sql_pesanan);
                                if($query_pesan){
                                    ?>
                                        <script type="text/javascript">
                                            window.location.href="?p=pesan";
                                        </script>
                                    <?php
                                }else {
                                    ?>
                                    <div class="alert alert-danger">
                                        Gagal Menyimpan!!
                                    </div>
                                    <?php
                                }                                                                       
                        }else {
                            ?>
                                <div class="alert alert-danger">
                                    GAGAL MENYIMPAN!
                                </div>
                            <?php
                        }
                        if($current_stock >= $jumlah) {
                            $new_stock = $current_stock - $jumlah;
                            $sql_update_stock = "UPDATE menu SET stok = '$new_stock' WHERE idMenu = '$idMenu'";
                            $query_update_stock = mysqli_query($koneksi, $sql_update_stock);
                            if($query_update_stock){
                            } else {
                            }
                        } else {

                        }
                        }

                    }
                ?>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                Daftar Pesanan Hari ini
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Opsi</th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $hari_ini = date('Y-m-d');
                            $d_pesanan = "SELECT * FROM pesanan left join pelanggan on pelanggan.idPelanggan = pesanan.idPelanggan 
                            left join menu on menu.idMenu = pesanan.idMenu WHERE date (tanggalPesanan) = '$hari_ini'";
                            $d_query = mysqli_query($koneksi, $d_pesanan);
                            $cek = mysqli_num_rows($d_query);

                            if($cek > 0) {
                                $no = 1;
                                while ($data_d = mysqli_fetch_array($d_query)){
                                    ?>
                                        <tr>
                                            <td> <?= $no++ ?></td>
                                            <td> <?= $data_d['namaPelanggan'] ?></td>
                                            <td> <?= $data_d['namaMenu'] ?></td>
                                            <td> <?= $data_d['jumlah'] ?></td>
                                            <td>
                                                <?php
                                                    if ($data_d['status'] == '0') {
                                                        echo "<label class='label label-primary'>Belum</label>";
                                                    }else if($data_d['status'] == '1'){
                                                        echo "<label class='label label-success'>Sudah</label>";
                                                    }else {
                                                        echo "<label class='label label-info'>Lunas</label>";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if($data_d['status'] == '0'){
                                                        ?>
                                                            <a onclick="return confirm('Yakin ?')" href="page/tandai.php?idPesanan=<?= $data_d['idPesanan'] ?>" class="btn btn-sm btn-primary">Tandai</a>
                                                        <?php
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                }
                            }else {
                                ?>
                                    <tr>
                                        <td colspan="6">Tidak ada data!!</td>
                                    </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>