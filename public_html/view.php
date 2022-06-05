<?php
session_start();
include './connection/local_connect.php';
$pdo = pdo_connect_mysql();
include './common/datetime.php';


// Check if the ID param in the URL exists
if (!isset($_GET['id'])) {
    exit('No ID specified!');
}
// MySQL query that selects the ticket by the ID column, using the ID GET request variable
$stmt = $pdo->prepare('SELECT * FROM tickets WHERE id = ?');
$stmt->execute([$_GET['id']]);
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);
// Check if ticket exists
if (!$ticket) {
    exit('Invalid ticket ID!');
}


// Update status
if (isset($_GET['status']) && in_array($_GET['status'], array('open', 'closed', 'resolved'))) {
    $stmt = $pdo->prepare('UPDATE tickets SET status = ? WHERE id = ?');
    $stmt->execute([$_GET['status'], $_GET['id']]);
    header('Location: view.php?id=' . $_GET['id']);
    exit;
}
// Check if the comment form has been submitted
if (isset($_POST['msg']) && !empty($_POST['msg'])) {
    // Insert the new comment into the "tickets_comments" table
    $stmt = $pdo->prepare('INSERT INTO tickets_comments (ticket_id, msg, uid) VALUES (?, ?, ?)');
    $stmt->execute([$_GET['id'], $_POST['msg'], $_SESSION['user_id']]);
    header('Location: view.php?id=' . $_GET['id']);
    exit;
}
$stmt = $pdo->prepare('SELECT * FROM tickets_comments WHERE ticket_id = ? ORDER BY created DESC');
$stmt->execute([$_GET['id']]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
include_once 'common/header.php';
?>
<section class="d-xxl-flex flex-grow-0 py-4 py-xl-5">
    <div class="container">
        <div class="text-white bg-dark border rounded border-0 p-4 p-md-5" style="filter: blur(0px);">

            <div class="view">

                <h2><?= htmlspecialchars($ticket['title'], ENT_QUOTES) ?> <span class="<?= $ticket['status'] ?>">(<?= $ticket['status'] ?>)</span></h2>

                <div class="ticket">
                    <!-- show username of the ticket creator-->
                    <?php
                    $stmt = $pdo->prepare('Select username from users where id = ?');
                    $stmt->execute([$ticket['uid']]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo '<p>Created by: ' . $user['username'] . '</p>';
                    ?>

                    <p class="created"><?= date('F dS, G:ia', strtotime(dateToTimezone('Asia/Kathmandu', $ticket['created']))) ?></p>
                    <p class="msg"><?= nl2br(htmlspecialchars($ticket['msg'], ENT_QUOTES)) ?></p>
                </div>
                <?php
                // disable class btns if user is not the ticket creator
                if (!isset($_SESSION['user_id'])) {
                    echo '<div class="btns" style="display:none;">';
                } else if ($_SESSION['user_id'] != $ticket['uid'] && $_SESSION['user_id'] != 1) {
                    echo '<div class="btns" style="display:none;">';
                } else {
                ?>
                    <div class="btns">
                        <a href="view.php?id=<?= $_GET['id'] ?>&status=closed" class="btn red" id='closeBtn'>Close</a>
                        <?php
                        // reopen button
                        if ($ticket['status'] == 'closed') {
                            echo '<a href="view.php?id=' . $_GET['id'] . '&status=open" class="btn green" id="reopenBtn">Reopen</a>';
                        }
                        // if user is not admin, hide the resolve button
                        if ($_SESSION['user_id'] == 1) {
                            echo '<a href="view.php?id=' . $_GET['id'] . '&status=resolved" class="btn green" id="resolveBtn">Resolve</a>';
                            // if resolved and user is admin, show the reopen button
                            if ($ticket['status'] == 'resolved') {
                                echo '<a href="view.php?id=' . $_GET['id'] . '&status=open" class="btn green" id="reopenBtn">Reopen</a>';
    
                            }
                        }  ?>
                    </div>
                <?php
                }

                ?>

                <div class="comments">
                    <?php foreach ($comments as $comment) : ?>
                        <div class="comment">
                            <div>
                                <i class="fas fa-comment fa-2x"></i>
                            </div>
                            <p>

                                <?php
                                $stmt = $pdo->prepare('SELECT username FROM users WHERE id = ?');
                                $stmt->execute([$comment['uid']]);
                                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <?= htmlspecialchars($user['username'], ENT_QUOTES) ?>
                                <span><?= date('F dS, G:ia', strtotime(dateToTimezone('Asia/Kathmandu', $comment['created']))) ?></span>
                                <?= nl2br(htmlspecialchars($comment['msg'], ENT_QUOTES)) ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                    <center>
                    <form action="" method="post">
                        <textarea name="msg" placeholder="Enter your comment..."></textarea>
                        <center><input type="submit" value="Post Comment" ></center>
                    </form>
                    </center>
                </div>

            </div>
        </div>
    </div>
    </div>
</section>

<?php
include_once 'common/footer.php';
?>