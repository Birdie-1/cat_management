<?php
$servername = "localhost";  // หรือใช้ "127.0.0.1" ถ้า localhost มีปัญหา
$username = "root";  // ใส่ชื่อผู้ใช้ MySQL ของคุณ
$password = "";  // ถ้ามีรหัสผ่านให้ใส่ตรงนี้ (ค่าเริ่มต้นของ XAMPP/MAMP มักเป็นค่าว่าง)
$dbname = "cat";  // ชื่อฐานข้อมูลที่สร้างไว้

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตั้งค่าภาษาไทยให้รองรับ UTF-8
$conn->set_charset("utf8mb4");
?>

