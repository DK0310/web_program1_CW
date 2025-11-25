<?php
session_start();
$title = "Forgot Password";
ob_start();
include 'templates/forgot.html.php';
$output = ob_get_clean();
include 'templates/menu.html.php';
?>