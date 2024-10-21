<?php
session_start();
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role']; // Nhận giá trị từ danh sách chọn

    // Kiểm tra tài khoản đã tồn tại chưa
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Tên đăng nhập đã tồn tại!";
    } else {
        // Thêm người dùng vào cơ sở dữ liệu
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $password, $role);
        if ($stmt->execute()) {
            header('Location: login.php');
            exit;
        } else {
            echo "Đăng ký thất bại!";
        }
    }
}
?>

<?php include('includes/header.php'); ?>

<div class="container">
    <h2 class="my-4">Đăng ký</h2>
    <form action="register.php" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Tên đăng nhập</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Chọn vai trò</label>
            <select class="form-control" id="role" name="role" required>
                <option value="student">Học sinh</option>
                <option value="librarian">Người quản lý</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Đăng ký</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
