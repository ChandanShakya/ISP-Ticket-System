<?php
session_start();
include './connection/local_connect.php';
$pdo = pdo_connect_mysql();
include './common/datetime.php';
if (isset($_SESSION['logged_in'])) {
    echo '<script>document.getElementsById("button_change").innerHTML = "History";</script>';

}
// MySQL query that retrieves  all the tickets from the databse
$stmt = $pdo->prepare('SELECT * FROM tickets ORDER BY created DESC');
$stmt->execute();
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
include_once "common/header.php";
?>
<section class="d-xxl-flex flex-grow-0 py-4 py-xl-5">
	<div class="container">
		<div class="text-white bg-dark border rounded border-0 p-4 p-md-5 shadow-lg" style="filter: blur(0px);">
			<h2 class="fw-bold text-center text-white mb-3">Tickets</h2>
			<div class="home">
				<div class="tickets-list ">
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
								<?php
								
								?>
								<div class="con created col-md-4"><?= date('F dS, G:ia', strtotime(dateToTimezone('Asia/Kathmandu', $ticket['created']))) ?></div>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="text-center my-3"><a class="btn btn-primary btn-lg text-center me-2" role="button" href="create.php">Create Ticket</a></div>

		</div>
	</div>

</section>


<?php
include_once 'common/footer.php';
?>