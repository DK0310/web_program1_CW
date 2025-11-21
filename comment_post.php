<?php
session_start();
try {
    include 'db/db.php';
    include 'db/db_function.php';

    if (empty($_SESSION['user_id']) && empty($_SESSION['admin_id'])) {
        header('Location: login.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        if ($action === 'add') {
            $content = trim($_POST['content'] ?? '');
            $questionid = $_POST['questionid'] ?? null;
            if ($content === '' || !$questionid) {
                throw new Exception('Missing content or question id');
            }
            $userid = $_SESSION['admin_id'] ?? $_SESSION['user_id'];
            // determine module id from question
            $q = query($pdo, 'SELECT moduleid FROM question WHERE id = :id', [':id' => $questionid])->fetch(PDO::FETCH_ASSOC);
            $moduleid = $q['moduleid'] ?? null;
            insertComment($pdo, $content, $userid, $questionid, $moduleid);
            header('Location: question.php');
            exit;
        }
        if ($action === 'delete') {
            $id = $_POST['id'] ?? null;
            if (!$id) throw new Exception('Missing id');
            $comment = query($pdo, 'SELECT * FROM comment WHERE id = :id', [':id' => $id])->fetch(PDO::FETCH_ASSOC);
            if (!$comment) throw new Exception('Comment not found');
            // admin can delete any, user only own
            if (!empty($_SESSION['admin_id']) || (!empty($_SESSION['user_id']) && $comment['userid'] == $_SESSION['user_id'])) {
                deleteComment($pdo, $id);
                header('Location: question.php');
                exit;
            }
            throw new Exception('Not allowed to delete this comment');
        }
        if ($action === 'edit') {
            $id = $_POST['id'] ?? null;
            $content = trim($_POST['content'] ?? '');
            if (!$id || $content === '') throw new Exception('Missing id or content');
            $comment = query($pdo, 'SELECT * FROM comment WHERE id = :id', [':id' => $id])->fetch(PDO::FETCH_ASSOC);
            if (!$comment) throw new Exception('Comment not found');
            if (!empty($_SESSION['admin_id']) || (!empty($_SESSION['user_id']) && $comment['userid'] == $_SESSION['user_id'])) {
                editComment($pdo, $id, $content);
                header('Location: question.php');
                exit;
            }
            throw new Exception('Not allowed to edit this comment');
        }
    }

    header('Location: question.php');
    exit;
} catch (Exception $e) {
    $title = 'An error has occured';
    $output = 'Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
include 'templates/menu.html.php';
