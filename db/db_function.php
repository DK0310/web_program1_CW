<?php
/**
 * Get avatar path with proper prefix handling
 * @param string $userImage - the user_image value from database
 * @param string $prefix - prefix for admin pages (e.g., '../') or empty for user pages
 * @return string - the full avatar path or empty string
 */
function getAvatarPath($userImage, $prefix = '') {
    if (empty($userImage)) {
        return '';
    }
    if (strpos($userImage, 'images/') === 0) {
        return $prefix . $userImage;
    }
    return $prefix . 'images/' . $userImage;
}

function insertQuestion($pdo, $content, $userid, $moduleid, $imagePath){
    $query = 'INSERT INTO question (content, date, userid, moduleid, image_path) 
            VALUES (:content, NOW(), :userid, :moduleid, :image_path)';
    $paraments = [
        ':content'    => $content,
        ':userid'     => $userid,
        ':moduleid'   => $moduleid,
        ':image_path' => $imagePath
    ];
    query($pdo, $query, $paraments);
}

function deleteQuestion($pdo, $questionid){
    $query = 'DELETE FROM question WHERE id = :id';
    $paraments = [':id' => $questionid];
    query($pdo, $query, $paraments);
}

function getAllQuestions($pdo){
    $query = 'SELECT question.id, question.content, question.date, question.image_path AS image, question.userid AS userid, user.name AS name, user.email AS email, user.user_image AS user_image, module.name AS module FROM question LEFT JOIN user ON question.userid = user.id LEFT JOIN module ON question.moduleid = module.id ORDER BY question.id DESC';
    return query($pdo, $query)->fetchAll(PDO::FETCH_ASSOC);
}

function getQuestion($pdo, $id){
    $paraments = [':id' => $id];
    $query = query($pdo, 'SELECT * FROM question WHERE id = :id', $paraments);
    return $query->fetch();
}

function query($pdo, $query, $paraments = []){
    $query= $pdo->prepare($query);
    $query->execute($paraments);
    return $query;
}

function editQuestion($pdo, $id, $content, $moduleid = null){
    $query = 'UPDATE question SET content = :content, moduleid = :moduleid WHERE id = :id';
    $paraments = [
        ':id' => $id,
        ':content' => $content,
        ':moduleid' => $moduleid
    ];
    query($pdo, $query, $paraments);
}

function allModules($pdo){
    $query = 'SELECT * FROM module';
    return query($pdo, $query)->fetchAll(PDO::FETCH_ASSOC);
}

function deleteModule($pdo, $moduleid){
    $query = 'DELETE FROM module WHERE id = :id';
    $paraments = [':id' => $moduleid];
    query($pdo, $query, $paraments);
}

function clearModuleFromQuestions($pdo, $moduleId) {
    $query = 'UPDATE question SET moduleid = NULL WHERE moduleid = :id';
    $params = [':id' => $moduleId];
    query($pdo, $query, $params);
}

function allUsers($pdo){
    $query = 'SELECT * FROM user';
    return query($pdo, $query)->fetchAll();
}

function handleImageUpload($inputName = 'image') {
    $imagePath = null;

    if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES[$inputName]['tmp_name'];
        $originalName = basename($_FILES[$inputName]['name']);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate extension and check if it’s a real image
        if (in_array($ext, $allowed) && @getimagesize($tmpName)) {
            $uploadDir = __DIR__ . '/../images/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate a safe unique filename
            $safeName = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $originalName);
            $destination = $uploadDir . $safeName;

            // Move the uploaded file
            if (move_uploaded_file($tmpName, $destination)) {
                $imagePath = $safeName;
            }
        }
    }

    return $imagePath; // null if no valid image uploaded
}

function getUserByNameEmail($pdo, $name, $email){
    $paraments = [':name' => $name, ':email' => $email];
    return query($pdo, 'SELECT * FROM user WHERE name = :name OR email = :email', $paraments)->fetch(PDO::FETCH_ASSOC);
}

function getCurrentUser($pdo, $id){
    $paraments = [':id' => $id];
    return query($pdo, 'SELECT name, email FROM user WHERE id = :id', $paraments)->fetch(PDO::FETCH_ASSOC);
}

function getUserProfile($pdo, $id){
    $paraments = [':id' => $id];
    return query($pdo, 'SELECT id, name, email, user_image, description FROM user WHERE id = :id', $paraments)->fetch(PDO::FETCH_ASSOC);
}

function getUserPassword($pdo, $id){
    $paraments = [':id' => $id];
    return query($pdo, 'SELECT password FROM user WHERE id = :id', $paraments)->fetch(PDO::FETCH_ASSOC);
}

function getUserIdFromEmail($pdo, $email){
    $paraments = [':email' => $email];
    return query($pdo, 'SELECT id FROM user WHERE email = :email', $paraments)->fetch(PDO::FETCH_ASSOC);
}

function isEmailTakenByOther($pdo, $email, $excludeUserId){
    $paraments = [':email' => $email, ':id' => $excludeUserId];
    return query($pdo, 'SELECT id FROM user WHERE email = :email AND id != :id', $paraments)->fetch(PDO::FETCH_ASSOC);
}

