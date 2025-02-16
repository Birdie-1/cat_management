<?php
require 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cat Gallery</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .card-body {
            flex: 1 1 auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Cat Gallery</h1>
        <a href="logout.php" class="btn btn-danger mb-3">Logout</a>
        <a href="admin.php" class="btn btn-warning mb-3">Admin</a>

        <div class="row">
            <?php
            $result = $conn->query("SELECT * FROM CatBreeds WHERE is_visible = 1");
            while ($row = $result->fetch_assoc()) {
                $short_description = mb_substr($row['description'], 0, 50) . '...';
                echo "<div class='col-md-4 mb-4'>
                        <div class='card'>
                            <img src='{$row['image_url']}' class='card-img-top'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$row['name_th']} ({$row['name_en']})</h5>
                                <p class='card-text short-description'>{$short_description}</p>
                                <a href='view_cat.php?id={$row['id']}' class='btn btn-link'>See More</a>
                            </div>
                        </div>
                    </div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
