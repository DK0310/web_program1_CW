<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
try{
    include 'db/db.php';
    include 'db/db_function.php';

    $mailConfig = [];
    if (file_exists(__DIR__ . '/config/mail.php')) {
        $mailConfig = include __DIR__ . '/config/mail.php';
    }

    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $content = trim($_POST['content'] ?? '');
        if ($content === ''){
            $error = 'Message required.';
        } else {
            insertEmail($pdo, $content, $_SESSION['user_id']);

            $sent = false;
            if (file_exists(__DIR__ . '/vendor/autoload.php')) {
                try {
                    require __DIR__ . '/vendor/autoload.php';
                    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

                    if (!empty($mailConfig['smtp']) && $mailConfig['smtp'] === true) {
                        $mail->isSMTP();
                        $mail->Host = $mailConfig['host'] ?? 'smtp.example.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = $mailConfig['username'] ?? '';
                        $mail->Password = $mailConfig['password'] ?? '';
                        $mail->SMTPSecure = $mailConfig['secure'] ?? PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = $mailConfig['port'] ?? 587;
        
                    }

                    $from = $mailConfig['from_address'] ?? 'no-reply@example.com';
                    $fromName = $mailConfig['from_name'] ?? 'Site';
                    $adminTo = $mailConfig['admin_address'] ?? 'admin@example.com';

                    $mail->setFrom($from, $fromName);
                    $mail->addAddress($adminTo);
                    $mail->Subject = 'New message from user ' . ($_SESSION['user_name'] ?? '');
                    $mail->Body = $content;
                    $mail->isHTML(false);

                    $mail->send();
                    $sent = true;
                } catch (Exception $e) {
                    $sent = false;
                }
            }

            if (!$sent) {
                // fallback
                $to = $mailConfig['admin_address'] ?? 'admin@example.com';
                $subject = 'New message from user ' . ($_SESSION['user_name'] ?? '');
                $headers = 'From: ' . ($mailConfig['from_address'] ?? 'no-reply@example.com') . "\r\n" .
                           'Reply-To: ' . ($mailConfig['from_address'] ?? 'no-reply@example.com') . "\r\n" .
                           'X-Mailer: PHP/' . phpversion();
                @mail($to, $subject, $content, $headers);
            }

            header('Location: question.php');
            exit;
        }
    }

    $title = 'Send Message to Admin';
    ob_start();
    include 'templates/send_email.html.php';
    $output = ob_get_clean();

} catch (PDOException $e){
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
}

include 'templates/menu.html.php';
