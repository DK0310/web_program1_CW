<?php
session_start();
include 'db/db.php';
include 'db/db_function.php';

$mailConfig = include __DIR__ . '/config/mail.php';

$email = trim($_POST['email'] ?? '');
if ($email === '') {
    header("Location: forgot.php?error=empty");
    exit;
}

// Check if email exists in database
$user = getUserIdFromEmail($pdo, $email);
if (!$user) {
    header("Location: forgot.php?error=notfound");
    exit;
}

$code = random_int(100000, 999999);

// Store in session (expires in 5 min)
$_SESSION['reset_code'] = $code;
$_SESSION['reset_email'] = $email;
$_SESSION['reset_expires'] = time() + 300; // 5 minutes

// Send email
sendPasswordResetCodeByEmail($mailConfig, $email, 'User', $code);

header("Location: verify.php");
exit;
