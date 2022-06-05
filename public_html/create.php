<?php
session_start();
include './connection/local_connect.php';
$pdo = pdo_connect_mysql();
// if session is not set redirect to login.php
if (!isset($_SESSION['logged_in'])) {
    header("Location:login.php");
}
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
<section class="d-xxl-flex flex-grow-0 py-4 py-xl-3">
	<div class="container">
		<div class="text-white bg-dark border rounded border-0 p-4 p-md-5" style="filter: blur(0px);">
<center>
<div class="create">
    <h2>Create Ticket</h2>
    <form action="create.php" method="post">
        <label for="title">Title</label>
        <input type="text" class="form-control" name="title" placeholder="Title" id="title" required>
        <label for="phone">Phone Number</label>
        <input type="tel" class="form-control" name="phone" placeholder="98xxxxxxxx" id="phone" required pattern="[0-9]{10}">
        <label for="msg">Message</label>
        <textarea name="msg" class="form-control" placeholder="Enter your message here..." id="msg" required></textarea>
        <center><input type="submit" value="Create" style="background-color:#0d6efd">
        </center>
        
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>
</center>
        </div>
    </div>
</section>
<?php
include_once "common/footer.php";
?>