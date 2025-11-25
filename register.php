<?php
session_start();
try{
    include 'db/db.php';
    include 'db/db_function.php';

    $error = '';
    $success = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        if ($name === '' || $password === '' || $password_confirm === ''){
            $error = 'Please fill required fields.';
        } elseif ($password !== $password_confirm){
            $error = 'Passwords do not match.';
        } elseif (getUserByName($pdo, $name)){
            $error = 'Username already taken.';
        } elseif ($email !== '' && query($pdo, 'SELECT id FROM user WHERE email = :email', [':email' => $email])->fetch(PDO::FETCH_ASSOC)){
            $error = 'Email already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $newId = createUser($pdo, $name, $hash, $email, 'user');
            if ($newId) {
                $_SESSION['user_id'] = $newId;
                $_SESSION['user_name'] = $name;
                $success = 'Registration successful.';
            } else {
                $error = 'Could not create user.';
            }
        }
    }

    $title = 'Register';
    ob_start();
    include 'templates/register.html.php';
    $output = ob_get_clean();

} catch (PDOException $e){
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}

include 'templates/menu.html.php';
?>