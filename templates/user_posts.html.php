<h2>My Posts</h2>
<?php if (!empty($posts)): ?>
    <?php foreach ($posts as $p): ?>
        <article class="question">
            <div class="meta">
                <div style="font-size:0.95em; color:#444;">Posted: <?=htmlspecialchars(date('j M Y', strtotime($p['date'])), ENT_QUOTES, 'UTF-8')?> • Module: <?= htmlspecialchars($p['module'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
            </div>

            <div class="content">
                <?= nl2br(htmlspecialchars($p['content'] ?? '', ENT_QUOTES, 'UTF-8')) ?>
            </div>

            <?php if (!empty($p['image'])): ?>
                <img src="images/<?= htmlspecialchars($p['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Post image">
            <?php endif; ?>

            <div class="actions" style="margin-top:8px">
                <a class="btn" href="edit_question.php?id=<?= urlencode($p['id']) ?>">Edit</a>
                <form action="delete_post.php" method="post" style="display:inline" onsubmit="return confirm('Delete this post?');">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>">
                    <input class="btn btn-danger" type="submit" value="Delete">
                </form>
            </div>
        </article>
    <?php endforeach; ?>
<?php else: ?>
    <p>You have not posted anything yet.</p>
<?php endif; ?>