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
$user = getUserProfile($pdo, $userId);
if (!$user) {
    $title = 'User Profile';
    $output = '<div class="errors">User not found.</div>';
    include 'templates/menu.html.php';
    exit;
}

// Calculate avatar path in PHP (logic)
$upAvatarPath = getAvatarPath($user['user_image'] ?? '', '');

$backUrl = 'index.php';
$backText = 'Back to Home';

$title = htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') . "'s Profile";


ob_start();
include 'templates/user_profile.html.php';
$output = ob_get_clean();

include 'templates/menu.html.php';
