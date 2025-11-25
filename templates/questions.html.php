<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php if (!empty($questions) && is_array($questions)): ?>
    <?php foreach ($questions as $question): ?>
        <article class="question">
            <div class="meta">
                <strong><?= htmlspecialchars($question['name'] ?? 'Anonymous', ENT_QUOTES, 'UTF-8') ?></strong>
                <?php if (!empty($question['email'])): ?> &lt;<a href="mailto:<?=htmlspecialchars($question['email'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars($question['email'], ENT_QUOTES, 'UTF-8')?></a>&gt; <?php endif; ?>
                <div class="meta">Posted: <?=htmlspecialchars(date('j M Y', strtotime($question['date'])), ENT_QUOTES, 'UTF-8')?> • Module: <?=htmlspecialchars($question['module'] ?? '', ENT_QUOTES, 'UTF-8')?></div>
            </div>

            <div class="content">
                <?= nl2br(htmlspecialchars($question['content'] ?? '', ENT_QUOTES, 'UTF-8')) ?>
            </div>

            <div class="actions">
                <?php if (!empty($_SESSION['user_id']) && isset($question['userid']) && $_SESSION['user_id'] == $question['userid']): ?>
                    <form action="delete_post.php" method="post" onsubmit="return confirm('Are you sure you want to delete this post?');" style="display:inline">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($question['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <input class="btn btn-danger btn-small" type="submit" value="Delete">
                    </form>
                <?php endif; ?>
            </div>

            <?php if (!empty($question['image'])): ?>
                <img src="images/<?= htmlspecialchars($question['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Post image">
            <?php endif; ?>

            

            <?php
                $comments = getCommentsByQuestion($pdo, $question['id']);
                include 'comment_post.html.php';
            ?>
        </article>
    <?php endforeach; ?>
<?php else: ?>
    <p>No questions to display.</p>
<?php endif; ?>
