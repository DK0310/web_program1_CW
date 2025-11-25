<h2>Reset Your Password</h2>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<form action="" method="post">

    <label for="password">New Password</label><br>
    <input type="password" name="password" id="password" required minlength="8"><br><br>

    <label for="password_confirm">Confirm New Password</label><br>
    <input type="password" name="password_confirm" id="password_confirm" required minlength="8"><br><br>

    <input type="submit" value="Set Password">
</form>

<p style="font-size: 0.9em; color: #666;">
    Your password must be at least 8 characters long.
</p>
