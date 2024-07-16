<?php
session_start();
include 'connect.php';

$promotion_name = $_POST['promotion_name'];
$description = $_POST['description'];
$discount_percentage = $_POST['discount_percentage'];

$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

$sql = "INSERT INTO promotions (promotion_name, description, discount_percentage, image_url) VALUES ('$promotion_name', '$description', '$discount_percentage', '$target_file')";

if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "เพิ่มโปรโมชั่นใหม่เรียบร้อยแล้ว";
} else {
    $_SESSION['message'] = "เกิดข้อผิดพลาดในการเพิ่มโปรโมชั่น: " . $conn->error;
}

$conn->close();

header("Location: manage_store.php");
exit;
?>
