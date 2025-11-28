<?php
session_start();
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    header('Location: admin/question.php');
    exit;
}
try{
    include 'db/db.php';
    include 'db/db_function.php';

    $mailConfig = [];
    if (file_exists(__DIR__ . '/config/mail.php')) {
        $mailConfig = include __DIR__ . '/config/mail.php';
    }

    $userId = $_SESSION['user_id'];
    $user = query($pdo, 'SELECT id, name, email, user_image, description FROM user WHERE id = :id', [':id' => $userId])->fetch(PDO::FETCH_ASSOC);
    
    // Current user name for nav display (will be updated after profile save)
    $currentUserName = $user['name'] ?? $_SESSION['user_name'] ?? 'User';

    $error = '';
    $success = '';
    $showEmailVerifyForm = false;
    
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
    
    // Handle email verification code submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_email_code'])) {
        $inputCode = trim($_POST['email_code'] ?? '');
        
        // Check if code expired
        if (time() > ($_SESSION['email_change_expires'] ?? 0)) {
            $error = 'Verification code expired. Please try again.';
            unset($_SESSION['email_change_code'], $_SESSION['email_change_data'], $_SESSION['email_change_expires']);
        }
        // Check if code matches
        elseif ($inputCode == ($_SESSION['email_change_code'] ?? '')) {
            // Code correct - update profile with new email
            $data = $_SESSION['email_change_data'];
            
            query($pdo, 'UPDATE user SET name = :name, email = :email, user_image = :user_image, description = :description WHERE id = :id', [
                ':name' => $data['name'],
                ':email' => $data['new_email'],
                ':user_image' => $data['user_image'],
                ':description' => $data['description'],
                ':id' => $userId
            ]);
            
            // Update session
            $_SESSION['user_name'] = $data['name'];
            $_SESSION['user_email'] = $data['new_email'];
            $currentUserName = $data['name'];
            
            // Clear email change session data
            unset($_SESSION['email_change_code'], $_SESSION['email_change_data'], $_SESSION['email_change_expires']);
            
            $success = 'Profile and email updated successfully.';
            $user = query($pdo, 'SELECT id, name, email, user_image, description FROM user WHERE id = :id', [':id' => $userId])->fetch(PDO::FETCH_ASSOC);
        } else {
            $error = 'Incorrect verification code.';
            $showEmailVerifyForm = true;
        }
    }
    // Cancel email change
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_email_change'])) {
        unset($_SESSION['email_change_code'], $_SESSION['email_change_data'], $_SESSION['email_change_expires']);
        $success = 'Email change cancelled.';
    }
    // Handle profile update
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['delete_account']) && !isset($_POST['verify_email_code'])) {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $user_image = $user['user_image'] ?? null;
        
        // Handle image upload
        if (!empty($_FILES['user_image']['name'])) {
            $imgName = basename($_FILES['user_image']['name']);
            $fileName = uniqid('avatar_') . '_' . $imgName;
            $targetPath = 'images/' . $fileName;
            if (move_uploaded_file($_FILES['user_image']['tmp_name'], $targetPath)) {
                $user_image = $fileName;
            } else {
                $error = 'Failed to upload image.';
            }
        }
        
        // Email duplicate check
        if (!empty($email)) {
            $exists = query($pdo, 'SELECT id FROM user WHERE email = :email AND id != :id', [':email' => $email, ':id' => $userId])->fetch(PDO::FETCH_ASSOC);
            if ($exists) {
                $error = 'Email already in use.';
            }
        }
        
        if (empty($error)) {
            // Check if email is being changed
            $emailChanged = !empty($email) && $email !== ($user['email'] ?? '');
            
            if ($emailChanged) {
                // Validate email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = 'Please enter a valid email address.';
                } else {
                    // Send verification code to new email
                    $code = random_int(100000, 999999);
                    
                    $_SESSION['email_change_code'] = $code;
                    $_SESSION['email_change_data'] = [
                        'name' => $name,
                        'new_email' => $email,
                        'user_image' => $user_image,
                        'description' => $description
                    ];
                    $_SESSION['email_change_expires'] = time() + 300; // 5 minutes
                    
                    $sent = sendPasswordResetCodeByEmail($mailConfig, $email, $name, $code);
                    
                    if ($sent) {
                        $success = 'Verification code sent to ' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . '. Please enter the code to confirm email change.';
                        $showEmailVerifyForm = true;
                    } else {
                        $error = 'Failed to send verification email. Please try again.';
                        unset($_SESSION['email_change_code'], $_SESSION['email_change_data'], $_SESSION['email_change_expires']);
                    }
                }
            } else {
                // No email change - update directly
                query($pdo, 'UPDATE user SET name = :name, email = :email, user_image = :user_image, description = :description WHERE id = :id', [
                    ':name' => $name,
                    ':email' => $email ?: $user['email'],
                    ':user_image' => $user_image,
                    ':description' => $description,
                    ':id' => $userId
                ]);
                
                $_SESSION['user_name'] = $name;
                $currentUserName = $name;
                
                $success = 'Profile updated successfully.';
                $user = query($pdo, 'SELECT id, name, email, user_image, description FROM user WHERE id = :id', [':id' => $userId])->fetch(PDO::FETCH_ASSOC);
            }
        }
    }
    // Check if already in email verification process
    elseif (!empty($_SESSION['email_change_code']) && time() <= ($_SESSION['email_change_expires'] ?? 0)) {
        $showEmailVerifyForm = true;
        $success = 'Please enter the verification code sent to your new email.';
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