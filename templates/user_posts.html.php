<h2>My Posts</h2>
<?php if (!empty($posts)): ?>
    <?php foreach ($posts as $p): ?>
        <article class="question">
            <div class="meta">
                <?php if (!empty($p['avatar_path']) && file_exists($p['avatar_path'])): ?>
                    <img src="<?= htmlspecialchars($p['avatar_path'], ENT_QUOTES, 'UTF-8') ?>" alt="Avatar" class="avatar-img" style="width:32px;height:32px;border-radius:50%;object-fit:cover;vertical-align:middle;margin-right:8px;">
                <?php else: ?>
                    <div class="avatar" style="width:32px;height:32px;border-radius:50%;background:#eaf0ff;color:#4a6cf7;display:inline-flex;align-items:center;justify-content:center;font-size:1.1em;font-weight:700;vertical-align:middle;margin-right:8px;">
                        <?= strtoupper(substr($p['name'] ?? 'A',0,1)) ?>
                    </div>
                <?php endif; ?>
                <a href="user_profile.php?id=<?= htmlspecialchars($p['userid'], ENT_QUOTES, 'UTF-8') ?>" style="font-weight:600;color:#4a6cf7;text-decoration:none;">
                    <?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?>
                </a>
                <span style="font-size:0.95em; color:#444; margin-left:8px;">Posted: <?=htmlspecialchars(date('j M Y', strtotime($p['date'])), ENT_QUOTES, 'UTF-8')?> • Module: <?= htmlspecialchars($p['module'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
            </div>

            <div class="content">
                <?= nl2br(htmlspecialchars($p['content'] ?? '', ENT_QUOTES, 'UTF-8')) ?>
            </div>

            <?php if (!empty($p['image'])): ?>
                <img src="images/<?= htmlspecialchars($p['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Post image">
            <?php endif; ?>

            <div class="actions" style="margin-top:8px;display:flex;gap:8px;align-items:center;">
                <a class="btn" href="edit_question.php?id=<?= urlencode($p['id']) ?>" style="padding:6px 14px;font-size:0.9em;">Edit</a>
                <form action="delete_post.php" method="post" style="display:inline;margin:0;" onsubmit="return confirm('Delete this post?');">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>">
                    <input class="btn btn-danger" type="submit" value="Delete" style="padding:6px 14px;font-size:0.9em;">
                </form>
            </div>
        </article>
    <?php endforeach; ?>
<?php else: ?>
    <p>You have not posted anything yet.</p>
<?php endif; ?>