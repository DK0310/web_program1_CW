<?php
session_start();
include 'db/db.php';
include 'db/db_function.php';

if (empty($_SESSION['verified']) || time() > ($_SESSION['reset_expires'] ?? 0)) {
    header("Location: forgot.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pw = $_POST['password'] ?? '';
    $pw2 = $_POST['password_confirm'] ?? '';

    if (strlen($pw) < 8) {
        $error = "Password must be at least 8 characters.";
    } elseif ($pw !== $pw2) {
        $error = "Passwords do not match.";
    } else {
        $email = $_SESSION['reset_email'];

        $stmt = $pdo->prepare("UPDATE user SET password = :pw WHERE email = :email");
        $stmt->execute([
            ':pw' => password_hash($pw, PASSWORD_DEFAULT),
            ':email' => $email
        ]);

        unset($_SESSION['verified'], $_SESSION['reset_email'], $_SESSION['reset_code'], $_SESSION['reset_expires']);

        header("Location: login.php?reset=1");
        exit;
    }
}

$title = "Reset Password";
ob_start();
include "templates/reset_pass.html.php";
$output = ob_get_clean();

include "templates/menu.html.php";
