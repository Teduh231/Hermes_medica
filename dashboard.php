<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>
<?php include 'header.php';?>
<?php include 'navbar.php';?>
