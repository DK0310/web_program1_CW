<?php
// Landing page offering choice to login as user or admin
if (session_status() === PHP_SESSION_NONE) session_start();

// If already logged in, redirect to appropriate area
if (!empty($_SESSION['user_id'])) {
    header('Location: question.php');
    exit;
}
if (!empty($_SESSION['admin_id'])) {
    header('Location: admin/question.php');
    exit;
}

$title = 'Login Choice';
ob_start();
?>
<h2>Sign in</h2>

<p>
    <a href="login.php"><button>Login</button></a>
</p>
<p>New user? <a href="register.php">Register here</a></p>
<?php
$output = ob_get_clean();
include 'templates/menu.html.php';
