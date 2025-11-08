<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

try {
    include 'db/db.php';
    include 'db/db_function.php';
    
    $questions = getAllQuestions($pdo);

    $title = 'Questions List';

    ob_start();
    include 'templates/questions.html.php'; 
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}

include 'templates/menu.html.php';
