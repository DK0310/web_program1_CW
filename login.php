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
            if ($user && !empty($user['password']) && password_verify($password, $user['password'])){
                // login success
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header('Location: question.php');
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
