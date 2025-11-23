<?php
session_start();
try{
    include '../db/db.php';
    include '../db/db_function.php';

    $modules = allModules($pdo);
    $title = 'Manage Modules';
    ob_start();
    include '../admin_templates/manage_module.html.php';
    $output = ob_get_clean();

} catch (PDOException $e){
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}
include '../admin_templates/admin_layout.html.php';
?>