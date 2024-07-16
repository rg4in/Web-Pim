<?php
ob_start(); // เริ่ม output buffering
session_start(); // เริ่ม session
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>ร้านค้า - จัดการร้าน</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <style>
        .table-wrapper {
            max-height: 600px;
            overflow-y: auto;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">

    <main class="flex-shrink-0">
        <?php include 'nev.php'; ?>
        <!-- Page Content-->
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="row gx-5">
                    <div class="col-lg-3">
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action manage-section active"
                                id="manage-products">
                                <i class="bi bi-cart-fill"></i> จัดการสินค้า
                            </a>
                            <a href="#" class="list-group-item list-group-item-action manage-section"
                                id="manage-promotions">
                                <i class="bi bi-gift-fill"></i> จัดการโปรโมชั่น
                            </a>
                            <div class="py-2"></div>
                            <a href="#"
                                class="list-group-item text-light bg-success list-group-item-action manage-section"
                                id="add-product" style="display: none;">
                                <i class="bi bi-plus-circle"></i> เพิ่มสินค้าใหม่
                            </a>
                            <a href="#"
                                class="list-group-item text-light bg-success list-group-item-action manage-section"
                                id="add-promotion" style="display: none;">
                                <i class="bi bi-plus-circle"></i> เพิ่มโปรโมชั่นใหม่
                            </a>

                        </div>
                    </div>

                    <div class="col-lg-9">
                        <!-- Alert Message -->
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo '<script>';
                            echo 'Swal.fire({
                                icon: "success",
                                title: "Success!",
                                text: "' . htmlspecialchars($_SESSION['message']) . '"
                            });';
                            echo '</script>';
                            unset($_SESSION['message']);
                        }
                        ?>



                        <!-- Products Management -->
                        <div id="product-management" class="management-section">
                            <!-- Products List -->
                            <div id="products-list">
                                <?php
                                include 'connect.php'; // เชื่อมต่อฐานข้อมูล
                                
                                $sql = "SELECT * FROM products";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    echo '<div class="table-responsive table-wrapper">';
                                    echo '<table class=" table table-striped">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th>ชื่อสินค้า</th>';
                                    echo '<th>รายละเอียด</th>';
                                    echo '<th>ราคา</th>';
                                    echo '<th>ประเภท</th>';
                                    echo '<th>ภาพสินค้า</th>';
                                    echo '<th>การจัดการ</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';

                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row["name"] . '</td>';
                                        echo '<td>' . $row["description"] . '</td>';
                                        echo '<td>' . $row["price"] . '</td>';
                                        echo '<td>' . $row["category"] . '</td>';
                                        echo '<td><img src="' . $row["image_url"] . '" class="img-thumbnail" width="100"></td>';
                                        echo '<td>';
                                        echo '<button class="btn btn-warning btn-sm edit-product" data-id="' . $row["product_id"] . '" data-name="' . $row["name"] . '" data-description="' . $row["description"] . '" data-price="' . $row["price"] . '" data-category="' . $row["category"] . '" data-image="' . $row["image_url"] . '">แก้ไข</button> ';
                                        echo '<button class="btn btn-danger btn-sm delete-product" data-id="' . $row["product_id"] . '">ลบ</button>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }

                                    echo '</tbody>';
                                    echo '</table>';
                                    echo '</div>';
                                } else {
                                    echo '<p class="text-muted">ยังไม่มีสินค้าในฐานข้อมูล</p>';
                                }

                                $conn->close();
                                ?>
                            </div>
                        </div>

                        <!-- Promotions Management -->
                        <div id="promotion-management" class="management-section" style="display: none;">
                            <!-- Promotion List -->
                            <div id="promotions-list">
                                <?php
                                include 'connect.php'; // เชื่อมต่อฐานข้อมูล
                                
                                $sql = "SELECT * FROM promotions";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    echo '<div class="table-responsive table-wrapper">';
                                    echo '<table class="table table-striped">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th>ชื่อโปรโมชั่น</th>';
                                    echo '<th>รายละเอียด</th>';
                                    echo '<th>ส่วนลด</th>';
                                    echo '<th>ภาพโปรโมชั่น</th>';
                                    echo '<th>การจัดการ</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';

                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row["promotion_name"] . '</td>';
                                        echo '<td>' . $row["description"] . '</td>';
                                        echo '<td>' . $row["discount_percentage"] . '</td>';
                                        echo '<td><img src="' . $row["image_url"] . '" class="img-thumbnail" width="100"></td>';
                                        echo '<td>';
                                        echo '<button class="btn btn-warning btn-sm edit-promotion" data-id="' . $row["promotion_id"] . '" data-name="' . $row["promotion_name"] . '" data-description="' . $row["description"] . '" data-discount="' . $row["discount_percentage"] . '" data-image="' . $row["image_url"] . '">แก้ไข</button> ';
                                        echo '<button class="btn btn-danger btn-sm delete-promotion" data-id="' . $row["promotion_id"] . '">ลบ</button>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }

                                    echo '</tbody>';
                                    echo '</table>';
                                    echo '</div>';
                                } else {
                                    echo '<p class="text-muted">ยังไม่มีโปรโมชั่นในฐานข้อมูล</p>';
                                }

                                $conn->close();
                                ?>
                            </div>
                        </div>

        </section>
    </main>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">เพิ่มสินค้าใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="add_product.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="productName" class="form-label">ชื่อสินค้า</label>
                            <input type="text" class="form-control" id="productName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="productDescription" class="form-label">รายละเอียดสินค้า</label>
                            <textarea class="form-control" id="productDescription" name="description" rows="3"
                                required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label">ราคา</label>
                            <input type="number" class="form-control" id="productPrice" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="productCategory" class="form-label">ประเภทสินค้า</label>
                            <input type="text" class="form-control" id="productCategory" name="category" required>
                        </div>
                        <div class="mb-3">
                            <label for="productImage" class="form-label">ภาพสินค้า</label>
                            <input class="form-control" type="file" id="productImage" name="image" required>
                        </div>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">แก้ไขสินค้า</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm" action="edit_product.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="editProductId" name="product_id">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">ชื่อสินค้า</label>
                            <input type="text" class="form-control" id="editProductName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductDescription" class="form-label">รายละเอียดสินค้า</label>
                            <textarea class="form-control" id="editProductDescription" name="description" rows="3"
                                required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editProductPrice" class="form-label">ราคา</label>
                            <input type="number" class="form-control" id="editProductPrice" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductCategory" class="form-label">ประเภทสินค้า</label>
                            <input type="text" class="form-control" id="editProductCategory" name="category" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductImage" class="form-label">ภาพสินค้า</label>
                            <input class="form-control" type="file" id="editProductImage" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Promotion Modal -->
    <div class="modal fade" id="addPromotionModal" tabindex="-1" aria-labelledby="addPromotionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPromotionModalLabel">เพิ่มโปรโมชั่นใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="add_promotion.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="promotionName" class="form-label">ชื่อโปรโมชั่น</label>
                            <input type="text" class="form-control" id="promotionName" name="promotion_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="promotionDescription" class="form-label">รายละเอียดโปรโมชั่น</label>
                            <textarea class="form-control" id="promotionDescription" name="description" rows="3"
                                required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="promotionDiscount" class="form-label">ส่วนลด (%)</label>
                            <input type="number" class="form-control" id="promotionDiscount" name="discount_percentage"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="promotionImage" class="form-label">ภาพโปรโมชั่น</label>
                            <input class="form-control" type="file" id="promotionImage" name="image" required>
                        </div>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit Promotion Modal -->
    <div class="modal fade" id="editPromotionModal" tabindex="-1" aria-labelledby="editPromotionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPromotionModalLabel">แก้ไขโปรโมชั่น</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPromotionForm" action="edit_promotion.php" method="post"
                        enctype="multipart/form-data">
                        <input type="hidden" id="editPromotionId" name="promotion_id">
                        <div class="mb-3">
                            <label for="editPromotionName" class="form-label">ชื่อโปรโมชั่น</label>
                            <input type="text" class="form-control" id="editPromotionName" name="promotion_name"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editPromotionDescription" class="form-label">รายละเอียดโปรโมชั่น</label>
                            <textarea class="form-control" id="editPromotionDescription" name="description" rows="3"
                                required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editPromotionDiscount" class="form-label">ส่วนลด (%)</label>
                            <input type="number" class="form-control" id="editPromotionDiscount"
                                name="discount_percentage" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPromotionImage" class="form-label">ภาพโปรโมชั่น</label>
                            <input class="form-control" type="file" id="editPromotionImage" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer-->
    <?php include 'footer.php'; ?>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Toggle between sections
        document.querySelectorAll(".manage-section").forEach(function (el) {
            el.addEventListener("click", function () {
                document.querySelectorAll(".manage-section").forEach(function (section) {
                    section.classList.remove("active");
                });
                el.classList.add("active");

                const sectionId = el.id;
                document.querySelectorAll(".management-section").forEach(function (section) {
                    section.style.display = "none";
                });
                if (sectionId === "manage-products") {
                    document.getElementById("product-management").style.display = "block";
                    document.getElementById("add-product").style.display = "block"; // แสดงปุ่มเพิ่มสินค้าใหม่
                    document.getElementById("add-promotion").style.display = "none"; // ซ่อนปุ่มเพิ่มโปรโมชั่นใหม่
                } else if (sectionId === "manage-promotions") {
                    document.getElementById("promotion-management").style.display = "block";
                    document.getElementById("add-product").style.display = "none"; // ซ่อนปุ่มเพิ่มสินค้าใหม่
                    document.getElementById("add-promotion").style.display = "block"; // แสดงปุ่มเพิ่มโปรโมชั่นใหม่
                }
            });
        });

        // Initial display setup
        const activeSection = document.querySelector(".manage-section.active");
        if (activeSection) {
            const sectionId = activeSection.id;
            if (sectionId === "manage-products") {
                document.getElementById("product-management").style.display = "block";
                document.getElementById("add-product").style.display = "block"; // แสดงปุ่มเพิ่มสินค้าใหม่
                document.getElementById("add-promotion").style.display = "none"; // ซ่อนปุ่มเพิ่มโปรโมชั่นใหม่
            } else if (sectionId === "manage-promotions") {
                document.getElementById("promotion-management").style.display = "block";
                document.getElementById("add-product").style.display = "none"; // ซ่อนปุ่มเพิ่มสินค้าใหม่
                document.getElementById("add-promotion").style.display = "block"; // แสดงปุ่มเพิ่มโปรโมชั่นใหม่
            }
        }

        // Show add product modal
        document.getElementById("add-product").addEventListener("click", function () {
            var myModal = new bootstrap.Modal(document.getElementById("addProductModal"));
            myModal.show();
        });

        // Show add promotion modal
        document.getElementById("add-promotion").addEventListener("click", function () {
            var myModal = new bootstrap.Modal(document.getElementById("addPromotionModal"));
            myModal.show();
        });

        // Show edit product modal
        document.querySelectorAll(".edit-product").forEach(function (button) {
            button.addEventListener("click", function () {
                const productId = button.getAttribute("data-id");
                const productName = button.getAttribute("data-name");
                const productDescription = button.getAttribute("data-description");
                const productPrice = button.getAttribute("data-price");
                const productCategory = button.getAttribute("data-category");

                document.getElementById("editProductId").value = productId;
                document.getElementById("editProductName").value = productName;
                document.getElementById("editProductDescription").value = productDescription;
                document.getElementById("editProductPrice").value = productPrice;
                document.getElementById("editProductCategory").value = productCategory;

                var myModal = new bootstrap.Modal(document.getElementById("editProductModal"));
                myModal.show();
            });
        });

        // Show edit promotion modal
        document.querySelectorAll(".edit-promotion").forEach(function (button) {
            button.addEventListener("click", function () {
                const promotionId = button.getAttribute("data-id");
                const promotionName = button.getAttribute("data-name");
                const promotionDescription = button.getAttribute("data-description");
                const promotionDiscount = button.getAttribute("data-discount");

                document.getElementById("editPromotionId").value = promotionId;
                document.getElementById("editPromotionName").value = promotionName;
                document.getElementById("editPromotionDescription").value = promotionDescription;
                document.getElementById("editPromotionDiscount").value = promotionDiscount;

                var myModal = new bootstrap.Modal(document.getElementById("editPromotionModal"));
                myModal.show();
            });
        });

        // Show delete product confirmation
        document.querySelectorAll(".delete-product").forEach(function (button) {
            button.addEventListener("click", function () {
                const productId = button.getAttribute("data-id");
                Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: "คุณจะไม่สามารถกู้คืนการลบนี้ได้!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ลบเลย!',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'delete_product.php?product_id=' + productId;
                    }
                });
            });
        });

        // Show delete promotion confirmation
        document.querySelectorAll(".delete-promotion").forEach(function (button) {
            button.addEventListener("click", function () {
                const promotionId = button.getAttribute("data-id");
                Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: "คุณจะไม่สามารถกู้คืนการลบนี้ได้!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ลบเลย!',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'delete_promotion.php?promotion_id=' + promotionId;
                    }
                });
            });
        });

    });
</script>

</body>

</html>