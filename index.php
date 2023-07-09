<?php
require_once 'functions.php';

// Menghubungkan ke database
$conn = connectDatabase();
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

        select option[disabled] {
            display: none;
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
                        <form class="user p-3" id="pengajuan">
                            <div class="form-group">
                                <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK..." required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama..." required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat..." required>
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="rw" name="rw" required>
                                    <option selected disabled>Pilih RW...</option>
                                    <?php $rws = showRw($conn); foreach ($rws as $rw) { ?>
                                    <option value="<?= $rw['rw'] ?>"><?= $rw['rw'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="rt" name="rt" required>
                                    <option selected disabled>Pilih RW terlebih dahulu...</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="keperluan" name="keperluan" placeholder="Masukkan Keperluan..." required>
                            </div>
                            <div id="result"></div>
                            <input type="submit" class="btn btn-primary btn-block" name="add" value="Ajukan">
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
                        <form class="user p-3" id="search" method="POST" action="search.php">
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

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function(){
        $('#rw').on('change', function(){
            var rwid = $(this).val();
            if(rwid){
                $.ajax({
                    type:'POST',
                    url:'ajaxData.php',
                    data:'rwid='+rwid,
                    success:function(html){
                        $('#rt').html(html);
                    }
                }); 
            }else{
                $('#rt').html('<option value="">Pilih RW terlebih dahulu...</option>');
            }
        });
    });
    </script>

    <script>
        $(document).ready(function() {
            $('#pengajuan').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                var form = this;
                $.ajax({
                    type: 'POST',
                    url: 'add_letter.php',
                    data: formData,
                    success: function(response) {
                        Swal.fire(
                            'Sukses',
                            response,
                            'success'
                        );
                        form.reset();
                    }
                });
            });
        });
    </script>

</body>

</html>