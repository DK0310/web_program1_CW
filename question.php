<?php
session_start();
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    header('Location: admin/question.php');
    exit;
}

try {
    include 'db/db.php';
    include 'db/db_function.php';
    
    // Get current user name from database for accurate display
    $currentUserName = '';
    if (!empty($_SESSION['user_id'])) {
        $currentUserData = getCurrentUser($pdo, $_SESSION['user_id']);
        $currentUserName = $currentUserData['name'] ?? $_SESSION['user_name'] ?? 'User';
    }
    
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

    $title = 'Questions List';

    ob_start();
    include 'templates/greet.html.php';
    include 'templates/questions.html.php'; 
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}

include 'templates/menu.html.php';
?>