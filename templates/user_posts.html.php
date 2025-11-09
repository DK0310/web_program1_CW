<h2>My Posts</h2>
<?php if (!empty($posts)): ?>
    <?php foreach ($posts as $p): ?>
        <article>
            <p><?= nl2br(htmlspecialchars($p['content'] ?? '', ENT_QUOTES, 'UTF-8')) ?></p>
            <p>Module: <?= htmlspecialchars($p['module'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
            <?php if (!empty($p['image'])): ?>
                <img src="images/<?= htmlspecialchars($p['image'], ENT_QUOTES, 'UTF-8') ?>" height="100">
            <?php endif; ?>

            <p>
                <a href="edit_question.php?id=<?= urlencode($p['id']) ?>">Edit</a>
                <form action="delete_post.php" method="post" style="display:inline" onsubmit="return confirm('Delete this post?');">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>">
                    <input type="submit" value="Delete">
                </form>
            </p>
        </article>
    <?php endforeach; ?>
<?php else: ?>
    <p>You have not posted anything yet.</p>
<?php endif; ?>
