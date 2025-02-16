<?php
require 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "<script>alert('ไม่พบข้อมูลแมวที่ต้องการดู'); window.location.href='index.php';</script>";
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT name_th, name_en, description, characteristics, care_instructions, image_url FROM CatBreeds WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name_th, $name_en, $description, $characteristics, $care_instructions, $image_url);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดแมว</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .card-img-top {
            max-width: 100%;
            height: auto;
            max-height: 400px; /* Set a maximum height for the image */
            object-fit: cover; /* Ensure the image covers the area without stretching */
        }
        h5 {
            color: red; /* Highlight h5 elements in red */
        }
        .card-title {
            font-weight: 700;
        }
        .card-text {
            font-weight: 400;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center"><?php echo htmlspecialchars($name_th); ?> (<?php echo htmlspecialchars($name_en); ?>)</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3">
                    <img src="<?php echo htmlspecialchars($image_url); ?>" class="card-img-top mx-auto d-block">
                    <div class="card-body">
                        <h5 class="card-title">คำอธิบาย</h5>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($description)); ?></p>
                        <h5 class="card-title">ลักษณะเฉพาะ</h5>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($characteristics)); ?></p>
                        <h5 class="card-title">คำแนะนำในการดูแล</h5>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($care_instructions)); ?></p>
                        <a href="index.php" class="btn btn-primary">Back to Gallery</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>