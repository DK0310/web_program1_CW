<?php
session_start();
try{
    include '../db/db.php';
    include '../db/db_function.php';

    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $name = trim($_POST['name'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($name === '' || $password === ''){
            $error = 'Username and password are required.';
        } else {
            $admin = getAdminByName($pdo, $name);
            // plain-text comparison because admin passwords are stored unhashed
            if ($admin && isset($admin['password']) && $admin['password'] === $password){
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                header('Location: question.php');
                exit;
            } else {
                $error = 'Invalid admin credentials.';
            }
        }
    }

    $title = 'Admin Login';
    ob_start();
    include '../admin_templates/login.html.php';
    $output = ob_get_clean();

} catch (PDOException $e){
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}

include '../admin_templates/admin_layout.html.php';
