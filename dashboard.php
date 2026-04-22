<?php
session_start();
require 'db.php';

if (!isset($_SESSION['logged_in'])) {
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
            background: #000;
            color: #fff;
            font-family: Arial;
            display: flex
        }

        .sidebar {
            width: 200px;
            height: 100vh;
            background: #111;
            padding: 20px;
            border-right: 1px solid #fff
        }

        .main {
            flex: 1;
            padding: 20px
        }

        .card {
            background: #111;
            padding: 20px;
            margin: 10px 0;
            border: 1px solid #fff
        }

        a {
            color: #fff;
            display: block;
            margin: 10px 0
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>Dashboard</h2>

        <a href="#">Home</a>
        <a href="#">Users</a>

        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="#">Admin Panel</a>
        <?php endif; ?>

        <a href="logout.php">Logout</a>
    </div>

    <div class="main">

        <h1>Welcome <?= $_SESSION['username'] ?></h1>
        <p>Role: <?= $_SESSION['role'] ?></p>

        <div class="card">
            <h3>System Status</h3>
            <p>All systems running</p>
        </div>

    </div>

</body>

</html>