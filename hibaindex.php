  <?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TaskFlow — Sign In</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --logo-blue:   #19324e; /* The exact shade from your new logo */
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
      color: var(--text-dark);
      overflow: hidden;
    }

    /* ── Layout ─────────────────────────────────────────── */
    .page {
      display: grid;
      grid-template-columns: 1fr 1fr;
      height: 100vh;
      width: 100vw;
    }

    /* ── Left panel updated for flat brand background ─────────────────── */
.left {
  position: relative;
  overflow: hidden;
  background-color: #19324e; /* The exact shade from your logo */
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
      pointer-events: none;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 14px;
      position: relative;
      z-index: 2;
      animation: fadeUp .6s ease both;
    }
    .brand-icon {
      width: 46px; 
      height: 46px;
      display: flex; 
      align-items: center; 
      justify-content: center;
      overflow: hidden;
    }
    .brand-icon img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }
    .brand-name {
      font-family: 'Sora', sans-serif;
      font-size: 20px;
      font-weight: 700;
      color: var(--white);
      letter-spacing: -.3px;
    }

    .tagline-container {
      position: relative;
      z-index: 2;
      animation: fadeUp .6s .15s ease both;
      margin: auto 0;
    }
    .tagline-container h1 {
      font-family: 'Sora', sans-serif;
      font-size: clamp(28px, 3.5vw, 44px);
      font-weight: 800;
      color: var(--white);
      line-height: 1.15;
      letter-spacing: -1px;
      margin-bottom: 18px;
    }
    .tagline-container h1 span.highlight {
      color: #2563EB;
    }
    .tagline-container p {
      font-size: 1.5rem;
      font-weight: 300;
      color: rgba(255,255,255, 0.8);
      line-height: 1.4;
    }

    .stats {
      display: flex;
      gap: 36px;
      position: relative;
      z-index: 2;
      animation: fadeUp .6s .3s ease both;
    }
    .stat-item { display: flex; flex-direction: column; gap: 3px; }
    .stat-num {
      font-family: 'Sora', sans-serif;
      font-size: 22px;
      font-weight: 700;
      color: var(--white);
    }
    .stat-label { font-size: 12px; color: rgba(255,255,255,.5); letter-spacing: .3px; }

    /* ── Right panel ─────────────────────────────────────── */
    .right {
      background: var(--white);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 60px;
      position: relative;
    }

    .form-wrap {
      width: 100%;
      max-width: 400px;
      animation: fadeUp .5s .2s ease both;
    }

    .form-header { 
      text-align: center;
      margin-bottom: 32px; 
    }
    .form-header h2 {
      font-family: 'Sora', sans-serif;
      font-size: 30px;
      font-weight: 800;
      letter-spacing: -.6px;
      color: var(--text-dark);
      margin-bottom: 6px;
    }
    .form-header p { font-size: 14px; color: var(--text-muted); }

    /* Fully rounded pill style for buttons */
  .google-container {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}
    .btn-google {
  display: inline-flex;
  align-items: center;
  gap: 10px;

  padding: 12px 20px;
  background: white;
  border: 1px solid #ddd;
  border-radius: 8px;

  text-decoration: none;
  color: #333;
  font-weight: 500;

  cursor: pointer;
}


