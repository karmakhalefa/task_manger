<?php

session_start();

require_once 'Database.php';
require_once 'Model.php';
require_once 'Task.php';

// لازم المستخدم يكون عامل Login
if (!isset($_SESSION['user_id'])) {
    die('You must login first');
}

// هات رقم المستخدم المسجل
$userId = $_SESSION['user_id'];

// اعمل object من Task
$task = new Task();

// هات كل مهام المستخدم
$tasks = $task->getAllByUser($userId);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Tasks</title>
</head>

<body>

<div class="container">

    <h1>My Tasks</h1>

    <a href="add_task.php" class="add-task">
        + Add New Task
    </a>


    <?php if (empty($tasks)): ?>

        <div class="no-tasks">
            You don't have any tasks yet.
        </div>

    <?php else: ?>

        <?php foreach ($tasks as $task): ?>

            <div class="task-card">

                <h3>
                    <?= htmlspecialchars($task['title']) ?>
                </h3>

                <p>
                    <?= htmlspecialchars($task['description']) ?>
                </p>

                <span class="status">
                    <?= htmlspecialchars($task['status']) ?>
                </span>

                <div class="actions">

                    <a
                        href="edit_task.php?id=<?= $task['id'] ?>"
                        class="edit"
                    >
                        Edit
                    </a>

<a
    href="delete_task.php?id=<?= $task['id'] ?>"
    class="delete"
>
    Delete
</a>

                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

</body>
</html>
<style>

* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f4f6f8;
    min-height: 100vh;
    padding: 50px;
}

.container {
    max-width: 900px;
    margin: auto;
}

h1 {
    text-align: center;
    margin-bottom: 30px;
}

/* زر إضافة مهمة */

.add-task {
    display: block;
    width: 200px;
    margin: 0 auto 30px;
    padding: 12px;

    background: #222;
    color: white;

    text-align: center;
    text-decoration: none;

    border-radius: 7px;
}

.add-task:hover {
    background: #444;
}

/* كارت المهمة */

.task-card {
    background: white;
    padding: 25px;
    margin-bottom: 20px;

    border-radius: 12px;

    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
}

.task-card h3 {
    margin-top: 0;
    margin-bottom: 10px;
}

.task-card p {
    color: #555;
    line-height: 1.6;
}

/* Status */

.status {
    display: inline-block;

    padding: 6px 12px;

    border-radius: 20px;

    background: #eee;

    font-size: 14px;
}

/* الأزرار */

.actions {
    margin-top: 20px;
}

.actions a {
    display: inline-block;

    padding: 8px 15px;

    margin-right: 8px;

    border-radius: 6px;

    text-decoration: none;

    color: white;
}

.edit {
    background: #222;
}

.edit:hover {
    background: #444;
}

.delete {
    background: #dc3545;
}

.delete:hover {
    background: #bb2d3b;
}

/* لو مفيش مهام */

.no-tasks {
    background: white;

    padding: 30px;

    text-align: center;

    border-radius: 12px;

    color: #777;
}

</style>