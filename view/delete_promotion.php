<?php
session_start();
include 'connect.php';

if (isset($_GET['promotion_id'])) {
    $promotion_id = $_GET['promotion_id'];
    $promotion_id = mysqli_real_escape_string($conn, $promotion_id);

    $sql = "DELETE FROM promotions WHERE promotion_id = $promotion_id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "ลบโปรโมชั่นเรียบร้อยแล้ว";
    } else {
        $_SESSION['message'] = "เกิดข้อผิดพลาดในการลบโปรโมชั่น: " . $conn->error;
    }
} else {
    $_SESSION['message'] = "ไม่พบ promotion_id ที่ส่งมา";
}

$conn->close();
header('Location: manage_store.php');
exit;
?>
