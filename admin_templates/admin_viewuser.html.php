<?php if (!empty($users) && is_array($users)): ?>
    <table>
        <thead>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <?php if ($user['role'] === 'admin') continue; ?> 
                <tr>
                    <td><?= htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <form action="delete_user.php" method="post" 
                              onsubmit="return confirm('Delete this user and their questions?');" 
                              style="display:inline">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <input class="btn btn-danger btn-small" type="submit" value="Delete">
                        </form>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No users.</p>
<?php endif; ?>
