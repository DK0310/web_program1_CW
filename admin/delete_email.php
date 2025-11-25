<?php
session_start();

try{
    include '../db/db.php';
    include '../db/db_function.php';

    $id = $_POST['id'] ?? null;
    if (!$id) throw new Exception('Missing id');

    deleteEmail($pdo, $id);

    header('Location: view_emails.php');
    exit;
} catch (Exception $e){
    $title = 'An error has occured';
    $output = 'Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
include '../admin_templates/admin_layout.html.php';