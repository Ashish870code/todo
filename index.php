<?php
require_once 'todo_function.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['task'])) {
        // Add a new task
        addTaskOrComment($_POST['task'], 'task');
    } elseif (isset($_POST['comment'])) {
        // Add a new comment
        addTaskOrComment($_POST['comment'], 'comment ', $_POST['task_id']);
    }
}

// Handle task deletion
if (isset($_GET['delete'])) {
    deleteTaskOrComment($_GET['delete']);
    header("Location: index.php");
    exit();
}

// Fetch all tasks and comments
$tasks = getTasksAndComments();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My To-Do List</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function showComments(taskId) {
            const comments = document.querySelectorAll(`.comments-${taskId}`);
            comments.forEach(comment => {
                comment.style.display = comment.style.display === 'none' ? 'table-row' : 'none';
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>My To-Do List</h1>

        <!-- Add Task Form -->
        <form method="POST" action="">
            <input type="text" name="task" placeholder="New Task" required>
            <button type="submit">Add Task</button>
        </form>

        <!-- Display Tasks and Comments -->
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Task/Comment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serial = 1;
                foreach ($tasks as $task) :
                    if ($task['type'] == 'task') :
                ?>
                    <tr>
                        <td><?= $serial++; ?></td>
                        <td><?= htmlspecialchars($task['content']); ?></td>
                        <td>
                            <a href="?delete=<?= $task['id']; ?>">Delete</a>
                            <button onclick="showComments(<?= $task['id']; ?>)">Show Comments</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <form method="POST" action="">
                                <input type="hidden" name="task_id" value="<?= $task['id']; ?>">
                                <input type="text" name="comment" placeholder="Add a comment" required>
                                <button type="submit">Add Comment</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                    $comments = getTasksAndComments($task['id']);
                    foreach ($comments as $comment) :
                    ?>
                    <tr class="comments-<?= $task['id']; ?>" style="display: none;">
                        <td></td>
                        <td style="padding-left: 20px;"><?= htmlspecialchars($comment['content']); ?></td>
                        <td>
                            <a href="?delete=<?= $comment['id']; ?>">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>