<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    header('Location: login.php');
    exit;
}
include('includes/db.php');

// Trả sách
if (isset($_POST['return_id'])) {
    $id = $_POST['return_id'];

    // Cập nhật số lượng sách và đánh dấu sách đã được trả
    $stmt = $conn->prepare("UPDATE books SET quantity = quantity + 1 WHERE id = (SELECT book_id FROM borrow_return WHERE id = ?)");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $stmt = $conn->prepare("UPDATE borrow_return SET return_date = NOW() WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    echo "Trả sách thành công!";
}

$borrowed_books = $conn->query("SELECT br.id, b.title FROM borrow_return br JOIN books b ON br.book_id = b.id WHERE br.user_id = {$_SESSION['user_id']} AND br.return_date IS NULL");
?>

<?php include('includes/header.php'); ?>

<h2>Trả sách</h2>

<form action="return.php" method="POST">
    <div class="mb-3">
        <label for="return_id" class="form-label">Chọn sách để trả</label>
        <select class="form-control" id="return_id" name="return_id" required>
            <?php while ($row = $borrowed_books->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
            <?php } ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Trả sách</button>
</form>

<?php include('includes/footer.php'); ?>
