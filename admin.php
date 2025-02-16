<?php
require 'config.php';
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">จัดการข้อมูลแมว</h1>
        <a href="add_cat.php" class="btn btn-primary mb-3">เพิ่มแมว</a>
        <a href="index.php" class="btn btn-success mb-3">หน้าหลัก</a>
        <a href="logout.php" class="btn btn-danger mb-3">Logout</a>

        <table class="table">
            <tr><th>ชื่อ (TH)</th><th>ชื่อ (EN)</th><th>จัดการ</th></tr>
            <?php
            $result = $conn->query("SELECT * FROM CatBreeds");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['name_th']}</td>
                        <td>{$row['name_en']}</td>
                        <td>
                            <a href='edit_cat.php?id={$row['id']}' class='btn btn-warning'>แก้ไข</a>
                            <a href='delete_cat.php?id={$row['id']}' class='btn btn-danger'>ลบ</a>
                        </td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
