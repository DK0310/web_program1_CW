<?php
session_start();
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    header('Location: admin/question.php');
    exit;
}

try{
    include 'db/db.php';
    include 'db/db_function.php';

    $id = $_GET['id'] ?? null;
    if (!$id) throw new Exception('Missing id');

    $q = getQuestion($pdo, $id);
    if (!$q) throw new Exception('Not found');
    if ($q['userid'] != $_SESSION['user_id']) throw new Exception('Not allowed');

    $modules = allModules($pdo);
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $content = $_POST['content'] ?? '';
        $moduleid = $_POST['moduleid'] ?? null;
        editQuestion($pdo, $id, $content, $moduleid);
        header('Location: user_posts.php');
        exit;
    }

    $title = 'Edit Question';
    ob_start();
    include 'templates/edit_question.html.php';
    $output = ob_get_clean();

} catch (Exception $e){
    $title = 'An error has occured';
    $output = 'Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
include 'templates/menu.html.php';
?>