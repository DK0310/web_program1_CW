<?php if (!empty($questions) && is_array($questions)): ?>
    <?php foreach ($questions as $question): ?>
        <article class="question">
            <div class="meta">
                <strong><?= htmlspecialchars($question['name'] ?? 'Anonymous', ENT_QUOTES, 'UTF-8') ?></strong>
                <?php if (!empty($question['email'])): ?> &lt;<a href="mailto:<?=htmlspecialchars($question['email'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars($question['email'], ENT_QUOTES, 'UTF-8')?></a>&gt; <?php endif; ?>
                <div style="font-size:0.9em; color:#666;">Posted: <?=htmlspecialchars(!empty($question['date']) ? date('j M Y', strtotime($question['date'])) : '', ENT_QUOTES, 'UTF-8')?> • Module: <?=htmlspecialchars($question['module'] ?? '', ENT_QUOTES, 'UTF-8')?></div>
            </div>

            <div class="content">
                <?= nl2br(htmlspecialchars($question['content'] ?? '', ENT_QUOTES, 'UTF-8')) ?>
            </div>

             <div class="actions">
                <form action="delete_post.php" method="post" onsubmit="return confirm('Are you sure you want to delete this post?');" style="display:inline">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($question['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    <input class="btn ghost" type="submit" value="Delete">
                </form>
            </div>

            <?php if (!empty($question['image'])): ?>
                <img src="../images/<?= htmlspecialchars($question['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Post image">
            <?php endif; ?>


            <?php
                // make $comments available for the included template
                $comments = $question['comments'] ?? [];
                include '../templates/comment_post.html.php';
            ?>
        </article>
    <?php endforeach; ?>
<?php else: ?>
    <p>No questions to display.</p>
<?php endif; ?>
