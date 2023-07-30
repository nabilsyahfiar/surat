<?php 
require_once '../../functions.php';

$conn = connectDatabase();

$id = $_POST['id'];

$query = "SELECT * FROM warga WHERE nik = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$result = $stmt->execute();
$row = $stmt->fetch();

if ($result) {
    echo $row['nama'];
} else {
    echo "Gagal validasi";
}
?>