<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
    header("Location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .dashboard-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 400px;
        }

        h2 {
            margin-bottom: 15px;
            color: #333;
        }

        p {
            color: #555;
            margin-bottom: 25px;
        }

        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #e74a3b;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <p>This is your secure dashboard.</p>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>
