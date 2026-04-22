<?php
session_start();
require 'db.php';

$message = "";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->rowCount() > 0) {
        $message = "Username already exists!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        if ($stmt->execute([$username, $hashed_password])) {
            $message = "Registration successful! <a href='login.php'>Login</a>";
        } else {
            $message = "Registration failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
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
        <h2>Register</h2>

        <form method="POST">
            <input type="text" name="username" required placeholder="Username">
            <input type="password" name="password" required placeholder="Password">
            <input type="submit" name="register" value="Register" class="btn">
        </form>

        <p class="message"><?php echo $message; ?></p>

        <p style="text-align:center;">
            <a href="login.php">Back to login</a>
        </p>
    </div>

</body>

</html>