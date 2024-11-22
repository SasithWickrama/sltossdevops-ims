<?php
session_start();
unset($_SESSION['$usrname']);
unset($_SESSION["$area"]);
$_SESSION['loggedin'] = false;
header("Location:login.html");
?>

