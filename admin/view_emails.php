<?php
session_start();
if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
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

    $emails = getAllEmails($pdo);
    $title = 'User Emails';
    ob_start();
    include '../admin_templates/view_email.html.php';
    $output = ob_get_clean();

} catch (PDOException $e){
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}

include '../admin_templates/admin_layout.html.php';
?>