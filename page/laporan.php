<?php
    $hari_ini = date('Y-m-d');
?>


<div class="col-lg-8">
    <div class="panel panel-default">
        <div class="panel-heading">Data Transaksi</div>
        <div class="panel-body">
            <form class="form-inline" action="" method="get">
                <input type="hidden" name="p" value="laporan">
                <div class="form-group">
                    <label>Tanggal Awal</label>
                    <input id="tgl_awal" type="date" name="tglDari" class="form-control" value="<?= !empty($_GET['tglDari']) ? $_GET['tglDari'] : $hari_ini ?>">
                </div>

                <div class="form-group">
                    <label>Tanggal Sampai</label>
                    <input id="tgl_sampai"type="date" name="tglSampai" class="form-control" value="<?= !empty($_GET['tglSampai']) ? $_GET['tglSampai'] : $hari_ini ?>">
                </div>

                <div class="form-group">
                    <input type="submit" name="filter" value="Filter" class="btn btn-sm btn-primary" >
                    <button type="button" id="cetak" class="btn btn-sm btn-success">Cetak</button>
                </div>
            </form>
            <br>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        $cari = "";
                        @$tglDari = $_GET['tglDari'];
                        @$tglSampai = $_GET['tglSampai'];

                        if(!empty($tglDari)){
                            $cari .= " and date(transaksi.created_at) >= '".$tglDari."'";
                        }   

                        if(!empty($tglSampai)){
                            $cari .= " and date(transaksi.created_at) <= '".$tglSampai."'";
                        }
                        
                        if(empty($tglDari) && empty($tglSampai)){
                            $cari .= " and date(transaksi.created_at) >= '".$hari_ini."' and date(transaksi.created_at) >= '".$hari_ini."'";
                        }

                        $sql = "SELECT *, transaksi.created_at as tgl FROM transaksi left join pesanan on pesanan.idPesanan = transaksi.idPesanan 
                        left join pelanggan on pesanan.idPelanggan = pelanggan.idPelanggan left join menu on pesanan.idMenu = menu.idMenu 
                        WHERE 1=1 $cari";
                        $query = mysqli_query($koneksi, $sql);
                        $cek = mysqli_num_rows($query);
                        if($cek > 0){
                            $no = 1;
                            while($data = mysqli_fetch_array($query)){
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data['namaPelanggan'] ?></td>
                                        <td><?= $data['namaMenu'] ?></td>
                                        <td><?= $data['jumlah'] ?></td>
                                        <td><?= $data['tgl'] ?></td>
                                        <td><?= rupiah($data['total']) ?></td>
                                    </tr>
                                <?php
                            }
                        }else {
                            ?>
                                <tr>
                                    <td colspan="6">Tidak ada data!</td>
                                </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-lg-4">
    <div class="panel panel-success">
        <div class="panel-heading">Total hari ini</div>
        <div class="panel-body">
            <h2>
                <?php
                    $tot = "SELECT sum(total) as jumlah FROM transaksi WHERE date(created_at) = '".$hari_ini."' ";
                    $q = mysqli_query($koneksi, $tot);
                    $data = mysqli_fetch_array($q);
                    echo rupiah($data['jumlah']);
                ?>
            </h2>
        </div>
    </div>

    
    <div class="panel panel-success">
        <div class="panel-heading">Total 28 hari terakhir</div>
        <div class="panel-body">
            <h2>
                <?php
                    $tgl_awal_28_hari = date('Y-m-d', strtotime('-28 days', strtotime($hari_ini)));

                    $tot = "SELECT sum(total) as jumlah FROM transaksi WHERE date(created_at)>='".$tgl_awal_28_hari."' and date(created_at) <= '".$hari_ini."'";
                    $q_awal_28_hari = mysqli_query($koneksi, $tot);
                    $data_28_hari = mysqli_fetch_array($q_awal_28_hari);
                    echo rupiah($data_28_hari['jumlah']);
                ?>
            </h2>
        </div>
    </div>

    <div class="panel panel-success">
        <div class="panel-heading">Total selama ini</div>
        <div class="panel-body">
            <h2>
                <?php
                
                    $tot_keseluruhan = $tot_keseluruhan = "SELECT sum(total) as jumlah FROM transaksi WHERE date(created_at) >= '".$tgl_awal_28_hari."''".$hari_ini."' AND date(created_at) <= '".$hari_ini."'";
                    $q_keseluruhan = mysqli_query($koneksi, $tot_keseluruhan);
                    $data_keseluruhan = mysqli_fetch_array($q_keseluruhan);
                    echo rupiah($data_keseluruhan['jumlah']);
                ?>
            </h2>
        </div>
    </div>


</div>
