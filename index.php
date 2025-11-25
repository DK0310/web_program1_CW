<?php
session_start();

$title = 'Student Forum';
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