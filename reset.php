<?php
require 'db.php';

$message = "";

if (isset($_POST['reset'])) {

    $username = $_POST['username'];
    $newpass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("UPDATE users SET password=? WHERE username=?");
    $stmt->execute([$newpass, $username]);

    $message = "Password updated!";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
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
            border: 1px solid #fff;
            width: 300px
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background: #000;
            color: #fff;
            border: 1px solid #fff
        }

        button {
            width: 100%;
            padding: 10px;
            background: #fff;
            color: #000;
            border: none
        }
    </style>
</head>

<body>

    <div class="box">
        <h2>Reset Password</h2>

        <form method="POST">
            <input name="username" placeholder="Username" required>
            <input name="new_password" type="password" placeholder="New Password" required>
            <button name="reset">Reset</button>
        </form>

        <p><?= $message ?></p>

        <a href="login.php" style="color:white;">Back</a>
    </div>

</body>

</html>