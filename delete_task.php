<?php

session_start();

require_once 'Database.php';
require_once 'Model.php';
require_once 'Task.php';

$message = '';
$success = false;

// لازم المستخدم يكون عامل Login
if (!isset($_SESSION['user_id'])) {
    die('You must login first');
}

$userId = $_SESSION['user_id'];

// هات ID المهمة من الرابط
$id = $_GET['id'] ?? null;

if (!$id) {
    die('Task ID is required');
}

$taskModel = new Task();

// اتأكد إن المهمة موجودة وبتاعة المستخدم
$task = $taskModel->getById($id, $userId);

if (!$task) {
    die('Task not found');
}


// لما المستخدم يضغط Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $result = $taskModel->delete($id, $userId);

    if ($result) {

             $success = true;
           header('Location: index.php');
    exit;

    } else {

        $message = 'Failed to delete task';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Task</title>
</head>

<body>

<div class="delete-box">

    <h2>Delete Task</h2>

    <p>
        Are you sure you want to delete this task?
    </p>

    <h3>
        <?= htmlspecialchars($task['title']) ?>
    </h3>

    <form method="POST">

        <button type="submit" class="delete-btn">
            Yes, Delete
        </button>

        <a href="index.php" class="cancel-btn">
            Cancel
        </a>

    </form>

    <?php if ($message): ?>

        <div class="<?= $success ? 'success' : 'error' ?>">
            <?= htmlspecialchars($message) ?>
        </div>

    <?php endif; ?>

</div>

</body>
</html>