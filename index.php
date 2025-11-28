<?php
session_start();

// If logged in, redirect to appropriate question page
if (!empty($_SESSION['user_id'])) {
    if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
        header('Location: admin/question.php');
        exit;
    } else {
        header('Location: question.php');
        exit;
    }
}

$title = 'Student Forum';

try{
    include 'db/db.php';
    include 'db/db_function.php';
    
    $questions = getAllQuestions($pdo);
    
    // Load comments for each question and calculate avatar paths
    if (!empty($questions) && is_array($questions)) {
        foreach ($questions as $i => $q) {
            $questions[$i]['comments'] = getCommentsByQuestion($pdo, $q['id']);
            // Calculate avatar path for question author
            $questions[$i]['avatar_path'] = getAvatarPath($q['user_image'], '');
            // Calculate avatar path for each comment
            foreach ($questions[$i]['comments'] as $j => $c) {
                $questions[$i]['comments'][$j]['avatar_path'] = getAvatarPath($c['user_image'] ?? '', '');
            }
        }
    }
} catch (PDOException $e){
    $questions = [];
    echo '<div class="errors">Database error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</div>';
}

ob_start();
include 'templates/questions.html.php';

$output = ob_get_clean();
include 'templates/menu.html.php';
?>