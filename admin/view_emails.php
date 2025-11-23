<?php
session_start();
try{
    include '../db/db.php';
    include '../db/db_function.php';

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