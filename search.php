<?php

require_once "functions.php";

error_reporting(0);

$conn = connectDatabase();
$nik = $_POST['nik'];

$query = "SELECT * FROM letters WHERE nik = :nik";
$stmt = $conn->prepare($query);
$stmt->bindParam(':nik', $nik);
$stmt->execute();

$rows = $stmt->fetchAll();
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
            max-width: auto;
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
                                <h1 class="h4 text-gray-900 mb-4">Pencarian Surat Pengantar</h1>
                            </div>
                            <?php if (isset($_POST['nik']) && $stmt->rowCount() >= 1) {?>
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Keperluan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Menampilkan semua data pengguna
                                    foreach ($rows as $letter) {
                                    ?>
                                    <tr>
                                        <td><?= $letter['nik']; ?></td>
                                        <td><?= $letter['nama']; ?></td>
                                        <td><?= $letter['alamat']; ?></td>
                                        <td><?= $letter['keperluan']; ?></td>
                                        <td><?= $letter['status']; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php } else if (isset($_POST['nik']) && $stmt->rowCount() < 1) { ?>
                            <h1>NIK tidak ditemukan!</h1>
                            <?php } else {?>
                            <h1>Masukkan NIK anda!</h1>
                            <?php } ?>
                        </div>
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