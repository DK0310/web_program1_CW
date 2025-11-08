<?php if (!empty($questions) && is_array($questions)): ?>
    <?php foreach ($questions as $question): ?>
        <blockquote>
            <?= nl2br(htmlspecialchars($question['content'] ?? '', ENT_QUOTES, 'UTF-8')) ?><br>
            <div style="font-size:0.9em; color:#666; margin-bottom:0.5em;">Posted: <?=htmlspecialchars(date('j M Y', strtotime($question['date'])), ENT_QUOTES, 'UTF-8')?></div>

            <?php if (!empty($question['image'])): ?>
                <img height="100px" src="../images/<?= htmlspecialchars($question['image'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php endif; ?>

        <form action="delete_post.php" method="post"
                  onsubmit="return confirm('Are you sure you want to delete this post?');">
                <input type="hidden" name="id"
                       value="<?= htmlspecialchars($question['id'], ENT_QUOTES, 'UTF-8') ?>">
                <input type="submit" value="Delete">
            </form>
        </blockquote>
    <?php endforeach; ?>
<?php else: ?>
    <p>No questions to display.</p>
<?php endif; ?>
