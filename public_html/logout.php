<?php
    session_start();
    if(isset($_SESSION['logged_in'])) {
        session_unset();
        session_destroy();
        header("Location:login.php");
    }else{
        header("Location:index.php");
    }
?>