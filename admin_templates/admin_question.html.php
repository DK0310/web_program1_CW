<?php if (!empty($questions) && is_array($questions)): ?>
    <?php foreach ($questions as $question): ?>
        <blockquote>
            <?= nl2br(htmlspecialchars($question['content'] ?? '', ENT_QUOTES, 'UTF-8')) ?><br>
            <div style="font-size:0.9em; color:#666; margin-bottom:0.5em;">Posted: <?=htmlspecialchars(!empty($question['date']) ? date('j M Y', strtotime($question['date'])) : '', ENT_QUOTES, 'UTF-8')?></div>

            (by <?php if (!empty($question['email'])): ?>
                <a href="mailto:<?=htmlspecialchars($question['email'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars($question['name'] ?? 'Anonymous', ENT_QUOTES, 'UTF-8')?></a>
            <?php else: ?>
                <?=htmlspecialchars($question['name'] ?? 'Anonymous', ENT_QUOTES, 'UTF-8')?>
            <?php endif; ?>)
       
            <br>
            <div style="font-size:0.9em; color:#666; margin-bottom:0.5em;">Module: <?=htmlspecialchars($question['module'] ?? '', ENT_QUOTES, 'UTF-8')?></div>
            <br>
            <?php if (!empty($question['image'])): ?>
                <img height="100px" src="../images/<?= htmlspecialchars($question['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="">
            <?php endif; ?>

        <form action="delete_post.php" method="post"
                  onsubmit="return confirm('Are you sure you want to delete this post?');">
                <input type="hidden" name="id"
                       value="<?= htmlspecialchars($question['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <input type="submit" value="Delete">
            </form>
        </blockquote>
    <?php endforeach; ?>
<?php else: ?>
    <p>No questions to display.</p>
<?php endif; ?>
