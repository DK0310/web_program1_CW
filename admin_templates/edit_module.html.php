<?php if (!empty($error)): ?>
    <div class="errors"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<form action="" method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($module['id'], ENT_QUOTES, 'UTF-8') ?>">
    <label for="name">Module name</label>
    <input type="text" name="name" id="name" required value="<?= htmlspecialchars($module['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>
    <input type="submit" value="Save">
</form>
