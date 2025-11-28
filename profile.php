<?php
session_start();
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    header('Location: admin/question.php');
    exit;
}
try{
    include 'db/db.php';
    include 'db/db_function.php';

    $userId = $_SESSION['user_id'];
    $user = query($pdo, 'SELECT id, name, email FROM user WHERE id = :id', [':id' => $userId])->fetch(PDO::FETCH_ASSOC);

    $error = '';
    $success = '';
    
    // Handle account deletion
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_account'])) {
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if ($confirmPassword === '') {
            $error = 'Please enter your password to confirm account deletion.';
        } else {
            // Verify password
            $userWithPassword = query($pdo, 'SELECT password FROM user WHERE id = :id', [':id' => $userId])->fetch(PDO::FETCH_ASSOC);
            
            if ($userWithPassword && password_verify($confirmPassword, $userWithPassword['password'])) {
                deleteUser($pdo, $userId);
                
                // Destroy session
                session_unset();
                session_destroy();
                
                // Redirect to home with success message
                header('Location: index.php');
                exit;
            } else {
                $error = 'Incorrect password. Account deletion cancelled.';
            }
        }
    }
    
    // Handle profile update
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['delete_account'])){
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($name === ''){
            $error = 'Name is required.';
        } elseif ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = 'Invalid email address.';
        } elseif ($email !== '' && query($pdo, 'SELECT id FROM user WHERE email = :email AND id != :id', [':email' => $email, ':id' => $userId])->fetch(PDO::FETCH_ASSOC)){
            $error = 'Email already registered.';
        } else {
            updateUserProfile($pdo, $userId, $name, $email);
            $_SESSION['user_name'] = $name;
            $user['name'] = $name;
            $user['email'] = $email;
            $success = 'Profile updated successfully.';
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
?>