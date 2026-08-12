<?php

session_start();

require_once 'Database.php';
require_once 'Model.php';
require_once 'Task.php';

$message = '';
$success = false;


// 1. لازم يكون عامل Login
if (!isset($_SESSION['user_id'])) {
    die('You must login first');
}


// 2. ID المستخدم من Session
$userId = $_SESSION['user_id'];


// 3. ID المهمة من الرابط
$id = $_GET['id'] ?? null;

if (!$id) {
    die('Task ID is required');
}


// 4. إنشاء object من Task
$taskModel = new Task();


// 5. هات المهمة وتأكد إنها تخص المستخدم
$task = $taskModel->getById($id, $userId);

if (!$task) {
    die('Task not found');
}


// 6. لو المستخدم ضغط Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];


    // 7. تعديل المهمة
    $result = $taskModel->update(
        $id,
        $userId,
        $title,
        $description,
        $status
    );


    if ($result) {

        $success = true;
        $message = 'Task updated successfully';

        // نجيب البيانات الجديدة
        $task = $taskModel->getById($id, $userId);

    } else {

        $message = 'Failed to update task';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Edit Task</title>

</head>

<body>

<div class="edit-box">

    <h2>Edit Task</h2>


    <form method="POST">

        <div class="form-group">

            <label>Title</label>

            <input
                type="text"
                name="title"
                value="<?= htmlspecialchars($task['title']) ?>"
                required
            >

        </div>


        <div class="form-group">

            <label>Description</label>

            <textarea
                name="description"
                rows="5"
            ><?= htmlspecialchars($task['description']) ?></textarea>

        </div>


        <div class="form-group">

            <label>Status</label>

            <select name="status">

                <option
                    value="pending"
                    <?= $task['status'] === 'pending' ? 'selected' : '' ?>
                >
                    Pending
                </option>

                <option
                    value="completed"
                    <?= $task['status'] === 'completed' ? 'selected' : '' ?>
                >
                    Completed
                </option>

            </select>

        </div>


        <button type="submit">
            Update Task
        </button>


        <a href="index.php" class="back">
            Back to Tasks
        </a>


        <?php if ($message): ?>

            <div class="<?= $success ? 'success' : 'error' ?>">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>

    </form>

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

    display: flex;

    justify-content: center;

    align-items: center;

    min-height: 100vh;
}

.task-box {

    width: 450px;

    background: white;

    padding: 35px;

    border-radius: 12px;

    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

h2 {

    text-align: center;

    margin-bottom: 25px;
}

.form-group {

    margin-bottom: 18px;
}

label {

    display: block;

    margin-bottom: 7px;

    font-weight: bold;
}

input,
textarea,
select {

    width: 100%;

    padding: 12px;

    border: 1px solid #ccc;

    border-radius: 7px;

    font-size: 15px;
}

textarea {

    resize: vertical;
}

button {

    width: 100%;

    padding: 12px;

    border: none;

    border-radius: 7px;

    background: #222;

    color: white;

    font-size: 16px;

    cursor: pointer;
}

button:hover {

    background: #444;
}

.success {

    margin-top: 15px;

    padding: 10px;

    text-align: center;

    color: #198754;

    background: #d1e7dd;

    border-radius: 7px;
}

.error {

    margin-top: 15px;

    padding: 10px;

    text-align: center;

    color: #dc3545;

    background: #f8d7da;

    border-radius: 7px;
}

</style>