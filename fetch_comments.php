<?php
require_once 'todo_function.php';


if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];
    $comments = getComments($_GET['task_id']);
    echo json_encode($comments);
} else {
    echo json_encode([]);
}
?>
