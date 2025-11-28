<?php
session_start();
if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

try{
    include '../db/db.php';
    include '../db/db_function.php';

    $id = $_POST['id'] ?? null;
    if (!$id) throw new Exception('Missing id');

    deleteUser($pdo, $id);
    header('Location: users.php');
    exit;
} catch (Exception $e){
    $title = 'An error has occured';
    $output = 'Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
include '../admin_templates/admin_layout.html.php';
?>