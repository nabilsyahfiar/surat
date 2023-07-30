<?php 

require_once "../../functions.php";

$conn = connectDatabase();

session_start();
if ($_SESSION['level'] !== 'rw') {
  header("Location: ../login.php");
  exit();
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

    <title>e-Surat | Dashboard</title>

    <!-- Custom fonts for this template -->
    <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Sisfo Surat</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            
            <!-- Nav Item - Tables -->
            <li class="nav-item active">
                <a class="nav-link" href="data_surat.php">
                    <i class="fas fa-fw fa-table"></i><span>Data Surat</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-3 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['nik']; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="https://t4.ftcdn.net/jpg/00/64/67/63/360_F_64676383_LdbmhiNM6Ypzb3FM4PPuFP9rHe7ri8Ju.jpg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data Surat Pengantar</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Surat Pengantar</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Keperluan</th>
                                            <th>Status</th>
                                            <th>Alasan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Menampilkan semua data pengguna
                                        $letters = showData($conn, $_SESSION['nik'], $_SESSION['level']);

                                        foreach ($letters as $letter) {
                                        ?>
                                        <tr>
                                            <td><?= $letter['id']; ?></td>
                                            <td id="nik"><?= $letter['nik']; ?></td>
                                            <td><?= $letter['nama']; ?></td>
                                            <td><?= $letter['keperluan']; ?></td>
                                            <td>
                                                <?php 
                                                if ($letter['status'] == 1) {
                                                    echo "Menunggu persetujuan";
                                                } else if ($letter['status'] == 2){
                                                    echo "Sudah disetujui";
                                                } else {
                                                    echo "Ditolak";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if ($letter['status'] == 9) {
                                                    echo $letter['alasan'];
                                                } else {
                                                    echo "-";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if ($letter['status'] == 1) {
                                                    echo "<button class='btn btn-sm btn-primary' data-toggle='modal' data-target='#validate' data-id='$letter[0]'>Validasi</button>";

                                                    echo "<button class='btn btn-sm btn-danger' data-toggle='modal' data-target='#tolak' data-id='$letter[0]'>Tolak</button>";
                                                }
                                                ?>
                                                <a href="detail.php?id=<?= $letter['nik']; ?>" class="btn btn-sm btn-success" id="infowarga">Detail</button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Validate modal -->
    <div class="modal fade" id="validate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Informasi Warga</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_modal" id="id_modal">
                    Apakah anda yakin untuk menyetujui surat pengantar ini?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Kembali</button>
                    <button class="btn btn-primary" id="validateNow" type="button">Setujui</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tolak modal -->
    <div class="modal fade" id="tolak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Informasi Warga</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="alasan_id" id="alasan_id">
                    Alasan
                    <textarea class="form-control" name="alasan_tolak" id="alasan_tolak"></textarea>
                    <p class="mt-1">Apakah anda yakin untuk menolak surat pengantar ini?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Kembali</button>
                    <button class="btn btn-danger" id="tolakNow" type="button">Tolak</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

     <!-- Page level custom scripts -->
     <script src="../../assets/js/demo/datatables-demo.js"></script>

     <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#validate').on('show.bs.modal', function (event) {
                var div = $(event.relatedTarget);
                var id = div.data('id');
                var modal = $(this);
                modal.find('#id_modal').val(id);
            });

            $(document).on("click", "#validateNow", function() { 
                $.ajax({
                    url: "update_data.php",
                    type: "POST",
                    cache: false,
                    data:{id: $('#id_modal').val()},
                    success: function(response){
                        Swal.fire(
                            'Sukses',
                            response,
                            'success'
                        ).then( () => {
                            location.href = './data_surat.php'
                        });
                    }
                });
            }); 
        });
    </script>

    <!-- <script>
        $(document).ready(function () {
            $('#infowarga').on('click', function (event) {
                var id = $(this).data('id');

                $.ajax({
                    url: "fetch_warga.php",
                    type: "POST",
                    cache: false,
                    data:{id: id},
                    success: function(response){
                        Swal.fire(
                            'Sukses',
                            response
                        )
                    }
                });
            });
        });
    </script> -->

    <script>
        $(document).ready(function () {
            $('#tolak').on('show.bs.modal', function (event) {
                var div = $(event.relatedTarget);
                var id = div.data('id');
                var modal = $(this);

                modal.find('#alasan_id').val(id);
            });

            $(document).on("click", "#tolakNow", function() { 
                $.ajax({
                    url: "tolak.php",
                    type: "POST",
                    cache: false,
                    data:{
                        id: $('#alasan_id').val(),
                        alasan: $('#alasan_tolak').val()
                    },
                    success: function(response){
                        Swal.fire(
                            'Sukses',
                            response,
                            'success'
                        ).then( () => {
                            location.href = './data_surat.php'
                        });
                    }
                });
            }); 
        });
    </script>

</body>

</html>