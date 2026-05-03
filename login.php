<?php
session_start();
require 'db.php';

$message = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Login</title>
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
            --radius: 14px;
            --max-w: 420px;
        }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--gray-50);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px 20px;
        }

        /* ── Splash screen (welcome slide) ── */
        .splash {
            width: 100%;
            max-width: var(--max-w);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            animation: fadeUp 0.5s ease both;
        }

        .splash-art {
            width: 180px;
            height: 180px;
            margin-bottom: 36px;
        }

        .splash h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--black);
            line-height: 1.25;
            margin-bottom: 12px;
            letter-spacing: -0.03em;
        }

        .splash p {
            font-size: 0.88rem;
            color: var(--gray-600);
            line-height: 1.65;
            max-width: 260px;
            margin: 0 auto 40px;
        }

        .splash-btns {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* ── Card ── */
        .card {
            width: 100%;
            max-width: var(--max-w);
            background: var(--white);
            border-radius: 28px;
            padding: 36px 28px 32px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.08);
            animation: fadeUp 0.45s ease both;
        }

        .card-title {
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--black);
            letter-spacing: -0.03em;
            margin-bottom: 6px;
        }

        .card-sub {
            font-size: 0.85rem;
            color: var(--gray-400);
            margin-bottom: 28px;
        }

        /* ── Form ── */
        .form-field {
            position: relative;
            margin-bottom: 14px;
        }

        .form-field svg {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            pointer-events: none;
            flex-shrink: 0;
        }

        .form-field input {
            width: 100%;
            padding: 14px 16px 14px 44px;
            background: var(--gray-100);
            border: 1.5px solid transparent;
            border-radius: var(--radius);
            font-family: 'Sora', sans-serif;
            font-size: 0.9rem;
            color: var(--black);
            outline: none;
            transition: border-color 0.2s, background 0.2s;
            -webkit-appearance: none;
        }

        .form-field input::placeholder {
            color: var(--gray-400);
        }

        .form-field input:focus {
            border-color: var(--black);
            background: var(--white);
        }

        .forgot {
            text-align: right;
            margin-bottom: 22px;
            margin-top: -4px;
        }

        .forgot a {
            font-size: 0.78rem;
            color: var(--gray-600);
            text-decoration: none;
        }

        .forgot a:hover {
            color: var(--black);
        }

        /* ── Buttons ── */
        .btn {
            width: 100%;
            padding: 15px;
            border-radius: var(--radius);
            font-family: 'Sora', sans-serif;
            font-size: 0.92rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: opacity 0.2s, background 0.2s;
            letter-spacing: -0.01em;
            -webkit-tap-highlight-color: transparent;
        }

        .btn-primary {
            background: var(--black);
            color: var(--white);
            margin-bottom: 16px;
        }

        .btn-primary:hover {
            opacity: 0.82;
        }

        .btn-outline {
            background: transparent;
            border: 1.5px solid var(--gray-200);
            color: var(--black);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-outline:hover {
            background: var(--gray-100);
        }

        .btn-ghost {
            background: transparent;
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            color: var(--white);
        }

        .btn-ghost:hover {
            border-color: rgba(255, 255, 255, 0.6);
        }

        /* ── Divider ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 16px 0;
        }

        .divider span {
            flex: 1;
            height: 1px;
            background: var(--gray-200);
        }

        .divider p {
            font-size: 0.75rem;
            color: var(--gray-400);
            white-space: nowrap;
        }

        /* ── Switch link ── */
        .switch-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.83rem;
            color: var(--gray-600);
        }

        .switch-link a {
            color: var(--black);
            font-weight: 600;
            text-decoration: none;
        }

        /* ── Error ── */
        .error-msg {
            background: #fff0f0;
            border: 1px solid #f5c0c0;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.82rem;
            color: #cc3333;
            margin-bottom: 16px;
        }

        /* ── Splash left panel (welcome) ── */
        .splash-panel {
            width: 100%;
            max-width: var(--max-w);
            background: var(--black);
            border-radius: 28px;
            padding: 48px 28px 40px;
            text-align: center;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.15);
            animation: fadeUp 0.45s ease both;
            margin-bottom: 16px;
        }

        .splash-panel h1 {
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--white);
            letter-spacing: -0.03em;
            line-height: 1.25;
            margin-bottom: 12px;
        }

        .splash-panel p {
            font-size: 0.85rem;
            color: var(--gray-400);
            line-height: 1.65;
            max-width: 240px;
            margin: 0 auto 36px;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>



    <!-- Login card -->
    <div class="card">
        <div class="card-title">Login</div>
        <div class="card-sub">Welcome back — let's get you in.</div>

        <?php if ($message): ?>
            <div class="error-msg"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-field">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                <input name="username" placeholder="Username" required autocomplete="username">
            </div>
            <div class="form-field">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
                <input name="password" type="password" placeholder="Password" required autocomplete="current-password">
            </div>
            <div class="forgot"><a href="reset.php">Forgot Password?</a></div>
            <button class="btn btn-primary" name="login" type="submit">Login</button>
        </form>

        <div class="divider"><span></span>
            <p>or continue with</p><span></span>
        </div>

        <button class="btn btn-outline">
            <svg width="18" height="18" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" />
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
            </svg>
            Login using Google
        </button>

        <div class="switch-link">Don't have an account? <a href="register.php">Sign up</a></div>
    </div>

</body>

</html>