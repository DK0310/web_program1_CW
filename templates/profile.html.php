<?php if (!empty($error)): ?>
    <div class="errors"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<h2>My Profile</h2>
<form action="" method="post">
    <label for="name">Name</label>
    <input type="text" name="name" id="name" required value="<?= htmlspecialchars($user['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <label for="email">Email</label>
    <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <input class="btn" type="submit" value="Save">
</form>
