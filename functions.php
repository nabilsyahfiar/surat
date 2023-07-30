<?php
// Menghubungkan ke database
function connectDatabase() {
  $host = "localhost"; // Ganti sesuai dengan host database Anda
  $dbname = "surat"; // Ganti sesuai dengan nama database Anda
  $dbuser = "root"; // Ganti sesuai dengan username database Anda
  $dbpass = ""; // Ganti sesuai dengan password database Anda

  $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
  return $conn;
}

// Memeriksa kecocokan username dan password
function checkLogin($conn, $nik, $password) {
  $query = "SELECT * FROM users WHERE nik = :nik";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':nik', $nik);
  $stmt->execute();

  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['level'] = $user['level'];
    $_SESSION['nik'] = $user['nik'];
    return true;
  } else {
    return false;
  }
}

// Menambahkan user baru
function addUser($conn, $id, $nik, $password, $level, $rt, $rw) {
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  $query = "INSERT INTO users (id, nik, password, level, rt, rw) VALUES (:id, :nik, :password, :level, :rt, :rw)";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':nik', $nik);
  $stmt->bindParam(':password', $hashedPassword);
  $stmt->bindParam(':level', $level);
  $stmt->bindParam(':rt', $rt);
  $stmt->bindParam(':rw', $rw);

  return $stmt->execute();
}

function addSurat($conn, $id, $nik, $nama, $alamat, $rt, $rw, $keperluan) {
  $query = "INSERT INTO letters (id, nik, nama, alamat, rt, rw, keperluan, status) VALUES (:id, :nik, :nama, :alamat, :rt, :rw, :keperluan, 0)";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':nik', $nik);
  $stmt->bindParam(':nama', $nama);
  $stmt->bindParam(':alamat', $alamat);
  $stmt->bindParam(':rt', $rt);
  $stmt->bindParam(':rw', $rw);
  $stmt->bindParam(':keperluan', $keperluan);

  return $stmt->execute();
}

function generateID($conn) {
  if (!isset($_SESSION['nik'])) {
    $query = "SELECT MAX(CAST(SUBSTRING_INDEX(id, '-', -1) AS UNSIGNED)) as maxId FROM letters";
    $prefix = 'PNT-';
  } else {
    $query = "SELECT MAX(CAST(SUBSTRING_INDEX(id, '-', -1) AS UNSIGNED)) as maxId FROM users";
    $prefix = 'AAD-';
  }

  $stmt = $conn->prepare($query);
  $stmt->execute();
  $row = $stmt->fetch();
  $maxId = $row['maxId'];

  // Increment the maxId and generate the new ID
  $newId = $maxId + 1;
  $newId = str_pad($newId, 3, '0', STR_PAD_LEFT); // Pad the ID with zeros if necessary
  $newId = $prefix . $newId;

  return $newId;
}


function showData($conn, $nik, $level) {
  switch ($level) {
    case "rt":
      $query = "SELECT * FROM letters WHERE rt = (SELECT rt FROM users WHERE nik = :nik) AND rw = (SELECT rw FROM users WHERE nik = :nik) AND status = 0";
      break;
    case "rw":
      $query = "SELECT * FROM letters WHERE rw = (SELECT rw FROM users WHERE nik = :nik) AND status = 1";
      break;
    case "kel":
      $query = "SELECT * FROM letters WHERE status = 2 OR 3";
      break;
  }

  $stmt = $conn->prepare($query);
  $stmt->bindParam(':nik', $nik);
  $stmt->execute();
  $row = $stmt->fetchAll();

  return $row;
}

function countData($conn, $nik, $level) {
  switch ($level) {
    case "rt":
      $query = "SELECT * FROM letters WHERE rt = (SELECT rt FROM users WHERE nik = :nik) AND rw = (SELECT rw FROM users WHERE nik = :nik) AND status = 0";
      break;
    case "rw":
      $query = "SELECT * FROM letters WHERE rw = (SELECT rw FROM users WHERE nik = :nik) AND status = 1";
      break;
    case "kel":
      $query = "SELECT * FROM letters WHERE status = 2 OR 3";
      break;
  }

  $stmt = $conn->prepare($query);
  $stmt->bindParam(':nik', $nik);
  $stmt->execute();

  return $stmt;
}

function showRw($conn) {
  $query = "SELECT * FROM rw ORDER BY rw ASC";
  $stmt = $conn->prepare($query);
  $stmt->execute();
  $row = $stmt->fetchAll();

  return $row;
}

function showWarga($conn, $nik) {
  $query = "SELECT * FROM warga WHERE nik = :nik";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':nik', $nik);
  $stmt->execute();
  $row = $stmt->fetch();

  return $row;
}
?>
