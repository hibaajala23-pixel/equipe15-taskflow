<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/google_oauth.php';

// ── Vérification du state anti-CSRF ──────────────────────────────────────────
if (!isset($_GET['state']) || $_GET['state'] !== ($_SESSION['oauth_state'] ?? '')) {
    die('Accès non autorisé.');
}
unset($_SESSION['oauth_state']);

if (!isset($_GET['code'])) {
    header('Location: /taskflow/index.php');
    exit;
}

// ── Échange du code contre un access token ───────────────────────────────────
$tokenResponse = file_get_contents('https://oauth2.googleapis.com/token', false, stream_context_create([
    'http' => [
        'method'  => 'POST',
        'header'  => 'Content-Type: application/x-www-form-urlencoded',
        'content' => http_build_query([
            'code'          => $_GET['code'],
            'client_id'     => GOOGLE_CLIENT_ID,
            'client_secret' => GOOGLE_CLIENT_SECRET,
            'redirect_uri'  => GOOGLE_REDIRECT_URI,
            'grant_type'    => 'authorization_code',
        ]),
    ],
]));

$tokenData = json_decode($tokenResponse, true);

if (!isset($tokenData['access_token'])) {
    die('Erreur lors de la récupération du token Google.');
}

// ── Récupération du profil Google ─────────────────────────────────────────────
$profileResponse = file_get_contents('https://www.googleapis.com/oauth2/v2/userinfo', false, stream_context_create([
    'http' => [
        'header' => 'Authorization: Bearer ' . $tokenData['access_token'],
    ],
]));

$profile = json_decode($profileResponse, true);

if (!isset($profile['email'])) {
    die('Impossible de récupérer le profil Google.');
}

// ── Connexion ou création du compte ──────────────────────────────────────────
$db   = getDB();
$stmt = $db->prepare('SELECT id, full_name, email FROM users WHERE email = ? LIMIT 1');
$stmt->execute([$profile['email']]);
$user = $stmt->fetch();

if (!$user) {
    // Créer le compte automatiquement
    $insert = $db->prepare('INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)');
    $insert->execute([
        $profile['name']  ?? 'Utilisateur Google',
        $profile['email'],
        password_hash(bin2hex(random_bytes(16)), PASSWORD_BCRYPT), // mot de passe aléatoire
    ]);
    $user = [
        'id'        => (int) $db->lastInsertId(),
        'full_name' => $profile['name'] ?? 'Utilisateur Google',
        'email'     => $profile['email'],
    ];
}

loginUser($user);
header('Location: /taskflow/dashboard/index.php');
exit;
