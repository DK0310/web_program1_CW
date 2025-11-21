<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<?php if (!empty($comments) && is_array($comments)): ?>
    <div class="comments">
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <div class="comment-meta">
                    <?= htmlspecialchars(date('j M Y', strtotime($comment['date'])), ENT_QUOTES, 'UTF-8') ?> — 
                    <strong><?= htmlspecialchars($comment['name'] ?? 'Anonymous', ENT_QUOTES, 'UTF-8') ?></strong>
                    <?php if (!empty($comment['role']) && $comment['role'] === 'admin'): ?>
                        <span>(admin)</span>
                    <?php elseif (isset($question['userid']) && $comment['userid'] == $question['userid']): ?>
                        <span>(author)</span>
                    <?php endif; ?>
                </div>
                <div class="comment-content"><?= nl2br(htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8')) ?></div>

                <div class="comment-actions">
                    <?php if ((!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') || (!empty($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['userid'])): ?>
                        <form action="comment_post.php" method="post" style="display:inline">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <input class="btn ghost" type="submit" value="Delete" onclick="return confirm('Delete this comment?');">
                        </form>

                        <button class="btn" onclick="document.getElementById('edit-form-<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>').style.display='block'">Edit</button>

                        <form id="edit-form-<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>" action="comment_post.php" method="post" style="display:none; margin-top:0.5em">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <textarea name="content" required><?= htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8') ?></textarea>
                            <div style="margin-top:6px">
                                <input class="btn" type="submit" value="Save">
                                <button type="button" class="btn ghost" onclick="this.parentNode.parentNode.style.display='none'">Cancel</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!empty($_SESSION['user_id']) || !empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
    <form action="comment_post.php" method="post">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="questionid" value="<?= htmlspecialchars($question['id'], ENT_QUOTES, 'UTF-8') ?>">
        <label for="content">Add comment</label>
        <textarea name="content" id="content" required></textarea>
        <div class="actions">
            <input class="btn" type="submit" value="Post comment">
        </div>
    </form>
<?php endif; ?>
