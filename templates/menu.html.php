<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="base.css">
    <title>Document</title>
</head>
<body>
        <header>
            <h1>Student Forum</h1>
        </header>
        <nav>
            <ul>
                <?php if (!empty($_SESSION['admin_id'])): ?>
                    <li><a href="admin/question.php">Home</a></li>
                    <li><a href="admin/question.php">View Users</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php elseif (!empty($_SESSION['user_id'])): ?>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="addquestion.php">Create a question</a></li>
                    <li><a href="user_posts.php">My Posts</a></li>
                    <li><a href="send_email.php">Send email to Admin</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login_choice.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <main>
            <?= $output ?>
        </main>    
</html>