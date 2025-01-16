<?php
require_once 'db.php';


function addTaskOrComment($content, $type, $parent_id = null) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO tasks (type, content, parent_id) VALUES (:type, :content, :parent_id)");
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':parent_id', $parent_id);
    $stmt->execute();
}


function getTasksAndComments($parent_id = null) {
    global $pdo;
    $query = "SELECT * FROM tasks WHERE parent_id " . ($parent_id ? "= :parent_id" : "IS NULL") . " ORDER BY created_at ASC";
    $stmt = $pdo->prepare($query);
    if ($parent_id) {
        $stmt->bindParam(':parent_id', $parent_id);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function deleteTaskOrComment($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}
?>
