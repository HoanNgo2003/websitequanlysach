<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'librarian' && $_SESSION['role'] != 'admin')) {
    header('Location: login.php');
    exit;
}
include('includes/db.php');

// Thống kê tồn kho
$total_books = $conn->query("SELECT SUM(quantity) AS total FROM books")->fetch_assoc()['total'];

// Thống kê sách đã mượn
$borrowed_books = $conn->query("SELECT br.id, b.title, u.username, br.borrow_date FROM borrow_return br JOIN books b ON br.book_id = b.id JOIN users u ON br.user_id = u.id WHERE br.return_date IS NULL");
?>

<?php include('includes/header.php'); ?>

<h2>Thống kê</h2>

<p>Tổng số sách trong thư viện: <?php echo $total_books; ?></p>
<p>Số sách đã mượn: <?php echo $borrowed_books->num_rows; ?></p>

<h3>Danh sách sách đã mượn</h3>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sách</th>
            <th>Người mượn</th>
            <th>Ngày mượn</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $borrowed_books->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo date('d-m-Y H:i:s', strtotime($row['borrow_date'])); ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php include('includes/footer.php'); ?>

