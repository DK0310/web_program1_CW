<?php
session_start();
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    header('Location: admin/question.php');
    exit;
}
try{
    include 'db/db.php';
    include 'db/db_function.php';

    // Get current user name from database for accurate display
    $currentUserName = '';
    if (!empty($_SESSION['user_id'])) {
        $currentUserData = getCurrentUser($pdo, $_SESSION['user_id']);
        $currentUserName = $currentUserData['name'] ?? $_SESSION['user_name'] ?? 'User';
    }

    $userId = $_SESSION['user_id'];
    $all = getAllQuestions($pdo);
    $posts = array_filter($all, function($q) use ($userId){
        return isset($q['userid']) && $q['userid'] == $userId;
    });
    
    // Calculate avatar path for each post
    foreach ($posts as &$post) {
        $post['avatar_path'] = getAvatarPath($post['user_image'] ?? '', '');
    }
    unset($post);

    $title = 'My Posts';
    ob_start();
    include 'templates/user_posts.html.php';
    $output = ob_get_clean();

} catch (PDOException $e){
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}
include 'templates/menu.html.php';
?>