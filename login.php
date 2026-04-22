<?php
session_start();
require 'db.php';

$message = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Invalid login!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <style>
        body {
            background: #000;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial
        }

        .box {
            background: #111;
            padding: 30px;
            width: 300px;
            border: 1px solid #fff
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background: #000;
            border: 1px solid #fff;
            color: #fff
        }

        button {
            width: 100%;
            padding: 10px;
            background: #fff;
            color: #000;
            border: none;
            cursor: pointer
        }
    </style>
</head>

<body>

    <div class="box">
        <h2>Login</h2>

        <form method="POST">
            <input name="username" required>
            <input name="password" type="password" required>
            <button name="login">Login</button>
        </form>

        <p><?= $message ?></p>

        <a href="register.php" style="color:white;">Register</a><br>
        <a href="reset.php" style="color:white;">Forgot Password?</a>
    </div>

</body>

</html>