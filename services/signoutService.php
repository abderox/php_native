<?php
session_start();
unset($_SESSION["id"]);
unset($_SESSION["username"]);
unset($_SESSION["logged_in"]);
unset($_SESSION["db_name"]);
header("Location:./login.php");
?>
