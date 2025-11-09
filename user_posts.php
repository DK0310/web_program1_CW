<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
try{
    include 'db/db.php';
    include 'db/db_function.php';

    $userId = $_SESSION['user_id'];
    $all = getAllQuestions($pdo);
    $posts = array_filter($all, function($q) use ($userId){
        return isset($q['userid']) && $q['userid'] == $userId;
    });

    $title = 'My Posts';
    ob_start();
    include 'templates/user_posts.html.php';
    $output = ob_get_clean();

} catch (PDOException $e){
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}
include 'templates/menu.html.php';
