<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="base.css">
    <title><?= htmlspecialchars($title ?? 'Student Forum', ENT_QUOTES, 'UTF-8') ?></title>
</head>
<body>
    <div class="container">
        <header>
            <h1>Student Forum</h1>
            <input type="checkbox" id="nav-toggle" class="nav-checkbox">
            <label for="nav-toggle" class="nav-toggle" aria-label="Toggle navigation">☰</label>
            <nav>
                <ul class="nav-tabs" id="navMenu">
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <li><a class="btn" href="question.php">Home</a></li>
                        <li><a class="btn" href="addquestion.php">Create Question</a></li>
                        <li><a class="btn" href="user_posts.php">My Post</a></li>
                        <li><a class="btn" href="profile.php">My Profile</a></li>
                        <li><a class="btn" href="send_email.php">Inbox Admin</a></li>
                    <?php endif; ?>
                </ul>

                <div class="nav-right">
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <span class="nav-user"><?= htmlspecialchars($currentUserName ?? $_SESSION['user_name'] ?? 'User', ENT_QUOTES, 'UTF-8') ?></span>
                        <form action="logout.php" method="post" style="display:inline;margin:0">
                            <button class="btn logout" type="submit">Logout</button>
                        </form>
                    <?php else: ?>
                        <a class="btn secondary" href="login.php">Login</a>
                        <a class="btn" href="register.php">Register</a>
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