<?php
if (getenv('ENVIRONMENT') === 'production') {
    // เชื่อมต่อ MySQL บน Render.com หรือบนเซิร์ฟเวอร์ที่กำหนด
    $servername = getenv('MYSQL_HOST');
    $username = getenv('MYSQL_USERNAME');
    $password = getenv('MYSQL_PASSWORD'); // รหัสผ่านของ MySQL บน Render.com

    // ชื่อฐานข้อมูล
    $dbname = getenv('MYSQL_DATABASE');
} else {
    // เชื่อมต่อ MySQL ใน localhost (สำหรับการพัฒนาบนเครื่องของคุณ)
    $servername = "localhost";
    $username = "root"; // หรือชื่อผู้ใช้ MySQL ของคุณใน localhost
    $password = ""; // รหัสผ่าน MySQL ใน localhost หากไม่มีการตั้งค่า

    // ชื่อฐานข้อมูล
    $dbname = "lovepotion_db";
}

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
