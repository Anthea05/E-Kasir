<?php 
  if(!empty($user)){
    ?>

    <script type="text/javascript">
      window.location.href="?p=home";
    </script>
    <?php
  }
?>


<style type="text/css">
body {
  padding-top: 40px;
  padding-bottom: 40px;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

</style>


<form action="" method="post" class="form-signin">
        <h2 class="form-signin-heading">Silahkan Login</h2>
        <label for="inputEmail" class="sr-only">Username</label>
        <input type="text" id="inputEmail" class="form-control" placeholder="Username" required autofocus name="username">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="password">
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="masuk">Masuk</button>
</form>

<?php 
// GANTI KODE LAMA ANDA DENGAN INI
if(isset($_POST['masuk'])){
  $username = $_POST['username'];
  $password_input = $_POST['password'];

  // 1. Siapkan statement untuk mencegah SQL Injection
  $stmt = mysqli_prepare($koneksi, "SELECT idUser, password, level FROM user WHERE username = ?");

  // 2. Ikat parameter ke statement
  mysqli_stmt_bind_param($stmt, "s", $username);

  // 3. Eksekusi
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if(mysqli_num_rows($result) > 0) {
      $data = mysqli_fetch_assoc($result);
      $pass_db = $data['password'];

      // Verifikasi password (lihat poin keamanan #2)
      if(md5($password_input) === $pass_db) {
          $_SESSION['username'] = $username;
          $_SESSION['level'] = $data['level'];
          $_SESSION['idUser'] = $data['idUser'];
          echo '<script>window.location.href="?p=home";</script>';
      } else {
          echo '<div class="alert alert-danger">Username atau Password salah.</div>';
      }
  } else {
      echo '<div class="alert alert-danger">Username atau Password salah.</div>';
  }
  mysqli_stmt_close($stmt);
}
?>