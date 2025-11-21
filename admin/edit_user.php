<?php
session_start();
if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
try {
    include '../db/db.php';
    include '../db/db_function.php';

    $error = '';
    $id = $_GET['id'] ?? $_POST['id'] ?? null;
    if (!$id) throw new Exception('Missing id');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($name === '') {
            $error = 'Name is required.';
        } elseif ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Invalid email address.';
        } else {
            query($pdo, 'UPDATE user SET name = :name, email = :email WHERE id = :id', [':name' => $name, ':email' => $email !== '' ? $email : null, ':id' => $id]);
            header('Location: users.php');
            exit;
        }
    }

    // fetch user for prefilling
    $user = query($pdo, 'SELECT * FROM user WHERE id = :id', [':id' => $id])->fetch(PDO::FETCH_ASSOC);
    if (!$user) throw new Exception('User not found');

    $title = 'Edit User';
    ob_start();
    include '../admin_templates/edit_user.html.php';
    $output = ob_get_clean();

} catch (Exception $e) {
    $title = 'An error has occured';
    $output = 'Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
include '../admin_templates/admin_layout.html.php';
