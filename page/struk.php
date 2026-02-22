<?php
    $idTransaksi = $_GET['idTransaksi'];
    include "../config/koneksi.php";
    include "../config/function.php";
    $sql = "SELECT * FROM transaksi left join pesanan on pesanan.idPesanan = transaksi.idPesanan 
    left join pelanggan on pesanan.idPelanggan = pelanggan.idPelanggan left join menu on pesanan.idMenu = menu.idMenu 
    WHERE idTransaksi='$idTransaksi'";
    $query = mysqli_query($koneksi, $sql);
    $cek = mysqli_num_rows($query);

    if($cek > 0){
        $data = mysqli_fetch_array($query);
    }else {
        ?>
            <script type="text/javascript">
                window.location.href="index.php?p=transaksi";
            </script>
        <?php
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Struk</title>
    <style type="text/css">
        body {
            font-family: monospace;
        }
        .cetak {
            width: 40%;
            height: auto;
            border: 1px solid #000;
            padding: 20px;
        }
    </style>
</head>
<body style="margin:0 auto">
    <center>
        <div class="cetak">
            <h2 style="margin: 0">E-KASIR</h2></br>
            <span><?= date('d-m-Y') . ", " . date('H:i:s')?></span>
            <br/>
            <table style="float: none" width="100%" border="0" cellpadding="10" cellspacing="0">
                <tr>
                    <td colspan="4">Nama : <?= $data['namaPelanggan'] ?></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #999"><?= $data['namaMenu'] ?></td>
                    <td style="border-bottom: 1px solid #999"><?= rupiah($data['harga']) ?></td>
                    <td style="border-bottom: 1px solid #999"><?= $data['jumlah'] ?>x</td>
                    <td style="border-bottom: 1px solid #999"><?= rupiah($data['total']) ?></td>
                </tr>
                <tr>
                    <td colspan="3">Uang Bayar</td>
                    <td><?= rupiah($data['bayar']) ?></td>
                </tr>
                <tr>
                    <td colspan="3">Kembalian</td>
                    <td><?= rupiah($data['kembalian']) ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: center">Terima kasih atas pembelian anda!</td>
                </tr>
            </table>
        </div>
    </center>
    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>