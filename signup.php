<?php
session_start();

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // CHECK IF EMAIL ALREADY EXISTS
    $check = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {

        $error = "This email already exists.";

    } else {

        // INSERT USER
        $sql = "INSERT INTO users(name, email, password)
                VALUES(?,?,?)";

        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$name, $email, $password])) {

            // CREATE SESSION
           $_SESSION['user_id'] = $pdo->lastInsertId();

           $_SESSION['user_name'] = $name;

           $_SESSION['user_email'] = $email;

            // REDIRECT TO DASHBOARD
            header("Location: dashboard.php");
            exit();

        } else {

            $error = "Registration failed.";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<title>TaskFlow — Sign Up</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

<style>

*, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

:root {
    --logo-blue:   #19324e;
    --teal-accent: #1a7fbe;
    --sky-bright:  #2aa8e0;
    --white:       #ffffff;
    --off-white:   #f7f9fc;
    --text-dark:   #0f1923;
    --text-muted:  #8a96a3;
    --border:      #e2e8ef;
    --error:       #e04545;
    --input-bg:    #f4f7fa;
}

html, body {
    height: 100%;
    font-family: 'DM Sans', sans-serif;
    background: var(--white);
    overflow: hidden;
}

.page {
    display: grid;
    grid-template-columns: 1fr 1fr;
    height: 100vh;
}

/* LEFT */

.left {
    position: relative;
    overflow: hidden;
    background-color: #19324e;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 48px 52px 56px;
}

.mesh {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,.02) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.02) 1px, transparent 1px);
    background-size: 48px 48px;
}

.brand {
    position: relative;
    z-index: 2;
}

.brand img {
    height: 250px;
    margin-left: -135px;
    margin-top: -70px;
}

.tagline-container {
    z-index: 2;
}

.tagline-container h1 {
    font-family: 'Sora', sans-serif;
    font-size: clamp(28px, 3.5vw, 44px);
    font-weight: 800;
    color: white;
    line-height: 1.15;
    letter-spacing: -1px;
    margin-bottom: 18px;
}

.highlight {
    color: #2563EB;
}

.tagline-container p {
    font-size: 1.5rem;
    font-weight: 300;
    color: rgba(255,255,255,.8);
}

.stats {
    display: flex;
    gap: 36px;
    z-index: 2;
}

.stat-item {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.stat-num {
    font-family: 'Sora', sans-serif;
    font-size: 22px;
    font-weight: 700;
    color: white;
}

.stat-label {
    font-size: 12px;
    color: rgba(255,255,255,.5);
}

/* RIGHT */

.right {
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 60px;
}

.form-wrap {
    width: 100%;
    max-width: 400px;
}

.form-header {
    text-align: center;
    margin-bottom: 32px;
}

.form-header h2 {
    font-family: 'Sora', sans-serif;
    font-size: 30px;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 6px;
}

.form-header p {
    font-size: 14px;
    color: var(--text-muted);
}

.field {
    margin-bottom: 18px;
}

.field label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: #4a5568;
    margin-bottom: 7px;
    padding-left: 4px;
}

.input-wrap {
    position: relative;
}

.input-wrap input {
    width: 100%;
    padding: 14px 16px;
    background: var(--input-bg);
    border: 1.5px solid var(--border);
    border-radius: 30px;
    font-size: 14px;
    outline: none;
    transition: .2s;
}

.input-wrap input:focus {
    background: white;
    border-color: var(--teal-accent);
    box-shadow: 0 0 0 3px rgba(26,127,190,.12);
}

.btn-signup {
    width: 100%;
    padding: 14px;
    background: var(--logo-blue);
    border: none;
    border-radius: 30px;
    font-family: 'Sora', sans-serif;
    font-size: 15px;
    font-weight: 700;
    color: white;
    cursor: pointer;
    transition: .2s;
}

.btn-signup:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(25,50,78,.2);
}

