<?php
require_once 'db.php';

function addTask($task) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO tasks (task) VALUES (:task)");
    $stmt->bindParam(':task', $task);
    $stmt->execute();
}

function getTasks() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM tasks");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deleteTask($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}
?>