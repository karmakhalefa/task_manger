<?php
session_start();
// التوجيه إلى صفحة Login

require_once 'Database.php';
require_once 'Model.php';
require_once 'User.php';

$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User();

    $result = $user->login($email, $password);

    $message = $result['message'];
       // لو التسجيل نجح
    if ($success) {
        header('Location: login.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>login</title>
</head>
<body>

<div class="register-box">

    <h2>Login</h2>

    <form method="POST">

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Login</button>

<p>
    Don't have an account?
</p>

<a href="register.php" class="register-btn">
    Register
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

    .register-box {
        width: 400px;
        background: white;
        padding: 35px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
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

    input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 7px;
        font-size: 15px;
    }

    input:focus {
        outline: none;
        border-color: #333;
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

    .message {
        text-align: center;
        margin-bottom: 15px;
        color: #555;
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
.register-btn {
    display: block;
    width: 100%;
    padding: 12px;
    margin-top: 10px;

    background: #222;
    color: white;

    text-align: center;
    text-decoration: none;

    border-radius: 7px;
    font-size: 16px;
}

.register-btn:hover {
    background: #444;
}
</style>