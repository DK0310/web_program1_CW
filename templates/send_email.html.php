<h2>Send Message to Admin</h2>
<?php if (!empty($error)): ?>
    <div class="errors"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<form action="" method="post">
    <label for="content">Message</label><br>
    <textarea name="content" id="content" rows="6" cols="60" required><?= htmlspecialchars($_POST['content'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea><br><br>
    <input type="submit" value="Send">
</form>
