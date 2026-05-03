<?php
session_start();
require 'db.php';

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

/* Fetch all users */
$stmt = $pdo->query("SELECT id, username, email FROM users ORDER BY id DESC");
$users = $stmt->fetchAll();

$username = htmlspecialchars($_SESSION['username']);
/* DELETE USER */
if (isset($_GET['delete'])) {
    $deleteId = (int) $_GET['delete'];

    // prevent deleting yourself
    $currentUser = $_SESSION['username'];

    $check = $pdo->prepare("SELECT username FROM users WHERE id = ?");
    $check->execute([$deleteId]);
    $target = $check->fetch();

    if ($target && $target['username'] !== $currentUser) {
        $del = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $del->execute([$deleteId]);
    }

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Sora', sans-serif;
            background: #f5f5f5;
            color: #111;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */

        .sidebar {
            width: 260px;
            background: #111;
            color: white;
            padding: 30px 20px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
        }

        .logo {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .menu a {
            color: #cfcfcf;
            text-decoration: none;
            padding: 14px 16px;
            border-radius: 14px;
            transition: .2s;
            font-size: .92rem;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(255, 255, 255, .08);
            color: white;
        }

        .logout {
            position: absolute;
            bottom: 30px;
            left: 20px;
            right: 20px;
        }

        .logout a {
            display: block;
            text-align: center;
            background: white;
            color: black;
            padding: 14px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 600;
        }

        /* MAIN */

        .main {
            margin-left: 260px;
            flex: 1;
            padding: 30px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            gap: 20px;
        }

        .welcome h1 {
            font-size: 2rem;
            margin-bottom: 6px;
        }

        .welcome p {
            color: #777;
        }

        .avatar {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            background: #111;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
        }

        /* HERO */

        .hero {
            background: #111;
            color: white;
            padding: 34px;
            border-radius: 28px;
            margin-bottom: 24px;
        }

        .hero h2 {
            font-size: 2rem;
            margin-bottom: 12px;
        }

        .hero p {
            color: #b8b8b8;
            line-height: 1.7;
            max-width: 600px;
        }

        /* STATS */

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 22px;
        }

        .stat-card span {
            color: #777;
            font-size: .82rem;
        }

        .stat-card h3 {
            font-size: 2rem;
            margin: 12px 0 4px;
        }

        /* USERS */

        .users-section {
            background: white;
            border-radius: 28px;
            padding: 28px;
        }

        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            gap: 20px;
        }

        .section-title h2 {
            font-size: 1.3rem;
        }

        .search {
            padding: 12px 16px;
            border-radius: 14px;
            border: 1px solid #ddd;
            outline: none;
            font-family: 'Sora', sans-serif;
            width: 240px;
        }

        .users-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 18px;
        }

        .user-card {
            background: #f7f7f7;
            border-radius: 22px;
            padding: 22px;
            transition: .2s;
        }

        .user-card:hover {
            transform: translateY(-3px);
        }

        .user-top {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 18px;
        }

        .user-avatar {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            background: #111;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .user-info h3 {
            font-size: 1rem;
            margin-bottom: 4px;
        }

        .user-info p {
            color: #777;
            font-size: .82rem;
            word-break: break-word;
        }

        .badge {
            display: inline-flex;
            padding: 8px 12px;
            border-radius: 999px;
            background: white;
            font-size: .72rem;
            font-weight: 600;
        }

        @media (max-width: 900px) {

            .sidebar {
                width: 88px;
                padding: 24px 12px;
            }

            .logo {
                font-size: 1rem;
                text-align: center;
            }

            .menu a {
                text-align: center;
                padding: 14px 0;
                font-size: .75rem;
            }

            .main {
                margin-left: 88px;
            }
        }

        @media (max-width: 700px) {

            .sidebar {
                display: none;
            }

            .main {
                margin-left: 0;
                padding: 18px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .section-title {
                flex-direction: column;
                align-items: stretch;
            }

            .search {
                width: 100%;
            }

            .hero h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>

    <div class="layout">

        <!-- SIDEBAR -->

        <aside class="sidebar">

            <div>

                <div class="logo">Fusion.</div>

                <div class="menu">
                    <a href="#" class="active">Dashboard</a>
                    <a href="#">Users</a>
                    <a href="#">Messages</a>
                    <a href="#">Analytics</a>
                    <a href="#">Settings</a>
                </div>

            </div>

            <div class="logout">
                <a href="logout.php">Logout</a>
            </div>

        </aside>

        <!-- MAIN -->

        <main class="main">

            <!-- TOPBAR -->

            <div class="topbar">

                <div class="welcome">
                    <h1>Hello, <?= $username ?> 👋</h1>
                    <p>Here are all registered users in your system.</p>
                </div>

                <div class="avatar">
                    <?= strtoupper(substr($username, 0, 1)) ?>
                </div>

            </div>

            <!-- HERO -->

            <div class="hero">
                <h2>Modern User Dashboard</h2>

                <p>
                    Manage and explore all registered users in your application
                    with a beautiful responsive dashboard interface.
                </p>
            </div>

            <!-- STATS -->

            <div class="stats">

                <div class="stat-card">
                    <span>Total Users</span>
                    <h3><?= count($users) ?></h3>
                    <p>Registered accounts</p>
                </div>

                <div class="stat-card">
                    <span>System</span>
                    <h3>99%</h3>
                    <p>Server uptime</p>
                </div>

                <div class="stat-card">
                    <span>Status</span>
                    <h3>✓</h3>
                    <p>Everything running</p>
                </div>

            </div>

            <!-- USERS -->

            <div class="users-section">

                <div class="section-title">
                    <h2>All Users</h2>

                    <input
                        type="text"
                        class="search"
                        id="searchInput"
                        placeholder="Search users...">
                </div>

                <div class="users-grid" id="usersGrid">

                    <?php foreach ($users as $user): ?>

                        <div class="user-card">

                            <div class="user-top">

                                <div class="user-avatar">
                                    <?= strtoupper(substr($user['username'], 0, 1)) ?>
                                </div>

                                <div class="user-info">
                                    <h3><?= htmlspecialchars($user['username']) ?></h3>

                                    <p>
                                        <?= htmlspecialchars($user['email']) ?>
                                    </p>
                                </div>

                            </div>

                            <div class="badge">
                                Registered User
                            </div>

                            <a href="dashboard.php?delete=<?= $user['id'] ?>"
                                onclick="return confirm('Are you sure you want to delete this user?')"
                                style="
                                display:inline-block;
                                margin-top:10px;
                                padding:8px 12px;
                                background:#ff3b3b;
                                color:white;
                                border-radius:10px;
                                font-size:12px;
                                text-decoration:none;
                        ">
                                Delete
                            </a>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>

        </main>

    </div>

    <script>
        const searchInput = document.getElementById("searchInput");
        const userCards = document.querySelectorAll(".user-card");

        searchInput.addEventListener("keyup", function() {

            const value = this.value.toLowerCase();

            userCards.forEach(card => {

                const text = card.textContent.toLowerCase();

                card.style.display = text.includes(value) ?
                    "block" :
                    "none";

            });

        });
    </script>

</body>

</html>