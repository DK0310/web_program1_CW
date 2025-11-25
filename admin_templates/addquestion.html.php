<?php if (!empty($error)): ?>
    <div class="errors"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
    <label for="content">Type any content here</label><br>
    <textarea name="content" rows="3" cols="40" required><?= htmlspecialchars($_POST['content'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea><br><br>


    <label for="moduleid">Select module</label>
    <select name="moduleid" id="moduleid" required>
        <option value="">Select module</option>
        <?php foreach($modules as $module): ?>
            <option value="<?= htmlspecialchars($module['id'], ENT_QUOTES, 'UTF-8') ?>" <?= (isset($_POST['moduleid']) && $_POST['moduleid'] == $module['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($module['name'], ENT_QUOTES, 'UTF-8') ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="image">Upload image</label>
    <input type="file" name="image" id="image" accept="image/*"><br><br>

    <input class="btn" type="submit" name="submit" value="Add">
</form>
