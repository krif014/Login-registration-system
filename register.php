<?php
session_start();
require 'db.php';
$message = "";
if (isset($_POST['register'])){
   $username = $_POST['username'];
   $password = $_POST['password'];
   $hashed_password = password_hash($password, PASSWORD_DEFAULT);
   
   $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
   $stmt->execute([$username]);
if($stmt->rowCount() > 0){
   $message = "Username already exists!";  
}else{
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
if($stmt->execute([$username, $hashed_password])){
    $message = "Registration successful!You can now <a href='login.php'>login</a>.";
} else {
    $message = "Registration failed! Please try again.";
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
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #4e73df;
            box-shadow: 0 0 5px rgba(78, 115, 223, 0.5);
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background: #4e73df;
            border: none;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background: #2e59d9;
        }

        .message {
            margin-top: 15px;
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Create Account</h2>

    <form method="POST" action="">
        <input type="text" name="username" placeholder="Enter username" required>
        <input type="password" name="password" placeholder="Enter password" required>
        <input type="submit" name="register" value="Register">
    </form>

    <p class="message"><?php echo $message; ?></p>
</div>

</body>
</html>
