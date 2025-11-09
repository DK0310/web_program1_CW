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
            <?php if (!empty($_SESSION['admin_id'])): ?>
                <li><a href="question.php">Question List</a></li>
                <li><a href="users.php">View all users</a></li>
                <li><a href="manage_module.php">Manage Modules</a></li>
                <li><a href="../logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="../index.php">Back</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <main>
        <?= $output ?? '' ?>
    </main>    
</body>
</html>
