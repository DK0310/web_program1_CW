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
            <nav>
                <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
                <ul class="nav-tabs">
                    <li class="<?= (isset($active) && $active === 'home') ? 'active' : '' ?>">
                        <a class="<?= (isset($active) && $active === 'home') ? '' : 'ghost' ?>" href="question.php">Home</a></li>
                    </li>
                    <li class="<?= (isset($active) && $active === 'add') ? 'active' : '' ?>">
                        <a class="<?= (isset($active) && $active === 'add') ? '' : 'ghost' ?>" href="addquestion.php">Add</a>
                    </li>
                    <li class="<?= (isset($active) && $active === 'modules') ? 'active' : '' ?>">
                        <a class="<?= (isset($active) && $active === 'modules') ? '' : 'ghost' ?>" href="manage_module.php">Modules</a>
                    </li>
                    <li class="<?= (isset($active) && $active === 'users') ? 'active' : '' ?>">
                        <a class="<?= (isset($active) && $active === 'users') ? '' : 'ghost' ?>" href="users.php">Users</a>
                    </li>
                    <li class="<?= (isset($active) && $active === 'emails') ? 'active' : '' ?>">
                        <a class="<?= (isset($active) && $active === 'emails') ? '' : 'ghost' ?>" href="view_emails.php">View Emails</a>
                    </li>
                </ul>

                <div class="nav-right">
                    <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <span class="nav-user"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></span>
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