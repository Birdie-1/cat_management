<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "<script>alert('ไม่พบข้อมูลแมวที่ต้องการลบ'); window.location.href='index.php';</script>";
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM CatBreeds WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('ลบข้อมูลสำเร็จ!'); window.location.href='index.php';</script>";
} else {
    echo "<script>alert('ลบข้อมูลไม่สำเร็จ'); window.location.href='index.php';</script>";
}
$stmt->close();
?>