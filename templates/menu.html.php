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
            <nav>
                <ul class="nav-tabs">
                    <li class="<?= (isset($active) && $active === 'home') ? 'active' : '' ?>"><a class="btn" href="index.php">Home</a></li>
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <li class="<?= (isset($active) && $active === 'add') ? 'active' : '' ?>"><a class="btn" href="addquestion.php">Create a question</a></li>
                        <li class="<?= (isset($active) && $active === 'post') ? 'active' : '' ?>"><a class="btn" href="user_posts.php">My Posts</a></li>
                        <li class="<?= (isset($active) && $active === 'profile') ? 'active' : '' ?>"><a class="btn" href="profile.php">My Profile</a></li>
                        <li class="<?= (isset($active) && $active === 'send') ? 'active' : '' ?>"><a class="btn" href="send_email.php">Send Email</a></li>
                    <?php endif; ?>
                </ul>

                <div class="nav-right">
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <span class="nav-user"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User', ENT_QUOTES, 'UTF-8') ?></span>
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