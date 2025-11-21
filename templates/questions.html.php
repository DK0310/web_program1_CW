<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php if (!empty($questions) && is_array($questions)): ?>
    <?php foreach ($questions as $question): ?>
        <blockquote>
            <?= nl2br(htmlspecialchars($question['content'] ?? '', ENT_QUOTES, 'UTF-8')) ?><br>
            <div style="font-size:0.9em; color:#666; margin-bottom:0.5em;">Posted: <?=htmlspecialchars(date('j M Y', strtotime($question['date'])), ENT_QUOTES, 'UTF-8')?></div>

            (by <?php if (!empty($question['email'])): ?>
                <a href="mailto:<?=htmlspecialchars($question['email'], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars($question['name'] ?? 'Anonymous', ENT_QUOTES, 'UTF-8')?></a>
            <?php else: ?>
                <?=htmlspecialchars($question['name'] ?? 'Anonymous', ENT_QUOTES, 'UTF-8')?>
            <?php endif; ?>)
       
            <br>
            <div style="font-size:0.9em; color:#666; margin-bottom:0.5em;">Module: <?=htmlspecialchars($question['module'] ?? '', ENT_QUOTES, 'UTF-8')?></div>
            <br>
            <?php if (!empty($question['image'])): ?>
                <img height="150px" src="images/<?= htmlspecialchars($question['image'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php endif; ?>

            <?php if (!empty($_SESSION['user_id']) && isset($question['userid']) && $_SESSION['user_id'] == $question['userid']): ?>
            <form action="delete_post.php" method="post"
                  onsubmit="return confirm('Are you sure you want to delete this post?');">
                <input type="hidden" name="id"
                       value="<?= htmlspecialchars($question['id'], ENT_QUOTES, 'UTF-8') ?>">
                <input type="submit" value="Delete">
            </form>
            <?php endif; ?>

            <?php
                // load comments for this question
                $comments = getCommentsByQuestion($pdo, $question['id']);
                include 'comment_post.html.php';
            ?>
        </blockquote>
    <?php endforeach; ?>
<?php else: ?>
    <p>No questions to display.</p>
<?php endif; ?>
