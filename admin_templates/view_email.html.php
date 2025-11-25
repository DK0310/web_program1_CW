<h2>User Messages</h2>
<?php if (!empty($emails) && is_array($emails)): ?>
    <table>
        <thead><tr><th>ID</th><th>User</th><th>Email</th><th>Message</th><th>Date</th></tr></thead>
        <tbody>
            <?php foreach ($emails as $e): ?>
                <tr>
                    <td><?= htmlspecialchars($e['id'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($e['username'] ?? 'Unknown', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($e['useremail'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= nl2br(htmlspecialchars($e['content'], ENT_QUOTES, 'UTF-8')) ?></td>
                    <td><?= htmlspecialchars(date('j M Y', strtotime($e['date'] ?? '')), ENT_QUOTES, 'UTF-8') ?>

                    <form action="delete_email.php" method="post" onsubmit="return confirm('Delete this email?');" style="display:inline">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($e['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <input class="btn btn-danger btn-small" type="submit" value="Delete">
                    </form>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No messages.</p>
<?php endif; ?>