function createUser($pdo, $name, $passwordHash, $email = null, $role = 'user'){
    $query = 'INSERT INTO user (name, password, email, role) VALUES (:name, :password, :email, :role)';
    $paraments = [
        ':name' => $name,
        ':password' => $passwordHash,
        ':email' => $email,
        ':role' => $role
    ];
    query($pdo, $query, $paraments);
    return $pdo->lastInsertId();
}

function updateUserProfile($pdo, $id, $name, $email, $user_image, $description){
    $query = 'UPDATE user SET name = :name, email = :email, user_image = :user_image, description = :description WHERE id = :id';
    $paraments = [
        ':id' => $id,
        ':name' => $name,
        ':email' => $email,
        ':user_image' => $user_image,
        ':description' => $description
    ];
    query($pdo, $query, $paraments);
}

function getAdminByName($pdo, $name){
    $paraments = [':name' => $name];
    return query($pdo, 'SELECT * FROM user WHERE name = :name AND role = "admin"', $paraments)->fetch(PDO::FETCH_ASSOC);
}

function deleteQuestionsByUser($pdo, $userid){
    $paraments = [':userid' => $userid];
    query($pdo, 'DELETE FROM question WHERE userid = :userid', $paraments);
}

function deleteUser($pdo, $userid){
    deleteQuestionsByUser($pdo, $userid);
    $paraments = [':id' => $userid];
    query($pdo, 'DELETE FROM user WHERE id = :id', $paraments);
}

function insertEmail($pdo, $content, $userid){
    $query = 'INSERT INTO email (content, userid, date) VALUES (:content, :userid, NOW())';
    $params = [':content' => $content, ':userid' => $userid];
    query($pdo, $query, $params);
    return $pdo->lastInsertId();
}

function getAllEmails($pdo){
    $query = 'SELECT email.id, email.content, email.date, email.userid, user.name AS username, user.email AS useremail FROM email LEFT JOIN user ON email.userid = user.id ORDER BY email.id DESC';
    return query($pdo, $query)->fetchAll(PDO::FETCH_ASSOC);
}

function deleteEmail($pdo, $id){
    $params = [':id' => $id];
    query($pdo, 'DELETE FROM email WHERE id = :id', $params);
}

function getCommentsByQuestion($pdo, $questionId){
    $params = [':questionid' => $questionId];
    $query = 'SELECT comment.id, comment.content, comment.date, comment.userid, comment.questionid, comment.moduleid, user.name AS name, user.email AS email, user.role AS role, user.user_image AS user_image FROM comment LEFT JOIN user ON comment.userid = user.id WHERE comment.questionid = :questionid ORDER BY comment.date ASC';
    return query($pdo, $query, $params)->fetchAll(PDO::FETCH_ASSOC);
}

function insertComment($pdo, $content, $userid, $questionid, $moduleid = null){
    $query = 'INSERT INTO comment (content, date, userid, questionid, moduleid) VALUES (:content, NOW(), :userid, :questionid, :moduleid)';
    $params = [':content' => $content, ':userid' => $userid, ':questionid' => $questionid, ':moduleid' => $moduleid];
    query($pdo, $query, $params);
    return $pdo->lastInsertId();
}

function editComment($pdo, $id, $content){
    $query = 'UPDATE comment SET content = :content WHERE id = :id';
    $params = [':id' => $id, ':content' => $content];
    query($pdo, $query, $params);
}

function deleteComment($pdo, $id){
    $params = [':id' => $id];
    query($pdo, 'DELETE FROM comment WHERE id = :id', $params);
}

function sendPasswordResetCodeByEmail($mailConfig, $toEmail, $toName, $code) {
    
    require __DIR__ . '/../vendor/autoload.php';
    

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        if (!empty($mailConfig['smtp'])) {
            $mail->isSMTP();
            $mail->Host = $mailConfig['host'] ?? 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $mailConfig['username'] ?? '';
            $mail->Password = $mailConfig['password'] ?? '';
            $secure = $mailConfig['secure'] ?? 'tls';
            $mail->SMTPSecure = ($secure === 'ssl') ? PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS : PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $mailConfig['port'] ?? 587;

         
        }

        $from = $mailConfig['from_address'] ?? 'no-reply@example.com';
        $fromName = $mailConfig['from_name'] ?? 'Site';
        $adminTo = $mailConfig['admin_address'] ?? $toEmail;

        $mail->setFrom($from, $fromName);
        $mail->addAddress($toEmail, $toName);
        $mail->Subject = 'Your verification code';
        $mail->isHTML(true);
        $mail->Body = "<p>Your verification code is: <strong>{$code}</strong></p><p>This code is valid for 5 minutes.</p>";
        $mail->AltBody = "Your verification code is: {$code}\nThis code is valid for 5 minutes.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Mail error: ' . ($e->getMessage() ?? $mail->ErrorInfo));
        return false;
    }
}

function updatePassword($pdo, $userid, $newPasswordHash){
    $query = 'UPDATE user SET password = :password WHERE id = :id';
    $params = [
        ':id' => $userid,
        ':password' => $newPasswordHash
    ];
    query($pdo, $query, $params);
}
?>
