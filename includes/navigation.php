<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">Quản Lý Thư Viện</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'student') { ?>
                    <li class="nav-item"><a class="nav-link" href="borrow.php">Mượn sách</a></li>
                    <li class="nav-item"><a class="nav-link" href="return.php">Trả sách</a></li>
                <?php } ?>

                <?php if (isset($_SESSION['role']) && ($_SESSION['role'] == 'librarian' || $_SESSION['role'] == 'admin')) { ?>
                    <li class="nav-item"><a class="nav-link" href="books.php">Quản lý sách</a></li>
                    <li class="nav-item"><a class="nav-link" href="statistics.php">Thống kê</a></li>
                <?php } ?>

                <?php if (isset($_SESSION['role'])) { ?>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Đăng xuất</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Đăng nhập</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Đăng ký</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

