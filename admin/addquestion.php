<?php 
session_start();
if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
try{
    include '../db/db.php';
    include '../db/db_function.php';

    // Get current admin name from database for accurate display
    $currentUserName = '';
    if (!empty($_SESSION['user_id'])) {
        $currentUserData = getCurrentUser($pdo, $_SESSION['user_id']);
        $currentUserName = $currentUserData['name'] ?? $_SESSION['user_name'] ?? 'Admin';
    }

    $modules = allModules($pdo);
    $error = '';
    $success = '';

    // current admin user as author

    $userid = $_SESSION['user_id'] ?? null;
    if (empty($userid)) {
        throw new Exception('Admin user not identified in session.');
    }

    if(isset($_POST['content'])){
        $imagePath = handleImageUpload();
        insertQuestion($pdo, $_POST['content'], $userid, $_POST['moduleid'] ?? null, $imagePath);
        $success = 'Question added successfully.';
        header('location: question.php');
        exit;
    }

    $title = 'Add a new question';
    ob_start();
    include '../admin_templates/addquestion.html.php';
    $output = ob_get_clean();

} catch (Exception $e){
    $title = 'An error has occured';
    $output = 'Error: ' . $e->getMessage();
}
include '../admin_templates/admin_layout.html.php';
?>