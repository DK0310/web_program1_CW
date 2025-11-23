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
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <li><a class="btn" href="index.php">Home</a></li>
                    <li><a class="btn" href="addquestion.php">Create a question</a></li>
                    <li><a class="btn" href="user_posts.php">My Posts</a></li>
                    <li><a class="btn" href="send_email.php">Send email to Admin</a></li>
                    <li><a class="btn" href="profile.php">My Profile</a></li>
                    <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <li><a class="btn" href="admin/question.php">Admin area</a></li>
                    <?php endif; ?>
                    <li><a class="btn secondary" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a class="btn" href="login.php">Login</a></li>
                    <li><a class="btn secondary" href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>

    <div class="container">
        <main>
            <?= $output ?>
        </main>
        <footer>&copy; Greenwich Student Forum 2025 </footer>
    </div>
</html>