<?php 
require_once '../../functions.php';

$conn = connectDatabase();

$id = $_POST['id'];

$query = "UPDATE letters SET status = 2 WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$result = $stmt->execute();

if ($result) {
    echo "Berhasil validasi!";
} else {
    echo "Gagal validasi";
}
?>