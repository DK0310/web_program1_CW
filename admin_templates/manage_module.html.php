<h2>Manage Modules</h2>

<p><a class="btn" href="create_module.php">Create new module</a></p>

<?php if (!empty($modules) && is_array($modules)): ?>
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($modules as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['id'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($m['name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <a class="btn btn-small" href="edit_module.php?id=<?= rawurlencode($m['id']) ?>">Edit</a>
                        <form action="delete_module.php" method="post" onsubmit="return confirm('Delete this module?');" style="display:inline">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($m['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <input class="btn btn-danger btn-small" type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No modules yet.</p>
<?php endif; ?>