<?php
session_start();
try{
    include 'db/db.php';
    include 'db/db_function.php';

    $error = '';
    $success = '';
    
    // Check for password reset success
    if (isset($_GET['reset']) && $_GET['reset'] == '1') {
        $success = 'Your password has been reset successfully! You can now login with your new password.';
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $identifier = trim($_POST['name'] ?? ''); // username or email
        $password = $_POST['password'] ?? '';

        if ($identifier === '' || $password === ''){
            $error = 'Username or email, and password are required.';
        } else {
            // use helper to find user by username OR email
            // pass identifier twice in case the helper expects both params
            $user = null;

            $user = getUserByNameEmail($pdo, $identifier, $identifier);

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