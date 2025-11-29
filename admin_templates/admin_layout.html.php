<?php 
if (session_status() === PHP_SESSION_NONE) session_start();
// $basePath should be set by calling PHP file. Default '../' for files in admin/
if (!isset($basePath)) $basePath = '../';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $basePath ?>base.css">
    <title><?= htmlspecialchars($title ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></title>
</head>
<body>
    <div class="container">
        <header>
            <h1>Admin Panel</h1>
            <input type="checkbox" id="nav-toggle" class="nav-checkbox">
            <label for="nav-toggle" class="nav-toggle" aria-label="Toggle navigation">☰</label>
            <nav>
                <ul class="nav-tabs" id="navMenu">
                    <li><a class="btn" href="<?= $basePath ?>admin/question.php">Home</a></li>
                    <li><a class="btn" href="<?= $basePath ?>admin/addquestion.php">Create Post</a></li>
                    <li><a class="btn" href="<?= $basePath ?>admin/manage_module.php">Modules</a></li>
                    <li><a class="btn" href="<?= $basePath ?>admin/users.php">Users</a></li>
                    <li><a class="btn" href="<?= $basePath ?>admin/view_emails.php">View Inbox</a></li>
                </ul>

                <div class="nav-right">
                    <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <span class="nav-user"><?= htmlspecialchars($currentUserName ?? $_SESSION['user_name'] ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></span>
                        <form action="<?= $basePath ?>logout.php" method="post" style="display:inline;margin:0">
                            <button class="btn logout" type="submit">Logout</button>
                        </form>
                    <?php else: ?>
                        <a class="btn ghost" href="<?= $basePath ?>index.php">Back to site</a>
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