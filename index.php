<?php
require_once __DIR__ . '/../includes/session.php';
requireLogin(); // Redirige vers index.php si non connecté
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=1440" />
<title>TaskFlow — Dashboard</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  html, body { height: 100%; font-family: 'Inter', sans-serif; background: #f3f4f6; color: #111827; }

  /* ── Navbar ── */
  nav {
    background: #fff;
    border-bottom: 1px solid #e5e7eb;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 40px;
    position: sticky; top: 0; z-index: 10;
  }
  .nav-brand { display: flex; align-items: center; gap: 10px; font-size: 20px; font-weight: 700; color: #005a92; }
  .nav-brand span { color: #111827; }
  .nav-user { display: flex; align-items: center; gap: 16px; }
  .nav-user-name { font-size: 14px; font-weight: 500; color: #374151; }
  .btn-logout {
    padding: 8px 18px;
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
    text-decoration: none;
    transition: 0.15s;
  }
  .btn-logout:hover { background: #fef2f2; border-color: #fca5a5; color: #dc2626; }

  /* ── Content ── */
  .container { max-width: 1100px; margin: 0 auto; padding: 48px 24px; }
  .welcome-card {
    background: linear-gradient(135deg, #003354 0%, #005a92 50%, #00a3e0 100%);
    border-radius: 16px;
    padding: 40px 48px;
    color: #fff;
    margin-bottom: 40px;
    position: relative;
    overflow: hidden;
  }
  .welcome-card::after {
    content: '';
    position: absolute;
    right: -40px; top: -40px;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
  }
  .welcome-card h1 { font-size: 28px; font-weight: 700; margin-bottom: 8px; }
  .welcome-card p  { font-size: 15px; opacity: 0.85; }

  /* ── Stats grid ── */
  .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px; }
  .stat-card {
    background: #fff;
    border-radius: 12px;
    padding: 28px 32px;
    border: 1px solid #e5e7eb;
  }
  .stat-label { font-size: 13px; font-weight: 500; color: #6b7280; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
  .stat-value { font-size: 36px; font-weight: 800; color: #005a92; }

  /* ── Info box ── */
  .info-box {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    padding: 32px;
  }
  .info-box h2 { font-size: 18px; font-weight: 600; margin-bottom: 20px; }
  .info-row { display: flex; gap: 12px; padding: 14px 0; border-bottom: 1px solid #f3f4f6; align-items: center; }
  .info-row:last-child { border-bottom: none; }
  .info-key { font-size: 13px; font-weight: 500; color: #6b7280; width: 140px; flex-shrink: 0; }
  .info-val { font-size: 14px; color: #111827; font-weight: 500; }
</style>
</head>
<body>

<nav>
  <div class="nav-brand">Task<span>Flow</span></div>
  <div class="nav-user">
    <span class="nav-user-name">👤 <?= htmlspecialchars($_SESSION['user_name']) ?></span>
    <a href="/taskflow/auth/logout.php" class="btn-logout">Déconnexion</a>
  </div>
</nav>

<div class="container">

  <div class="welcome-card">
    <h1>Bonjour, <?= htmlspecialchars($_SESSION['user_name']) ?> 👋</h1>
    <p>Bienvenue sur votre tableau de bord TaskFlow. Gérez vos tâches efficacement.</p>
  </div>

  <div class="stats">
    <div class="stat-card">
      <div class="stat-label">Tâches totales</div>
      <div class="stat-value">0</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">En cours</div>
      <div class="stat-value">0</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Terminées</div>
      <div class="stat-value">0</div>
    </div>
  </div>

  <div class="info-box">
    <h2>Informations du compte</h2>
    <div class="info-row">
      <span class="info-key">Nom complet</span>
      <span class="info-val"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
    </div>
    <div class="info-row">
      <span class="info-key">Adresse e-mail</span>
      <span class="info-val"><?= htmlspecialchars($_SESSION['user_email']) ?></span>
    </div>
    <div class="info-row">
      <span class="info-key">ID utilisateur</span>
      <span class="info-val">#<?= (int) $_SESSION['user_id'] ?></span>
    </div>
    <div class="info-row">
      <span class="info-key">Statut</span>
      <span class="info-val" style="color:#059669;">✓ Connecté</span>
    </div>
  </div>

</div>
</body>
</html>
