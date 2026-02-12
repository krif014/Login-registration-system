<?php
session_start();
require 'db.php';
$message="";
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password']; 
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?"); 
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if($user && password_verify($password, $user['password'])){
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
         exit; 
         } else { 
            $message = "Invalid username or password!"; }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }

        h2 {
            margin-bottom: 25px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
            transition: 0.3s;
            font-size: 14px;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #667eea;
            box-shadow: 0 0 6px rgba(102, 126, 234, 0.4);
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: #667eea;
            border: none;
            border-radius: 6px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            font-size: 15px;
        }

        input[type="submit"]:hover {
            background: #5563c1;
        }

        .message {
            margin-top: 15px;
            color: red;
            font-weight: bold;
        }

        .register-link {
            margin-top: 15px;
            font-size: 14px;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Welcome Back</h2>

    <form method="POST" action="">
        <input type="text" name="username" placeholder="Enter username" required>
        <input type="password" name="password" placeholder="Enter password" required>
        <input type="submit" name="login" value="Login">
    </form>

    <p class="message"><?php echo $message; ?></p>

    <div class="register-link">
        Don't have an account? <a href="register.php">Register</a>
    </div>
</div>

</body>
</html>
