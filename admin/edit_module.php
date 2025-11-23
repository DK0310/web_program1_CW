<?php
session_start();
try {
    include '../db/db.php';
    include '../db/db_function.php';

    $error = '';
    $id = $_GET['id'] ?? $_POST['id'] ?? null;
    if (!$id) throw new Exception('Missing id');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            $error = 'Module name required.';
        } else {
            query($pdo, 'UPDATE module SET name = :name WHERE id = :id', [':name' => $name, ':id' => $id]);
            header('Location: manage_module.php');
            exit;
        }
    }

    $module = query($pdo, 'SELECT * FROM module WHERE id = :id', [':id' => $id])->fetch(PDO::FETCH_ASSOC);
    if (!$module) throw new Exception('Module not found');

    $title = 'Edit Module';
    ob_start();
    include '../admin_templates/edit_module.html.php';
    $output = ob_get_clean();

} catch (Exception $e) {
    $title = 'An error has occured';
    $output = 'Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
include '../admin_templates/admin_layout.html.php';
?>