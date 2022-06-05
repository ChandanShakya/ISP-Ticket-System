<?php
    session_start();
    include './connection/local_connect.php';
    $pdo = pdo_connect_mysql();
    if (isset($_SESSION['logged_in'])) {
        header("Location:history.php");
    }
?>
<?php
include_once "common/header.php";
?>
<script>
    document.getElementsByClassName("btn btn-primary ms-md-2")[0].style.background = 'var(--bs-gray-dark)';
    document.getElementsByClassName("btn btn-primary ms-md-2")[0].disabled = true;
</script>
<div class="container " style="position: absolute;left: 0;right: 0;top: 50%;transform: translateY(-50%);-ms-transform: translateY(-50%);-moz-transform: translateY(-50%);-webkit-transform: translateY(-50%);-o-transform: translateY(-50%);">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-9 col-xl-9 col-xxl-7">
            <div class="card shadow-lg o-hidden border-0 my-5">
                <div class="card-body p-0 ">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5  text-white bg-dark">
                                <div class="text-center">
                                    <h4 class="mb-4">Welcome Back!</h4>
                                </div>
                                <form class="user" action="login.php" method="post">
                                    <div class="mb-3"><input id="text" class="form-control form-control-user" type="text" placeholder="Enter Username" name="username" required /></div>
                                    <div class="mb-3"><input class="form-control form-control-user" type="password" placeholder="Password" name="password" required /></div>
                                    <div class="row mb-3">
                                        <p id="errorMsg" class="text-danger" style="display: none;">Wrong Credentials</p>
                                    </div><center><button id="submitBtn" class="btn btn-primary d-block btn-user " type="submit">Login</button></center>
                                    <hr />
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// validating the user and setting the session using pdo
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $_SESSION['user'] = $user;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['logged_in'] = true;
        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        echo '<script>document.getElementById("errorMsg").style.display = "block";</script>';
    }
}

?>
<?php
include_once 'common/footer.php';
?>