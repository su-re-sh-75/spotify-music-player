<?php 
    session_start();
    $_SESSION["success"] = 0;
    $_SESSION["username"] = "";
    session_destroy();
    header("Location: login.php");
?>