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
    $is_visible = isset($_POST['is_visible']) ? 1 : 0;

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["cat_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["cat_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<script>alert('File is not an image.');</script>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "<script>alert('Sorry, file already exists.');</script>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["cat_image"]["size"] > 500000) {
        echo "<script>alert('Sorry, your file is too large.');</script>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.');</script>";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["cat_image"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO CatBreeds (name_th, name_en, description, characteristics, care_instructions, image_url, is_visible) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssi", $name_th, $name_en, $description, $characteristics, $care_instructions, $target_file, $is_visible);

            if ($stmt->execute()) {
                echo "<script>alert('เพิ่มข้อมูลสำเร็จ!'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('เพิ่มข้อมูลไม่สำเร็จ');</script>";
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
        }
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
        <form method="POST" enctype="multipart/form-data">
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
                <label for="cat_image">รูปภาพแมว</label>
                <input type="file" class="form-control" id="cat_image" name="cat_image" required>
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
