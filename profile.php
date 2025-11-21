<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
try{
    include 'db/db.php';
    include 'db/db_function.php';

    $userId = $_SESSION['user_id'];
    $user = query($pdo, 'SELECT id, name, email FROM user WHERE id = :id', [':id' => $userId])->fetch(PDO::FETCH_ASSOC);

    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        // handle updates from profile form
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($name === ''){
            $error = 'Name is required.';
        } elseif ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = 'Invalid email address.';
        } else {
            // update only name and email
            query($pdo, 'UPDATE user SET name = :name, email = :email WHERE id = :id', [':name' => $name, ':email' => $email, ':id' => $userId]);
            // refresh session name
            $_SESSION['user_name'] = $name;
            header('Location: profile.php');
            exit;
        }
    }

    $title = 'My Profile';
    ob_start();
    include 'templates/profile.html.php';
    $output = ob_get_clean();

} catch (PDOException $e){
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}

include 'templates/menu.html.php';
