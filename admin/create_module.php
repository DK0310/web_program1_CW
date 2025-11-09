<?php
session_start();
if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
try{
    include '../db/db.php';
    include '../db/db_function.php';

    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $name = trim($_POST['name'] ?? '');
        if ($name === ''){
            $error = 'Module name required.';
        } else {
            query($pdo, 'INSERT INTO module (name) VALUES (:name)', [':name' => $name]);
            header('Location: question.php');
            exit;
        }
    }

    $title = 'Create Module';
    ob_start();
    include '../admin_templates/create_module.html.php';
    $output = ob_get_clean();

} catch (PDOException $e){
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}
include '../admin_templates/admin_layout.html.php';
