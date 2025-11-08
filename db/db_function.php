<?php
function insertQuestion($pdo, $content, $userid, $moduleid, $imagePath){
    $query = 'INSERT INTO question (content, date, userid, moduleid, image_path) 
            VALUES (:content, NOW(), :userid, :moduleid, :image_path)';
    $paraments = [
        ':content'    => $content,
        ':userid'    => $userid,
        ':moduleid'  => $moduleid,
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
    $query = 'SELECT question.id, question.content, question.date, question.image_path AS image, user.name AS name, user.email AS email FROM question LEFT JOIN user ON question.userid = user.id ORDER BY question.id DESC';
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

function editQuestion($pdo, $id, $content){
    $query = 'UPDATE question SET content = :content WHERE id = :id';
    $paraments = [
        ':id'      => $id,
        ':content' => $content
    ];
    query($pdo, $query, $paraments);
}

function allModules($pdo){
    $query = 'SELECT * FROM module';
    return query($pdo, $query)->fetchAll();
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

function getUserByName($pdo, $name){
    $params = [':name' => $name];
    return query($pdo, 'SELECT * FROM user WHERE name = :name', $params)->fetch(PDO::FETCH_ASSOC);
}

function createUser($pdo, $name, $passwordHash, $email = null){
    $query = 'INSERT INTO user (name, password, email) VALUES (:name, :password, :email)';
    $params = [
        ':name' => $name,
        ':password' => $passwordHash,
        ':email' => $email
    ];
    query($pdo, $query, $params);
    return $pdo->lastInsertId();
}

function getAdminByName($pdo, $name){
    $params = [':name' => $name];
    return query($pdo, 'SELECT * FROM admin WHERE name = :name', $params)->fetch(PDO::FETCH_ASSOC);
}

?>
