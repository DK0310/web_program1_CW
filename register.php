<?php
session_start();
try{
    include 'db/db.php';
    include 'db/db_function.php';

    $mailConfig = [];
    if (file_exists(__DIR__ . '/config/mail.php')) {
        $mailConfig = include __DIR__ . '/config/mail.php';
    }

    $error = '';
    $success = '';
    $showVerifyForm = false;
    
    // Step 2: Verify code and create account
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_code'])) {
        $inputCode = trim($_POST['code'] ?? '');
        
        // Check if code expired
        if (time() > ($_SESSION['register_expires'] ?? 0)) {
            $error = 'Verification code expired. Please try again.';
            unset($_SESSION['register_code'], $_SESSION['register_data'], $_SESSION['register_expires']);
        }
        // Check if code matches
        elseif ($inputCode == ($_SESSION['register_code'] ?? '')) {
            // Code correct - create account
            $data = $_SESSION['register_data'];
            $hash = password_hash($data['password'], PASSWORD_DEFAULT);
            $newId = createUser($pdo, $data['name'], $hash, $data['email'], 'user');
            
            if ($newId) {
                $_SESSION['user_id'] = $newId;
                $_SESSION['user_name'] = $data['name'];
                
                // Clear registration session data
                unset($_SESSION['register_code'], $_SESSION['register_data'], $_SESSION['register_expires']);
                
                header('Location: index.php');
                exit;
            } else {
                $error = 'Could not create user.';
            }
        } else {
            $error = 'Incorrect verification code.';
            $showVerifyForm = true;
        }
    }
    // Step 1: Validate form and send verification code
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_code'])) {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        if ($name === '' || $email === '' || $password === '' || $password_confirm === ''){
            $error = 'Please fill all required fields including email.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } elseif ($password !== $password_confirm){
            $error = 'Passwords do not match.';
        } elseif (getUserByNameEmail($pdo, $name, $email)){
            $error = 'Username or email already taken.';
        } else {
            // Generate verification code
            $code = random_int(100000, 999999);
            
            // Store in session
            $_SESSION['register_code'] = $code;
            $_SESSION['register_data'] = [
                'name' => $name,
                'email' => $email,
                'password' => $password
            ];
            $_SESSION['register_expires'] = time() + 300; // 5 minutes
            
            // Send verification email
            $sent = sendPasswordResetCodeByEmail($mailConfig, $email, $name, $code);
            
            if ($sent) {
                $success = 'Verification code sent to your email. Please check and enter the code below.';
                $showVerifyForm = true;
            } else {
                $error = 'Failed to send verification email. Please try again.';
                unset($_SESSION['register_code'], $_SESSION['register_data'], $_SESSION['register_expires']);
            }
        }
    }
    // Check if already in verification process
    elseif (!empty($_SESSION['register_code']) && time() <= ($_SESSION['register_expires'] ?? 0)) {
        $showVerifyForm = true;
        $success = 'Please enter the verification code sent to your email.';
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