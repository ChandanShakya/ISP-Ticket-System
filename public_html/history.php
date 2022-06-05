<?php
session_start();
include './connection/local_connect.php';
$pdo = pdo_connect_mysql();
include './common/datetime.php';

// MySQL query that retrieves  all the tickets from the databse
if($_SESSION['user_id'] == '1'){
$stmt = $pdo->prepare('SELECT * FROM tickets ORDER BY created DESC');
$stmt->execute();
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
}else{
    $stmt = $pdo->prepare('SELECT * FROM tickets WHERE uid = ? ORDER BY created DESC');
    $stmt->execute([$_SESSION['user_id']]);
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<?php
include_once "common/header.php";
?>
<!-- List all the Tickets using php and pdo-->
<section class="d-xxl-flex flex-grow-0 py-4 py-xl-5">
    <div class="container">
        <div class="text-white bg-dark border rounded border-0 p-4 p-md-5 shadow-lg" style="filter: blur(0px);">
            <h2 class="fw-bold text-center text-white mb-3">History Panel </h2>
            <div class="home">
                <div class="tickets-list">
                    <?php foreach ($tickets as $ticket) : ?>
                        <div class="row shadow-lg">
                            <a href="view.php?id=<?= $ticket['id'] ?>" class="ticket">
                                <div class="con col-md-1">
                                    <?php if ($ticket['status'] == 'open') : ?>
                                        <i class="far fa-clock fa-2x"></i>
                                    <?php elseif ($ticket['status'] == 'resolved') : ?>
                                        <i class="fas fa-check fa-2x"></i>
                                    <?php elseif ($ticket['status'] == 'closed') : ?>
                                        <i class="fas fa-times fa-2x"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="con col-md-7">
                                    <span class="title"><?= htmlspecialchars($ticket['title'], ENT_QUOTES) ?></span>
                                    <span class="msg"><?= htmlspecialchars($ticket['msg'], ENT_QUOTES) ?></span>
                                </div>
                                <div class="con created col-md-3"><?= date('F dS, G:ia', strtotime(dateToTimezone('Asia/Kathmandu', $ticket['created']))) ?></div>
                                <!-- Button to delete the current ticket -->
                                <div class="con col-md-1">

                                    <form action="history.php" method="post">
                                        <input type="hidden" name="id" value="<?= $ticket['id'] ?>">
    
                                        <button type="submit" class="btn btn-danger" style="margin:0.2em">Delete</button>
                                    </form>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Logout button  that is centered-->
            <div class="text-center" style="margin-top: 1em;">
                <a href="logout.php" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </div>
</section>
<?php 
    //code to delete the entry
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare('DELETE FROM tickets WHERE id = ?');
        $stmt->execute([$id]);
        // reload the page without using header
        echo "<script>window.location.href = 'history.php';</script>";
    }
?>
<!-- include footer -->
<?php
include_once "common/footer.php";
?>