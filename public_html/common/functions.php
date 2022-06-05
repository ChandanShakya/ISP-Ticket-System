<?php
// if user is logged in change the login button to history button
if (isset($_SESSION['logged_in'])) {
    echo '<script>document.getElementsByClassName("btn btn-primary ms-md-2")[0].style.background = "var(--bs-gray-dark)";</script>';
    echo '<script>document.getElementsByClassName("btn btn-primary ms-md-2")[0].disabled = true;</script>';
    echo '<script>document.getElementsByClassName("btn btn-primary ms-md-2")[0].innerHTML = "History";</script>';
}

?>