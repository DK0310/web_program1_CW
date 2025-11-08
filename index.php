<?php
session_start();
// Redirect admin users to admin area
if (!empty($_SESSION['admin_id'])) {
    header('Location: admin/question.php');
    exit;
}
// If not logged in as a user, send to login choice screen
if (empty($_SESSION['user_id'])) {
    header('Location: login_choice.php');
    exit;
}

$title = 'Student Management System';
ob_start();
include 'templates/greet.html.php';

try{
    include 'db/db.php';
    include 'db/db_function.php';
    $questions = getAllQuestions($pdo);
} catch (PDOException $e){
    $questions = [];
    echo '<div class="errors">Database error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</div>';
}


include 'templates/questions.html.php';

$output = ob_get_clean();
include 'templates/menu.html.php';
?>