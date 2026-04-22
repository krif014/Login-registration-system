<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            height: 100vh;
            background: #111;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            background: #fff;
            padding: 40px;
            width: 350px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        input:focus {
            border-color: #000;
        }

        .btn {
            background: #000;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .btn:hover {
            background: #333;
        }

        .message {
            margin-top: 10px;
            color: red;
            text-align: center;
        }

        .link {
            text-align: center;
            margin-top: 15px;
        }

        .link a {
            color: #000;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="box">
        <h2>Register</h2>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="register" value="Register" class="btn">
        </form>

        <p class="message"><?php echo $message; ?></p>

        <div class="link">
            <a href="login.php">Back to login</a>
        </div>
    </div>

</body>

</html>