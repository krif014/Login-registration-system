<?php
require 'db.php';

$message = "";

if (isset($_POST['register'])) {

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");

    try {
        $stmt->execute([$username, $password]);
        $message = "Account created!";
    } catch (Exception $e) {
        $message = "Username already exists!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
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
        <h2>Register</h2>

        <form method="POST">
            <input name="username" placeholder="Username" required>
            <input name="password" type="password" placeholder="Password" required>
            <button name="register">Create</button>
        </form>

        <p><?= $message ?></p>

        <a href="login.php" style="color:white;">Login</a>
    </div>

</body>

</html>