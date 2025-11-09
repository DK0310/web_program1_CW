<?php
session_start();
try{
    include 'db/db.php';
    include 'db/db_function.php';

    $id = $_POST['id'] ?? null;
    if (!$id) {
        throw new Exception('Missing id');
    }

    // if admin logged in, allow delete
    if (!empty($_SESSION['admin_id'])){
        deleteQuestion($pdo, $id);
        header('location: admin/question.php');
        exit;
    }

    // if user logged in, ensure they own the question
    if (!empty($_SESSION['user_id'])){
        $questions = getAllQuestions($pdo);
        $found = null;
        foreach ($questions as $question){
            if ($question['id'] == $id){
                $found = $question;
                break;
            }
        }
        if (!$found){
            throw new Exception('Question not found');
        }
        if ($found['userid'] != $_SESSION['user_id']){
            throw new Exception('Not allowed to delete this question');
        }

        deleteQuestion($pdo, $id);
        header('location: question.php');
        exit;
    }

    // otherwise redirect to login
    header('Location: login.php');

}catch (Exception $e){
    $title = 'An error has occured';
    $output= 'Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
include 'templates/menu.html.php';