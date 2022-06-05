<?php
session_start();
include './connection/local_connect.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data exists (user submitted the form)
if (isset($_POST['title'], $_POST['phone'], $_POST['msg'])) {
    // Validation checks... make sure the POST data is not empty
    if (empty($_POST['title']) || empty($_POST['phone']) || empty($_POST['msg'])) {
        $msg = 'Please complete the form!';
    } else {
        // Insert new record into the tickets table
        $stmt = $pdo->prepare('INSERT INTO tickets (title, phone, msg, uid) VALUES (?, ?, ?, ?)');
        $stmt->execute([$_POST['title'], $_POST['phone'], $_POST['msg'], $_SESSION['user_id']]);
        // Redirect to the view ticket page, the user will see their created ticket on this page
        header('Location: view.php?id=' . $pdo->lastInsertId());
    }
}
?>
<?php
include_once "common/header.php";
?>
<div class="content create">
    <h2>Create Ticket</h2>
    <form action="create.php" method="post">
        <label for="title">Title</label>
        <input type="text" name="title" placeholder="Title" id="title" required>
        <label for="phone">Phone Number</label>
        <input type="tel" name="phone" placeholder="98xxxxxxxx" id="phone" required pattern="[0-9]{10}">
        <label for="msg">Message</label>
        <textarea name="msg" placeholder="Enter your message here..." id="msg" required></textarea>
        <input type="submit" value="Create">
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>
<?php
include_once "common/footer.php";
?>