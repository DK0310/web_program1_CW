<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputCode = trim($_POST['code'] ?? '');

    // Check expired
    if (time() > ($_SESSION['reset_expires'] ?? 0)) {
        $error = "Verification code expired. Request a new one.";
    }
    // Check correct
    elseif ($inputCode == ($_SESSION['reset_code'] ?? '')) {
        // verified OK
        $_SESSION['verified'] = true;
        header("Location: updatepass.php");
        exit;
    } else {
        $error = "Incorrect verification code.";
    }
}
include 'templates/verify.html.php';
?>
