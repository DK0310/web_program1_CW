<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<?php if (!empty($comments) && is_array($comments)): ?>
    <div class="comments">
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <div class="avatar"><?= strtoupper(substr($comment['name'] ?? 'A',0,1)) ?></div>
                <div class="body">
                    <div class="meta"><strong><?= htmlspecialchars($comment['name'] ?? 'User', ENT_QUOTES, 'UTF-8') ?></strong>
                        <span style="color:var(--muted);margin-left:8px;font-size:0.9rem"><?= htmlspecialchars(date('j M Y, H:i', strtotime($comment['date'] ?? '')), ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                    <div class="content"><?= nl2br(htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8')) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!empty($_SESSION['user_id']) || (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin')): ?>
    <form action="../admin/comment_post.php" method="post" class="card">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="questionid" value="<?= htmlspecialchars($question['id'], ENT_QUOTES, 'UTF-8') ?>">
        <label for="content">Add comment</label>
        <textarea name="content" id="content" required></textarea>
        <div class="actions" style="display:flex;justify-content:flex-end">
            <input class="btn" type="submit" value="Post comment">
        </div>
    </form>
<?php endif; ?>
