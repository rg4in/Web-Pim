<?php
session_start();
include 'connect.php';

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $product_id = mysqli_real_escape_string($conn, $product_id);

    $sql = "DELETE FROM products WHERE product_id = $product_id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "ลบสินค้าเรียบร้อยแล้ว";
    } else {
        $_SESSION['message'] = "เกิดข้อผิดพลาดในการลบสินค้า: " . $conn->error;
    }
} else {
    $_SESSION['message'] = "ไม่พบ product_id ที่ส่งมา";
}

$conn->close();
header('Location: manage_store.php');
exit;
?>
