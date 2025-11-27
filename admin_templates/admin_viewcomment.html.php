<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<?php if (!empty($comments) && is_array($comments)): ?>
    <div class="comments">
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <div class="avatar"><?= strtoupper(substr($comment['name'] ?? 'A',0,1)) ?></div>
                <div class="body">
                    <div class="meta">
                        <strong><?= htmlspecialchars($comment['name'] ?? 'User', ENT_QUOTES, 'UTF-8') ?></strong>
                        <?php if (!empty($comment['role']) && $comment['role'] === 'admin'): ?>
                            <span style="background:#4a6cf7;color:white;padding:2px 8px;border-radius:10px;font-size:0.75em;">ADMIN</span>
                        <?php elseif (isset($question['userid']) && $comment['userid'] == $question['userid']): ?>
                            <span style="background:#28a745;color:white;padding:2px 8px;border-radius:10px;font-size:0.75em;">AUTHOR</span>
                        <?php endif; ?>
                        <span style="color:#999;margin-left:4px;"><?= htmlspecialchars(date('j M Y', strtotime($comment['date'] ?? '')), ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                    <div class="content"><?= nl2br(htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8')) ?></div>

                    <div class="comment-actions" id="actions-<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <?php 
                        $isAdmin = !empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
                        $isOwner = !empty($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['userid'];
                        ?>
                        
                        <?php if ($isOwner): ?>
                            <button class="btn btn-small" onclick="document.getElementById('edit-form-<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>').style.display='block';document.getElementById('actions-<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>').style.display='none'">Edit</button>
                        <?php endif; ?>

                        <?php if ($isAdmin || $isOwner): ?>
                            <form action="../admin/comment_post.php" method="post" style="display:inline" onsubmit="return confirm('Delete this comment?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>">
                                <input class="btn btn-danger btn-small" type="submit" value="Delete">
                            </form>
                        <?php endif; ?>
                    </div>

                    <?php if ($isOwner): ?>
                        <form id="edit-form-<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>" action="../admin/comment_post.php" method="post" style="display:none; margin-top:0.5em">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <textarea name="content" required><?= htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8') ?></textarea>
                            <div style="margin-top:6px;display:flex;gap:8px;">
                                <input class="btn" type="submit" value="Save">
                                <button type="button" class="btn ghost" onclick="document.getElementById('edit-form-<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>').style.display='none';document.getElementById('actions-<?= htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8') ?>').style.display='block'">Cancel</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!empty($_SESSION['user_id']) || (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin')): ?>
    <form action="../admin/comment_post.php" method="post" style="margin-top:16px;">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="questionid" value="<?= htmlspecialchars($question['id'], ENT_QUOTES, 'UTF-8') ?>">
        <label for="content">Add comment</label>
        <textarea name="content" id="content" required></textarea>
        <div class="actions" style="justify-content:flex-end">
            <input class="btn" type="submit" value="Post comment">
        </div>
    </form>
<?php endif; ?>