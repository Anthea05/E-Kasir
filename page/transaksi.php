<div class="col-lg-8">
    <div class="panel panel-default">
        <div class="panel-heading">Data Pesanan yang belum lunas</div>
        <div class="panel-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                        <?php
                            $d_pesanan = "SELECT * FROM pesanan left join pelanggan on pelanggan.idPelanggan = pesanan.idPelanggan left join menu on menu.idMenu = pesanan.idMenu WHERE pesanan.status ='1'";
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
                                                <a href="?p=detail_transaksi&idPesanan=<?= $data_d['idPesanan'] ?>" class="btn btn-sm btn-primary">Proses</a>
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