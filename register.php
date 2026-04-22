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
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <style>
        body {
            height: 100vh;
            background: #111;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial;
        }

        .box {
            background: #fff;
            padding: 40px;
            width: 350px;
            border-radius: 10px;
        }

        h2 {
            text-align: center;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
        }

        .btn {
            background: black;
            color: white;
            border: none;
            cursor: pointer;
        }

        .message {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="box">
        <h2>Login</h2>

        <form method="POST">
            <input type="text" name="username" required placeholder="Username">
            <input type="password" name="password" required placeholder="Password">
            <input type="submit" name="login" value="Login" class="btn">
        </form>

        <p class="message"><?php echo $message; ?></p>

        <p style="text-align:center;">
            <a href="register.php">Create account</a>
        </p>
    </div>

</body>

</html>