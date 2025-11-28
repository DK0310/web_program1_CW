<?php
session_start();
include 'db/db.php';
include 'db/db_function.php';

$userId = $_GET['id'] ?? null;
if (!$userId) {
    $title = 'User Profile';
    $output = '<div class="errors">User not found.</div>';
    include 'templates/menu.html.php';
    exit;
}
$user = query($pdo, 'SELECT id, name, email, user_image, description FROM user WHERE id = :id', [':id' => $userId])->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    $title = 'User Profile';
    $output = '<div class="errors">User not found.</div>';
    include 'templates/menu.html.php';
    exit;
}

// Calculate avatar path in PHP (logic)
$upAvatarPath = getAvatarPath($user['user_image'] ?? '', '');

// Detect if coming from admin area (via referer or admin session)
$isFromAdmin = !empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
$backUrl = $isFromAdmin ? 'admin/question.php' : 'index.php';
$backText = $isFromAdmin ? 'Back to Admin' : 'Back to Home';

$title = htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') . "'s Profile";

// Capture UI template output
ob_start();
include 'templates/user_profile.html.php';
$output = ob_get_clean();

include 'templates/menu.html.php';
