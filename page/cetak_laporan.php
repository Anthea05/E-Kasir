<?php
include "../config/koneksi.php";
include "../config/function.php";

$tgl_awal = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '';
$tgl_sampai = isset($_GET['tgl_sampai']) ? $_GET['tgl_sampai'] : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak</title>
    <link rel="stylesheet" type="text/css" href="../dist/css/bootstrap.min.css">
</head>

<body>
    <div class="row">
        <div class="col-lg-6" style="margin:0 auto; float: none">
            <center>
                <h3>E-Kasir</h3>
                <h2>Laporan Penjualan Restoran</h2>
                Periode :
                <?= date('d-m-Y', strtotime($tgl_awal)) ?> s/d
                <?= date('d-m-Y', strtotime($tgl_sampai)) ?>
            </center>
            <br>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cari = "";
                    if (!empty($tgl_awal)) {
                        $cari .= " and date(transaksi.created_at) >= '" . $tgl_awal . "'";
                    }

                    if (!empty($tgl_sampai)) {
                        $cari .= " and date(transaksi.created_at) <= '" . $tgl_sampai . "'";
                    }

                    $sql = "SELECT *, sum(pesanan.jumlah) as jumlahnya, sum(transaksi.total) as Total FROM transaksi left join pesanan on pesanan.idPesanan = transaksi.idPesanan 
                    left join menu on pesanan.idMenu = menu.idMenu WHERE 1=1 $cari GROUP BY pesanan.idMenu";

                    $query = mysqli_query($koneksi, $sql);
                    $cek = mysqli_num_rows($query);
                    if ($cek > 0) {
                        $no = 1;
                        while ($data = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $data['namaMenu'] ?></td>
                                <td><?= $data['jumlahnya'] ?></td>
                                <td><?= rupiah($data['Total']) ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                            <tr>
                                <td colspan="3">Total</td>
                                <td>
                                    <?php
                                        $sql_total = "SELECT SUM(total) as semuanya FROM transaksi WHERE 1=1 $cari";
                                        $q = mysqli_query($koneksi, $sql_total);
                                        $data = mysqli_fetch_array($q);
                                        echo rupiah($data['semuanya']);
                                    ?>
                                </td>
                            </tr>
                        <?php
                    } else {
                        ?>
                        <tr>
                            <td colspan="4">Tidak ada data!</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
    window.print();
</script>