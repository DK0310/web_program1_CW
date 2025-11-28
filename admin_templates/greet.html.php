<h2>Welcome back, Admin <?= htmlspecialchars($currentUserName ?? $_SESSION['user_name'] ?? 'User', ENT_QUOTES, 'UTF-8') ?></h2>
<p>List of Questions</p>