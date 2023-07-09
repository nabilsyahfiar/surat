<?php
require_once '../functions.php';

// Memeriksa apakah pengguna sudah login atau belum
session_start();
if (isset($_SESSION['nik'])) {
  // Jika sudah login, redirect ke halaman utama atau halaman setelah login sukses
  header("Location: home.php");
  exit();
}

// Jika ada data yang dikirimkan melalui form login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nik = $_POST['nik'];
  $password = $_POST['password'];

  // Menghubungkan ke database
  $conn = connectDatabase();

  // Memeriksa kecocokan nik dan password
  if (checkLogin($conn, $nik, $password)) {
    // Jika login berhasil, simpan informasi user di session
    $_SESSION['nik'] = $nik;

    // Redirect ke halaman utama atau halaman setelah login sukses
    header("Location: home.php");
    exit();
  } else {
    // Jika login gagal, tampilkan pesan error
    $error = "NIK atau password salah!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>e-Surat | Login</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .card {
            max-width: 32rem;
        }
    </style>

</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card d-block mx-auto o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Silahkan Login</h1>
                            </div>
                            <form class="user" method="POST" action="login.php">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="nik" name="nik" placeholder="Masukkan NIK..." required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" required>
                                </div>
                                <input type="submit" class="btn btn-primary btn-user btn-block" value="Login">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

</body>

</html>
