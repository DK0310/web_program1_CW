<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../base.css">
    <title><?= htmlspecialchars($title ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></title>
</head>
<body>
    <header>
        <h1>Admin Operations</h1>
    </header>

    <nav>
        <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
        <ul>
            <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <li><a class="btn" href="question.php">Question List</a></li>
                <li><a class="btn" href="addquestion.php">Add Post</a></li>
                <li><a class="btn" href="users.php">View all users</a></li>
                <li><a class="btn" href="view_emails.php">View user emails</a></li>
                <li><a class="btn" href="manage_module.php">Manage Modules</a></li>
                <li><a class="btn secondary" href="../logout.php">Logout</a></li>
            <?php else: ?>
                <li><a class="btn ghost" href="../index.php">Back</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="container">
        <main>
            <?= $output ?? '' ?>
        </main>
        <footer>&copy; Greenwich Student Forum 2025 </footer>
    </div>
</body>
</html>
