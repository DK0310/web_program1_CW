<?php
session_start();
if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

try{
    include '../db/db.php';
    include '../db/db_function.php';

    $users = allUsers($pdo);
    $title = 'Users List';
    ob_start();
    include '../admin_templates/admin_viewuser.html.php';
    $output = ob_get_clean();

} catch (PDOException $e){
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}

include '../admin_templates/admin_layout.html.php';
