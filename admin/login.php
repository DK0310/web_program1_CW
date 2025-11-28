<?php
session_start();
// If already logged in as admin, redirect to admin home
if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    header('Location: question.php');
    exit;
}
// If logged in as regular user, redirect to user home
if (!empty($_SESSION['user_id']) && (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin')) {
    header('Location: ../index.php');
    exit;
}
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
            $admin = getAdminByName($pdo, $name); // returns user row if role='admin'
            if ($admin && !empty($admin['password']) && (password_verify($password, $admin['password']) || $admin['password'] === $password)){
                // login success - store as normal user with admin role
                $_SESSION['user_id'] = $admin['id'];
                $_SESSION['user_name'] = $admin['name'];
                $_SESSION['user_role'] = $admin['role'] ?? 'admin';
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
?>