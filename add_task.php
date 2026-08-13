<?php

session_start();

header('X-Frame-Options: SAMEORIGIN');
header("Content-Security-Policy: frame-ancestors 'self';");

require_once 'Database.php';
require_once 'Model.php';
require_once 'Task.php';

$message = '';
$success = false;

// التأكد إن المستخدم عامل Login
if (!isset($_SESSION['user_id'])) {
    die('You must login first');
}

// لو الفورم اتبعت
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // المستخدم الحالي
    $userId = $_SESSION['user_id'];

    // بيانات المهمة
    $title = $_POST['title'];
    $description = $_POST['description'];

    // إنشاء Object من Task
    $task = new Task();

    // إضافة المهمة
    $result = $task->create(
        $userId,
        $title,
        $description
    );

    // نتيجة العملية
    if ($result) {

        $success = true;
           header('Location: index.php');
    exit;

    } else {

        $message = 'Failed to create task';

    }
}
 
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Create Task</title>

</head>

<body>

<div class="task-box">

    <h2>Create New Task</h2>

    <form method="POST">

        <!-- Title -->
        <div class="form-group">

            <label>Title</label>

            <input
                type="text"
                name="title"
                required
            >

        </div>


        <!-- Description -->
        <div class="form-group">

            <label>Description</label>

            <textarea
                name="description"
                rows="5"
            ></textarea>

        </div>


        <!-- Button -->
        <button type="submit">
            Add Task
        </button>


        <!-- Message -->
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
textarea {

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