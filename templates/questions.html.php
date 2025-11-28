<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php if (!empty($questions) && is_array($questions)): ?>
    <?php foreach ($questions as $question): ?>
        <article class="question">
            <div class="meta">
                <?php if (!empty($question['avatar_path']) && file_exists($question['avatar_path'])): ?>
                    <img src="<?= htmlspecialchars($question['avatar_path'], ENT_QUOTES, 'UTF-8') ?>" alt="Avatar" class="avatar-img" style="width:32px;height:32px;border-radius:50%;object-fit:cover;vertical-align:middle;margin-right:8px;">
                <?php else: ?>
                    <div class="avatar" style="width:32px;height:32px;border-radius:50%;background:#eaf0ff;color:#4a6cf7;display:inline-flex;align-items:center;justify-content:center;font-size:1.1em;font-weight:700;vertical-align:middle;margin-right:8px;">
                        <?= strtoupper(substr($question['name'] ?? 'A',0,1)) ?>
                    </div>
                <?php endif; ?>
                <a href="user_profile.php?id=<?= htmlspecialchars($question['userid'], ENT_QUOTES, 'UTF-8') ?>" style="font-weight:600;color:#4a6cf7;text-decoration:none;">
                    <?= htmlspecialchars($question['name'], ENT_QUOTES, 'UTF-8') ?>
                </a>
                <br>
                <span style="font-size:0.95em; color:#444;">Posted: <?=htmlspecialchars(date('j M Y', strtotime($question['date'])), ENT_QUOTES, 'UTF-8')?> • Module: <?=htmlspecialchars($question['module'] ?? '', ENT_QUOTES, 'UTF-8')?></span>
            </div>
            <div class="content">
                <?= nl2br(htmlspecialchars($question['content'] ?? '', ENT_QUOTES, 'UTF-8')) ?>
            </div>
            <?php if (!empty($question['image'])): ?>
                <img src="images/<?= htmlspecialchars($question['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Post image">
            <?php endif; ?>
            <div class="actions">
                <?php if (!empty($_SESSION['user_id']) && isset($question['userid']) && $_SESSION['user_id'] == $question['userid']): ?>
                    <form action="delete_post.php" method="post" onsubmit="return confirm('Are you sure you want to delete this post?');" style="display:inline">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($question['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <input class="btn btn-danger btn-small" type="submit" value="Delete">
                    </form>
                <?php endif; ?>
            </div>
            <?php
                // make $comments available for the included template
                $comments = $question['comments'] ?? [];
                include 'comment_post.html.php';
            ?>
        </article>
    <?php endforeach; ?>
<?php else: ?>
    <p>No questions to display.</p>
<?php endif; ?>
