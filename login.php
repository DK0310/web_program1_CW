<?php
session_start();
try{
    include 'db/db.php';
    include 'db/db_function.php';

    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $name = trim($_POST['name'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($name === '' || $password === ''){
            $error = 'Username and password are required.';
        } else {
            $user = getUserByName($pdo, $name);
            if ($user && !empty($user['password']) && (password_verify($password, $user['password']) || $user['password'] === $password)){
                // login success
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'] ?? 'user';
                // redirect admin users to admin area
                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                    header('Location: admin/question.php');
                } else {
                    header('Location: question.php');
                }
                exit;
            } else {
                $error = 'Invalid credentials.';
            }
        }
    }

    $title = 'Login';
    ob_start();
    include 'templates/login.html.php';
    $output = ob_get_clean();

} catch (PDOException $e){
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}

include 'templates/menu.html.php';
?>