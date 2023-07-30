<?php 
require_once '../../functions.php';

$conn = connectDatabase();

$id = $_POST['id'];
$alasan = $_POST['alasan'];

$query = "UPDATE letters SET status = '9', alasan = :alasan WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':alasan', $alasan);
$result = $stmt->execute();

if ($result) {
    echo "Berhasil menolak!";
} else {
    echo "Gagal menolak!";
}
?>