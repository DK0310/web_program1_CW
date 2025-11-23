<?php
session_start();
if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
try{
    include '../db/db.php';
    include '../db/db_function.php';

    $id = $_POST['id'] ?? null;
    if (!$id) throw new Exception('Missing id');

    deleteModule($pdo, $id);
    clearModuleFromQuestions($pdo, $id);

    header('Location: manage_module.php');
    exit;
} catch (Exception $e){
    $title = 'An error has occured';
    $output = 'Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
include '../admin_templates/admin_layout.html.php';
?>