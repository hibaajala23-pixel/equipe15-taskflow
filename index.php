<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=1440" />
<title>TaskFlow — Authentication</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  html, body { height: 100%; font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; }
  .page { display: flex; width: 1440px; min-height: 100vh; margin: 0 auto; }
  .panel-left { flex: 0 0 780px; background: linear-gradient(145deg, #003354 0%, #005a92 35%, #00a3e0 100%); padding: 64px 72px; display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden; }
  .panel-left::before { content: ''; position: absolute; inset: 0; background-image: radial-gradient(ellipse 80% 60% at 20% 10%, rgba(255,255,255,0.1) 0%, transparent 60%), radial-gradient(ellipse 60% 80% at 80% 80%, rgba(0,0,0,0.2) 0%, transparent 60%); pointer-events: none; }
  .left-content { position: relative; z-index: 1; }
  .brand { display: flex; align-items: center; gap: 14px; margin-bottom: 40px; }
  .brand-logo-img { width: 52px; height: 52px; border-radius: 12px; object-fit: cover; background: #fff; padding: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
  .brand-name { font-size: 26px; font-weight: 700; color: #fff; letter-spacing: -0.3px; }
  .headline { font-size: 42px; font-weight: 800; color: #fff; line-height: 1.18; letter-spacing: -1px; max-width: 520px; }
  .panel-right { flex: 1; background: #fff; display: flex; align-items: center; justify-content: center; padding: 60px 72px; }
  .form-box { width: 100%; max-width: 440px; }
  .form-title { font-size: 32px; font-weight: 700; color: #111827; letter-spacing: -0.6px; margin-bottom: 8px; }
  .form-sub { font-size: 15px; color: #6b7280; font-weight: 400; margin-bottom: 36px; line-height: 1.5; }
  .btn-social { width: 100%; height: 52px; background: #fff; border: 1.5px solid #e5e7eb; border-radius: 10px; display: flex; align-items: center; justify-content: center; gap: 12px; font-family: 'Inter', sans-serif; font-size: 15px; font-weight: 500; color: #111827; cursor: pointer; transition: background 0.15s, border-color 0.15s; margin-bottom: 14px; }
  .btn-social:hover { background: #f9fafb; border-color: #d1d5db; }
  .divider { display: flex; align-items: center; gap: 14px; margin: 28px 0; }
  .divider-line { flex: 1; height: 1px; background: #e5e7eb; }
  .divider-text { font-size: 13px; font-weight: 400; color: #9ca3af; }
  .field { margin-bottom: 20px; }
  .field-label { display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px; }
  .input-wrap { position: relative; }
  .input-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #9ca3af; display: flex; align-items: center; }
  .field input { width: 100%; height: 52px; padding: 0 16px 0 46px; font-family: 'Inter', sans-serif; font-size: 15px; color: #111827; border: 1.5px solid #e5e7eb; border-radius: 10px; outline: none; transition: 0.2s; }
  .field input:focus { border-color: #005a92; box-shadow: 0 0 0 3px rgba(0,90,146,0.1); }
  .btn-primary { width: 100%; height: 52px; background: #005a92; color: #fff; font-size: 16px; font-weight: 600; border: none; border-radius: 10px; cursor: pointer; transition: 0.18s; margin-bottom: 28px; }
  .btn-primary:hover { background: #003354; }
  .form-footer { text-align: center; font-size: 14px; color: #6b7280; }
  .form-footer a { color: #005a92; font-weight: 500; text-decoration: none; cursor: pointer; }
  .form-footer a:hover { text-decoration: underline; }
  .strength-bar { display: flex; gap: 4px; margin-top: 8px; }
  .strength-seg { flex: 1; height: 4px; border-radius: 2px; background: #e5e7eb; }
  .alert-success { background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 16px; border-radius: 10px; margin-bottom: 24px; display: none; font-size: 14px; }
  .field-error { color: #dc2626; font-size: 13px; margin-top: 6px; display: none; }
  #register-view { display: none; }
</style>
</head>
<body>
<div class="page">
  <aside class="panel-left">
    <div class="left-content">
      <div class="brand">
        <img src="logo_taskflow.jpeg" alt="TaskFlow Logo" class="brand-logo-img">
        <span class="brand-name">TaskFlow</span>
      </div>
      <h1 class="headline">Organize your work,<br/>amplify your productivity</h1>
    </div>
  </aside>
  <main class="panel-right">
    <div class="form-box">
      <div id="login-view">
        <h2 class="form-title">Welcome back</h2>
        <p class="form-sub">Please enter your details to sign in</p>
        <button type="button" class="btn-social">
           <svg width="20" height="20" viewBox="0 0 18 18" fill="none"><path d="M17.64 9.2c0-.638-.057-1.252-.164-1.84H9v3.481h4.844a4.14 4.14 0 0 1-1.796 2.716v2.259h2.908C16.658 14.075 17.64 11.767 17.64 9.2z" fill="#4285F4"/><path d="M9 18c2.43 0 4.467-.806 5.956-2.184l-2.908-2.259c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332A8.997 8.997 0 0 0 9 18z" fill="#34A853"/><path d="M3.964 10.706A5.41 5.41 0 0 1 3.682 9c0-.593.102-1.17.282-1.706V4.962H.957A8.996 8.996 0 0 0 0 9c0 1.452.348 2.827.957 4.038l3.007-2.332z" fill="#FBBC05"/><path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0A8.997 8.997 0 0 0 .957 4.962L3.964 7.294C4.672 5.163 6.656 3.58 9 3.58z" fill="#EA4335"/></svg>
           Continue with Google
        </button>
        <div class="divider"><div class="divider-line"></div><span class="divider-text">Or continue with email</span><div class="divider-line"></div></div>
        <form onsubmit="return false;">
          <div class="field">
            <label class="field-label">Email Address</label>
            <div class="input-wrap">
              <span class="input-icon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></span>
              <input type="email" placeholder="you@example.com" />
            </div>
          </div>
          <div class="field">
            <label class="field-label">Password</label>
            <div class="input-wrap">
              <span class="input-icon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
              <input type="password" placeholder="Enter your password" />
            </div>
          </div>
          <button type="submit" class="btn-primary">Login</button>
        </form>
        <p class="form-footer">Don't have an account? <a onclick="toggleView('register')">Sign up</a></p>
      </div>
      <div id="register-view">
        <h2 class="form-title">Create an account</h2>
        <p class="form-sub">Sign up to get started with TaskFlow</p>
        <div id="successAlert" class="alert-success">Account successfully created!</div>
        <form id="registerForm">
          <div class="field">
            <label class="field-label">Full Name</label>
            <input type="text" id="reg-name" placeholder="John Doe" />
            <p class="field-error" id="nameError">Full name is required.</p>
          </div>
          <div class="field">
            <label class="field-label">Email Address</label>
            <input type="email" id="reg-email" placeholder="you@example.com" />
            <p class="field-error" id="emailError">Valid email is required.</p>
          </div>
          <div class="field">
            <label class="field-label">Password</label>
            <input type="password" id="reg-password" placeholder="Min. 8 characters" />
            <div class="strength-bar"><div class="strength-seg" id="seg1"></div><div class="strength-seg" id="seg2"></div><div class="strength-seg" id="seg3"></div></div>
          </div>
          <button type="submit" class="btn-primary">Create Account</button>
        </form>
        <p class="form-footer">Already have an account? <a onclick="toggleView('login')">Log in</a></p>
      </div>
    </div>
  </main>
</div>
<script>
  function toggleView(view) {
    document.getElementById('login-view').style.display = view === 'login' ? 'block' : 'none';
    document.getElementById('register-view').style.display = view === 'register' ? 'block' : 'none';
  }
  const regPassword = document.getElementById('reg-password');
  regPassword.addEventListener('input', (e) => {
    const val = e.target.value;
    const segs = [document.getElementById('seg1'), document.getElementById('seg2'), document.getElementById('seg3')];
    let score = val.length >= 8 ? (/[A-Z]/.test(val) && /[0-9]/.test(val) ? 3 : 2) : (val.length > 0 ? 1 : 0);
    segs.forEach((s, i) => s.style.background = i < score ? (score === 1 ? '#ef4444' : score === 2 ? '#f59e0b' : '#10b981') : '#e5e7eb');
  });
  document.getElementById('registerForm').addEventListener('submit', (e) => {
    e.preventDefault();
    document.getElementById('successAlert').style.display = 'block';
  });
</script>
</body>
</html>