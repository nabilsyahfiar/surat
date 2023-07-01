<?php
require_once 'functions.php';

// Menghubungkan ke database
$conn = connectDatabase();

// Jika ada data yang dikirimkan melalui form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = generateID($conn);
  $nik = $_POST['nik'];
  $password = $_POST['password'];
  $level = $_POST['level'];
  $rt = $_POST['rt'];
  $rw = $_POST['rw'];

  // Memanggil fungsi addUser untuk menambahkan user baru
  if (addUser($conn, $id, $nik, $password, $level, $rt, $rw)) {
    // Jika penambahan user berhasil, tampilkan pesan sukses
    $message = "User baru berhasil ditambahkan!";
  } else {
    // Jika penambahan user gagal, tampilkan pesan error
    $error = "Gagal menambahkan user baru!";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Tambah User</title>
</head>
<body>
    <h2>Tambah User Baru</h2>
    <?php if (isset($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>
    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>
    <form method="POST" action="add_user.php">
        <label for="nik">NIK:</label>
        <input type="text" id="nik" name="nik" required><br><br>
        <label for="level">Level:</label>
        <input type="text" id="level" name="level" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="rt">rt:</label>
        <input type="rt" id="rt" name="rt" required><br><br>
        <label for="rw">rw:</label>
        <input type="rw" id="rw" name="rw" required><br><br>
        <input type="submit" value="Tambah User">
    </form>
</body>
</html>
