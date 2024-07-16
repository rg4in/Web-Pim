<?php
session_start();

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบแล้วหรือไม่
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // เปลี่ยนเส้นทางไปยังหน้าล็อกอินหากยังไม่เข้าสู่ระบบ
    exit();
}

echo "Welcome, " . $_SESSION['username'] . "! This is the dashboard.";
?>

<a href="logout.php">Logout</a>
