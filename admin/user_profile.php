<?php
session_start();

if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include '../db/db.php';
include '../db/db_function.php';

$userId = $_GET['id'] ?? null;
if (!$userId) {
    $title = 'User Profile';
    $output = '<div class="errors">User not found.</div>';
    include '../admin_templates/admin_layout.html.php';
    exit;
}

$user = getUserProfile($pdo, $userId);
if (!$user) {
    $title = 'User Profile';
    $output = '<div class="errors">User not found.</div>';
    include '../admin_templates/admin_layout.html.php';
    exit;
}

// Calculate avatar path
$upAvatarPath = getAvatarPath($user['user_image'] ?? '', '../');

$title = htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') . "'s Profile";

ob_start();
include '../admin_templates/admin_viewuserprofile.html.php';
$output = ob_get_clean();

include '../admin_templates/admin_layout.html.php';