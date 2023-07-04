<?php
require_once 'functions.php';

// Menghubungkan ke database
$conn = connectDatabase();

// Jika ada data yang dikirimkan melalui form
if (isset($_POST["add"])) {
  $id = generateID($conn);
  $nik = $_POST['nik'];
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $rt = $_POST['rt'];
  $rw = $_POST['rw'];
  $keperluan = $_POST['keperluan'];

  // Memanggil fungsi addUser untuk menambahkan user baru
  if (addSurat($conn, $id, $nik, $nama, $alamat, $rt, $rw, $keperluan)) {
    // Jika penambahan user berhasil, tampilkan pesan sukses
    $message = "Surat pengantar baru berhasil ditambahkan!";
    header("Location: index.php");
  } else {
    // Jika penambahan user gagal, tampilkan pesan error
    $error = "Gagal menambahkan surat pengantar baru!";
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
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

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
                                <h1 class="h4 text-gray-900 mb-4">Pengajuan Surat Pengantar</h1>
                            </div>
                            <button class="btn btn-primary btn-user btn-block" data-toggle="modal" data-target="#newLetterModal">Buat surat pengantar</button>
                            <button class="btn btn-success btn-user btn-block" data-toggle="modal" data-target="#searchLetterModal">Cari surat pengantar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="newLetterModal" tabindex="-1" role="dialog" aria-labelledby="newLetterModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Buat Surat Pengantar</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="user p-3" method="POST" action="index.php">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nik" name="nik" placeholder="Masukkan NIK..." required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nama" name="nama" placeholder="Masukkan Nama..." required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="alamat" name="alamat" placeholder="Masukkan Alamat..." required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="rt" name="rt" placeholder="Masukkan RT..." required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="rw" name="rw" placeholder="Masukkan RW..." required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="keperluan" name="keperluan" placeholder="Masukkan Keperluan..." required>
                            </div>
                            <input type="submit" class="btn btn-primary btn-user btn-block" name="add" value="Ajukan">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Kembali</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="searchLetterModal" tabindex="-1" role="dialog" aria-labelledby="searchLetterModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cari Surat Pengantar</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="user p-3" method="POST" action="search.php">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nik" name="nik" placeholder="Masukkan NIK..." required>
                            </div>
                            <input type="submit" class="btn btn-primary btn-user btn-block" name="search" value="Cari">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>

</body>

</html>