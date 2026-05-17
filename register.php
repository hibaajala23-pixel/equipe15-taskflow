<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

// ── Méthode ──────────────────────────────────────────────────────────────────
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
// Regénérer le token après usage
unset($_SESSION['csrf_token']);

// ── Récupération & nettoyage des données ─────────────────────────────────────
$full_name = trim($_POST['full_name'] ?? '');
$email     = trim($_POST['email']     ?? '');
$password  = $_POST['password']       ?? '';

$errors = [];

if ($full_name === '' || strlen($full_name) < 2) {
    $errors['full_name'] = 'Le nom complet est requis (min. 2 caractères).';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Adresse e-mail invalide.';
}

if (strlen($password) < 8) {
    $errors['password'] = 'Le mot de passe doit contenir au moins 8 caractères.';
}

if (!empty($errors)) {
    http_response_code(422);
    exit(json_encode(['success' => false, 'errors' => $errors]));
}

// ── Vérification unicité email ────────────────────────────────────────────────
$db   = getDB();
$stmt = $db->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
$stmt->execute([$email]);

if ($stmt->fetch()) {
    http_response_code(409);
    exit(json_encode(['success' => false, 'errors' => ['email' => 'Cette adresse e-mail est déjà utilisée.']]));
}

// ── Hachage du mot de passe & insertion ──────────────────────────────────────
$hashed = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

$insert = $db->prepare('INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)');
$insert->execute([$full_name, $email, $hashed]);

$newUser = [
    'id'        => (int) $db->lastInsertId(),
    'full_name' => $full_name,
    'email'     => $email,
];

// ── Connexion automatique après inscription ───────────────────────────────────
loginUser($newUser);

exit(json_encode([
    'success'  => true,
    'message'  => 'Compte créé avec succès !',
    'redirect' => '/taskflow/dashboard/index.php',
]));