.google-icon {
  width: 20px;
  height: 20px;
}
    .divider {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 24px;
    }
    .divider::before, .divider::after {
      content: ''; flex: 1;
      height: 1px; background: var(--border);
    }
    .divider span { font-size: 12px; color: var(--text-muted); white-space: nowrap; }

    .field { margin-bottom: 18px; }
    .field label {
      display: block;
      font-size: 13px;
      font-weight: 500;
      color: #4a5568;
      margin-bottom: 7px;
      padding-left: 4px;
    }
    .input-wrap { position: relative; }
    .input-icon {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      pointer-events: none;
      display: flex;
    }
    .input-icon svg { width: 16px; height: 16px; }
    
    /* Fully rounded pill style for inputs */
    .input-wrap input {
      width: 100%;
      padding: 14px 14px 14px 46px;
      background: var(--input-bg);
      border: 1.5px solid var(--border);
      border-radius: 30px; /* Fully Rounded Pill Shape */
      font-family: 'DM Sans', sans-serif;
      font-size: 14.5px;
      color: var(--text-dark);
      outline: none;
      transition: border-color .2s, background .2s, box-shadow .2s;
    }
    .input-wrap input::placeholder { color: #b0bac4; }
    .input-wrap input:focus {
      background: var(--white);
      border-color: var(--teal-accent);
      box-shadow: 0 0 0 3px rgba(26,127,190,.12);
    }
    
    .input-wrap input.invalid {
      border-color: var(--error);
      background-color: #fff5f5;
    }

    .pw-toggle {
      position: absolute;
      right: 18px; top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: var(--text-muted);
      background: none; border: none;
      display: flex; padding: 2px;
      transition: color .2s;
    }
    .pw-toggle:hover { color: var(--teal-accent); }
    .pw-toggle svg { width: 16px; height: 16px; }

    .forgot-row {
      display: flex;
      justify-content: flex-end;
      margin-top: -6px;
      margin-bottom: 22px;
      padding-right: 4px;
    }
    .forgot-row a {
      font-size: 13px;
      color: var(--text-muted);
      text-decoration: none;
      font-weight: 500;
      transition: color .2s;
    }
    .forgot-row a:hover { color: var(--logo-blue); }

    /* Fully rounded pill style for main action button */
    .btn-login {
      width: 100%;
      padding: 14px;
      background: var(--logo-blue);
      border: none;
      border-radius: 30px; /* Fully Rounded Pill Shape */
      font-family: 'Sora', sans-serif;
      font-size: 15px;
      font-weight: 700;
      color: var(--white);
      cursor: pointer;
      letter-spacing: .2px;
      transition: opacity .2s, transform .15s, box-shadow .2s;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .btn-login:hover  { opacity: 0.95; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(25, 50, 78, 0.2); }
    .btn-login:active { transform: translateY(0); }

    .signup-row {
      text-align: center;
      margin-top: 22px;
      font-size: 13.5px;
      color: var(--text-muted);
    }
    .signup-row a {
      color: var(--logo-blue);
      font-weight: 600;
      text-decoration: none;
      transition: color .2s;
    }
    .signup-row a:hover { color: var(--teal-accent); }

    @media (max-width: 820px) {
      html, body { overflow: auto; }
      .page { grid-template-columns: 1fr; height: auto; }
      .left  { min-height: 260px; padding: 36px 28px; }
      .stats { gap: 24px; }
      .tagline-container h1 { font-size: 26px; }
      .right { padding: 40px 24px 60px; }
    }
    /* BACKGROUND BLUR */

.overlay{
    position: fixed;
    inset: 0;

    backdrop-filter: blur(8px);
    background: rgba(0,0,0,0.25);

    z-index: 999;
}

/* ALERT */

.custom-alert{

    position: fixed;

    top: 50%;
    left: 50%;

    transform: translate(-50%, -50%);

    width: 380px;

    background: rgba(255,255,255,0.95);

    border-radius: 24px;

    padding: 35px 30px;

    text-align: center;

    z-index: 1000;

    box-shadow:
    0 20px 60px rgba(0,0,0,0.25);

    animation: popup .35s ease;
}

/* ICON */

.alert-icon{

    width: 70px;
    height: 70px;

    margin: auto;

    border-radius: 50%;

    background: #ffe5e5;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 32px;

    color: #e04545;

    margin-bottom: 18px;
}

/* TEXT */

.alert-text{

    font-family: 'Sora', sans-serif;

    font-size: 18px;

    font-weight: 600;

    color: #19324e;

    margin-bottom: 24px;
}

/* BUTTON */

.close-alert{

    border: none;

    background: #19324e;

    color: white;

    padding: 12px 26px;

    border-radius: 30px;

    font-family: 'Sora', sans-serif;

    font-weight: 600;

    cursor: pointer;

    transition: .2s;
}

.close-alert:hover{

    transform: translateY(-2px);

    background: #2563EB;
}

/* ANIMATION */

@keyframes popup{

    from{
        opacity:0;
        transform: translate(-50%, -45%) scale(.9);
    }

    to{
        opacity:1;
        transform: translate(-50%, -50%) scale(1);
    }
}
  </style>
</head>
<body>

<?php if(isset($_SESSION["error"])) : ?>

<div class="overlay"></div>

<div class="custom-alert">

    <div class="alert-icon">⚠</div>

    <div class="alert-text">
        <?php
            echo $_SESSION["error"];
            unset($_SESSION["error"]);
        ?>
    </div>

    <button class="close-alert" onclick="closeAlert()">
        OK
    </button>

</div>

<?php endif; ?>
<div class="page">

  <div class="left">
    <div class="mesh"></div>
<div class="brand" style="display: flex; align-items: center; position: relative; z-index: 2; animation: fadeUp .6s ease both; margin-left: -135px; margin-top: -70px;">
  <img src="logo_app.png" alt="TaskFlow Logo" style="height: 250px; width: auto; object-fit: contain;">
</div>
  <div class="tagline-container">
  <h1 style="animation: fadeUp .8s cubic-bezier(0.16, 1, 0.3, 1) both;">
    Your daily life,<br>
    beautifully<br>
    <span class="highlight">organized.</span>
  </h1>
  <p style="animation: fadeUp .8s cubic-bezier(0.16, 1, 0.3, 1) 0.3s both;">
    Less stress, more living.
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

  <div class="right">
    <div class="form-wrap">

      <div class="form-header">
        <h2>Welcome back</h2>
        <p>Please enter your details to sign in</p>
      </div>

<div class="google-container">
  <a href="google-login.php" class="btn-google">
    <svg class="google-icon" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
      <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z" fill="#4285F4"/>
      <path d="M9 18c2.43 0 4.467-.806 5.956-2.184l-2.908-2.258c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332A8.997 8.997 0 009 18z" fill="#34A853"/>
      <path d="M3.964 10.707A5.41 5.41 0 013.682 9c0-.593.102-1.17.282-1.707V4.961H.957A8.996 8.996 0 000 9c0 1.452.348 2.827.957 4.039l3.007-2.332z" fill="#FBBC05"/>
      <path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0A8.997 8.997 0 00.957 4.961L3.964 7.293C4.672 5.163 6.656 3.58 9 3.58z" fill="#EA4335"/>
    </svg>

    Continue with Google
  </a>
</div>

      <div class="divider"><span>Or continue with email</span></div>

      <form id="loginForm"  action="login.php" method="POST" novalidate>
        <div class="field">
          <label for="email">Email Address</label>
          <div class="input-wrap">
            <span class="input-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="3"/>
                <path d="M2 7l10 7 10-7"/>
              </svg>
            </span>
            <input id="email"  name="email" type="email" placeholder="you@example.com" autocomplete="email" required />
          </div>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <div class="input-wrap">
            <span class="input-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="5" y="11" width="14" height="10" rx="2"/>
                <path d="M8 11V7a4 4 0 118 0v4"/>
              </svg>
            </span>
            <input id="password"  name="password" type="password" placeholder="Enter your password" autocomplete="current-password" required />
            <button class="pw-toggle" type="button" id="pwToggle" aria-label="Toggle password visibility">
              <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
        </div>

        <div class="forgot-row"><a href="forgot_password.php">Forgot password?</a></div>

        <button class="btn-login" id="loginBtn" type="submit">
          <span class="btn-label">Login</span>
        </button>
      </form>

      <p class="signup-row">Don't have an account? <a href="signup.php">Sign up</a></p>

    </div>
  </div>
</div>
<script>

  const pwToggle = document.getElementById('pwToggle');
  const passwordInput = document.getElementById('password');
  const eyeIcon = document.getElementById('eyeIcon');

  pwToggle.addEventListener('click', () => {

    // Vérifie le type actuel
    const isPassword = passwordInput.type === 'password';

    // Change password ↔ text
    passwordInput.type = isPassword ? 'text' : 'password';

    // Change l'icône
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
<script>

function closeAlert(){

    document.querySelector(".custom-alert").style.display = "none";

    document.querySelector(".overlay").style.display = "none";
}

</script>
</body>
</html>