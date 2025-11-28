<?php
session_start();
if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
try{
    include '../db/db.php';
    include '../db/db_function.php';
    
    deleteQuestion($pdo, $_POST['id']);
    header('location: question.php');

}catch (PDOException $e){
    $title = 'An error has occured';
    $output= 'Database error: ' . $e->getMessage();
}
include '../admin_templates/admin_layout.html.php';
?>