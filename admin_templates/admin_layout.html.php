<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../base.css">
    <title><?= htmlspecialchars($title ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></title>
</head>
<body>
    <div class="container">
        <header>
            <h1>Admin Panel</h1>
            <input type="checkbox" id="nav-toggle" class="nav-checkbox">
            <label for="nav-toggle" class="nav-toggle" aria-label="Toggle navigation">☰</label>
            <nav>
                <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
                <ul class="nav-tabs" id="navMenu">
                    <li><a class="btn" href="question.php">Home</a></li>
                    <li><a class="btn" href="addquestion.php">Create Post</a></li>
                    <li><a class="btn" href="manage_module.php">Modules</a></li>
                    <li><a class="btn" href="users.php">Users</a></li>
                    <li><a class="btn" href="view_emails.php">View Inbox</a></li>
                </ul>

                <div class="nav-right">
                    <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <span class="nav-user"><?= htmlspecialchars($currentUserName ?? $_SESSION['user_name'] ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></span>
                        <form action="../logout.php" method="post" style="display:inline;margin:0">
                            <button class="btn logout" type="submit">Logout</button>
                        </form>
                    <?php else: ?>
                        <a class="btn ghost" href="../index.php">Back to site</a>
                    <?php endif; ?>
                </div>
            </nav>
        </header>

        <main class="card">
            <?= $output ?? '' ?>
        </main>

        <footer>&copy; Greenwich Student Forum 2025</footer>
    </div>
</body>
</html>