<?php
require __DIR__ . '/vendor/autoload.php'; // ensure composer installed

// load config
$mailConfig = include __DIR__ . '/config/mail.php';

// prepare logger
$logFile = __DIR__ . '/logs/mail.log';
if (!is_dir(dirname($logFile))) mkdir(dirname($logFile), 0755, true);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // debug: prints SMTP conversation to output (set to 0 in production)
    $mail->SMTPDebug = 3; // 2 or 3 for dev. Remove in production.
    $mail->Debugoutput = function($str, $level) use ($logFile) {
        file_put_contents($logFile, date('Y-m-d H:i:s') . " [Debug-$level] $str\n", FILE_APPEND);
    };

    if (!empty($mailConfig['smtp']) && $mailConfig['smtp'] === true) {
        $mail->isSMTP();
        $mail->Host = $mailConfig['host'] ?? 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $mailConfig['username'] ?? '';
        $mail->Password = $mailConfig['password'] ?? ''; // app password
        $mail->SMTPSecure = ($mailConfig['secure'] ?? 'tls') === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $mailConfig['port'] ?? 587;

        // optional: avoid certificate issues on dev only
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];
    }

    $from = $mailConfig['from_address'] ?? 'no-reply@example.com';
    $fromName = $mailConfig['from_name'] ?? 'Site';
    $adminTo = $mailConfig['admin_address'] ?? 'admin@example.com';

    $mail->setFrom($from, $fromName);
    $mail->addAddress($adminTo);
    $mail->Subject = 'PHPMailer test ' . date('Y-m-d H:i:s');
    $mail->Body = "Test email body\nSent at " . date('c');
    $mail->AltBody = strip_tags($mail->Body);
    $mail->isHTML(false);

    $mail->send();
    echo "Message sent — check inbox (and logs: $logFile)\n";
} catch (Exception $e) {
    $err = 'Mailer Error: ' . $mail->ErrorInfo . ' Exception: ' . $e->getMessage();
    echo $err . "\n";
    file_put_contents($logFile, date('Y-m-d H:i:s') . " [ERROR] $err\n", FILE_APPEND);
}
