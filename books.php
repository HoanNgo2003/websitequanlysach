<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'librarian' && $_SESSION['role'] != 'admin')) {
    header('Location: login.php');
    exit;
}
include('includes/db.php');

// Thêm sách
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $quantity = $_POST['quantity'];

    $stmt = $conn->prepare("INSERT INTO books (title, author, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param('ssi', $title, $author, $quantity);
    $stmt->execute();

    header('Location: books.php');
    exit;
}

// Xóa sách
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    header('Location: books.php');
    exit;
}

$result = $conn->query("SELECT * FROM books");
?>

<?php include('includes/header.php'); ?>

<h2>Quản lý sách</h2>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sách</th>
            <th>Tác giả</th>
            <th>Số lượng</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['author']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td>
                <a href="books.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Xóa</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<form action="books.php" method="POST">
    <div class="mb-3">
        <label for="title" class="form-label">Tên sách</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="mb-3">
        <label for="author" class="form-label">Tác giả</label>
        <input type="text" class="form-control" id="author" name="author" required>
    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">Số lượng</label>
        <input type="number" class="form-control" id="quantity" name="quantity" required>
    </div>
    <button type="submit" class="btn btn-primary">Thêm sách</button>
</form>

<?php include('includes/footer.php'); ?>
