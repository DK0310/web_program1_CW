<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if(isset($_POST['content'])){
    try{
        include 'db/db.php';
        include 'db/db_function.php';

        $imagePath = handleImageUpload();

        $userid = $_SESSION['user_id'];
        $moduleid = $_POST['moduleid'] ?? null;

        insertQuestion($pdo, $_POST['content'], $userid, $moduleid, $imagePath);
        header('location: question.php');
    }catch (PDOException $e){
        $title = 'An error has occured';
        $output = 'Database error: ' . $e->getMessage();
    }
}else{
    include 'db/db.php'; 
    include 'db/db_function.php';
    $title = 'Add a new question';
    $modules = allModules($pdo);
    ob_start();
    include 'templates/addquestion.html.php';
    $output = ob_get_clean();
}
include 'templates/menu.html.php';
?>