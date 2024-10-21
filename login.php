<?php
session_start();
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // Điều hướng dựa trên quyền người dùng
        if ($user['role'] == 'student') {
            header('Location: borrow.php');
        } elseif ($user['role'] == 'librarian' || $user['role'] == 'admin') {
            header('Location: books.php');
        }
        exit;
    } else {
        echo "Sai tên đăng nhập hoặc mật khẩu!";
    }
}
?>

<?php include('includes/header.php'); ?>

<div class="container">
    <h2 class="my-4">Đăng nhập</h2>
    <form action="login.php" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Tên đăng nhập</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Đăng nhập</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
