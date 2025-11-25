<?php if (!empty($error)): ?>
    <div class="errors"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<form action="" method="post">
    <label for="name">Module name</label>
    <input type="text" name="name" id="name" required><br><br>
    <input class="btn" type="submit" value="Create">
</form>