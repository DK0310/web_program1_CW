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
        header("Location: sendpass.php");
        exit;
    } else {
        $error = "Incorrect verification code.";
    }
}
?>

<form method="post">
    <label>Enter the 6-digit code sent to your email</label>
    <input type="text" name="code" required pattern="\d{6}">
    <button type="submit">Verify</button>
</form>

<p style="color:red;"><?= htmlspecialchars($error) ?></p>
