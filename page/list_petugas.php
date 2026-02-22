<h2>Daftar Petugas</h2>
<br>

<a class="btn btn-primary btn-md" href="?p=tambah_petugas"> <span class="glyphicon glyphicon-plus"></span> </a>

<div style="float: right;">
    <form method="get" class="form-inline">
      <input type="hidden" name="p" value="list_petugas">
        <input type="text" name="cari" class="form-control" placeholder="Cari disini">
        <button type="submit" class="btn btn-sm btn-primary"> <span class="glyphicon glyphicon-search"></span></button>
    </form>
</div>

<br>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Level <a href="?p=list_petugas&sort=asc"><span class="glyphicon glyphicon-chevron-up"></span></a> <a href="?p=list_petugas&sort=desc"><span class="glyphicon glyphicon-chevron-down"></span></a></th>
            <th>Tanggal Ditambahkan</th>
            <th>Dirubah</th>
            <th>Opsi</th>
        </tr>
    </thead>
    <tbody>
        
        <?php
        @$cari = $_GET['cari'];
        $q_cari = '';
        if (!empty($cari)) {
          $q_cari .= " and username like '%" . $cari . "%'";
        }
        
        $sort_direction = isset($_GET['sort']) ? $_GET['sort'] : 'asc';
        $sort_icon = $sort_direction === 'asc' ? 'glyphicon-chevron-up' : 'glyphicon-chevron-down';

        // Penentuan urutan level
        $level_order = "FIELD(level, 'admin', 'pemilik', 'kasir', 'waiter')";

        $pembagian = 5;
        $page = isset($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
        $mulai = $page > 1 ? $page * $pembagian - $pembagian : 0;

        // Query SQL dengan sorting dan urutan level
        $sql = "SELECT * FROM user WHERE 1=1 $q_cari ORDER BY $level_order $sort_direction LIMIT $mulai,$pembagian";
        $query = mysqli_query($koneksi, $sql);
        $cek = mysqli_num_rows($query);
        $sql_total = "SELECT * FROM user";
        $q_total = mysqli_query ($koneksi, $sql_total);
        $total = mysqli_num_rows($q_total);
        $jumlahHalaman = ceil($total / $pembagian);

        if($cek > 0) {
            $no = $mulai + 1;
            while($data = mysqli_fetch_array($query)) {
            ?>
                <tr>
                  <td> <?= $no++ ?></td>
                  <td> <?= $data['idUser'] ?></td>
                  <td> <?= $data['username'] ?></td>
                  <td> <?= $data['password'] ?></td>
                  <td> <?= $data['level'] ?></td>
                  <td> <?= $data['created_at'] ?></td>
                  <td> <?= $data['updated_at'] ?></td>
                  <td>
                    <a onclick="return confirm('Yakin akan anda hapus?')" class="btn btn-danger btn-md" href="page/hapus_petugas.php?idUser=<?= $data['idUser'] ?>"><span class="glyphicon glyphicon-trash"></span></a>
                    |
                    <a class="btn btn-info btn-md" href="?p=edit_petugas&idUser=<?= $data['idUser'] ?>"><span class="glyphicon glyphicon-edit"></span></a>
                  </td>
                </tr>
            <?php
            }
        } else {
        ?>
            <tr>
              <td colspan="6">
                Tidak ada user!
              </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<div class="float-left">
    Jumlah : <?= $total ?>
</div>

<div style="float: right;">
<nav aria-label="Page navigation">
  <ul class="pagination">
    <li>
      <a href="?p=list_petugas&halaman=<?= $page -1 ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>

        <?php
          for ($i = 1; $i <= $jumlahHalaman; $i++) {
            ?>
              <li class="<?= (isset($_GET['halaman']) && $i == intval($_GET['halaman']) ? 'active' : '') ?>"><a href="?p=list_petugas&halaman=<?= $i ?>"> <?= $i ?> </a></li>

            <?php
          }
        ?>

    <li><?php
