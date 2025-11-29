<?php
session_start();

$error = '';
$success = '';

if (isset($_GET['error'])) {
    if ($_GET['error'] === 'notfound') {
        $error = 'No account found with that email address.';
    } elseif ($_GET['error'] === 'empty') {
        $error = 'Please enter your email address.';
    }
}

if (isset($_GET['expired'])) {
    $error = 'Your verification code has expired. Please request a new one.';
}

if (isset($_GET['sent']) && $_GET['sent'] == '1') {
    $success = 'A verification code has been sent to your email.';
}

$title = "Forgot Password";
ob_start();
include 'templates/forgot.html.php';
$output = ob_get_clean();
include 'templates/menu.html.php';
?>