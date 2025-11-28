<?php if (!empty($error)): ?>
    <div class="errors"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<form action="" method="post">
    <label for="content">Content</label><br>
    <textarea name="content" id="content" rows="4" cols="60"><?= htmlspecialchars($q['content'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea><br><br>

    <label for="moduleid">Module</label>
    <select name="moduleid" id="moduleid">
        <?php foreach ($modules as $m): ?>
            <option value="<?= htmlspecialchars($m['id'], ENT_QUOTES, 'UTF-8') ?>" <?= ($q['moduleid'] == $m['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($m['name'], ENT_QUOTES, 'UTF-8') ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <input class="btn" type="submit" value="Save">
</form>
