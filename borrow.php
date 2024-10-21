<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    header('Location: login.php');
    exit;
}
include('includes/db.php');

// Mượn sách
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = $_POST['book_id'];
    $user_id = $_SESSION['user_id'];

    // Kiểm tra số lượng sách
    $stmt = $conn->prepare("SELECT quantity FROM books WHERE id = ?");
    $stmt->bind_param('i', $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();

    if ($book['quantity'] > 0) {
        // Giảm số lượng sách và ghi lại thông tin mượn
        $conn->query("UPDATE books SET quantity = quantity - 1 WHERE id = $book_id");
        $stmt = $conn->prepare("INSERT INTO borrow_return (user_id, book_id, borrow_date) VALUES (?, ?, NOW())");
        $stmt->bind_param('ii', $user_id, $book_id);
        $stmt->execute();

        echo "Mượn sách thành công!";
    } else {
        echo "Sách đã hết!";
    }
}

$books = $conn->query("SELECT * FROM books WHERE quantity > 0");
?>

<?php include('includes/header.php'); ?>

<h2>Mượn sách</h2>

<form action="borrow.php" method="POST">
    <div class="mb-3">
        <label for="book_id" class="form-label">Chọn sách</label>
        <select class="form-control" id="book_id" name="book_id" required>
            <?php while ($row = $books->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
            <?php } ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Mượn sách</button>
</form>

<?php include('includes/footer.php'); ?>
