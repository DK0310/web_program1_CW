<h2>Manage Modules</h2>

<p><a href="create_module.php">Create new module</a></p>

<?php if (!empty($modules) && is_array($modules)): ?>
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($modules as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['id'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($m['name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <form action="delete_module.php" method="post" onsubmit="return confirm('Delete this module?');">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($m['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No modules yet.</p>
<?php endif; ?>
