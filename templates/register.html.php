<?php if (!empty($error)): ?>
    <div class="errors"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<div style="max-width:520px;margin:0 auto">
    <h2 style="margin-top:0">Create an account</h2>
    <p style="color:var(--muted);margin-bottom:12px">Register to post and comment.</p>
    <form action="" method="post" class="card">
        <label for="name">Username</label>
        <input type="text" name="name" id="name" required value="<?= htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
    <br />
        <label for="password_confirm">Confirm Password</label>
        <input type="password" name="password_confirm" id="password_confirm" required>

        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:8px">
            <a class="btn ghost" href="login.php">Already have an account?</a>
            <input class="btn" type="submit" value="Register">
        </div>
    </form>
</div>