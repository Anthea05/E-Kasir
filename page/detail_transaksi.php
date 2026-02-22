<?php

    $sql_kode = "SELECT max(idTransaksi) as maxKode FROM transaksi";
    $query_kode = mysqli_query($koneksi, $sql_kode);

    $data_kode = mysqli_fetch_array($query_kode);
    $idTransaksi = $data_kode['maxKode'];

    if ($idTransaksi !== null) {
    $noUrut = (int) substr($idTransaksi, 3, 3) + 1;
    } else {
    $noUrut = 1;
    }

    $char = "TRX";
    $kodeTransaksi = $char . sprintf("%03s", $noUrut);

    $idPesanan = $_GET['idPesanan'];
    if(empty($idPesanan)){
        ?>
            <script type="text/javascript">
                window.location.href="?p=transaksi";
            </script>
        <?php
    }

    $d_pesanan = "SELECT * FROM pesanan left join pelanggan on pelanggan.idPelanggan = pesanan.idPelanggan left join menu on menu.idMenu = pesanan.idMenu WHERE idPesanan='$idPesanan'";
    $d_query = mysqli_query($koneksi, $d_pesanan);
    $data = mysqli_fetch_array($d_query);
    
?>


<div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">Input Pembayaran</div>
        <div class="panel-body">
            <div class="row">
            <form action="" method="post">
                <input type="hidden" name="kodeTransaksi" value="<?= $kodeTransaksi ?>">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Pelanggan</label>
                        <input type="text" name="" class="form-control" value="<?=$data['namaPelanggan']?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Menu</label>
                        <input type="text" name="" class="form-control" value="<?=$data['namaMenu']?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Harga Satuan</label>
                        <input type="text" name="" class="form-control" value="<?=$data['harga']?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="text" name="" class="form-control" value="<?=$data['jumlah']?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Total Bayar</label>
                        <input type="text" name="total" class="form-control" value="<?=$data['jumlah'] * $data['harga']?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Uang Pelanggan</label>
                        <input type="number" <?= ($data['status'] == '2' ? 'readonly="readonly"' : '') ?> name="bayar" class="form-control">
                    </div>

                    <input type="submit" <?= ($data['status'] == '2' ? 'disabled="disabled"' : '') ?> name="simpan" value="Simpan" class="btn btn-sm btn-primary">
                </div>
            </form>
            </div>
            <br/>
            <div class="row">
            <?php
                if(isset($_POST['simpan'])) {
                    $total = $_POST['total'];
                    $bayar = $_POST['bayar'];
                    $kode = $_POST['kodeTransaksi'];
                    if($bayar < $total) {
                        ?>
                            <div class="alert alert-danger">
                                Nominal Kurang
                            </div>
                        <?php
                    }else {
                        $kembalian = $bayar - $total;
                        $sql_insert = "INSERT INTO transaksi SET idTransaksi='$kode', idPesanan='$idPesanan', total='$total', bayar='$bayar', kembalian='$kembalian'";
                        $query_insert = mysqli_query ($koneksi, $sql_insert);

                        if($query_insert){
                            $update = "UPDATE pesanan SET status='2' WHERE idPesanan='$idPesanan'";
                            $query_update = mysqli_query($koneksi, $update);

                            if($query_update) {
                                ?>
                                    <div class="col-lg-12">
                                    <p>Uang Kembalian : <?= rupiah($kembalian) ?></p>
                                    <a href="?p=transaksi" class="btn btn-default">Kembali</a>
                                    <span style="float: right;"><a target="_blank" href="page/struk.php?idTransaksi=<?= $kode ?>" class="btn btn-primary">Cetak</a></span>
                                    </div>
                                <?php
                            }
                        }
                    }
                }
            ?>
            
            </div>
        </div>
    </div>
</div>