<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            background: #f4f6f9;
        }

        /* SIDEBAR */
        .sidebar {
            width: 220px;
            height: 100vh;
            background: #111;
            color: #fff;
            padding: 20px;
        }

        .sidebar h2 {
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: #ccc;
            text-decoration: none;
            margin: 15px 0;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: #fff;
        }

        /* MAIN */
        .main {
            flex: 1;
            padding: 20px;
        }

        /* TOPBAR */
        .topbar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .topbar h2 {
            color: #333;
        }

        .logout-btn {
            padding: 8px 15px;
            background: black;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        /* CARDS */
        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            color: #555;
        }

        .card p {
            font-size: 22px;
            margin-top: 10px;
        }

        /* TABLE */
        .table {
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #f1f1f1;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>MyApp</h2>
        <a href="#">Dashboard</a>
        <a href="#">Users</a>
        <a href="#">Settings</a>
        <a href="#">Reports</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- TOPBAR -->
        <div class="topbar">
            <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>

        <!-- CARDS -->
        <div class="cards">
            <div class="card">
                <h3>Total Users</h3>
                <p>120</p>
            </div>
            <div class="card">
                <h3>Active Users</h3>
                <p>80</p>
            </div>
            <div class="card">
                <h3>New Signups</h3>
                <p>15</p>
            </div>
        </div>

        <!-- USERS TABLE -->
        <div class="table">
            <h3>Users List</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                </tr>

                <?php
                require 'db.php';
                $stmt = $pdo->query("SELECT id, username FROM users");

                while ($row = $stmt->fetch()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['username']}</td>
                      </tr>";
                }
                ?>
            </table>
        </div>

    </div>

</body>

</html>