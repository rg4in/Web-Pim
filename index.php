<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Modern Business - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="d-flex flex-column h-100">
        <main class="flex-shrink-0">
        <?php include 'nev.php'; ?>


<!-- Header with Promotional Slideshow -->
<header class="bg-pink2 py-3 ">
    <div class="container px-5">
        <div id="promoCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Carousel Indicators -->
            <ol class="carousel-indicators">
                <?php
                include 'connect.php'; // Include database connection

                $sql = "SELECT * FROM promotions ORDER BY promotion_id ASC";
                $result = $conn->query($sql);

                $active = true;
                $index = 0;
                while ($row = $result->fetch_assoc()) {
                    $active_class = $active ? 'active' : '';
                ?>
                    <li data-bs-target="#promoCarousel" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $active_class; ?>"></li>
                <?php
                    $active = false; // Set active to false after the first item
                    $index++;
                }
                $conn->close(); // Close database connection
                ?>
            </ol>

            <div class="carousel-inner">
                <?php
                include 'connect.php'; // Include database connection

                $sql = "SELECT * FROM promotions ORDER BY promotion_id ASC";
                $result = $conn->query($sql);

                $active = true;
                while ($row = $result->fetch_assoc()) {
                    $promotion_name = $row['promotion_name'];
                    $description = $row['description'];
                    $image_url = $row['image_url'];

                    // Set active class for the first item
                    $active_class = $active ? 'active' : '';
                ?>
                    <div class="carousel-item <?php echo $active_class; ?>">
                        <div class="row gx-5 align-items-center justify-content-center">
                            <div class="col-lg-8 col-xl-7 col-xxl-6">
                                <div class="my-5 text-center text-xl-start">
                                    <h1 class="display-5 fw-bolder text-white mb-2"><?php echo $promotion_name; ?></h1>
                                    <p class="lead fw-normal text-white-50 mb-4"><?php echo $description; ?></p>
                                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                                        <!-- Add any additional content here -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center">
                                <img class="img-fluid rounded-3 my-5" src="<?php echo $image_url; ?>" alt="Promotion Image">
                            </div>
                        </div>
                    </div>
                <?php
                    $active = false; // Set active to false after the first item
                }
                $conn->close(); // Close database connection
                ?>
            </div>
        </div>
    </div>
</header>

<!-- Other Sections -->

            <!-- Product preview section-->
            <section class="py-2">
                <div class="container px-5 my-5">
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">
                            <div class="text-center">
                                <h2 class="fw-bolder">Lovepotion Products</h2>
                                <p class="lead fw-normal text-muted mb-5">"สินค้าของเรามาพร้อมกับคุณภาพและการบริการที่ดีที่สุด"</p>
                            </div>
                        </div>
                    </div>

                    
                    <div class="search-form-container border">
                        <form class="d-flex w-100" method="POST" action="">
                            <input class="form-control me-2" type="search" name="search_query" placeholder="ค้นหาสินค้า..." aria-label="Search">
                            <button class="btn btn-pink btn px-4" type="submit">
                                <i class="bi bi-search"></i> <!-- Bootstrap Icons search icon -->
                            </button>
                        </form>
                    </div>
                    
                    <?php
                    include 'connect.php'; // รวมไฟล์เชื่อมต่อฐานข้อมูล

                    $search_query = "";
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $search_query = $_POST['search_query'];
                    }

                    $sql = "SELECT * FROM products WHERE name LIKE '%$search_query%' OR description LIKE '%$search_query%'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<section class="py-5">';
                        echo '<div class="container px-5 my-5">';
                        echo '<div class="row gx-5 justify-content-center">';

                        while($row = $result->fetch_assoc()) {
                            echo '<div class="col-lg-4 mb-5">';
                            echo '<div class="card h-100  shadow border-0">';
                            echo '<img class="card-img-top" src="'.$row["image_url"].'" alt="Product Image" />';
                            echo '<div class="card-body p-4">';
                            echo '<h5 class="card-title mb-3">'.$row["name"].'</h5>';
                            echo '<p class="card-text">'.$row["description"].'</p>';
                            echo '</div>';
                            echo '<div class="card-footer p-4 pt-0 bg-transparent border-top-0">';
                            echo '<div class="d-flex align-items-end justify-content-between">';
                            echo '<div class="fw-bold">'.$row["price"].'</div>';
                            echo '<a class="btn btn-pink2 " href="https://www.instagram.com/tp23_shop?igsh=MXBobXFwNnpobHM0cA%3D%3D&utm_source=qr">Buy Now</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }

                        echo '</div>';
                        echo '</div>';
                        echo '</section>';
                    } else {
                        echo '<div class="opacity-50 text-center">ไม่พบสินค้าที่ตรงกับคำค้นหา</div>';
                    }

                    $conn->close();
                    ?>

<!-- Call to action-->
<aside class="rounded-3 p-4 p-sm-5 mt-5 shadow  border rounded" style="background: linear-gradient(to bottom right, #ffffff, #f0f0f0); background-image: url('images/followus.jpg'); background-size: 100%; background-position: center;">
    <div class="d-flex align-items-center justify-content-between flex-column flex-xl-row text-center text-xl-start">
        <div class="mb-4 mb-xl-0">
            <div class="fs-3 fw-bold text-dark">ติดตามข่าวสารได้ที่ IG</div>
            <div class="text-dark">ติดตามเราเพื่อรับข่าวสารล่าสุดและโปรโมชั่น</div>
        </div>
        <div class="ms-xl-4">
            <a class="btn btn-pink" href="https://www.instagram.com/tp23_shop?igsh=MXBobXFwNnpobHM0cA%3D%3D&utm_source=qr" target="_blank">ติดตามเรา</a>
        </div>
    </div>
</aside>




        </main>
<!-- Footer-->
<footer class="bg-dark py-4 mt-auto">
    <div class="container px-5">
        <div class="row align-items-center justify-content-between flex-column flex-sm-row">
            <div class="col-auto">
                <div class="small m-0 text-white">ลิขสิทธิ์ &copy; Lovepotion 2023</div>
            </div>
            <div class="col-auto">

                <a class="link-light small text-decoration-none" href="https://www.instagram.com/tp23_shop?igsh=MXBobXFwNnpobHM0cA%3D%3D&utm_source=qr" target="_blank">
                    <i class="bi bi-instagram"></i> Instagram
                </a>
                <span class="text-white mx-1 ">&middot;</span>
                <a class="link-light small text-decoration-none" href="https://www.tiktok.com/@tp23_shop?_t=8o0ZBqDdza3&_r=1" target="_blank">
                <i class="bi bi-file-play "></i> Tiktok
                </a>
            </div>
        </div>
    </div>
</footer>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
