<?php if (!empty($error)): ?>
    <div class="errors"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<form action="" method="post">
    <label for="name">Admin Username</label>
    <input type="text" name="name" id="name" required value="<?= htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required><br><br>

    <input type="submit" value="Login">
</form>
