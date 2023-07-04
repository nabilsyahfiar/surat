<?php
require_once '../functions.php';

$conn = connectDatabase();

session_start();
if (!isset($_SESSION['nik'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$status = $_GET['status'];

switch ($status) {
    case 0:
        $newStatus = 1;
        break;
    case 1:
        $newStatus = 2;
        break;
    case 2:
        $newStatus = 3;
        break;
}

$query = "UPDATE letters SET status = :newStatus WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':newStatus', $newStatus);
$result = $stmt->execute();

if ($result) {
    header("Location: home.php");
} else {
    $error = "Error";
}