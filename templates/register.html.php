<?php if (!empty($error)): ?>
    <div class="errors"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<form action="" method="post">
    <label for="name">Username</label>
    <input type="text" name="name" id="name" required value="<?= htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <label for="email">Email</label>
    <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required><br><br>
    <br />
    <label for="password_confirm">Confirm Password</label>
    <input type="password" name="password_confirm" id="password_confirm" required><br><br>

    <input class="btn" type="submit" value="Register">
</form>

<p>Already have an account? <a href="login.php">Login here</a></p>