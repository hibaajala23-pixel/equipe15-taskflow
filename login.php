<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['success' => false, 'message' => 'Méthode non autorisée.']));
}

// ── CSRF ─────────────────────────────────────────────────────────────────────
$token = $_POST['csrf_token'] ?? '';
if (!csrf_verify($token)) {
    http_response_code(403);
    exit(json_encode(['success' => false, 'message' => 'Token CSRF invalide.']));
}
unset($_SESSION['csrf_token']);

// ── Données ───────────────────────────────────────────────────────────────────
$email    = trim($_POST['email']    ?? '');
$password = $_POST['password']      ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
    http_response_code(422);
    exit(json_encode(['success' => false, 'message' => 'Email ou mot de passe manquant.']));
}

// ── Recherche utilisateur ─────────────────────────────────────────────────────
$db   = getDB();
$stmt = $db->prepare('SELECT id, full_name, email, password FROM users WHERE email = ? LIMIT 1');
$stmt->execute([$email]);
$user = $stmt->fetch();

// Vérification du mot de passe (timing-safe via password_verify)
if (!$user || !password_verify($password, $user['password'])) {
    http_response_code(401);
    exit(json_encode(['success' => false, 'message' => 'Identifiants incorrects.']));
}

// ── Connexion ─────────────────────────────────────────────────────────────────
loginUser($user);

exit(json_encode([
    'success'  => true,
    'message'  => 'Connexion réussie.',
    'redirect' => '/taskflow/dashboard/index.php',
]));
