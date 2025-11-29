<?php if (!empty($error)): ?>
    <div class="errors"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="post" action="send_code.php">
    <label>Email:</label>
    <input type="email" name="email" required>
    <button class="btn" type="submit">Send verification code</button>
</form>
