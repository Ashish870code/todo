<?php
require_once 'todo_function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task'])) {
    addTask($_POST['task']);
}

if (isset($_GET['delete'])) {
    deleteTask($_GET['delete']);
}

$tasks = getTasks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>My To-Do List</h1>

        <form method="POST" action="">
            <input type="text" name="task" placeholder="New Task" required>
            <button type="submit">Add Task</button>
        </form>

        <ul>
            <?php foreach ($tasks as $task) : ?>
                <li>
                    <?= htmlspecialchars($task['task']); ?>
                    <a href="?delete=<?= $task['id']; ?>">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
