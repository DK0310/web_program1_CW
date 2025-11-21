<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<?php if (!empty($comments) && is_array($comments)): ?>
    <div class="comments">
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <div style="font-size:0.85em;color:#666;">
                    <?= htmlspecialchars(date('j M Y H:i', strtotime($comment['date'])), ENT_QUOTES, 'UTF-8') ?> — 
                    <?= htmlspecialchars($comment['name'] ?? 'Anonymous', ENT_QUOTES, 'UTF-8') ?>
                    <?php if (!empty($comment['admin_id'])): ?>
                        (admin)
                    <?php elseif (!empty($comment['userid']) && isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['userid']): ?>
                        (author)
                    <?php endif; ?>
                </div>
                <div class="comment-content"><?= nl2br(htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8')) ?></div>

                <div class="comment-actions">
                    <?php if (!empty($_SESSION['admin_id']) || (!empty($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['userid'])): ?>
                        <form action="comment_post.php" method="post" style="display:inline">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <input type="submit" value="Delete" onclick="return confirm('Delete this comment?');">
                        </form>

                        <button onclick="document.getElementById('edit-form-<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>').style.display='block'">Edit</button>

                        <form id="edit-form-<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>" action="comment_post.php" method="post" style="display:none; margin-top:0.5em">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <textarea name="content" required><?= htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8') ?></textarea><br>
                            <input type="submit" value="Save">
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!empty($_SESSION['user_id']) || !empty($_SESSION['admin_id'])): ?>
    <form action="comment_post.php" method="post">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="questionid" value="<?= htmlspecialchars($question['id'], ENT_QUOTES, 'UTF-8') ?>">
        <label for="content">Add comment</label><br>
        <textarea name="content" id="content" required></textarea><br>
        <input type="submit" value="Post comment">
    </form>
<?php endif; ?>
