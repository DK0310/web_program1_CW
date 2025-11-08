<form action="" method="post" enctype="multipart/form-data">
    <label for="content">Type any content here</label><br>
    <textarea name="content" rows="3" cols="40" required></textarea><br><br>

    <label for="userid">Select user</label>
    <select name="userid" id="userid" required>
        <option value="">Select user</option>
        <?php foreach($users as $user): ?>
            <option value="<?= htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?>">
                <?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="moduleid">Select module</label>
    <select name="moduleid" id="moduleid" required>
        <option value="">Select module</option>
        <?php foreach($modules as $module): ?>
            <option value="<?= htmlspecialchars($module['id'], ENT_QUOTES, 'UTF-8') ?>">
                <?= htmlspecialchars($module['name'], ENT_QUOTES, 'UTF-8') ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="image">Upload image</label>
    <input type="file" name="image" id="image" accept="image/*"><br><br>

    <input type="submit" name="submit" value="Add">
</form>
