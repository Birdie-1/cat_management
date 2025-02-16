<?php
require 'config.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name_th = $_POST['name_th'];
    $name_en = $_POST['name_en'];
    $description = $_POST['description'];
    $characteristics = $_POST['characteristics'];
    $care_instructions = $_POST['care_instructions'];
    $image_url = $_POST['image_url'];
    $is_visible = isset($_POST['is_visible']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO CatBreeds (name_th, name_en, description, characteristics, care_instructions, image_url, is_visible) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $name_th, $name_en, $description, $characteristics, $care_instructions, $image_url, $is_visible);

    if ($stmt->execute()) {
        echo "<script>alert('เพิ่มข้อมูลสำเร็จ!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('เพิ่มข้อมูลไม่สำเร็จ');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลแมว</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">เพิ่มข้อมูลแมว</h1>
        <form method="POST">
            <div class="form-group">
                <label for="name_th">ชื่อภาษาไทย</label>
                <input type="text" class="form-control" id="name_th" name="name_th" required>
            </div>
            <div class="form-group">
                <label for="name_en">ชื่อภาษาอังกฤษ</label>
                <input type="text" class="form-control" id="name_en" name="name_en" required>
            </div>
            <div class="form-group">
                <label for="description">คำอธิบาย</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="characteristics">ลักษณะเฉพาะ</label>
                <textarea class="form-control" id="characteristics" name="characteristics" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="care_instructions">คำแนะนำในการดูแล</label>
                <textarea class="form-control" id="care_instructions" name="care_instructions" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="image_url">URL รูปภาพ</label>
                <input type="text" class="form-control" id="image_url" name="image_url" required>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="is_visible" name="is_visible">
                <label class="form-check-label" for="is_visible">แสดงผล</label>
            </div>
            <button type="submit" class="btn btn-primary btn-block">เพิ่มข้อมูล</button>
        </form>
    </div>
</body>
</html>
