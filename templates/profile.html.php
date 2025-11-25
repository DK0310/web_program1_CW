<?php if (!empty($error)): ?>
    <div class="errors"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<div style="max-width:520px;margin:0 auto">
    <h2 style="margin-top:0">My Profile</h2>
    <form action="" method="post" class="card">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" required value="<?= htmlspecialchars($user['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

        <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:8px">
            <a class="btn ghost" href="index.php">Back</a>
            <input class="btn" type="submit" value="Save">
        </div>
    </form>
</div>