.error {
    background: #ffe5e5;
    color: #c53030;
    padding: 12px;
    border-radius: 12px;
    margin-bottom: 18px;
    font-size: 14px;
}

.login-row {
    text-align: center;
    margin-top: 22px;
    font-size: 13.5px;
    color: var(--text-muted);
}

.login-row a {
    color: var(--logo-blue);
    text-decoration: none;
    font-weight: 600;
}

.pw-toggle{
    position:absolute;
    right:18px;
    top:50%;
    transform:translateY(-50%);
    background:none;
    border:none;
    cursor:pointer;
    color:#8a96a3;
    display:flex;
    align-items:center;
    justify-content:center;
}

.pw-toggle:hover{
    color:#1a7fbe;
}

@media (max-width: 820px) {

    html, body {
        overflow: auto;
    }

    .page {
        grid-template-columns: 1fr;
        height: auto;
    }

    .left {
        min-height: 260px;
        padding: 36px 28px;
    }

    .right {
        padding: 40px 24px 60px;
    }

}

</style>
</head>

<body>

<div class="page">

    <!-- LEFT -->
    <div class="left">

        <div class="mesh"></div>

        <div class="brand">
            <img src="logo_app.png" alt="TaskFlow Logo">
        </div>

        <div class="tagline-container">

            <h1>
                Start organizing<br>
                your life with<br>
                <span class="highlight">TaskFlow.</span>
            </h1>

            <p>
                Create your account and stay productive.
            </p>

        </div>

        <div class="stats">

            <div class="stat-item">
                <span class="stat-num">50k+</span>
                <span class="stat-label">Active users</span>
            </div>

            <div class="stat-item">
                <span class="stat-num">99.9%</span>
                <span class="stat-label">Uptime SLA</span>
            </div>

            <div class="stat-item">
                <span class="stat-num">4.9★</span>
                <span class="stat-label">User rating</span>
            </div>

        </div>

    </div>

    <!-- RIGHT -->
    <div class="right">

        <div class="form-wrap">

            <div class="form-header">
                <h2>Create account</h2>
                <p>Please enter your details</p>
            </div>

            <?php if(isset($error)): ?>
                <div class="error">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <div class="field">
                    <label>Full Name</label>

                    <div class="input-wrap">
                        <input
                            type="text"
                            name="name"
                            placeholder="John Doe"
                            required
                        >
                    </div>
                </div>

                <div class="field">
                    <label>Email Address</label>

                    <div class="input-wrap">
                        <input
                            type="email"
                            name="email"
                            placeholder="you@example.com"
                            required
                        >
                    </div>
                </div>

                <div class="field">

                    <label>Password</label>

                    <div class="input-wrap">

                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Enter your password"
                            required
                        >

                        <button
                            type="button"
                            class="pw-toggle"
                            id="pwToggle"
                        >

                            <svg
                                id="eyeIcon"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                width="18"
                                height="18"
                            >
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>

                        </button>

                    </div>

                </div>

                <button class="btn-signup" type="submit">
                    Create Account
                </button>

            </form>

            <p class="login-row">
                Already have an account?
                <a href="hibaindex.php">Login</a>
            </p>

        </div>

    </div>

</div>

<script>

const pwToggle = document.getElementById('pwToggle');
const passwordInput = document.getElementById('password');
const eyeIcon = document.getElementById('eyeIcon');

pwToggle.addEventListener('click', () => {

    const isPassword = passwordInput.type === 'password';

    passwordInput.type = isPassword ? 'text' : 'password';

    eyeIcon.innerHTML = isPassword
    ? `
      <path d="M17.94 17.94A10.94 10.94 0 0112 20C5 20 1 12 1 12a21.8 21.8 0 015.06-6.94"/>
      <path d="M9.9 4.24A10.94 10.94 0 0112 4c7 0 11 8 11 8a21.8 21.8 0 01-4.06 5.94"/>
      <path d="M1 1l22 22"/>
      `
    : `
      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
      <circle cx="12" cy="12" r="3"/>
      `;
});

</script>

</body>
</html>