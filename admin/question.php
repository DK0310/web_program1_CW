<?php
session_start();
try {
    include '../db/db.php';
    include '../db/db_function.php';

    $questions = getAllQuestions($pdo);
    if (!empty($questions) && is_array($questions)) {
        foreach ($questions as $i => $q) {
            $questions[$i]['comments'] = getCommentsByQuestion($pdo, $q['id']);
        }
    }

    $title = 'Questions List';

    ob_start();
    include '../admin_templates/greet.html.php';
    include '../admin_templates/admin_question.html.php'; 
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}

include '../admin_templates/admin_layout.html.php';
?>