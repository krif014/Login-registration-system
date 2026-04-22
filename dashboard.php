<?php
session_start();
require 'db.php';

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --black: #111111;
            --white: #ffffff;
            --gray-50: #f9f9f9;
            --gray-100: #f0f0f0;
            --gray-200: #e0e0e0;
            --gray-400: #999999;
            --gray-600: #555555;
            --radius: 18px;
            --nav-h: 68px;
        }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--gray-50);
            min-height: 100vh;
            padding-bottom: calc(var(--nav-h) + 16px);
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── Top bar ── */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 20px 0;
            margin-bottom: 20px;
        }

        .topbar .logo {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--black);
            letter-spacing: -0.04em;
            background: var(--black);
            color: var(--white);
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .topbar .search {
            flex: 1;
            margin: 0 12px;
            position: relative;
        }

        .topbar .search svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
        }

        .topbar .search input {
            width: 100%;
            padding: 10px 14px 10px 38px;
            background: var(--white);
            border: 1.5px solid var(--gray-200);
            border-radius: 12px;
            font-family: 'Sora', sans-serif;
            font-size: 0.82rem;
            color: var(--black);
            outline: none;
            transition: border-color 0.2s;
        }

        .topbar .search input:focus {
            border-color: var(--black);
        }

        .topbar .avatar {
            width: 36px;
            height: 36px;
            background: var(--black);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 600;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        /* ── Scroll area ── */
        .scroll {
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        /* ── Cards shared ── */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 22px 20px;
            animation: slideUp 0.4s ease both;
        }

        /* ── Welcome card ── */
        .welcome-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .welcome-card .text h2 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--black);
            letter-spacing: -0.03em;
            margin-bottom: 4px;
        }

        .welcome-card .text p {
            font-size: 0.8rem;
            color: var(--gray-400);
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--gray-100);
            border-radius: 8px;
            padding: 4px 10px;
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--gray-600);
            margin-top: 8px;
        }

        .role-badge.admin {
            background: var(--black);
            color: var(--white);
        }

        .welcome-card .emoji-avatar {
            width: 54px;
            height: 54px;
            background: var(--gray-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        /* ── Stats strip ── */
        .stats-strip {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .stat-cell {
            background: var(--white);
            border-radius: var(--radius);
            padding: 16px 14px;
            animation: slideUp 0.45s ease both;
        }

        .stat-cell .label {
            font-size: 0.68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--gray-400);
            margin-bottom: 6px;
        }

        .stat-cell .value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--black);
            letter-spacing: -0.04em;
            line-height: 1;
        }

        .stat-cell .sub {
            font-size: 0.68rem;
            color: var(--gray-400);
            margin-top: 4px;
        }

        /* ── Continue banner ── */
        .continue-banner {
            background: var(--black);
            border-radius: var(--radius);
            padding: 16px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            animation: slideUp 0.5s ease both;
        }

        .continue-banner .icon {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            flex-shrink: 0;
        }

        .continue-banner .info {
            flex: 1;
        }

        .continue-banner .info strong {
            display: block;
            color: var(--white);
            font-size: 0.88rem;
            font-weight: 600;
        }

        .continue-banner .info span {
            font-size: 0.72rem;
            color: var(--gray-400);
        }

        .btn-continue {
            padding: 9px 16px;
            background: var(--white);
            color: var(--black);
            border: none;
            border-radius: 10px;
            font-family: 'Sora', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            flex-shrink: 0;
        }

        /* ── Section header ── */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .section-header h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--black);
            letter-spacing: -0.02em;
        }

        .tabs {
            display: flex;
            gap: 4px;
        }

        .tab {
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--gray-600);
            cursor: pointer;
            border: none;
            background: transparent;
            font-family: 'Sora', sans-serif;
            transition: background 0.2s, color 0.2s;
        }

        .tab.active,
        .tab:hover {
            background: var(--black);
            color: var(--white);
        }

        /* ── Item cards ── */
        .item-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .item-card {
            background: var(--white);
            border-radius: 14px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: box-shadow 0.2s;
            animation: slideUp 0.55s ease both;
        }

        .item-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.07);
        }

        .item-icon {
            width: 40px;
            height: 40px;
            background: var(--gray-100);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .item-info {
            flex: 1;
        }

        .item-info strong {
            display: block;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--black);
        }

        .item-info span {
            font-size: 0.72rem;
            color: var(--gray-600);
        }

        .item-rating {
            display: flex;
            align-items: center;
            gap: 3px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--black);
        }

        .item-rating svg {
            color: #f0c040;
        }

        .btn-open {
            padding: 8px 14px;
            background: var(--black);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-family: 'Sora', sans-serif;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .btn-open:hover {
            opacity: 0.8;
        }

        /* ── Stats chart card ── */
        .stats-card h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--black);
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }

        .chart-tabs {
            display: flex;
            gap: 4px;
            margin-bottom: 14px;
        }

        .chart-tab {
            padding: 4px 12px;
            border-radius: 7px;
            font-size: 0.7rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            background: transparent;
            color: var(--gray-600);
            font-family: 'Sora', sans-serif;
        }

        .chart-tab.active {
            background: var(--black);
            color: var(--white);
        }

        .stat-badges {
            display: flex;
            gap: 10px;
            margin-bottom: 16px;
        }

        .stat-badge {
            flex: 1;
            background: var(--gray-100);
            border-radius: 12px;
            padding: 12px 14px;
        }

        .stat-badge .num {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--black);
            letter-spacing: -0.04em;
        }

        .stat-badge .lbl {
            font-size: 0.7rem;
            color: var(--gray-600);
            margin-top: 2px;
        }

        .chart-area {
            height: 80px;
            position: relative;
        }

        .chart-area svg {
            width: 100%;
            height: 100%;
        }

        .chart-days {
            display: flex;
            justify-content: space-between;
            margin-top: 6px;
            font-size: 0.65rem;
            color: var(--gray-400);
        }

        /* ── Upgrade card ── */
        .upgrade-card {
            background: var(--black);
            border-radius: var(--radius);
            padding: 26px 20px;
            text-align: center;
            animation: slideUp 0.6s ease both;
        }

        .upgrade-card .art {
            font-size: 2.2rem;
            margin-bottom: 10px;
        }

        .upgrade-card h4 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--white);
            letter-spacing: -0.02em;
            margin-bottom: 8px;
        }

        .upgrade-card p {
            font-size: 0.8rem;
            color: var(--gray-400);
            line-height: 1.55;
            margin-bottom: 18px;
        }

        .btn-upgrade {
            width: 100%;
            padding: 13px;
            background: var(--white);
            color: var(--black);
            border: none;
            border-radius: 12px;
            font-family: 'Sora', sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-upgrade:hover {
            opacity: 0.88;
        }

        /* ── Bottom nav ── */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: var(--nav-h);
            background: var(--white);
            border-top: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding: 0 10px;
            z-index: 100;
        }

        .nav-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            color: var(--gray-400);
            cursor: pointer;
            transition: color 0.2s;
            padding: 8px 14px;
            border-radius: 12px;
            border: none;
            background: transparent;
            font-family: 'Sora', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .nav-btn.active {
            color: var(--black);
        }

        .nav-btn .dot {
            width: 4px;
            height: 4px;
            background: var(--black);
            border-radius: 50%;
            display: none;
        }

        .nav-btn.active .dot {
            display: block;
        }

        .nav-btn.logout-btn:hover {
            color: #e05050;
        }

        .nav-label {
            font-size: 0.62rem;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <!-- Top bar -->
    <div class="topbar">
        <div class="logo">F.</div>
        <div class="search">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <input type="text" placeholder="Search...">
        </div>
        <div class="avatar"><?= strtoupper(substr($_SESSION['username'], 0, 1)) ?></div>
    </div>

    <!-- Scrollable content -->
    <div class="scroll">

        <!-- Welcome -->
        <div class="card welcome-card">
            <div class="text">
                <h2>Hello, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
                <p>It's good to see you again.</p>
                <div class="role-badge <?= $_SESSION['role'] === 'admin' ? 'admin' : '' ?>">
                    <?= $_SESSION['role'] === 'admin' ? '⚡' : '👤' ?> <?= ucfirst(htmlspecialchars($_SESSION['role'])) ?>
                </div>
            </div>
            <div class="emoji-avatar">👋</div>
        </div>

        <!-- Stats strip -->
        <div class="stats-strip">
            <div class="stat-cell">
                <div class="label">Status</div>
                <div class="value">✓</div>
                <div class="sub">All good</div>
            </div>
            <div class="stat-cell">
                <div class="label">Online</div>
                <div class="value">24</div>
                <div class="sub">Users</div>
            </div>
            <div class="stat-cell">
                <div class="label">Uptime</div>
                <div class="value">99%</div>
                <div class="sub">30 days</div>
            </div>
        </div>

        <!-- Continue banner -->
        <div class="continue-banner">
            <div class="icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="5 3 19 12 5 21 5 3" />
                </svg>
            </div>
            <div class="info">
                <strong>Continue where you left off</strong>
                <span>System overview · Last session</span>
            </div>
            <button class="btn-continue">Continue</button>
        </div>

        <!-- Statistics chart -->
        <div class="card stats-card">
            <h3>Your statistics</h3>
            <div class="chart-tabs">
                <button class="chart-tab active">Weekly</button>
                <button class="chart-tab">Monthly</button>
            </div>
            <div class="stat-badges">
                <div class="stat-badge">
                    <div class="num">12</div>
                    <div class="lbl">Sessions</div>
                </div>
                <div class="stat-badge">
                    <div class="num">4</div>
                    <div class="lbl">Active now</div>
                </div>
            </div>
            <div class="chart-area">
                <svg viewBox="0 0 260 70" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="grad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#111111" stop-opacity="0.12" />
                            <stop offset="100%" stop-color="#111111" stop-opacity="0" />
                        </linearGradient>
                    </defs>
                    <path d="M0,55 L37,42 L74,50 L111,26 L148,16 L185,30 L222,12 L260,22" fill="none" stroke="#111111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M0,55 L37,42 L74,50 L111,26 L148,16 L185,30 L222,12 L260,22 L260,70 L0,70 Z" fill="url(#grad)" />
                    <circle cx="111" cy="26" r="3.5" fill="#111111" />
                    <circle cx="222" cy="12" r="3.5" fill="#111111" />
                </svg>
            </div>
            <div class="chart-days">
                <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
            </div>
        </div>

        <!-- Quick access -->
        <div>
            <div class="section-header">
                <h3>Quick Access</h3>
                <div class="tabs">
                    <button class="tab active">All</button>
                    <button class="tab">Recent</button>
                    <button class="tab">Popular</button>
                </div>
            </div>
            <div class="item-list">
                <div class="item-card">
                    <div class="item-icon">🏠</div>
                    <div class="item-info">
                        <strong>Home</strong>
                        <span>Overview &amp; quick actions</span>
                    </div>
                    <div class="item-rating">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        4.9
                    </div>
                    <button class="btn-open">Open</button>
                </div>
                <div class="item-card">
                    <div class="item-icon">👥</div>
                    <div class="item-info">
                        <strong>Users</strong>
                        <span>Manage user accounts</span>
                    </div>
                    <div class="item-rating">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        4.7
                    </div>
                    <button class="btn-open">Open</button>
                </div>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <div class="item-card">
                        <div class="item-icon">⚡</div>
                        <div class="item-info">
                            <strong>Admin Panel</strong>
                            <span>Full system control</span>
                        </div>
                        <div class="item-rating">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                            </svg>
                            5.0
                        </div>
                        <button class="btn-open">Open</button>
                    </div>
                <?php endif; ?>
                <div class="item-card">
                    <div class="item-icon">📊</div>
                    <div class="item-info">
                        <strong>Analytics</strong>
                        <span>Reports &amp; insights</span>
                    </div>
                    <div class="item-rating">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        4.5
                    </div>
                    <button class="btn-open">Open</button>
                </div>
            </div>
        </div>

        <!-- Upgrade -->
        <div class="upgrade-card">
            <div class="art">📘</div>
            <h4>Unlock even more!</h4>
            <p>Upgrade your plan to access premium features for only $9.99/month.</p>
            <button class="btn-upgrade">Go Premium</button>
        </div>

    </div><!-- /scroll -->

    <!-- Bottom navigation -->
    <nav class="bottom-nav">
        <button class="nav-btn active">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
            <div class="dot"></div>
            <span class="nav-label">Home</span>
        </button>
        <button class="nav-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
            <div class="dot"></div>
            <span class="nav-label">Users</span>
        </button>
        <button class="nav-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
            </svg>
            <div class="dot"></div>
            <span class="nav-label">Messages</span>
        </button>
        <button class="nav-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="3" />
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
            </svg>
            <div class="dot"></div>
            <span class="nav-label">Settings</span>
        </button>
        <a href="logout.php" style="text-decoration:none;">
            <button class="nav-btn logout-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                <div class="dot"></div>
                <span class="nav-label">Logout</span>
            </button>
        </a>
    </nav>

    <script>
        // Tab switching
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                tab.closest('.tabs').querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
            });
        });
        document.querySelectorAll('.chart-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                tab.closest('.chart-tabs').querySelectorAll('.chart-tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
            });
        });
        // Bottom nav switching
        document.querySelectorAll('.nav-btn:not(.logout-btn)').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });
    </script>

</body>

</html>