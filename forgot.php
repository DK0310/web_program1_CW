<?php
session_start();

$error = '';
$success = '';


if (isset($_GET['expired'])) {
    $error = 'Your verification code has expired. Please request a new one.';
}

if (isset($_GET['sent']) && $_GET['sent'] == '1') {
    $success = 'If an account exists with that email, a verification code has been sent.';
}

$title = "Forgot Password";
ob_start();
include 'templates/forgot.html.php';
$output = ob_get_clean();
include 'templates/menu.html.php';
?>