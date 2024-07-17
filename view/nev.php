<?php
// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar shadow navbar-expand-lg navbar-dark bg-pink">
    <div class="container px-5">
        <a class="navbar-brand fw-bold" href="index.php">LOVEPOTION</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                <li class="nav-item"><a class="nav-link" href="about.html"><i class="bi bi-info-circle"></i> เกี่ยวกับ</a></li>
                <li class="nav-item"><a class="nav-link" href="faq.html"><i class="bi bi-question-circle"></i> คำถามที่พบบ่อย</a></li>
                <?php
                // Check if username is set in session
                if (isset($_SESSION['username'])) {
                    // Check if role is set in session and it's 'manager'
                    if (isset($_SESSION['role']) && $_SESSION['role'] === 'manager') {
                        echo '<li class="nav-item">
                            <a class="nav-link" href="manage_store.php"><i class="bi bi-gear"></i> จัดการร้าน</a>
                          </li>';
                    }
                    $username = $_SESSION['username'];
                    echo '<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownUser" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> ' . $username . '
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">

                                <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right"></i> ออกจากระบบ</a></li>
                            </ul>
                          </li>';

                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="login.php"><i class="bi bi-person-circle"></i> เข้าสู่ระบบ    </a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
