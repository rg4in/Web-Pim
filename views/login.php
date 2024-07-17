<?php
session_start();

// Check if the user is already logged in, redirect to index.php if true
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lovepotion_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Validate input
    if (empty($username) || empty($password)) {
        echo "<script>
                setTimeout(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'เข้าสู่ระบบไม่สำเร็จ',
                        text: 'Username หรือ Password ไม่ถูกต้อง',
                        confirmButtonText: 'OK'
                    });
                }, 100);
              </script>";
    } else {
        // Prepare and execute SQL statement
        $stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists in database
        if ($result->num_rows > 0) {
            // Fetch user details including role
            $user = $result->fetch_assoc();
            $role = $user['role'];

            // Set session variables
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            // Show success message with SweetAlert
            echo "<script>
                    setTimeout(function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'เข้าสู่ระบบสำเร็จ',
                            text: 'กำลังพาคุณกลับไปยังหน้าหลัก...',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function() {
                            window.location.href = '" . ($role === 'manager' ? 'index.php' : 'index.php') . "';
                        });
                    }, 100);
                  </script>";
        } else {
            // Show error message if login fails
            echo "<script>
                    setTimeout(function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'เข้าสู่ระบบไม่สำเร็จ',
                            text: 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
                            confirmButtonText: 'OK'
                        });
                    }, 100);
                  </script>";
        }
    }
}
?>


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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body class="d-flex flex-column">
    <main class="flex-shrink-0">
        <div id="navbarContainer"></div>
        <!-- Script to load Navigation Bar -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <script>
            $(function() {
                $('#navbarContainer').load('nav.php');
            });
        </script>
        <!-- Page content-->
        <section class="py-5">
            <div class="container px-5">
                <!-- Login form-->
                <div class="bg-light rounded-3 py-5 px-4 px-md-5 mb-5">
                    <div class="text-center mb-5">
                        <div class="feature bg-pink bg-gradient text-white rounded-3 mb-3"><i class="bi bi-person-circle"></i></div>
                        <h1 class="fw-bolder">Login</h1>
                        <p class="lead fw-normal text-muted mb-0">เข้าสู่ระบบเพื่อเริ่มต้นใช้งาน</p>
                    </div>
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">
                            <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <!-- Username input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="username" name="username" type="text" placeholder="Enter your Username..." required />
                                    <label for="username">Username</label>
                                    <div class="invalid-feedback">A Username is required.</div>
                                </div>
                                <!-- Password input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="password" name="password" type="password" placeholder="Enter your password..." required />
                                    <label for="password">Password</label>
                                    <div class="invalid-feedback">A Password is required.</div>
                                </div>
                                <!-- Submit Button-->
                                <div class="d-grid">
                                    <button class="btn btn-success btn-lg" id="submitButton" type="submit">Login</button>
                                </div>
                            </form>
                            <!-- Back Button -->
                            <div class="d-grid mt-3">
                                <a href="index.php" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
