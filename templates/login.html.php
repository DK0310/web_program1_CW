<?php if (!empty($error)): ?>
    <div class="errors"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<form action="" method="post">
    <label for="name">Username or Email</label>
    <input type="text" name="name" id="name" required value="<?= htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required><br><br>

    <input class="btn" type="submit" value="Login">
</form>

<p>New user? <a href="register.php">Register here</a></p>
<br />
<p><a href="sendpass.php">Forgot Password?</a></p>