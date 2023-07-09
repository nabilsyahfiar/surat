<?php 
require_once 'functions.php';

$conn = connectDatabase();

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
echo "Surat pengantar baru berhasil ditambahkan!";
} else {
// Jika penambahan user gagal, tampilkan pesan error
echo "Gagal menambahkan surat pengantar baru!";
}
?>