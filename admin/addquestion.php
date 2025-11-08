<?php 
if(isset($_POST['content'])){
    try{
        include '../db/db.php';
        include '../db/db_function.php';

        $imagePath = handleImageUpload();
        
        insertQuestion($pdo, $_POST['content'], $_POST['userid'], $_POST['moduleid'], $imagePath);
        header('location: question.php');
    }catch (PDOException $e){
        $title = 'An error has occured';
        $output = 'Database error: ' . $e->getMessage();
    }
}else{
    include 'db/db.php'; 
    include '../db/db_function.php';
    $title = 'Add a new question';
    $users = allUsers($pdo);
    $modules = allModules($pdo);
    ob_start();
    include '../admin_templates/admin_question.html.php';
    $output = ob_get_clean();
}
include '../admin_templates/admin_layout.html.php';
?>